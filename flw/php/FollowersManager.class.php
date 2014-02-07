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


    class FollowersManager
    {
        protected $db;


        public function __construct(PDO $db) {
        
            $this->db = $db;

        }

        
        public function is_follower() {
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


        public function remove_follower() {
        }


        public function count_follower() {
        }


    }
