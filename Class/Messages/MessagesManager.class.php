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


    class MessagesManager
    {
        protected $db;


        public function __construct(PDO $db) {

            $this->db = $db;

        }


        public function send_message(Messages $message) {

            $sql = 'INSERT INTO messages
                        ( author_id,
                          message_receiver_id,
                          message_receiver_pseudo,
                          message_receiver_avatar,
                          message_subject,
                          message_content,
                          message_created_at)
                     VALUES
                         ( :author,
                           :receiver_id,
                           :receiver_pseudo,
                           :receiver_avatar,
                           :subject,
                           :content,
                           NOW())
                   ';


             $query = $this->db->prepare($sql);
             $query->execute(array(
                                'author' => $message->get_author_id(),
                                'receiver_id' =>  $message->get_message_receiver_id(),
                                'receiver_pseudo' => $message->get_message_receiver_pseudo(),
                                'receiver_avatar' => $message->get_message_receiver_avatar(),
                                'subject' => $message->get_message_subject(),
                                'content' => $message->get_message_content()
                                )) or die(print_r($query->errorInfo()));

              $query->closeCursor();
        }
        
        

        public function get_msg_by_id($mid) {

            $sql = 'SELECT 
                    m.*,
                    a.*,
                    av.avatar_100x100
                    FROM messages m
                    INNER JOIN authors a USING(author_id)
                    LEFT JOIN avatars av USING(author_id)
                    WHERE message_id = :mid
                   ';


            $query = $this->db->prepare($sql);
            $query->bindValue('mid', $mid, PDO::PARAM_INT);
            $query->execute() or die(print_r($query->errorInfo()));

            $data = $query->fetch();

            return $data;

        }

        

        
        public function get_msg_inbox($receiver_id) {

            $sql = 'SELECT 
                    m.*,
                    a.*,
                    av.avatar_50x50
                    FROM messages m
                    INNER JOIN  authors a USING(author_id)
                    LEFT JOIN avatars av USING(author_id)
                    WHERE message_receiver_id = :receiver_id
                    ORDER BY message_created_at DESC
                   ';


            $query = $this->db->prepare($sql);
            $query->bindValue(':receiver_id', $receiver_id, PDO::PARAM_INT);
            $query->execute() or die(print_r($query->errorInfo()));

            $data = $query->fetchAll();
            
            $query->closeCursor();

             
            return $data;

        }

        

        public function get_msg_sent($author_id) {

            $sql = 'SELECT 
                    m.*,
                    a.*
                    FROM messages m
                    INNER JOIN authors a USING(author_id)
                    WHERE author_id = :author_id
                    ORDER BY message_created_at DESC
                   ';
            
            $query = $this->db->prepare($sql);
            $query->bindValue(':author_id', $author_id, PDO::PARAM_INT);
            $query->execute() or die(print_r($query->errorInfo()));

            $data = $query->fetchAll();

            $query->closeCursor();

            
            return $data;

        }


        public function get_number_msg_unread($receiver_id) {
        
            $sql = "SELECT
                    COUNT(message_is_read)
                    FROM messages
                    WHERE message_is_read = 'f' AND message_receiver_id = :receiver_id
                   ";
            $query = $this->db->prepare($sql);
            $query->bindValue(':receiver_id', $receiver_id, PDO::PARAM_INT);
            $query->execute() or die(print_r($query->errorInfo()));

            
            $data = $query->fetch();

            $count = count($data);

            $query->closeCursor();

            return $data;
           

        }
        
        

        
        public function set_msg_like_read($mid, $receiver_id) {

            $sql = "UPDATE messages
                    SET message_is_read = 't'
                    WHERE message_id = :mid AND message_receiver_id = :receiver_id
                   ";
            

            $query = $this->db->prepare($sql);
            $query->bindValue(':mid', $mid, PDO::PARAM_INT);
            $query->bindValue(':receiver_id', $receiver_id, PDO::PARAM_INT);
            $query->execute() or die(print_r($query->errorInfo()));


            $query->closeCursor();


        }




        


    }
