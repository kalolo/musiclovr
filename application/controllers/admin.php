<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin extends BaseController {
    
    protected $_auth = array(
        'role_id' => array(ROLE_COMPA, ROLE_MACIZO)
    );

    public function index() {
        $this->load->model('Categories');
        
        $arrCategories = $this->Categories->getAll();
        $this->_addViewParam('arrCategories', $arrCategories);
        $this->_loadView("home");
    }
    
    public function active_category() {
        $this->load->model('Categories');
        
        if ($this->input->post('category')) {
            $numCategory = (int)$this->input->post('category');
            $numDays     = (int)$this->input->post('active_days');
            $this->Categories->setActive($numCategory, $numDays);
        }
        
        $arrCategories = $this->Categories->getAll();
        $this->_addViewParam('arrCategories', $arrCategories);
        $this->_loadView('admin/active_category');
    }
}