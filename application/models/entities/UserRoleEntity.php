<?php

class UserRoleEntity {

    private $_numRoleId;
    private $_strRoleDescription;

    public function __construct() {
        
    }

    public function setUserRoleId($numRoleId) {
        $this->_numRoleId = $numRoleId;
    }

    public function getUserRoleId() {
        return $this->_numRoleId;
    }

    public function setRoleDescription($strRoleDesc) {
        $this->_strRoleDescription = $strRoleDesc;
    }

    public function getRoleDescription() {
        return $this->_strRoleDescription;
    }

}