<?php
require_once 'entities/SongEntity.php';
class songs extends BaseModel {
    
    public function add($strFileName, $strPath) {
        $strSlug = Utils::slugger($strFileName);
        if ($this->slugExist($strSlug)) {
            $strSlug .= '-'.date('Y-m-d');
        }
        $this->db->insert('songs', array(
                'filename' => $strFileName,
                'path'     => $strPath,
                'slug'     => $strSlug,
                'created'  => date('Y-m-d H:i:s')
            )
        );
        return $this->db->insert_id();
    }
    
    public function getById($numId) {
        $oSong = null;
        $this->db->select('*');
        $this->db->where('id', $numId);
        $result = $this->db->get('songs');
        if ($result->num_rows > 0) {
            $arrRows = $result->result();
            $oSong   = $this->_getFromDBRecord($arrRows[0]);
        }
        return $oSong;
    }
    
    public function slugExist($strSlug) {
        $this->db->select('*');
        $this->db->where('slug', $strSlug);
        $result = $this->db->get('songs');
        return ($result->num_rows > 0);
    }
    
    private function _getFromDBRecord($row) {
        $oSong = new SongEntity();
        $oSong->setId($row->id);
        $oSong->setFileName($row->filename);
        $oSong->setFullPath($row->path);
        $oSong->setSlug($row->slug);
        $oSong->setCreated($row->created);
        return $oSong;
    }
}
