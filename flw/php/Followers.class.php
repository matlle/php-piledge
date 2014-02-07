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

    class Followers
    {
        protected $user_follower_id;
        protected $author_id;
        protected $follower_id;
        protected $follower_created_at;

        
        public function __construct(array $values) {

            if (!empty($values)) {
                $this->hydrate($values);
            }
        }


        public function hydrate($data) {

            foreach ($data as $key => $value) {

                $method = "set_" . "$key";

                if (method_exists($this, $method)) {

                    $this->$method($value);
                }
            }
        }


        public function isValid() {

            return !(empty($this->author_id) || empty($this->follower_id));
        }


        /* ----------------------- GETTER AND SETTERS ---------------------------- */
        
        public function get_user_follower_id() {

            return $this->user_follower_id;

        }

        public function set_user_follower_id($id) {

            $this->user_follower_id = (int) $id;
        }



        public function get_author_id() {

            return $this->author_id;
        }


        public function set_author_id($id) {

            $this->author_id = (int) $id;
        }




        public function get_follower_id() {

            return $this->follower_id;
        }

        public function set_follower_id($id) {

            $this->follower_id = (int) $id;
        }



        public function get_follower_created_at() {

            return $this->follower_created_at;
        }

        public function set_follower_created_at($follower_created_at) {

            $this->follower_created_at = $follower_created_at;
        }


































    }
