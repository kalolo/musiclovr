<?php
require_once 'entities/UserEntity.php';

class Users extends BaseModel {

    protected $table = 'users';

    public function getByCredentials($strUserName, $strPassword) {
        $arrUser = null;
        if (!empty($strUserName) && !empty($strPassword)) {
            $this->db->select('*');
            $this->db->where('username', $strUserName);
            $this->db->where('password', $strPassword);
            $result = $this->db->get('users');
            if ($result->num_rows > 0) {
                $arrUser = $result->result();
                $arrUser = $arrUser[0];
            }
        }
        return $arrUser;
    }

    public function getAll() {
        return $this->_getAll($this->table);
    }
}