<?php
require_once 'UserRoleEntity.php';
require_once 'UserInfoEntity.php';

class UserEntity {

    private $_numId;
    private $_strUsername;
    private $_strPassword;
    private $_strFirstname;
    private $_strLastname;
    private $_oUserRole;
    private $_numStatus;
    private $_strDateCreated;

    private $_oUserInfo = null;
    private $_oMemberSHip = null;
    
    public function __construct() {
        
    }

    public function setId($numId) {
        $this->_numId = $numId;
    }

    public function getId() {
        return $this->_numId;
    }

    public function setUsername($strUsername) {
        $this->_strUsername = $strUsername;
    }

    public function getUsername() {
        return $this->_strUsername;
    }

    public function setPassword($strPassword) {
        $this->_strPassword = $strPassword;
    }

    public function getPassword() {
        return $this->_strPassword;
    }

    public function setRoleId($numUserRoleId) {
        if (empty($this->_oUserRole)) {
            $this->_oUserRole = new UserRoleEntity();
        }
        $this->_oUserRole->setUserRoleId($numUserRoleId);
    }

    public function getRoleId() {
        if (empty($this->_oUserRole)) {
            $this->_oUserRole = new UserRoleEntity();
        }
        $this->_oUserRole->getUserRoleId();
    }

    public function setRoleDescription($strRoleDesc) {
        if (empty($this->_oUserRole)) {
            $this->_oUserRole = new UserRoleEntity();
        }
        $this->_oUserRole->setRoleDescription($strRoleDesc);
    }

    public function getRoleDescription() {
        if (empty($this->_oUserRole)) {
            $this->_oUserRole = new UserRoleEntity();
        }
        $this->_oUserRole->getRoleDescription();
    }

    public function setUserRole(UserRole $oRole) {
        $this->_oUserRole = $oRole;
    }

    public function getUserRole() {
        return $this->_oUserRole;
    }

    public function setFirstname($strFirstname) {
        $this->_strFirstname = $strFirstname;
    }

    public function getFirstname() {
        return $this->_strFirstname;
    }

    public function setLastname($strLastname) {
        $this->_strLastname = $strLastname;
    }

    public function getLastname() {
        return $this->_strLastname;
    }

    public function getStatus() {
        return $this->_numStatus;
    }

    public function setStatus($status) {
        $this->_numStatus = $status;
    }

    public function getCreatedDate() {
        return $this->_strDateCreated;
    }

    public function setCreatedDate($date) {
        $this->_strDateCreated = $date;
    }

    public function getUserInfo() {
        if($this->_oUserInfo == null) {
            $this->_oUserInfo = new UserInfoEntity();
        }
        return $this->_oUserInfo;
    }

    public function setUserInfo(UserInfoEntity $oUInf) {
        $this->_oUserInfo = $oUInf;
    }

    public function getFullName() {
        return $this->_strFirstname." ".$this->_strLastname;
    }
    
    public function addMemberShip(UserMembershipEntity $oObj) {
        $this->_oMemberSHip = $oObj;
    }
    
    public function getMemberShip() {
        return $this->_oMemberSHip;
    }
}
