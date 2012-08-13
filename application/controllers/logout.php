<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Logout extends BaseController {

    public function index() {
        $this->session->sess_destroy();
        redirect(base_url() . 'home/', 'location');
    }

}