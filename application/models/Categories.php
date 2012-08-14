<?php
require_once 'entities/CategoryEntity.php';

class Categories extends BaseModel {

    protected $table = 'categories';
    
    public function getAll() {
        $arrCategories = array();
        $this->db->select('categories.*, 
            users.id AS user_id,
            users.username AS user_username,
            users.firstname AS user_firstname,
            users.lastname AS user_lastname,
            users.profile_image_id AS user_profile_image_id,
            users.slug AS user_slug');
        $this->db->from('categories');
        $this->db->join('users',
                'categories.user_id = users.id',
                'left'
        );
        $this->db->order_by('categories.created','DESC');
        $result = $this->db->get();
        if ($result->num_rows > 0) {
            $arrRows = $result->result();
            foreach ($arrRows as $oRow) {
                $arrCategories[] = $this->_getFromDBRecord($oRow);
            }
        }
        return $arrCategories;
    }

    public function add($numUserId, $strName, $strDescription) {
        $strSlug = Utils::slugger($strName);
        if ($this->slugExist($strSlug)) {
            $strSlug .= date('Y-m-d');
        }
        $this->db->insert('categories', array(
                'name'        => $strName,
                'description' => $strDescription,
                'user_id'     => $numUserId,
                'slug'        => $strSlug,
                'created'     => date('Y-m-d H:i:s')
            )
        );
        return $this->db->insert_id();
    }
    
    public function slugExist($strSlug) {
        $this->db->select('*');
        $this->db->where('slug', $strSlug);
        $result = $this->db->get('categories');
        return ($result->num_rows > 0);
    }
    
    private function _getFromDBRecord($oRow) {
        $oCat = new CategoryEntity();
        $oCat->setId($oRow->id);
        $oCat->setName($oRow->name);
        $oCat->setDescription($oRow->description);
        $oCat->setUserId($oRow->user_id);
        $oCat->setSlug($oRow->slug);
        $oCat->setCreated($oRow->created);
        
        if (isset($oRow->user_username)) {
            $oUser = new UserEntity();
            $oUser->setUsername($oRow->user_username);
            $oUser->setFirstname($oRow->user_firstname);
            $oUser->setLastname($oRow->user_lastname);
            $oUser->setProfileImageId($oRow->user_profile_image_id);
            $oUser->setSlug($oRow->user_slug);
            $oCat->setUser($oUser);
        }
        return $oCat;
    }

}