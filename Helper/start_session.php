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

  
  if (!session_id()) session_start();

  // If the session vars aren't set, try to set them with a cookie
  if (!isset($_SESSION['aid'])) {
    if (isset($_COOKIE['aid'])) {
      $_SESSION['aid'] = $_COOKIE['aid'];
      
    }
  }
?>
