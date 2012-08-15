<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Categoria extends BaseController {

    public function view($strCategory) {
        echo Utils::slugger("Carlos Lopez del a Rosa");
        echo "<br/>";
        echo $strCategory;exit;
    }

}