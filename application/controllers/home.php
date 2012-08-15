<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Home extends BaseController {
    
    protected $_auth = array(
        'role_id' => array(ROLE_COMPA, ROLE_MACIZO)
    );

    public function index() {
        $oLastActiveCat = $this->Categories->lastActiveCategory();
        $this->_addViewParam('oLastActiveCat', $oLastActiveCat);
        $this->_loadView("home");
    }
    
    public function add_category() {
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
            redirect(base_url().'home/add_category', 'location');
        }
        $this->_loadView('home/add_category');   
    }
    
    public function new_post() {
        
        $oActiveCategory = $this->Categories->getActiveCategory();
        $this->_addViewParam('oActiveCategory', $oActiveCategory);
        
        $this->_loadView('posts/new');
    }
}