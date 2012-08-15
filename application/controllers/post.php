<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Post extends BaseController {

    public function view($strHeadline) {
        $strSlug = str_replace(array('.html','/'),'', $strHeadline);
        $this->load->model('posts');
        $oPost = $this->Posts->getBySlug($strSlug);
        if ($oPost == null) {
            redirect(base_url().'home', 'location');
        }
        $this->_addViewParam('oPost', $oPost);
        $this->_loadView('posts/full_view');
    }

}