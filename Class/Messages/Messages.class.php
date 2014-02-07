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


    class Messages
    {
        protected $message_id;
        protected $author_id;
        protected $message_receiver_id;
        protected $message_receiver_pseudo;
        protected $message_receiver_avatar;
        protected $message_subject;
        protected $message_is_read;
        protected $message_content;
        protected $message_created_at;
        protected $message_updated_at;


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

            return !(empty($this->message_content) || empty($this->message_receiver_id) || empty($this->message_receiver_pseudo) || empty($this->author_id) || empty($this->message_subject));
        }

        



        /* ----------------------------- GETTER AND SITTERS ------------------------------- */


        public function get_message_id() {
        
            return $this->message_id;

        }

        public function set_message_id($id) {

            $this->message_id = (int) $id;
        }


        
        public function get_author_id() {

            return $this->author_id;

        }

        public function set_author_id($id) {

            $this->author_id = (int) $id;

        }

        

        public function get_message_receiver_id() {

            return $this->message_receiver_id;

        }
        
        public function set_message_receiver_id($messageReceiver) {

            $this->message_receiver_id = (int) $messageReceiver;

        }



        public function get_message_receiver_pseudo() {

            return $this->message_receiver_pseudo;

        }


        public function set_message_receiver_pseudo($receiverPseudo) {

            $this->message_receiver_pseudo = $receiverPseudo;

        }



        public function get_message_receiver_avatar() {

            return $this->message_receiver_avatar;

        }


        public function set_message_receiver_avatar($receiverAvatar) {

            $this->message_receiver_avatar = $receiverAvatar;

        }



        public function get_message_subject() {

            return $this->message_subject;

        }
       
        
        public function set_message_subject($messageSub) {

            $this->message_subject = (string) $messageSub;

        }

        

        public function get_message_is_read() {

            return $this->message_is_read;

        }


        public function set_message_is_read($int) {

            $this->message_is_read = (int) $int;
        }

       

        public function get_message_content() {
            
            return $this->message_content;

        }


        public function set_message_content($messageContent) {

            $this->message_content = (string) $messageContent;

        }


        
        public function get_message_created_at() {

            return $this->message_created_at;

        }

        
        public function set_message_created_at($messageCreatedAt) {

            $this->message_created_at = $messageCreatedAt;
        }



        public function get_message_updated_at() {

            return $this->message_updated_at;

        }


        public function set_message_updated_at($messageUpdatedAt) {

            $this->message_updated_at = $messageUpdatedAt;

        }



    }
