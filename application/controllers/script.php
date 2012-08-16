<?php
class Script extends CI_Controller {
    
    private $_systemUser = null;
    
    public function __construct() {
        if (php_sapi_name() != 'cli') {
            exit;
        }
        parent::__construct();
        
        $this->load->library('utils');
        $this->load->helper('url');
        $this->load->model('users');
        $this->load->model('categories');
        $this->load->model('posts');
        $this->load->model('users');
                
        $this->_systemUser = $this->users->getSystemUser();
    }
    
    public function pick_new_category() {
        // Primermos nos traemos todas las categorias
        $arrData = $this->categories->query("SELECT id,name FROM categories");
        $arrCategories = array();
        echo ">> Categorias disponibles:\n";
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
        echo ">> Categorias usadas:\n";
        print_r($arrUsedOnes);
        
        
        $arrToUse = array_diff($arrCategories, $arrUsedOnes);
        if (!empty($arrToUse)) {
            echo ">> Categorias a usar:\n";
            print_r($arrToUse);
            echo ">> Random.... ";
            $id  = array_rand($arrToUse);
            echo "cat:".$arrToUse[$id]."\n";
            $this->categories->setActive($id, 7);
        } else {
            echo ">> Todas las categorias ya fueron usadas...\n";
        }
        
        $oActiveCat = $this->categories->getActiveCategory();
        echo "> Active Category: ".$oActiveCat->getName()." Termina: ".$oActiveCat->getEnds()."\n";
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
        echo ">> Building album for:". $oCat->getName()."\n";
        $arrPosts = $this->posts->getByCategory($numCatId);
        echo ">> Getting songs...\n";
        $arrSongs = array();
        foreach ($arrPosts as $oPost) {
            $oSong = $oPost->getSong();
            if ($oSong != null) {
                echo "    > ".$oSong->getFileName()."\n";
                if (file_exists(MP3_FOLDER.$oSong->getFullpath())) {
                    $arrSongs[] = array(
                        'path' => MP3_FOLDER.$oSong->getFullpath(),
                        'name' => $oSong->getFileName()
                    );
                }
            }
        }
        if (!empty($arrSongs)) {
            echo ">> Building zip file...\n";
            $strZipFile = Utils::createZip($oCat->getName(), $arrSongs);
            echo ">> Album created: $strZipFile Size: ".Utils::fileZise(ALBUMS_FOLDER.$strZipFile)."\n";
            echo ">> Sending emails...\n";
            
            echo ">> Creating System post in the category...\n";
            $strPostBody = $this->_renderTemplate('posts/category_album', 
                    array('album_url' => base_url().'assets/albums/'.$strZipFile)
            );
            $this->posts->add($this->_systemUser->getId(), 
                    'Album de '.$oCat->getName().' listo!', 
                    $strPostBody, 
                    $oCat->getId(), 
                    0
            );
            
        } else {
            echo "No songs where found :(\n";
        }
        exit;
    }
    
    private function _renderTemplate($strTemplate, $arrParams) {
        return $this->load->view(
                'templates/'. $strTemplate, 
                $arrParams, true
        );
    }
}
