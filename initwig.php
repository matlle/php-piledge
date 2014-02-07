<?php

   include_once('Twig/lib/Twig/Autoloader.php');
    Twig_Autoloader::register();
                 
    $loader = new Twig_Loader_Filesystem('View'); // Dossier contenant les templates
    $twig = new Twig_Environment($loader, array(
            'cache' => false,
            'autoescape' => true
    ));

?>
