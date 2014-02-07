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

    $mmanager = new MessagesManager($db);
    $amanager = new AuthorsManager($db);

    $amanager->logged_out_protected();

    $au = $amanager->get_session_id();

    $errors = array();
    $to_pseudo = '';
    $subject = '';
    $content = '';

    if (isset($_POST['submit'])) {

        if (empty($_POST['to'])) {

            $errors[] = 'You must define a destinater.';

        }
        
        if (empty($_POST['content'])) { 

            $errors[] = 'Your message cannot to be empty, you must define a message.';

        } else {

            if ($amanager->pseudo_exists($_POST['to']) === false) {
                $errors[] = "That user don't exists";
            }


            if (!ctype_alnum($_POST['to'])) {
                $errors[] = 'Please enter a pseudo with only alphabets and numbers';
            }

            if ((trim (htmlspecialchars($_POST['ap']))) == $_POST['to']) {
                $errors[] = 'Hum ' . $_POST['ap'] . ', you cannot send message to yourself :-)';
            }
        }

        
            $to_pseudo = (string) htmlspecialchars($_POST['to']);
            $to_id = $amanager->get_author_id($to_pseudo);
            $to_avatar = $amanager->get_author_avatar($to_pseudo);          
            

            $subject =  htmlspecialchars($_POST['subject']);
            $content =  htmlspecialchars($_POST['content']);
        


        if (empty($errors) === true && isset($_POST['subject']) && !empty($_POST['subject'])) {

            
            $message = new Messages(array(
                               'message_receiver_id' => $to_id,
                               'message_receiver_pseudo' => $to_pseudo,
                               'message_receiver_avatar' => $to_avatar,
                               'message_subject' => $subject,
                               'message_content' => $content,
                               'author_id' => $au
                           ));
            
            if ($message->isValid()) {
                
               $mmanager->send_message($message);

               header('Location: msg.php');
               exit();

            } else {
                echo 'Message is not valid<br/>';
                
            }



        }


     }

    echo $twig->render('msg/nmsg.html', array(
        'errors' => $errors,
        'msg_unread' => $msg_unread,
        'to_pseudo' => $to_pseudo,
        'subject' => $subject,
        'content' => $content,
        'author' => $author
    ));
