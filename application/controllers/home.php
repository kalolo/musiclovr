<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Home extends BaseController {
    
    protected $_auth = array(
        'role_id' => array(ROLE_COMPA, ROLE_MACIZO)
    );

    public function index() {
        $this->load->model('Categories');
        $arrCategories   = $this->Categories->getAll();
        $oActiveCategory = $this->Categories->getActiveCategory();
        $this->_addViewParam('oActiveCategory', $oActiveCategory);
        $this->_addViewParam('arrCategories', $arrCategories);
        $this->_loadView("home");
    }
    
    public function add_category() {
        $this->load->model('Categories');
        if ($this->input->post('btn_add')) {
            $strName        = trim($this->input->post('category_name'));
            $strDescription = trim($this->input->post('category_description'));
            if (!empty($strName)) {
                $this->Categories->add(
                        $this->_getLoggedUser()->id, 
                        $strName, 
                        $strDescription
                );
            }
        }
        
        $arrCategories = $this->Categories->getAll();
        $this->_addViewParam('arrCategories', $arrCategories);
        $this->_loadView('home/add_category');   
    }
    
    public function add_new_song() {
        $this->load->model('Categories');
        $arrCategories = $this->Categories->getAll();
        $this->_addViewParam('arrCategories', $arrCategories);
    }
}