<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Home extends BaseController {
    
    protected $_auth = array(
        'role_id' => array(ROLE_COMPA, ROLE_MACIZO)
    );

    public function index() {
        $this->_loadView("home");
    }
}