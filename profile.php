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
   require_once 'Helper/fucs_helper.php';
   require_once 'initwig.php';


  

   
   $db = DBFactory::PgDAO();

   $amanager = new AuthorsManager($db);
   $pmanager = new ProfilesManager($db);

   $amanager->logged_out_protected();

   $errors = array();
   $infos = array();
   $er_fname = '';
   $er_lname = '';
   $er_bio = '';
   $er_expe = '';

   $firstName = '';
   $lastName = '';
   $bio = '';
   $experience = '';
  // $gender = '';
  // $birthday = '';
   

   if (isset($_GET['username']) && !empty($_GET['username'])) {

        $pseudo = (string) htmlspecialchars($_GET['username']);

        $author_data = $amanager->receiver_data($pseudo);
   }

   if (isset($_POST['SubmitProfile'])) {
      
      $firstName = (string) htmlspecialchars($_POST['fname']);
      $lastName = (string) htmlspecialchars($_POST['lname']);
      $bio =  (string) htmlspecialchars($_POST['bio']);
      $experience = (string) htmlspecialchars($_POST['experience']);
      
      if (!empty($firstName) && $pmanager->is_first_name_valid($firstName) === false) {
          $er_fname = 'Invalid first name, it must be at least 2 characters';
      } else if (!empty($firstName)) {
        $infos['profile_first_name'] = $firstName;
      }

      if (!empty($lastName) && $pmanager->is_last_name_valid($lastName) === false) {
          $er_lname = 'Invalid last name, it must be at least 2 characters';
      } else if (!empty($lastName)) {
        $infos['profile_last_name'] = $lastName;
      }

      if (!empty($bio) && $pmanager->is_bio_valid($bio) === false) {
          $er_bio = 'Invalid bio, you must say something :)';
      } else if (!empty($bio)) {
        $infos['profile_bio'] = $bio;
      }

      if (!empty($experience) && $pmanager->is_experience_valid($experience) === false) {
          $er_expe = 'Invalid experience, it must to be at least 5 characters';
      } else if (!empty($experience)) {
        $infos['profile_experience'] = $experience;
      }
       
       print_r($infos);

       $profile = new Profiles($infos);

       if ($profile->isValid()) { 
           echo 'Profile is valid';
       } else {
           echo 'Profile is not valid';
       }

       
   }

   echo $twig->render('authors/profile.html', array(
            'a_d' => $author_data,
            'er_fname' => $er_fname,
            'er_lname' => $er_lname,
            'er_bio' => $er_bio,
            'er_expe' => $er_expe,
            'firstName' => $firstName,
            'lastName' => $lastName,
            'bio' => $bio,
            'epxerience' => $experience,
            'msg_unread' => $msg_unread,
            'author' => $author
        ));
