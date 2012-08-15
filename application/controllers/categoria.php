<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Categoria extends BaseController {

    public function view($strCategory) {
        
        $strCategorySlug = str_replace(array('.html','/'),'', $strCategory);
        $this->load->model('Categories');
        $oCategory = $this->Categories->getBySlug($strCategorySlug);
        if ($oCategory == null) {
            redirect(base_url().'home', 'location');
        }
        $this->_addViewParam('oCategory', $oCategory);
        $this->_loadView('category');
    }

}