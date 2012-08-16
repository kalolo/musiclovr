<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login extends BaseController {

    public function index() {   
        if ($this->_isUserLogged()) {
            redirect(base_url().'home', 'location');
        }
        if ($this->input->post('lgn_username') && $this->input->post('lgn_password')) {
            $strUserName = trim($this->input->post('lgn_username'));
            $strPassword = trim($this->input->post('lgn_password'));
            if (!empty($strUserName) && !empty($strPassword)) {
                $this->load->model('users');
                $oUser = $this->users->getByCredentials($strUserName, $strPassword);
                if ($oUser) {
                    $this->_setLoggedUser($oUser);
                    redirect(base_url().'home/', 'location');
                }
            }
            $this->_addViewParam('error', 'No te encontramos D: .... are you drunk?..');
        }
        $this->_loadView("login", 'ajax');
    }
}