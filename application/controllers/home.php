<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Home extends BaseController {
    
    protected $_auth = array(
        'role_id' => array(ROLE_COMPA, ROLE_MACIZO)
    );

    public function index() {
        $oLastActiveCat = $this->categories->lastActiveCategory();
        $this->_addViewParam('oLastActiveCat', $oLastActiveCat);
        $this->_loadView("home");
    }
    
    public function add_category() {
        if ($this->input->post('btn_add')) {
            $strName        = trim($this->input->post('category_name'));
            $strDescription = trim($this->input->post('category_description'));
            if (!empty($strName)) {
                $this->categories->add(
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
        
        $oActiveCategory = $this->categories->getActiveCategory();
        $this->_addViewParam('oActiveCategory', $oActiveCategory);
        
        if ($this->input->post('add_post') && $oActiveCategory != null) {
            $strHeadline = $this->input->post('headline');
            $strBody     = $this->input->post('post_body');
            
            $this->load->model('posts');
            $strSlug = $this->posts->add($this->_getLoggedUser()->id, $strHeadline, $strBody, $oActiveCategory->getId(), 0);
            redirect(base_url().'post/'.$strSlug.'.html');
        }
        $this->_loadView('posts/new');
    }
}