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
    
    $sent = $mmanager->get_msg_sent($aid);

    //print_r($sent);

    echo $twig->render('msg/sent_messages.html', array(
        'sent' => $sent,
        'msg_unread' => $msg_unread,
        'author' => $author
    ));
