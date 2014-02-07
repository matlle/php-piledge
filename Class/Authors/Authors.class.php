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


    class Authors
    {

        protected $author_id;
        protected $author_pseudo;
        protected $auhor_password;
        protected $author_email;
        protected $author_ip;
        protected $author_hash;
        protected $author_active;
        protected $author_join_date;



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

            return !(empty($this->author_pseudo) || empty($this->author_password) || empty($this->author_email) || empty($this->author_ip) || empty($this->author_hash));

        }

        

        public function isNew() {

             return empty($this->author_id);

        }

       
       /* ------------------------- GETTERS AND SETTERS ------------------------- */

        
        public function get_author_id() {

            return $this->author_id;
        }
        
        
        public function set_author_id($id) {

             $this->author_id = (int) $id;

        }


        public function get_author_pseudo() {

            return $this->author_pseudo;

        }


        public function set_author_pseudo($authorPseudo) {

            $this->author_pseudo = trim($authorPseudo);

        }

        
        public function get_author_password() {

            return $this->author_password;

        }


        public function set_author_password($authorPassword) {
            
            $authorPassword = trim($authorPassword);

            $pass_crypt = hash('sha512', $authorPassword);

            $this->author_password = $pass_crypt;

        }



        public function get_author_email() {

            return $this->author_email;

        }

        
        public function set_author_email($authorEmail) {
             
             $this->author_email = $authorEmail;

        }

        

        public function get_author_ip() {

            $this->author_ip;

        }
        
        
        public function set_author_ip($authorIp) {
            
            $this->author_ip = $authorIp;

        }


        public function get_author_hash() {

            return $this->author_hash;

        }


        public function set_author_hash($authorHash) {

             $this->author_hash = $authorHash;

        }


        public function get_author_active() {

             return $this->author_active;

        }

        

        public function set_author_active($authorActive) {

             $this->author_active = $authorActive;

        }


        
        public function get_author_join_date() {

             return $this->author_join_date;

        }



        public function set_author_join_date($authorJoinDate) {

             $this->author_join_date = $authorJoinDate;

        }



    }
