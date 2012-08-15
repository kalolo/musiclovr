<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Categoria extends BaseController {
    
    protected $_auth = array(
        'role_id' => array(ROLE_COMPA, ROLE_MACIZO)
    );

    public function view($strCategory) {
        
        $strCategorySlug = str_replace(array('.html','/'),'', $strCategory);
        $this->load->model('categories');
        $oCategory = $this->categories->getBySlug($strCategorySlug);
        if ($oCategory == null) {
            redirect(base_url().'home', 'location');
        }
        $this->load->model('posts');
        $arrPosts = $this->posts->getByCategory($oCategory->getId());
        
        $this->_addViewParam('arrPosts', $arrPosts);
        $this->_addViewParam('oCategory', $oCategory);
        $this->_loadView('category');
    }

}