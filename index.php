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

include_once('Twig/lib/Twig/Autoloader.php');
    Twig_Autoloader::register();
                 
    $loader = new Twig_Loader_Filesystem('View'); // Dossier contenant les templates
    $twig = new Twig_Environment($loader, array(
            'cache' => false
    ));

if (!isset($_GET['section']) OR $_GET['section'] == 'index') {

include_once('gate.php');

}


//define('SITE_ROOT', 'http://localhost/oscar/');


?>

