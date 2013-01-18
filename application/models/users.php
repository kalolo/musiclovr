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
            $this->db->where('role_id IN (1,2)');
            $result = $this->db->get('users');
            if ($result->num_rows > 0) {
                $arrUser = $result->result();
                return $arrUser[0];
                #return $this->_buildFromResultSet($arrUser[0]);
            }
        }
        return $oUser;
    }
    
    public function getByUserName($strUserName) {
        $oUser = null;
        if (!empty($strUserName)) {
            $this->db->select('*');
            $this->db->where('username', $strUserName);
            $result = $this->db->get('users');
            if ($result->num_rows > 0) {
                $arrUser = $result->result();
                return $this->_buildFromResultSet($arrUser[0]);
            }
        }
        return $oUser;
    }
    
    public function getByFirstName($name) {
        $oUser = null;
        if (!empty($name)) {
            $this->db->select('*');
            $this->db->where('firstname', $name);
            $result = $this->db->get('users');
            if ($result->num_rows > 0) {
                $arrUser = $result->result();
                return $this->_buildFromResultSet($arrUser[0]);
            }
        }
        return $oUser;
    }

    public function getAll() {
        $arrUsers = array();
        $arrData  = $this->_getAll($this->table);
        foreach ($arrData as $row) {
            $arrUsers[] = $this->_buildFromResultSet($row);
        }
        return $arrUsers;
    }
    
    public function getSystemUser() {
        $this->db->select('*');
        $this->db->where('role_id', ROLE_SYSTEM);
        $result = $this->db->get('users');
        if ($result->num_rows > 0) {
            $arrUser = $result->result();
            return $this->_buildFromResultSet($arrUser[0]);
        }
        return null;
    }
    
    public function getById($numUserId) {
        $this->db->select('*');
        $this->db->where('id', $numUserId);
        $result = $this->db->get('users');
        if ($result->num_rows > 0) {
            $arrUser = $result->result();
            return $this->_buildFromResultSet($arrUser[0]);
        }
        return null;
    }
    
    public function getBySlug($strSlug) {
        $this->db->select('*');
        $this->db->where('slug', $strSlug);
        $result = $this->db->get('users');
        if ($result->num_rows > 0) {
            $arrUser = $result->result();
            return $this->_buildFromResultSet($arrUser[0]);
        }
        return null;
    }
    
    public function udpateUserSlug($numUserId) {
        $oUser = $this->getById($numUserId);
        if ($oUser != null) {
            $strSlug = Utils::slugger($oUser->getFullName());
            if ($this->slugExist($strSlug)) {
                $strSlug .= '-' . date('Y-m-d');
            }
            $this->db->where('id', $numUserId);
            $this->db->update('users', array(
                'slug' => $strSlug,
            )
            );
        }
    }
    
    public function slugExist($strSlug) {
        $this->db->select('*');
        $this->db->where('slug', $strSlug);
        $result = $this->db->get('posts');
        return ($result->num_rows > 0);
    }
    
    public function update($userId, $arrData) {
        $this->_udpate('users', $userId, $arrData);
    }
   
    public function getEmails() {
        $arrEmails = array();
        $this->db->select('*');
        $this->db->where('role_id != ', ROLE_SYSTEM);
        $result = $this->db->get('users');
        if ($result->num_rows > 0) {
             $arrUser = $result->result();
             $oUser   = $this->_buildFromResultSet($arrUser[0]);
             $arrEmails[] = $oUser->getFullName().' <'.$oUser->getUsername().'>';
        }
        return $arrEmails;
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
            $oUser->setProfileImageUrl($resultSet->profile_image_url);
            $oUser->setTwitterHandler($resultSet->twitter_handler);
        }
        return $oUser;
    }
}