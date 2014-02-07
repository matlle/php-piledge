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

    global $nb_following;
    global $nb_follower;
    global $nb_file;

    $db = DBFactory::PgDAO();
    $amanager = new AuthorsManager($db);
    $fmanager = new FilesManager($db);
    $fomanager = new FollowersManager($db);

    $aid = $amanager->get_session_id();
    
    $nb_file = $fmanager->count_files($aid);
    $nb_following = $fomanager->count_following($aid);
    $nb_follower = $fomanager->count_followers($aid);
