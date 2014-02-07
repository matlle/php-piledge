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
    $mmanager = new MessagesManager($db);
    
    $amanager->logged_out_protected();

    $aid = $amanager->get_session_id();
    //$pseudo = $amanager->get_author_pseudo($aid);
    
    //print_r($inbox);

    $errors = array();
    
    if (isset($_GET['mid']) && !empty($_GET['mid'])) {
        
        if (isset($_POST['submit']) && empty($_POST['content'])) {
        
            $errors = 'Your message cannot to be empty';

            header('Location: msg.php?mid=' . (int) $_GET['mid']);

        }

        $get_mid = (int) $_GET['mid'];
        $get_mid = htmlspecialchars($get_mid);

        $msg_reading = $mmanager->get_msg_by_id($get_mid);

        //print_r($msg_reading);
        
        $mmanager->set_msg_like_read($get_mid, $aid);

        echo $twig->render('msg/msg_reading.html', array(
           'msg_reading' => $msg_reading,
           'msg_unread' => $msg_unread,
           'author' => $author 
        ));
    
    
    } else {
    
        $inbox = $mmanager->get_msg_inbox($aid);

        echo $twig->render('msg/msg.html', array(
           'inbox' => $inbox,
           'msg_unread' => $msg_unread,
           'author' => $author 
        ));

    }
