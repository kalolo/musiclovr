<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Home extends BaseController {

    public function index() {
        $this->_loadView("home");
    }
}