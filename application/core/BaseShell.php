<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class BaseShell extends CI_Controller {

    public function  __construct() {
        if (php_sapi_name() != 'cli') {
            exit;
        }
        parent::__construct();
        $this->load->library('utils');
        $this->load->helper('url');
        
        
        $this->load->model('users');
        $oUser = $this->users->getSystemUser();
        $this->_setLoggedUser($oUser);
    }
    
    protected function _setLoggedUser($oUser) {
        $this->_loggedUser = $oUser;
    }
    
    protected function _getLoggedUser() {
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