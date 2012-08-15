<?php

class Comment extends BaseController {

    public function add() {
        if ($this->input->post('post_id')) {
            $numPostId  = (int)$this->input->post('post_id');
            if ($numPostId > 0) {
                $this->load->model('posts');
                $oPost  = $this->posts->getById($numPostId);
                if ($oPost != null) {
                    $strComment = $this->input->post('comment');
                    $strSlug = $this->posts->addComment(
                        $oPost->getId(), 
                        $this->_getLoggedUser()->id, 
                        $strComment
                    );
                    redirect(base_url() . 'post/' . $oPost->getSlug() . '.html');
                }
            }
        }
        redirect(base_url());
    }

}