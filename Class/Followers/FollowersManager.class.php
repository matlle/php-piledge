<?php

    /*
	@@ -=::MATLLE::=-
-----------------------------------------------------------------------------	
	# author: @matlle
	# email: paso.175@gmail.com
	# mobile: (225) 41870768
-----------------------------------------------------------------------------
	@@ Simple is better than complex.
*/    


    class FollowersManager extends AuthorsManager
    {
        protected $db;


        public function __construct(PDO $db) {
        
            $this->db = $db;

        }


        
        public function unfollow($auid, $usid) {

            $sql = 'DELETE FROM user_followers
                    WHERE author_id = :aid AND follower_id = :foid
                   ';

            $query = $this->db->prepare($sql);
            $query->bindValue(':aid', $auid, PDO::PARAM_INT);
            $query->bindValue(':foid', $usid, PDO::PARAM_INT);
            $query->execute() or die(print_r($query->errorInfo()));

            $query->closeCursor();

        }

        
        
        public function is_follower($aid, $user_id) {

            $sql = "SELECT COUNT('user_follower_id') 
                    FROM user_followers
                    WHERE author_id = :aid AND follower_id = :user_id
                   ";

            $query = $this->db->prepare($sql);
            $query->bindValue(':user_id', $user_id, PDO::PARAM_INT);
            $query->bindValue(':aid', $aid, PDO::PARAM_INT);
            $query->execute() or die(print_r($query->errorInfo()));
            
            $row = $query->fetchColumn();

            $query->closeCursor();

            if ($row == 1) {
                return true;
            } else {
                return false;
            }

        }


        public function add_follower(Followers $follower) {

            $sql = 'INSERT INTO user_followers
                        ( author_id,
                          follower_id,
                          follower_created_at
                        )
                    VALUES
                        ( :author_id,
                          :follower_id,
                          NOW())
                    ';

            $query = $this->db->prepare($sql);
            $query->bindValue(':author_id', $follower->get_author_id(), PDO::PARAM_INT);
            $query->bindValue(':follower_id', $follower->get_follower_id(), PDO::PARAM_INT);
            $query->execute() or die(print_r($query->errorInfo()));

            $query->closeCursor();
        }


        
        public function count_following($author_id) {

            $sql = "SELECT COUNT('user_follower_id')
                    FROM user_followers
                    WHERE author_id = :auid
                   ";
            $query = $this->db->prepare($sql);
            $query->bindValue(':auid', $author_id, PDO::PARAM_INT);
            $query->execute() or die(print_r($query->errorInfo()));

            $following = $query->fetchColumn();

            $query->closeCursor();

            return $following;
        }
        

        public function count_followers($author_id) {

            $sql = "SELECT COUNT('user_following_id')
                    FROM user_followers
                    WHERE follower_id = :auid
                   ";

            $query = $this->db->prepare($sql);
            $query->bindValue(':auid', $author_id, PDO::PARAM_INT);
            $query->execute() or die(print_r($query->errorInfo()));

            $followers = $query->fetchColumn();

            $query->closeCursor();

            return $followers;
        }



        public function get_followings($user_id) {

            $sql = 'SELECT follower_id
                    FROM user_followers
                    WHERE author_id = :user_id
                   ';

            $query = $this->db->prepare($sql);
            $query->bindValue(':user_id', $user_id, PDO::PARAM_INT);
            $query->execute() or die(print_r($query->errorInfo()));

            $followings = array();
            
            while ($row = $query->fetch()) {
                $followings[] = $this->author_data($row['follower_id']);
            }

            $query->closeCursor();

            return $followings;
        }
        

        public function get_followers($user_id) {

            $sql = 'SELECT author_id
                    FROM user_followers
                    WHERE follower_id = :user_id
                   ';

            $query = $this->db->prepare($sql);
            $query->bindValue(':user_id', $user_id, PDO::PARAM_INT);
            $query->execute() or die(print_r($query->errorInfo()));

            $followers = array();

            while ($row = $query->fetch()) {
                $followers[] = $this->author_data($row['author_id']);
            }

            $query->closeCursor();

            return $followers;

        }

































    }
