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

    
    if(isset($_POST['fid'])) {

        $fid = $_POST['fid'];
  
        $cman = new CommentsManager($db);
        $cdall = $cman->get_all_comments_by_file($fid);
        
        echo $twig->render('file/list_comments.html', array(
              'cdall' => $cdall
              ));
    }
