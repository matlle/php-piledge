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

    class Comments
    {
        protected $comment_id;
        protected $file_id;
        protected $author_id;
        protected $comment_content;
        protected $comment_created_at;
        protected $comment_updated_at;

        

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

            return !(empty($this->comment_content) || empty($this->file_id));
        }


        public function isNew() {
            
            return empty($this->comment_id);

        }

        
        /* -------------------------- GETTER AND SETTERS ------------------------ */

        public function get_comment_id() {

             return $this->commen_id;

        }
        

        public function set_comment_id($id) {

            $this->comment_id = (int) $id;
        }


        public function get_file_id() {

            return $this->file_id;

        }


        public function set_file_id($id) {

            $this->file_id = (int) $id;

        }


        public function get_author_id() {

            return $this->author_id;

        }


        public function set_author_id($id) {

            $this->author_id = (int) $id; 

        }


        public function get_comment_content() {

            return $this->comment_content;

        }


        public function set_comment_content($commentContent) {

            $this->comment_content = $commentContent;

        }
        


        public function get_comment_created_at() {

            return $this->comment_created_at;

        }

        
        public function set_comment_created_at($commentCreatedAt) {

             $this->comment_created_at = $commentCreatedAt;

        }


        public function get_comment_updated_at() {

             return $this->comment_created_at;

        }


        public function set_comment_updated_at($commentUpdatedAt) {

            $this->comment_updated_at = $commentUpdatedAt;

        }


    }
