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
    

    function autoload($classname) {

        if (file_exists($file = 'Class/' . $classname . '.class.php')) {

            require $file;
        
        } elseif (file_exists($file = 'Class/Files/' . $classname . '.class.php')) {

            require $file;

        } elseif (file_exists($file = 'Class/Comments/' . $classname . '.class.php')) {

            require $file;

        } elseif (file_exists($file = 'Class/Authors/' . $classname . '.class.php')) {

            require $file;

        } elseif (file_exists($file = 'Class/Topics/' . $classname . '.class.php')) {

            require $file;

        } elseif (file_exists($file = 'Class/Messages/' . $classname . '.class.php')) {

            require $file;

        } elseif (file_exists($file = 'Class/Clubs/' .$classname . '.class.php')) {

            require $file;

        } elseif (file_exists($file = 'Class/Profiles/' .$classname . '.class.php')) {

            require $file;

        } elseif (file_exists($file = 'Class/Followers/' .$classname . '.class.php')) {

            require $file;
        }



        require_once 'start_session.php';
        require_once 'header.php';
        require_once 'left_menu.php';

        
    }

    spl_autoload_register('autoload');
