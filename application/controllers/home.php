<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Home extends BaseController {
    
    protected $_auth = array(
        'role_id' => array(ROLE_COMPA, ROLE_MACIZO)
    );

    public function index() {
        $this->load->model('posts');
        $arrPosts       = array();
        $oLastActiveCat = null;
        $oLastActiveCat = $this->categories->lastActiveCategory();
        if (null != $oLastActiveCat) {
            $arrPosts = $this->posts->getByCategory(
                $oLastActiveCat->getId()
            );
        }
        $this->_addViewParam('oLastActiveCat', $oLastActiveCat);
        $this->_addViewParam('arrPosts', $arrPosts);
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
        $arrCategories = $this->categories->getAll();
        $this->_addViewParam('arrCategories', $arrCategories);
        $this->_loadView('home/add_category', 'dashboard');   
    }
    
    public function new_post() {
        $oActiveCategory = $this->categories->getActiveCategory();
        $this->_addViewParam('oActiveCategory', $oActiveCategory);
        
        if ($this->input->post('add_post') && $oActiveCategory != null) {
            if ($_FILES["song"]["error"] > 0) {
                $this->_addViewParam('error_msg', 'Problemas al subir el archivo D:');
            } else {
                $strFileName = $_FILES["song"]["name"];
                $strTmpPath  = $_FILES["song"]["tmp_name"];
                $this->_log(">> uploaded file: $strFileName -> path: $strTmpPath ");
                $this->load->model('songs');
                $this->load->model('posts');

                $strHeadline = $this->input->post('headline');
                $strBody     = $this->input->post('post_body');
                $strNewPath = Utils::moveSong($strFileName, $strTmpPath, $oActiveCategory->getSlug());
                
                $numSongId = $this->songs->add($strFileName, $strNewPath);
                $strSlug   = $this->posts->add(
                    $this->_getLoggedUser()->id, 
                    $strHeadline, 
                    $strBody, 
                    $oActiveCategory->getId(), 
                    $numSongId
                 );
                redirect(base_url() . 'post/' . $strSlug . '.html');
            }
        }
        $this->_loadView('posts/new', 'dashboard');
    }
    
    public function profile(){
        $this->load->model('users');
        if ($this->input->post('btn_add')) {
            $strFirstname = $this->input->post('firstname');
            $strLastname  = $this->input->post('lastname');
            $strImgUrl    = $this->input->post('image_url');
            
            $arrUpdateData = array(
                'firstname' => $strFirstname,
                'lastname'  => $strLastname,
                'profile_image_url' => $strImgUrl
             );
            
            if ($this->input->post('update_password')) {
                $pass  = trim($this->input->post('password'));
                $pass2 = trim($this->input->post('password2'));
                if (!empty($pass) && $pass == $pass2) {
                    $arrUpdateData['password'] = $pass;    
                } else {
                    $this->_addViewParam('error_msg', 'Las contraseñas no coinciden');
                }
            }
            $this->users->update($this->_getLoggedUser()->id, $arrUpdateData);
        }
        $oUser = $this->users->getById($this->_getLoggedUser()->id);
        $this->_addViewParam('oUser', $oUser);
        $this->_loadView('home/edit_profile', 'dashboard');
    }
}