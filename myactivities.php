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
    require_once 'flw/php/functions.php';
    
    $db = DBFactory::PgDAO();
    
    $fmanager = new FilesManager($db);
    $amanager = new AuthorsManager($db);
    $cmanager = new CommentsManager($db);
    $fomanager = new FollowersManager($db);

    $amanager->logged_out_protected();
    $rows = array();

    $au_id = $amanager->get_session_id();
    $author_pseudo = $amanager->get_author_pseudo($au_id);
    
    $nfollowing = '';
    $nfollowers = '';
    $followings = '';
    $followers  = '';
    
    $fkey = get_token(50);
    $_SESSION['token'] = $fkey;

    

    if (isset($_GET['username']) && !empty($_GET['username'])) {

        $pseudo = (string) htmlspecialchars($_GET['username']);

        $author_activities = $fmanager->get_all_files_by_author($pseudo);
        
        $author_data = $amanager->receiver_data($pseudo);

        $user_id = $amanager->get_author_id($pseudo);

        $nfollowing = $fomanager->count_following($user_id);
        $nfollowers = $fomanager->count_followers($user_id);

        $followings = $fomanager->get_followings($user_id); 
        $followers = $fomanager->get_followers($user_id);
        
        //print_r($followers);
                
        if ($au_id != $user_id) {
		    if ($fomanager->is_follower($au_id, $user_id) == true) {
			    $follower = '<a class="btn btn-small strong unfollow" href="javascript:;" id="unfollow-'.$user_id.'">Following</a>';
		    } else {
			    $follower = '<a class="btn btn-small btn-info strong follow" href="javascript:;" id="follow-'.$user_id.'">Follow</a>';
		    }
	    } else {
		    $follower = '<a class="btn btn-small strong" href="profile.php?username='.$author_pseudo.'">Edit profile</a>';
	     }
    

    }



    echo $twig->render('authors/myactivities.html', array(
         'a_d' => $author_data,
         'a_a' => $author_activities,
         'msg_unread' => $msg_unread,
         'user_id' => $user_id,
         'fkey' => $fkey,
         'follower' => $follower,
         'nfollower' => $nfollowers,
         'nfollowing' => $nfollowing,
         'followings' => $followings,
         'followers' => $followers,
         'author' => $author
         ));



