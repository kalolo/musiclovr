<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class BaseController extends CI_Controller {
    
    private $_viewParams = array();
    private $_loggedUser = null;
    private $_arrJSpaths = array();
    private $_arrCSSPaths = array();

    public function  __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('utils');
        $this->load->helper('url');
        
        if (!$this->_checkAuth()) {
            redirect(base_url().'login', 'location');
        }
        
        if ($this->_isUserLogged()) {
            $this->_addViewParam('is_logged', true);
            $this->_addViewParam('logged_user', $this->_getLoggedUser());
        } else {
            $this->_addViewParam('is_logged', false);
        }
    }
    
    protected function _checkAuth() {
        if (isset($this->_auth)) {
            if ($this->_isUserLogged() && 
                    in_array($this->_getLoggedUser()->role_id, $this->_auth['role_id'])) {
                return true;
            }
            return false;
        }
        return true;
    }
    
    protected function _log($msg, $lvl='debug') {
        error_log($msg);
    }
    
    protected function _isUserLogged() {
        return $this->session->userdata('is_logged');
    }

    protected function _setLoggedUser($oUser) {
        $this->session->set_userdata('is_logged', true);
        $this->session->set_userdata('logged_user', $oUser);
        $this->_loggedUser = $oUser;
        $this->_addViewParam('is_logged', true);
        $this->_addViewParam('logged_user', $this->_getLoggedUser());
    }
    
    protected function _getLoggedUser() {
        if ($this->_loggedUser == null && $this->_isUserLogged()) {            
            $this->_loggedUser = $this->session->userdata('logged_user');
        }
        return $this->_loggedUser;
    }

    /**
     * Adds a JS to the layout
     * 
     * @param String $strJsPath
     * 
     * @return void
     */
    protected function _addJs($strJsPath) {
    	$this->_arrJSpaths[] = $strJsPath;
    }

    /**
     * Adds a CSS Fila to the layout
     * 
     * @param String $strCSSPath
     * 
     * @return void
     */
    protected function _addCss($strCSSPath) {
    	$this->_arrCSSPaths[] = $strCSSPath;
    }
    
    /**
     * Adds a parameter to the view
     *
     * @param mixed $name  An array with format array(paramName=>paramValue)
     * 					   or parameter name
     * @param mixed $value Value of parameter. If name is an array it will be
     * 					   ignored
     */
    protected function _addViewParam($name, $value = NULL) {
        if (!empty($name)) {
            if ($value == NULL && is_array($name)) {
                $params = (array) $name;
                foreach ($params as $name => $value) {
                    $this->_viewParams[$name] = $value;
                }
            } else {
                $name = (string) $name;
                $this->_viewParams[$name] = $value;
            }
        }
    }

	/**
     * Loads a view
     *
     * @param String $strView   view path
     * @param String $strLayout Layout to be used path should start from views/layouts/
     */
    protected function _loadView($strView, $strLayout = 'default') {
    	$layoutData['arrJs']          = $this->_arrJSpaths;
    	$layoutData['arrCss']         = $this->_arrCSSPaths;
    	$layoutData['oLoggedUser']    = $this->_getLoggedUser();        
        if ($strLayout == 'ajax') {
            $this->load->view($strView, $this->_viewParams);
        } else {
    	    $layoutData['strContentView'] = $this->load->view($strView, $this->_viewParams, true);
    	    $this->load->view('layouts/' . $strLayout, $layoutData);
        }
    }

}