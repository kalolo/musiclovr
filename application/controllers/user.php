<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User extends BaseController {
    
    protected $_auth = array(
        'role_id' => array(ROLE_COMPA, ROLE_MACIZO)
    );

    public function view($strUserSlug) {
        $this->load->model('users');
        $this->load->model('songs');
        $strUserSlug = trim(str_replace('.html','',$strUserSlug));
        error_log(__METHOD__." $strUserSlug");
        $oUser = $this->users->getBySlug($strUserSlug);
        if ($oUser) {
            $arrSongs = $this->songs->getUserSongs($oUser->getId());
            $this->_addViewParam(array('oUser' => $oUser, 'arrSongs' => $arrSongs));
            $this->_loadView('users/view');
        } else {
            redirect(base_url().'home', 'location');
        }
    }

}