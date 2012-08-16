<?php
class SongEntity {
    
    private $_numId;
    private $_strFileName;
    private $_strFullPath;
    private $_strSlug;
    private $_strCreated;
    
    public function setId($val) {
        $this->_numId = $val;
    }
    
    public function getId() {
        return $this->_numId;
    }
    
    public function setFileName($val) {
        $this->_strFileName = $val;
    }
    
    public function getFileName() {
        return $this->_strFileName;
    }
    
    public function setFullPath($val) {
        $this->_strFullPath = $val;
    }
    
    public function getFullPath() {
        return $this->_strFullPath;
    }
    
    public function setSlug($val) {
        $this->_strSlug = $val;
    }
    
    public function getSlug() {
        return $this->_strSlug;
    }
    
    public function setCreated($val) {
        $this->_strCreated = $val;
    }
    
    public function getCreated() {
        return $this->_strCreated;
    }
}
