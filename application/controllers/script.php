<?php
class Script extends CI_Controller {
    
    private $_systemUser = null;
    
    public function __construct() {
        if (php_sapi_name() != 'cli') {
            if (!isset($_GET['api']) || $_GET['api'] != 'k4l0l04699') {
                exit;
            }
        }
        parent::__construct();
        $this->load->library('utils');
        $this->load->helper('url');
        $this->load->model('users');
        $this->load->model('categories');
        $this->load->model('posts');
        $this->load->model('users');
        $this->load->library('email');
        $this->_systemUser = $this->users->getSystemUser();
    }
    
    public function close_active_category() {
        $oActiveCat = $this->categories->getActiveCategory();
        if ($oActiveCat != null) {
            $this->_log("> Active Category: ".$oActiveCat->getName()." Termina: ".$oActiveCat->getEnds());
            $arrAlbumData = $this->_build_album($oActiveCat->getId());
            print_r($arrAlbumData);
            $oNewCategory = $this->_pick_new_category();
            $strEmailBody = $this->_renderTemplate('emails/new_album', 
                    array('oNewCategory' => $oNewCategory,
                          'arrAlbumData' => $arrAlbumData)
            );
            echo "\n\n\n\ $strEmailBody \n\n\n\n";
            $this->_sendEmail($this->users->getEmails(), "Greetings musiclovers!", $strEmailBody);
        } else {
            $this->_log(">> No hay categoria activa...");
        }
        exit;
    }
    
    public function set_new_category() {
        $oNewCategory = $this->_pick_new_category();
    }
    
    private function _pick_new_category() {
        // Primermos nos traemos todas las categorias
        $arrData = $this->categories->query("SELECT id,name FROM categories");
        $arrCategories = array();
        $this->_log(">> Categorias disponibles:");
        foreach ($arrData as $oCat) {
            $arrCategories[$oCat->id] = $oCat->name;
        }
        print_r($arrCategories);
        // Ahora sacamos las categorias que ya han estado activas, hacemos un merge
        // y las que queden, tomamos una random de ahi para activarla :)
        $arrData = $this->categories->query("SELECT cat.id,cat.name FROM categories cat 
            INNER JOIN current_category cc ON cc.category_id = cat.id
            GROUP BY cat.id");
        $arrUsedOnes = array();
        foreach ($arrData as $oCat) {
            $arrUsedOnes[$oCat->id] = $oCat->name;
        }
        $this->_log(">> Categorias usadas:");
        print_r($arrUsedOnes);
        $arrToUse = array_diff($arrCategories, $arrUsedOnes);
        if (!empty($arrToUse)) {
            $this->_log(">> Categorias a usar:");
            print_r($arrToUse);
            $id  = array_rand($arrToUse);
            $this->_log(">> Random.... cat:".$arrToUse[$id]);
            $this->categories->setActive($id, 7);
        } else {
            $this->_log( ">> Todas las categorias ya fueron usadas...");
        }
        $oActiveCat = $this->categories->getActiveCategory();
        $this->_log("> Active Category: ".$oActiveCat->getName()." Termina: ".$oActiveCat->getEnds());
        return $oActiveCat;
    }
    
    public function update_user_slugs() {
        echo __METHOD__."\n";
        $arrUsers = $this->users->getAll();
        foreach ($arrUsers as $oUser) {
            $slug = $oUser->getSlug();
            if (empty($slug)) {
                echo "    >> Actualizando slug a ".$oUser->getUsername()."\n";
                $this->users->udpateUserSlug($oUser->getId());
            }
        }
        exit;
    }
    
    private function _build_album($numCatId) {
        $oCat     = $this->categories->getById($numCatId);
        $this->_log(">> Building album for:". $oCat->getName());
        $arrPosts = $this->posts->getByCategory($numCatId);
        $this->_log(">> Getting songs...");
        $arrSongs = array();
        foreach ($arrPosts as $oPost) {
            $oSong = $oPost->getSong();
            if ($oSong != null) {
                $this->_log("    > ".$oSong->getFileName());
                if (file_exists(MP3_FOLDER.$oSong->getFullpath())) {
                    $arrSongs[] = array(
                        'path' => MP3_FOLDER.$oSong->getFullpath(),
                        'name' => $oSong->getFileName()
                    );
                }
            }
        }
        if (!empty($arrSongs)) {
            $this->_log(">> Building zip file...");
            $strZipFile = Utils::createZip($oCat->getName(), $arrSongs);
            $this->_log(">> Album created: $strZipFile Size: ".Utils::fileZise(ALBUMS_FOLDER.$strZipFile));
            $this->_log(">> Creating System post in the category...");
            $strPostBody = $this->_renderTemplate('posts/category_album', 
                    array(
                          'album_url'     => base_url().'assets/albums/'.$strZipFile,
                          'category_name' => $oCat->getName(),
                          'cover_img'     => 'default.png',
                          'thumb_img'     => 'default_thumb.png',
                          'arrSongs'      => $arrSongs
                    )
            );
            $numPostId = $this->posts->isSystemPostExist($oCat->getId(), $this->_systemUser->getId());
            if ($numPostId) {
                $this->posts->update($numPostId, array(
                    'body' => $strPostBody
                ));
            } else {
                $this->posts->add($this->_systemUser->getId(), 
                    'Album de '.$oCat->getName().' listo!', 
                    $strPostBody, 
                    $oCat->getId(), 
                    0
                );
            }
            return array(
                        'album_url'     => base_url().'assets/albums/'.$strZipFile,
                        'category_name' => $oCat->getName(),
                        'cover_img'     => 'default.png',
                        'arrSongs'      => $arrSongs
            );
        } else {
            $this->_log("No songs where found :(");
        }
        return false;
    }
    
    private function _sendEmail($arrEmails, $subject, $body) {
        $config['mailtype'] = 'html';
        $this->email->initialize($config);
        $this->email->from('admin@musiclovr.net', 'Musiclovr');
        $this->email->to($arrEmails);
        $this->email->subject($subject);
        $this->email->message($body);
        $this->email->send();
    }
    
    private function _renderTemplate($strTemplate, $arrParams) {
        return $this->load->view(
                'templates/'. $strTemplate, 
                $arrParams, true
        );
    }
    
    private function _log($msg) {
        if (php_sapi_name() == 'cli') {
            echo $msg."\n";
        } else {
            echo $msg."<br />";
        } 
            
    }
}
