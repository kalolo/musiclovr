<?php
class CommentEntity {
    private $_numId;
    private $_numPostId;
    private $_strBody;
    private $_strCreated;
    
    private $_oUser = null;
    
    public function setId($val) {
        $this->_numId = $val;
    }
    
    public function getId() {
        return $this->_numId;
    }
    
    public function setPostId($val) {
        $this->_numPostId = $val;
    }
    
    public function getPostId() {
        return $this->_numPostId;
    }
    
    public function setBody($val) {
        $this->_strBody = $val;
    }
    
    public function getBody() {
        return $this->_strBody;
    }
    
    public function setUser(UserEntity $oUser) {
        $this->_oUser = $oUser;
    }
    
    public function getUser() {
        return $this->_oUser;
    }
    
    public function setCreated($val) {
        $this->_strCreated = $val;
    }
    
    public function getCreated() {
        return $this->_strCreated;
    }
}
