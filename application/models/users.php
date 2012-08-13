<?php
require_once 'entities/UserEntity.php';
class Users extends BaseModel {

    protected $table = 'users';

    public function getByCredentials($strUserName, $strPassword) {
        $oUser = null;
        if (!empty($strUserName) && !empty($strPassword)) {
            $this->db->select('*');
            $this->db->where('username', $strUserName);
            $this->db->where('password', $strPassword);
            $result = $this->db->get('users');
            if ($result->num_rows > 0) {
                $arrUser = $result->result();
                return $arrUser[0];
                #return $this->_buildFromResultSet($arrUser[0]);
            }
        }
        return $oUser;
    }

    public function getAll() {
        return $this->_getAll($this->table);
    }
    
    private function _buildFromResultSet($resultSet) {
        $oUser = new UserEntity();
        if (is_object($resultSet)) {
            $oUser->setId($resultSet->id);
            $oUser->setUsername($resultSet->username);
            $oUser->setFirstname($resultSet->firstname);
            $oUser->setLastname($resultSet->lastname);
            $oUser->setProfileImageId($resultSet->profile_image_id);
            $oUser->setRoleId($resultSet->role_id);
        }
        return $oUser;
    }
}