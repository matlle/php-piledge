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

   $amanager = new AuthorsManager($db);
   $au = $amanager->get_session_id(); 

    if (isset($_GET['fid']) && !empty($_GET['fid'])) {

        $fmanager = new FilesManager($db);
        $cmanager = new CommentsManager($db);

        $id_get = (int) $_GET['fid'];

       $fdata = $fmanager->get_file_id($id_get);
       $cdata = $cmanager->get_all_comments_by_file($id_get);
       
       $count = count($cdata);
       $second_count = '';
       $limit = 2;

       if($count>2) {
            $second_count = $count - 2;
       
       } else {
            $second_count = 0;
       }

       $two_comments = $cmanager->get_offset_comments_by_file($id_get, $limit, $second_count);

       //print_r($two_comments);  

        echo $twig->render('file/show.html', array(
              'f' => $fdata,
              //'comments' => $cdata,
              'twoc' => $two_comments,
              'count'=> $count,
              'scount' => $second_count,
              'author' => $author,
              'msg_unread' => $msg_unread,
              'nb_file' => $nb_file,
              'nb_following' => $nb_following,
              'nb_follower' => $nb_follower,
              'action' => ACTION,
              'maxsize' => MAXFILESIZE
             ));

    }

    if (isset($_POST['submit']) && isset($_POST['content']) && isset($_POST['fid']) && !empty($_POST['content']) && !empty($_POST['fid'])) {
        $comment_content = (string) $_POST['content'];
        $file_id = (int) $_POST['fid'];
        
        
        $comment = new Comments(array(
                                    'file_id' => $file_id,
                                    'author_id' => $au,
                                    'comment_content' => $comment_content
                                ));

        $cmanager = new CommentsManager($db);

        $cmanager->save_comment($comment);
         

        $comment_content = "";

        header('Location: show.php?fid='.$file_id);
        

    }
