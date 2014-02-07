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
    $manager = new AuthorsManager($db);
    
    $manager->logged_in_protected();

    $success = '';
    $errors = '';
    
    if (isset($_GET['success']) && empty($_GET['success'])) {

        $success = 'Thank you for registering. Please check your email.';
    
    } else {
        
        $errors = "Please get out here ! :)";
    }

    echo $twig->render('authors/signuped.html', array(
             'success' => $success,
             'errors' => $errors
             ));


