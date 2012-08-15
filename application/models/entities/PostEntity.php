<?php
class PostEntity {
    private $_numId;
    private $_numUserId;
    private $_numCategoryId;
    private $_strHeadline;
    private $_strBody;
    private $_strCreted;
    private $_strSlug;
    private $_numSongId;
    
    private $_oSong;
    private $_oCategory;
    private $_oUser;
    private $_arrComments;
    
    public function setId($val) {
        $this->_numId = $val;
    }
    
    public function getId() {
        return $this->_numId;
    }
    
    public function setUserId($val) {
        $this->_numUserId = $val;
    }
    
    public function getUserId() {
        return $this->_numUserId;
    }
    
    public function setCategoryId($val) {
        $this->_numCategoryId = $val;
    }
    
    public function getCategoryId() {
        return $this->_numCategoryId;
    }
    
    public function setHeadline($val) {
        $this->_strHeadline = $val;
    }
    
    public function getHeadline() {
        return $this->_strHeadline;
    }
    
    public function setBody($val) {
        $this->_strBody = $val;
    }
    
    public function getBody() {
        return $this->_strBody;
    }
    
    public function setSlug($val) {
        $this->_strSlug = $val;
    }
    
    public function getSlug() {
        return $this->_strSlug;
    }
    
    public function setCreated($val) {
        $this->_strCreted;
    }
    
    public function getCreated() {
        return $this->_strCreted;
    }
    
    public function setSongId($val) {
        $this->_numSongId = $val;
    }
    
    public function getSongId() {
        return $this->_numSongId;
    }
    
    public function setUser(UserEntity $oUser) {
        $this->_oUser = $oUser;
    }
    
    public function getUser() {
        return $this->_oUser;
    }
    
    public function setCategory(CategoryEntity $oCat) {
        $this->_oCategory = $oCat;
    }
    
    public function getCategory() {
        return $this->_oCategory;
    }
}