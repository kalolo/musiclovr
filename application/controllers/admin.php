<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin extends BaseController {
    
    protected $_auth = array(
        'role_id' => array(ROLE_MACIZO)
    );
    
    public function pick_category() {
        $this->load->model('categories');
        
        if ($this->input->post('category')) {
            $numCategory = (int)$this->input->post('category');
            $numDays     = (int)$this->input->post('active_days');
            $this->categories->setActive($numCategory, $numDays);
        }
        
        $arrCategories = $this->categories->getAll();
        $this->_addViewParam('arrCategories', $arrCategories);
        $this->_loadView('admin/active_category');
    }
}