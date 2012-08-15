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
}
