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
   
   $home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/index.php';

   $email = '';

  // If the user isn't logged in, try to log them in
    if (isset($_POST['submitl'])) {
     

      // Grab the user-entered log-in data
      $email = trim($_POST['author_email']);
      $password = trim($_POST['author_password']);

      if (empty($email) === true || empty($password) === true) {

          $errors[] = 'Sorry both email and password are required';
      
      } else if ($manager->email_exists($email) === false) {

          $errors[] = 'Sorry that email don\'t exists.';

     /* } else if ($manager->email_confirmed($email){
          $errors[] = 'Sorry, but you need to activete your account. Please check your email.';
      }*/

      } else {

          if (strlen($password) > 18) {

            $errors[] = 'The password should be less than 18 characters';
            
          }
          $login = $manager->login($email, $password);
          if ($login === false) {
          
              $errors[] = 'Sorry, that email/password is invalid';

          } else {
              session_regenerate_id(true);          
              $_SESSION['aid'] = $login;
              setcookie('aid', $login, time() + (60 * 60 * 24 * 30)); // expires in 30 days
              header('Location: ' . $home_url);
              exit();

          }

      }

}

echo $twig->render('authors/login.html', array(
         'email' => $email,
         'le' => $errors
     ));
