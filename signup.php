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

  require_once 'Helper/autoload.inc.php';
  require_once 'initwig.php'; 
  
  
  $db = DBFactory::PgDAO();
  $manager = new AuthorsManager($db);
  $errors = array();

  $manager->logged_in_protected();

  $email = '';
  $pseudo = '';
  
  if (!isset($_SESSION['aid']) && isset($_POST['submitr'])) {

    if (empty($_POST['author_pseudo']) || empty($_POST['author_email']) || empty($_POST['author_password']) || empty($_POST['author_password_confirmation'])) {
    
       $errors[] = 'All fields are required';
    
    } else {
        
        $email = $_POST['author_email'];
        $pseudo = $_POST['author_pseudo'];

        if ($manager->pseudo_exists($_POST['author_pseudo']) === true) {
            $errors[] = 'That pseudo already exists';
        }

        if  (!ctype_alnum($_POST['author_pseudo'])) {
            $errors[] = 'Please enter a pseudo with only alphabets and numbers';
        }

        if (strlen($_POST['author_password']) < 6) {
            $errors[] = 'Your password must be at least 6 characters';

        } else if (strlen($_POST['author_password']) > 18) {
            $errors[] = 'Your password cannot be more than 18 characters long';
        
        } else if($manager->passwords_match($_POST['author_password'], $_POST['author_password_confirmation']) === false) {
            $errors[] = 'Both passwords must match exactly';
        }

        if (filter_var($_POST['author_email'], FILTER_VALIDATE_EMAIL) === false) {
            $errors[] = 'Please enter a valide email address';
        
        } else if ($manager->email_exists($_POST['author_email']) === true) {
            $errors[] = 'That email already exists';
        }
    }
        

        if (empty($errors) === true) {

            $hash = hash('sha256', rand(0, 100000));
            $ip = $_SERVER['REMOTE_ADDR'];
            $pseudo = (string) htmlspecialchars($_POST['author_pseudo']);
            $email = (string) htmlspecialchars($_POST['author_email']);
            $password = (string) htmlspecialchars($_POST['author_password']);

        
            $author = new Authors(array(
                              'author_pseudo' => $pseudo,
                              'author_email' => $email,
                              'author_ip' => $ip,
                              'author_password' => $password,
                              'author_hash' => $hash
                           ));

            if ($author->isValid()) {
                 
                 $manager->connect_author($author);
                 
                 header('Location: signuped.php?success');
                 exit();

            }


        } 

 }


echo $twig->render('authors/signup.html', array(
         'email' => $email,
         'pseudo' => $pseudo,
         'le' => $errors
     ));

