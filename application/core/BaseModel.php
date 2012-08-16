<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class BaseModel extends CI_Model {

    public function  __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function query($strQuery) {
        $query = $this->db->query($strQuery);
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return array();
    }

    protected function _getAll($strTable) {
        $query = $this->db->get($strTable);
        return $query->result();
    }
    
    protected function _udpate($strTable, $numRecordId, $arrData) {
        $this->db->where('id', $numRecordId);
        $this->db->update($strTable, $arrData);
    }
    
    protected function _loadModel($strModel) {
        $ci= get_instance();
        $ci->load->model($strModel);
        return $ci->$strModel;
    }
}