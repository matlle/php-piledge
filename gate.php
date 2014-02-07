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
    require_once 'Helper/appvar.php';
    require_once 'Helper/fucs_helper.php';

     
     $db = DBFactory::PgDAO();

     $fmanager = new FilesManager($db);
     $amanager = new AuthorsManager($db);
     $cmanager = new CommentsManager($db);

     //$amanager->logged_out_protected();

     $au_id = $amanager->get_session_id();
     
     if ($amanager->logged_in() === false) {
         $rows = $fmanager->get_all_files();
     } else {
         $rows = $fmanager->get_all_files_by_followings($au_id);
     }


     echo $twig->render('base/home.html', array(
         'maxsize' => MAXFILESIZE,
         'row' => $rows,
         'nb_file' => $nb_file,
         'nb_following' => $nb_following,
         'nb_follower' => $nb_follower,
         'msg_unread' => $msg_unread,
         'author' => $author
       ));

