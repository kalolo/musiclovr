<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class BaseModel extends CI_Model {

    public function  __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function query($strQuery) {
        $this->db->query($strQuery);
        return $this->db->result_array();
    }

    protected function _getAll($strTable) {
        $query = $this->db->get($strTable, 10);
        return $query->result();
    }
}