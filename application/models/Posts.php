<?php
require_once 'entities/PostEntity.php';

class Posts extends BaseModel {

    protected $table = 'posts';
    
    public function getAll() {
        $arrPosts = array();
        $this->db->select('posts.*, 
            users.id AS user_id,
            users.username AS user_username,
            users.firstname AS user_firstname,
            users.lastname AS user_lastname,
            users.profile_image_id AS user_profile_image_id,
            users.slug AS user_slug');
        $this->db->from('posts');
        $this->db->join('users',
                'posts.user_id = users.id',
                'inner'
        );
        $this->db->order_by('posts.created','DESC');
        $result = $this->db->get();
        if ($result->num_rows > 0) {
            $arrRows = $result->result();
            foreach ($arrRows as $oRow) {
                $arrPosts[] = $this->_getFromDBRecord($oRow);
            }
        }
        return $arrPosts;
    }
    
    public function getByCategory($numCategoryId) {
        $arrPosts = array();
        $this->db->select('posts.*, 
            users.id AS user_id,
            users.username AS user_username,
            users.firstname AS user_firstname,
            users.lastname AS user_lastname,
            users.profile_image_id AS user_profile_image_id,
            users.slug AS user_slug');
        $this->db->from('posts');
        $this->db->join('users',
                'posts.user_id = users.id',
                'inner'
        );
        $this->db->where('posts.category_id', $numCategoryId);
        $this->db->order_by('posts.created','DESC');
        $result = $this->db->get();
        if ($result->num_rows > 0) {
            $arrRows = $result->result();
            foreach ($arrRows as $oRow) {
                $arrPosts[] = $this->_getFromDBRecord($oRow);
            }
        }
        return $arrPosts;
    }

    public function add($numUserId, $strHeadline, $strBody, $numCategoryId, $numSongId) {
        $strSlug = Utils::slugger($strHeadline);
        if ($this->slugExist($strHeadline)) {
            $strSlug .= '-'.date('Y-m-d');
        }
        $this->db->insert('posts', array(
                'headline'    => $strHeadline,
                'body'        => $strBody,
                'user_id'     => $numUserId,
                'category_id' => $numCategoryId,
                'song_id'     => $numSongId,
                'slug'        => $strSlug,
                'created'     => date('Y-m-d H:i:s')
            )
        );
        return $strSlug;
    }
    
    public function getBySlug($strSlug) {
        $oCat = null;
        $this->db->select('posts.*, 
            categories.name AS category_name,
            categories.description AS category_description,
            users.id AS user_id,
            users.username AS user_username,
            users.firstname AS user_firstname,
            users.lastname AS user_lastname,
            users.profile_image_id AS user_profile_image_id,
            users.slug AS user_slug');
        $this->db->from('posts');
        $this->db->join('users',
                'posts.user_id = users.id',
                'inner'
        );
        $this->db->join('categories',
                'categories.id = posts.category_id',
                'inner'
        );
        $this->db->where('posts.slug', $strSlug);
        $result = $this->db->get();
        if ($result->num_rows > 0) {
            $arrRows = $result->result();
            $oCat =  $this->_getFromDBRecord($arrRows[0]);
        }
        return $oCat;
    }
    
    public function slugExist($strSlug) {
        $this->db->select('*');
        $this->db->where('slug', $strSlug);
        $result = $this->db->get('posts');
        return ($result->num_rows > 0);
    }
    
    private function _getFromDBRecord($oRow) {
        $oPost = new PostEntity();
        $oPost->setId($oRow->id);
        $oPost->setHeadline($oRow->headline);
        $oPost->setBody($oRow->body);
        $oPost->setUserId($oRow->user_id);
        $oPost->setSlug($oRow->slug);
        $oPost->setCreated($oRow->created);
        
        if (isset($oRow->category_name)) {
            $oCat = new CategoryEntity();
            $oCat->setName($oRow->category_name);
            $oCat->setDescription($oRow->category_description);
            $oPost->setCategory($oCat);
        }
        
        if (isset($oRow->user_username)) {
            $oUser = new UserEntity();
            $oUser->setUsername($oRow->user_username);
            $oUser->setFirstname($oRow->user_firstname);
            $oUser->setLastname($oRow->user_lastname);
            $oUser->setProfileImageId($oRow->user_profile_image_id);
            $oUser->setSlug($oRow->user_slug);
            $oPost->setUser($oUser);
        }
        return $oPost;
    }

}