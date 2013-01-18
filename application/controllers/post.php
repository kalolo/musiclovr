<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Post extends BaseController {
    
    protected $_auth = array(
        'role_id' => array(ROLE_COMPA, ROLE_MACIZO)
    );

    public function view($strHeadline) {
        $strSlug = str_replace(array('.html','/'),'', $strHeadline);
        $this->load->model('posts');
        $oPost = $this->posts->getBySlug($strSlug);
        if ($oPost == null) {
            redirect(base_url().'home', 'location');
        }
        $isOwner = ($oPost->getUserId() == $this->_getLoggedUser()->id);
        $this->_addViewParam('oPost', $oPost);
        $this->_addViewParam('isOwner', $isOwner);
        $this->_loadView('posts/full_view');
    }
}