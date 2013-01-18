<?php
class Script extends CI_Controller {
    
    private $_systemUser = null;
    
    public function __construct() {
        if (php_sapi_name() != 'cli') {
            //if (!isset($_GET['api']) || $_GET['api'] != '') {
                exit;
            //}
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
    
    public function update_user_slugs() {
        $this->out(__METHOD__);
        $arrUsers = $this->users->getAll();
        foreach ($arrUsers as $oUser) {
            $slug = $oUser->getSlug();
            if (empty($slug)) {
                $this->out("    >> Actualizando slug a ".$oUser->getUsername());
                $this->users->udpateUserSlug($oUser->getId());
            }
        }
        exit;
    }
    
    public function close_active_category() {
        $oActiveCat = $this->categories->getActiveCategory();
        if ($oActiveCat != null) {
            $this->out("> Active Category: " 
                    . $oActiveCat->getName() 
                    . " Termina: ".$oActiveCat->getEnds()
            );
            $this->categories->deactivate($oActiveCat->getId());
            $oNewCategory = $this->_pick_new_category();    
            $strEmailBody = $this->_renderTemplate('emails/new_category', array('oNewCategory' => $oNewCategory));
            $this->_sendEmail($this->users->getEmails(), "Greetings musiclovers!", $strEmailBody);
        } else {
            $this->out(">> No hay categoria activa...");
        }
        exit;
    }
    
    public function set_new_category() {
        $oNewCategory = $this->_pick_new_category();
    }
    
    public function process_categories() {
        $arrCategories = $this->categories->getPendingToBeProcessed();
        foreach ($arrCategories as $oCategory) {
            $this->out(">> ".$oCategory->getId()." ".$oCategory->getName());
            $arrAlbumData = $this->_build_album($oCategory->getId());
            //$this->out($arrAlbumData);
            $strEmailBody = $this->_renderTemplate('emails/new_album', $arrAlbumData);
            $this->_sendEmail($this->users->getEmails(), "Greetings musiclovers!", $strEmailBody);
        }
    }
    
    private function _pick_new_category() {
        // Primermos nos traemos todas las categorias
        $arrData = $this->categories->query("SELECT id,name FROM categories");
        $arrCategories = array();
        $this->out(">> Categorias disponibles:");
        foreach ($arrData as $oCat) {
            $arrCategories[$oCat->id] = $oCat->name;
        }
        $this->out($arrCategories);
        // Ahora sacamos las categorias que ya han estado activas, hacemos un merge
        // y las que queden, tomamos una random de ahi para activarla :)
        $arrData = $this->categories->query("SELECT cat.id,cat.name FROM categories cat 
            INNER JOIN current_category cc ON cc.category_id = cat.id
            GROUP BY cat.id");
        $arrUsedOnes = array();
        foreach ($arrData as $oCat) {
            $arrUsedOnes[$oCat->id] = $oCat->name;
        }
        $this->out(">> Categorias usadas:");
        $this->out($arrUsedOnes);
        $arrToUse = array_diff($arrCategories, $arrUsedOnes);
        if (!empty($arrToUse)) {
            $this->out(">> Categorias a usar:");
            $this->out($arrToUse);
            $id  = array_rand($arrToUse);
            $this->out(">> Random.... cat:".$arrToUse[$id]);
            $this->categories->setActive($id, 7);
        } else {
            $this->out( ">> Todas las categorias ya fueron usadas...");
        }
        $oActiveCat = $this->categories->lastActiveCategory();
        $this->out("> Active Category: ".$oActiveCat->getName()." Termina: ".$oActiveCat->getEnds());
        return $oActiveCat;
    }
    
    private function _build_album($numCatId) {
        $oCat     = $this->categories->getById($numCatId);
        $this->out(">> Building album for:". $oCat->getName());
        $arrPosts = $this->posts->getByCategory($numCatId);
        $this->out(">> Getting songs...");
        $arrSongs = array();
        foreach ($arrPosts as $oPost) {
            $oSong = $oPost->getSong();
            if ($oSong != null) {
                $this->out("    > ".$oSong->getFileName());
                if (file_exists(MP3_FOLDER.$oSong->getFullpath())) {
                    $arrSongs[] = array(
                        'path' => MP3_FOLDER.$oSong->getFullpath(),
                        'name' => $oSong->getFileName()
                    );
                }
            }
        }
        if (!empty($arrSongs)) {
            $this->out(">> Building zip file...");
            $strZipFile = Utils::createZip($oCat->getName(), $arrSongs);
            $this->out(">> Album created: $strZipFile Size: ".Utils::fileZise(ALBUMS_FOLDER.$strZipFile));
            $this->out(">> Creating System post in the category...");
            $strPostBody = $this->_renderTemplate('posts/category_album', 
                    array(
                          'album_url'     => base_url().'assets/albums/'.$strZipFile,
                          'category_name' => $oCat->getName(),
                          'cover_img'     => 'default.png',
                          'thumb_img'     => 'default_thumb.png',
                          'arrSongs'      => $arrSongs
                    )
            );
            $this->categories->flagAsProccess($oCat->getId());
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
                        'thumb_img'     => 'default_thumb.png',
                        'arrSongs'      => $arrSongs
            );
        } else {
            $this->out("No songs where found :(");
            return array(
                        'album_url'     => "#",
                        'category_name' => $oCat->getName(),
                        'cover_img'     => 'default.png',
                        'thumb_img'     => 'default_thumb.png',
                        'arrSongs'      => array()
            );
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
    
    public function info() {
        phpinfo();
    }
    
    public function importer() {
        exit;
        $this->load->model('Users');
        $this->load->model('Posts');
        $this->load->model('Categories');
        $this->load->model('songs');
        $xml = simplexml_load_file(FCPATH. 'musiclovr.wordpress.2013-01-17.xml');
        $arrPosts = array();
        $arrAuthors = array();
        $arrCategories = array();
        $arrEmails = array();
        foreach ($xml->channel->item as $nodes) {
            $oPost          = new stdClass();
            $oPost->title   = (string) $nodes->title;
            $oPost->content = (string) $nodes->content;
            $oPost->date    = (string) $nodes->post_date_gmt;
            $oPost->author  = $this->Users->getByFirstName(
                    strtolower((string) $nodes->creator))->getId();
            $category = (string) $nodes->category;
            $oCat     = $this->Categories->getBySlug(Utils::slugger($category));
            $numCatId = $oCat->getId();
            $oPost->category = $numCatId;
            $arrComments = array();
            $oPost->comments = $arrComments;
            $oPost->songId   = 0;
            echo ">> Creando post: ".$oPost->title."\n";
            echo "    >> Bajando la rola...\n";
            preg_match_all('/href=[\'"]?([^\s\>\'"]*)[\'"\>]/', $oPost->content, $matches);
            $hrefs  = ($matches[1] ? $matches[1] : array());
            $mp3Url = false;
            foreach ($hrefs as $link) {
                if (strstr($link, '.mp3')) {
                    $mp3Url = $link;
                }
            }
            if ($mp3Url) {
                echo "    >> Downloading $mp3Url";
                $file = explode('/', $mp3Url);
                $fileName = $file[count($file) - 1];
                $data = @file_put_contents(
                        ini_get('upload_tmp_dir') . $fileName, 
                        @file_get_contents($mp3Url)
                );
                if ($data > 0) {
                    echo "    >> $data done!\n";
                    echo "    >> Moving " . ini_get('upload_tmp_dir') . $fileName . "\n";
                    $songPath = $this->putSong(
                                    $fileName, ini_get('upload_tmp_dir') . $fileName, $oCat->getSlug()
                    );
                    $oPost->songId = $this->songs->add($fileName, $songPath);
                }
            }
            echo "    >> Creando post!\n";
            $slug = $this->Posts->add(
                    $oPost->author, 
                    $oPost->title, 
                    $oPost->content, 
                    $oPost->category, 
                    $oPost->songId, 
                    $oPost->date
             );
            $postId = $this->Posts->getBySlug($slug)->getId();
            echo "    >> Agregando commentarios\n";
            foreach ($nodes->comment as $comment) {
                $oComment = new stdClass();
                $oComment->author = $this->Users->getByUserName(
                        strtolower((string) $comment->comment_author_email)
                )->getId();
                $oComment->body = (string) $comment->comment_content;
                $oComment->date = (string) $comment->comment_date_gmt;
                $this->Posts->addComment(
                        $postId, $oComment->author, $oComment->body, $oComment->date
                );
            }
        }
    }
    
    private function putSong($fileName, $currentPath, $folderSlug) {
        $fileName = str_replace('.mp3','',$fileName);
        $fileName = Utils::slugger(date('Ymd_His_').$fileName);
        $fileName .= '.mp3';
        $newPath  = MP3_FOLDER.$folderSlug;
        if (Utils::createFolder($newPath)) {
            $flag = copy($currentPath, $newPath.'/'.$fileName);
            return $folderSlug.'/'.$fileName;
        }
        return false;
    }
    
    
    private function out($msg) {
        if (is_array($msg)) {
            $msg = print_r($msg,true);
        }
        
        
        if (php_sapi_name() == 'cli') {
            echo $msg."\n";
        } else {
            echo nl2br($msg)."<br />";
        } 
            
    }
}
