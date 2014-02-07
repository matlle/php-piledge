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

  session_start();
  if (isset($_SESSION['aid'])) {
    // Delete the session vars by clearing the $_SESSION array
    $_SESSION = array();


    // Delete the session cookie by setting its expiration to an hour ago (3600)
    if (isset($_COOKIE[session_name()])) {  
           setcookie(session_name(), '', time() - 3600);    
       }

    session_unset();
    session_destroy();
  }

  setcookie('aid', '', time() - 3600);

  $home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/index.php';
  header('Location: ' .$home_url);

