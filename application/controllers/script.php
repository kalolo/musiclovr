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
    
    public function pick_new_category() {
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
        exit;
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
    
    public function build_album($numCatId) {
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
                    array('album_url' => base_url().'assets/albums/'.$strZipFile)
            );
            $this->posts->add($this->_systemUser->getId(), 
                    'Album de '.$oCat->getName().' listo!', 
                    $strPostBody, 
                    $oCat->getId(), 
                    0
            );
            $this->_log(">> Sending emails...");
            $arrEmails    = $this->users->getEmails();
            $strEmailBody = $this->_renderTemplate('emails/new_album', 
                    array('album_url' => base_url().'assets/albums/'.$strZipFile)
            );
            $this->_sendEmail($arrEmails, 'Album de '.$oCat->getName().' listo!', $strEmailBody);
        } else {
            $this->_log("No songs where found :(");
        }
        exit;
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
    public function parse_comments() {
         $strComment ='Bla bla bla adfasdf asdfa sdfñasdjfañklsdflkaadsfasd www.youtube.com/watch?v=234239smv01b asdfasdf adfasf http://www.imgur.com/imagen.png adsfa sdfas dfasdas';
         $strText    = Utils::parseComment($strComment);
         echo "\n ".$strComment."\n\n\n".$strText."\n";
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
