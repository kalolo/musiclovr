<?php
require_once 'entities/PostEntity.php';
require_once 'entities/CommentEntity.php';

class Posts extends BaseModel {

    protected $table = 'posts';

    public function update($numPostId, $arrData) {
         $this->db->where('id', $numPostId);
         $this->db->update('posts', $arrData);
    }
    
    public function getAll() {
        $arrPosts = array();
        $this->db->select('posts.*, 
            users.id AS user_id,
            users.username AS user_username,
            users.firstname AS user_firstname,
            users.lastname AS user_lastname,
            users.profile_image_id AS user_profile_image_id,
            users.profile_image_url AS user_profile_image_url,
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
            users.profile_image_url AS user_profile_image_url,
            users.slug AS user_slug,
            count(comments.id) AS total_comments');
        $this->db->from('posts');
        $this->db->join('users',
                'posts.user_id = users.id',
                'inner'
        );
        $this->db->join('comments',
                'comments.post_id = posts.id',
                'left'
        );
        $this->db->where('posts.category_id', $numCategoryId);
        $this->db->group_by('posts.id');
        $this->db->order_by('posts.created','DESC');
        $result = $this->db->get();
        if ($result->num_rows > 0) {
            $arrRows = $result->result();
            $SongsModel = $this->_loadModel('songs');
            foreach ($arrRows as $oRow) {
                $oPost = $this->_getFromDBRecord($oRow);
                $oSong = $SongsModel->getById($oPost->getSongId());
                if ($oSong != null) {
                    $oPost->setSong($oSong);
                }
                $arrPosts[] = $oPost;
            }
        }
        return $arrPosts;
    }

    public function add($numUserId, $strHeadline, $strBody, $numCategoryId, $numSongId, $date = false) {
        $strSlug = Utils::slugger($strHeadline);
        if ($this->slugExist($strSlug)) {
            $strSlug .= '-'.date('Y-m-d');
        }
        $date    = ($date)
                 ? $date
                 : date('Y-m-d H:i:s');
        $this->db->insert('posts', array(
                'headline'    => $strHeadline,
                'body'        => $strBody,
                'user_id'     => $numUserId,
                'category_id' => $numCategoryId,
                'song_id'     => $numSongId,
                'slug'        => $strSlug,
                'created'     => $date
            )
        );
        return $strSlug;
    }
    
    public function addComment($numPostId, $numUserId, $strBody, $date = false) {
        $strBody = Utils::parseComment($strBody);
        $date    = ($date)
                 ? $date
                 : date('Y-m-d H:i:s');
        $this->db->insert('comments', array(
                'post_id' => $numPostId,
                'body'    => $strBody,
                'user_id' => $numUserId,
                'created' => $date
            )
        );
    }
    
    public function getById($numId) {
        $oPost = null;
        $this->db->select('posts.*, 
            categories.name AS category_name,
            categories.description AS category_description,
            users.id AS user_id,
            users.username AS user_username,
            users.firstname AS user_firstname,
            users.lastname AS user_lastname,
            users.profile_image_id AS user_profile_image_id,
            users.profile_image_url AS user_profile_image_url,
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
        $this->db->where('posts.id', $numId);
        $result = $this->db->get();
        if ($result->num_rows > 0) {
            $arrRows = $result->result();
            $oPost   = $this->_getFromDBRecord($arrRows[0]);
            $oPost->setComments(
                $this->getComments($oPost->getId())
            );
        }
        return $oPost;
    }
    
    public function getBySlug($strSlug) {
        $oPost = null;
        $this->db->select('posts.*, 
            categories.name AS category_name,
            categories.description AS category_description,
            users.id AS user_id,
            users.username AS user_username,
            users.firstname AS user_firstname,
            users.lastname AS user_lastname,
            users.profile_image_id AS user_profile_image_id,
            users.profile_image_url AS user_profile_image_url,
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
            $oPost   = $this->_getFromDBRecord($arrRows[0]);
            $oPost->setComments(
                $this->getComments($oPost->getId())
            );
            $SongsModel = $this->_loadModel('songs');
            $oSong = $SongsModel->getById($oPost->getSongId());
            if ($oSong != null) {
                $oPost->setSong($oSong);
            }
        }
        return $oPost;
    }
    
    public function getComments($numPostId) {
        $arrComments = array();
        $this->db->select('comments.*, 
            users.id AS user_id,
            users.username AS user_username,
            users.firstname AS user_firstname,
            users.lastname AS user_lastname,
            users.profile_image_id AS user_profile_image_id,
            users.profile_image_url AS user_profile_image_url,
            users.slug AS user_slug');
        $this->db->from('comments');
        $this->db->join('users',
                'comments.user_id = users.id',
                'inner'
        );
        $this->db->where('comments.post_id', $numPostId);
        $this->db->order_by('comments.created','ASC');
        $result = $this->db->get();
        if ($result->num_rows > 0) {
            $arrRows = $result->result();
            foreach ($arrRows as $row) {
                $oComment = new CommentEntity();
                if (isset($row->user_username)) {
                    $oUser = new UserEntity();
                    $oUser->setUsername($row->user_username);
                    $oUser->setFirstname($row->user_firstname);
                    $oUser->setLastname($row->user_lastname);
                    $oUser->setProfileImageId($row->user_profile_image_id);
                    $oUser->setSlug($row->user_slug);
                    $oUser->setProfileImageUrl($row->user_profile_image_url);
                    $oComment->setUser($oUser);
                }
                
                $oComment->setId($row->id);
                $oComment->setBody($row->body);
                $oComment->setCreated($row->created);
                $arrComments[] = $oComment;
            }
        }
        return $arrComments;
    }
    
    public function slugExist($strSlug) {
        $this->db->select('*');
        $this->db->from('posts');
        $this->db->where('slug', $strSlug);
        $result = $this->db->get();
        return ($result->num_rows > 0);
    }
    
    public function isSystemPostExist($numCatId, $numSystemUserId) {
        $this->db->select('posts.id');
        $this->db->from('posts');
        $this->db->where('category_id', $numCatId);
        $this->db->where('user_id', $numSystemUserId);
        $result = $this->db->get();
        
        if ($result->num_rows > 0)  {
            $arrRecord = $result->result();
            return $arrRecord[0]->id;
        }
        return false;
    }
    
    private function _getFromDBRecord($oRow) {
        $oPost = new PostEntity();
        $oPost->setId($oRow->id);
        $oPost->setHeadline($oRow->headline);
        $oPost->setBody($oRow->body);
        $oPost->setUserId($oRow->user_id);
        $oPost->setSlug($oRow->slug);
        $oPost->setCreated($oRow->created);
        $oPost->setSongId($oRow->song_id);
        $oPost->setCategoryId($oRow->category_id);
        if (isset($oRow->category_name)) {
            $oCat = new CategoryEntity();
            $oCat->setName($oRow->category_name);
            $oCat->setDescription($oRow->category_description);
            $oPost->setCategory($oCat);
        }
        
        if (isset($oRow->total_comments)) {
            $oPost->setTotalComments($oRow->total_comments);
        }
        
        if (isset($oRow->user_username)) {
            $oUser = new UserEntity();
            $oUser->setUsername($oRow->user_username);
            $oUser->setFirstname($oRow->user_firstname);
            $oUser->setLastname($oRow->user_lastname);
            $oUser->setProfileImageId($oRow->user_profile_image_id);
            $oUser->setSlug($oRow->user_slug);
            $oUser->setProfileImageUrl($oRow->user_profile_image_url);
            $oPost->setUser($oUser);
        }
        return $oPost;
    }

}
