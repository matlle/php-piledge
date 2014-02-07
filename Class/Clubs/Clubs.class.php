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

  class Clubs
  {
        protected $club_id;
        protected $author_id;
        protected $club_name;
        protected $club_description;
        protected $club_members;
        protected $club_created_at;
        protected $club_updated_at;


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

            return !(empty($this->club_name) || empty($this->club_description));
        }

        
        /* ------------------------------- GETTER AND SITTERS --------------------------- */


        public function get_club_id() {
            return $this->club_id;
        }

        public function set_club_id($id) {
            $this->club_id = (int) $id;
        }


        public function get_author_id() {
            return $this->author_id;
        }

        public function set_author_id($id) {

            $this->author_id = (int) $id;
        }

        
        public function get_club_name() {
            return $this->club_name;
        }

        public function set_club_name($name) {

            $this->club_name = (string) $name;
        }


        public function get_club_description() {
            return $this->club_description;
        }

        public function set_club_description($description) {

            $this->club_description = (string) $description;
        }


        public function get_club_created_at() {

            return $this->club_created_at;
        }
        
        public function set_club_created_at($createdAt) {
            
            $this->club_created_at = $createdAt;
        }



        public function get_club_updated_at() {

            return $this->club_updated_at;
        }

        public function set_club_updated_at($updatedAt) {

            $this->club_updated_at = $updatedAt;
        }




















  }
