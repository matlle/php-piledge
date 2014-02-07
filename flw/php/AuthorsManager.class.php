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

    class AuthorsManager
    {
        protected $db;


        public function __construct(PDO $db) {

            $this->db = $db;

        }

        


        public function connect_author(Authors $author) {

            if ($author->isValid()) {

                $author->isNew() ? $this->signup($author) : $this->login($author);

            } else {

                throw new RuntimeException('Author need to be valid for connect');

            }
        }

        
        
        protected function signup(Authors $author) {
        
            $sql = 'INSERT INTO authors
                       ( author_pseudo,
                         author_password,
                         author_email,
                         author_hash,
                         author_join_date,
                         author_ip)
                     VALUES
                       ( :pseudo,
                         :password,
                         :email,
                         :hash,
                         NOW(),
                         :ip)
                    ';

             $query = $this->db->prepare($sql);
            
             $query->execute(array(
                                 'pseudo' => $author->get_author_pseudo(),
                                 'password' => $author->get_author_password(),
                                 'email' => $author->get_author_email(),
                                 'hash' => $author->get_author_hash(),
                                 'ip' => $author->get_author_ip()
                                     )) or die(print_r($query->errorInfo()));

            // mail($author->get_author_email(), 'Please active your account',
            // "Hello " . $author->get_author_pseudo(). ",\r\nThank you for registering with us. Please visit the link below so we can activate your account:\r\n\r\nhttp://www.example.com/check.php?email=" . $author->get_author_email() . "&email_code=" . $author->get_author_hash() . "\r\n\r\n-- Example team");

        }
        

  
        public function pseudo_exists($pseudo) {
            
            $sql = "SELECT COUNT('auhtor_id')
                    FROM authors
                    WHERE author_pseudo = :pseudo
                    ";

	        $query = $this->db->prepare($sql);
 
	        try{
 
		        $query->execute(array('pseudo' => $pseudo));
		        $rows = $query->fetchColumn();
 
		        if($rows == 1){

			        return true;
		        
                } else {

			        return false;
		        }

              
 
	        } catch (PDOException $e){

		          die($e->getMessage());
	        }

            $query->closeCursor();
 
         } 


        public function passwords_match($pass1, $pass2) {

           return (trim($pass1) == trim($pass2)) ? true : false;

        }

 
        public function email_exists($email) {
            
            $sql = "SELECT COUNT('author_id')
                    FROM authors
                    WHERE author_email = :email
                   ";

	        $query = $this->db->prepare($sql);
 
	        try {
 
		        $query->execute(array('email' => $email));

		        $rows = $query->fetchColumn();
 
		        if($rows == 1){
			        return true;
		        
                }else{
			         return false;
		        }
 
	         } catch (PDOException $e){
		           die($e->getMessage());
	         }  

             $query->closeCursor();
 
       }  
       
       
        public function activate($email, $email_code) {
		
		$query = $this->db->prepare("SELECT COUNT(`id`) FROM `users` WHERE `email` = ? AND `email_code` = ? AND `confirmed` = ?");
 
		$query->bindValue(1, $email);
		$query->bindValue(2, $email_code);
		$query->bindValue(3, 0);
 
		try{
 
			$query->execute();
			$rows = $query->fetchColumn();
 
			if($rows == 1){
				
				$query_2 = $this->db->prepare("UPDATE `users` SET `confirmed` = ? WHERE `email` = ?");
 
				$query_2->bindValue(1, 1);
				$query_2->bindValue(2, $email);				
 
				$query_2->execute();
				return true;
 
			}else{
				return false;
			}
 
		} catch(PDOException $e){
			die($e->getMessage());
		}
	}       

       
        public function update_author_avatar($author_id, $avatar) {
        
            $sql = 'UPDATE authors
                    SET author_avatar = :avatar
                    WHERE author_id = :author_id
                   ';

            $query = $this->db->prepare($sql);
            $query->bindValue(':avatar', $avatar, PDO::PARAM_INT);
            $query->bindValue(':author_id', $author_id, PDO::PARAM_INT);
            $query->execute() or die(print_r($query->errorInfo()));

            $query->closeCursor();


        }


        public function update_avatar($xxsmall, $xsmall, $small, $xlarge, $xxlarge, $author_id) {
           
          $sqls = 'SELECT * 
                   FROM avatars
                   WHERE author_id = :author_id
                   ';

          $querys = $this->db->prepare($sqls);
          $querys->bindValue(':author_id', $author_id, PDO::PARAM_INT);
          $querys->execute() or die(print_r($querys->errorInfo()));
          
          $avatar = $querys->fetch();

          foreach ($avatar as $f) {
              @unlink($f);
          }
 

          $querys->closeCursor();


           $sqld = 'DELETE FROM avatars
                    WHERE author_id = :author_id
                   ';

           $queryd = $this->db->prepare($sqld);
           $queryd->bindValue(':author_id', $author_id, PDO::PARAM_INT);
           $queryd->execute() or die(print_r($queryd->errorInfo()));

           $queryd->closeCursor();


            $sqli = 'INSERT INTO avatars
                        ( avatar_22x22,
                          avatar_30x30,
                          avatar_50x50,
                          avatar_100x100,
                          avatar_200x200,
                          avatar_created_at,
                          author_id)
                     VALUES
                        ( :xxsmall,
                          :xsmall,
                          :small,
                          :xlarge,
                          :xxlarge,
                          NOW(),
                          :author_id
                         )                  
                    ';

            $queryi = $this->db->prepare($sqli);
            $queryi->bindValue(':xxsmall', $xxsmall, PDO::PARAM_STR);
            $queryi->bindValue(':xsmall', $xsmall, PDO::PARAM_STR);
            $queryi->bindValue(':small', $small, PDO::PARAM_STR);
            $queryi->bindValue(':xlarge', $xlarge, PDO::PARAM_STR);
            $queryi->bindValue(':xxlarge', $xxlarge, PDO::PARAM_STR);
            $queryi->bindValue(':author_id', $author_id, PDO::PARAM_INT);
  
            $queryi->execute() or die(print_r($queryi->errorInfo()));

            $queryi->closeCursor();

        }




        public function delete_author($id) {
        }

        
        public function login($email, $password) {

            $sql = 'SELECT  author_id, author_password
                    FROM authors
                    WHERE author_email = :email
                   ';
		    
            $query = $this->db->prepare($sql);
		    $query->execute(array('email' => $email)) or die(print_r($query->errorInfo()));

		    $data 				= $query->fetch();
		    $stored_password 	= $data['author_password'];
		    $id 				= $data['author_id'];
		
		#hashing the supplied password and comparing it with the stored hashed password.
		    if($stored_password === hash('sha512', $password)){
			    return $id;	
		    }else{
			    return false;	
		    }
 
	    

        }
        

                
        public function logged_in () {

            return (isset($_SESSION['aid'])) ? true : false;

        }
        
        
        public function logged_in_protected() {

            if ($this->logged_in() === true ) {
                header('Location: index.php');
                exit();
            }
        }



        public function logged_out_protected() {

            if ($this->logged_in() === false) {
                header('Location: login.php');
                exit();
            }
        }


        public function get_session_id() {

            if ($this->logged_in() === true) {

                $session_id = $_SESSION['aid'];

                return $session_id;
            }
        }



        public function get_author_pseudo($author_id) {

            $sql = 'SELECT author_pseudo
                    FROM authors
                    WHERE author_id = :author_id
                   ';

            
            $query = $this->db->prepare($sql);
            $query->bindValue('author_id', $author_id, PDO::PARAM_INT);
            $query->execute() or die(print_r($query->errorInfo()));

            $data = $query->fetch();

            $pseudo = $data['author_pseudo'];

            $query->closeCursor();

            
            return $pseudo;

        }
        


        public function author_data($id) {
        
             $sql = 'SELECT 
                     a.*,
                     av.*
                     FROM authors a 
                     LEFT JOIN avatars av USING(author_id)
                     WHERE author_id = :id
                    ';


                $query = $this->db->prepare($sql);
                $query->execute(array('id' => $id)) or die(print_r($query->errorInfo()));

                return $query->fetch();
        }




        public function receiver_data($pseudo) {

            $sql = 'SELECT 
                    a.*,
                    av.avatar_200x200,
                    av.avatar_100x100
                    FROM authors a
                    LEFT JOIN avatars av USING(author_id)
                    WHERE author_pseudo = :pseudo;
                   ';
            
            $query = $this->db->prepare($sql);
            $query->bindValue(':pseudo', $pseudo, PDO::PARAM_STR);
            $query->execute() or die(print_r($query->errorInfo()));

            $data = $query->fetch();

            $query->closeCursor();

            return $data;
        }

        


        public function email_confirmed($username) {
 
	$query = $this->db->prepare("SELECT COUNT(`id`) FROM `users` WHERE `username`= ? AND `confirmed` = ?");
	$query->bindValue(1, $username);
	$query->bindValue(2, 1);
	
	try{
		
		$query->execute();
		$rows = $query->fetchColumn();
 
		if($rows == 1){
			return true;
		}else{
			return false;
		}
 
	} catch(PDOException $e){
		die($e->getMessage());
	}
 
}
           

        public function logout() {
        
            session_start();
            session_destroy();
            header('Location: index.php');

        }


        public function notification($id) {
        }
        


        public function send_mail(Author $autor) {
        }
        


        
        public function get_author_id($pseudo) {

            $sql = 'SELECT author_id
                    FROM authors
                    WHERE author_pseudo = :pseudo
                   ';


            $query = $this->db->prepare($sql);
            $query->bindValue(':pseudo', $pseudo, PDO::PARAM_STR);
            $query->execute() or die(print_r($query->errorInfo()));

            $data = $query->fetch();

            $id = $data['author_id'];

            $query->closeCursor();

            return $id;

        }
        
        
        
        public function get_author_avatar($pseudo) {
            
            $author_id = $this->get_author_id($pseudo);

            $sql = 'SELECT avatar_100x100
                    FROM avatars
                    WHERE author_id = :author_id
                   ';

            $query = $this->db->prepare($sql);
            $query->bindValue(':author_id', $author_id, PDO::PARAM_INT);
            $query->execute() or die(print_r($query->errorInfo()));

            $data = $query->fetch();

            $avatar = $data['avatar_100x100'];

            $query->closeCursor();

            return $avatar;

        }
          
        

        
        public function get_profile($aid) {
        }





        public function get_all_authors() {
        }









    }
