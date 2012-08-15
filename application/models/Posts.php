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

    public function add($numUserId, $strHeadline, $strBody, $numCategoryId, $numSongId) {
        $strSlug = Utils::slugger($strHeadline);
        if ($this->slugExist($strHeadline)) {
            $strSlug .= date('Y-m-d');
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
    
    public function getActiveCategory() {
        $oCat = null;
        $arrData = $this->query("SELECT Category.*, CurrentCategory.*
            FROM current_category CurrentCategory
            INNER JOIN categories Category ON Category.id = CurrentCategory.category_id
            WHERE CurrentCategory.ends >= NOW() 
            ORDER BY CurrentCategory.id DESC
            LIMIT 1");
        if (!empty($arrData)) {
            $oCat =  $this->_getFromDBRecord($arrData[0]);
        }
        return $oCat;
    }
    
    public function setActive($catId, $numDays) {
        $strEndDate   = date('Y-m-d', strtotime('+'.$numDays.' days' , strtotime (date('Y-m-d'))));
        $this->db->insert('current_category', array(
                'category_id' => $catId,
                'starts'      => date('Y-m-d'),
                'ends'        => $strEndDate
            )
        );
    }
    
    public function lastActiveCategory() {
        $oCat = null;
        $arrData = $this->query("SELECT Category.*, CurrentCategory.*
            FROM current_category CurrentCategory
            INNER JOIN categories Category ON Category.id = CurrentCategory.category_id
            ORDER BY CurrentCategory.id DESC
            LIMIT 1");
        if (!empty($arrData)) {
            $oCat =  $this->_getFromDBRecord($arrData[0]);
        }
        return $oCat;
    }
    
    private function _getFromDBRecord($oRow) {
        $oPost = new PostEntity();
        $oPost->setId($oRow->id);
        $oPost->setHeadline($oRow->headline);
        $oPost->setBody($oRow->body);
        $oPost->setUserId($oRow->user_id);
        $oPost->setSlug($oRow->slug);
        $oPost->setCreated($oRow->created);
        
        if (isset($oRow->starts)) {
            $oCat->setStarts($oRow->starts);
            $oCat->setEnds($oRow->ends);
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