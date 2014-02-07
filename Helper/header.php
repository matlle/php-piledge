<?php

    /*
	@@ -=::MATLLE::=-
-----------------------------------------------------------------------------	
	# author: @matlle
	# email: paso.175@gmail.com
	# mobile: (225) 41860768
-----------------------------------------------------------------------------
	@@ Simple is better than complex.
*/

   
   require_once 'autoload.inc.php';

   global $author;
   global $msg_unread;

    $db = DBFactory::PgDAO();
    $amanager = new AuthorsManager($db);
    $mmanager = new MessagesManager($db);


    if (isset($_SESSION['aid'])) {

        $author_id = $_SESSION['aid'];

        $author = $amanager->author_data($author_id);
        
       // $pseudo = $amanager->get_author_pseudo($author_id);
        $msg_unread = $mmanager->get_number_msg_unread($author_id);

    }

