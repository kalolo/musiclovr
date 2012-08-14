<?php
require_once 'UserEntity.php';
class CategoryEntity {
    
    private $_numId;
    private $_strName;
    private $_strDescription;
    private $_strSlug;
    private $_numUserId;
    private $_strCreated;
    
    private $_oUser;
    
    public function __construct() {
        
    }
    
    public function setId($value) {
        $this->_numId = $value;
    }
    
    public function getId() {
        return $this->_numId;
    }
    
    public function setName($value) {
        $this->_strName = $value;
    }
    
    public function getName() {
        return $this->_strName;
    }
    
    public function setDescription($value) {
        $this->_strDescription = $value;
    }
    
    public function getDescription() {
        return $this->_strDescription;
    }
    
    public function setSlug($value) {
        $this->_strSlug = $value;
    }
    
    public function getSlug() {
        return $this->_strSlug;
    }
    
    public function setUserId($value) {
        $this->_numUserId = $value;
    }
    
    public function getUserId() {
        return $this->_numUserId;
    }
    
    public function setCreated($value) {
        $this->_strCreated = $value;
    }
    
    public function getCreated() {
        return $this->_strCreated;
    }
    
    public function getUser() {
        return $this->_oUser;
    }
    
    public function setUser(UserEntity $oUser) {
        $this->_oUser = $oUser;
    }
}