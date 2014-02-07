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
    
    if (isset($_POST['button-shr'])) {
        
        echo 'button-shr clicked!'.'<br>';
        echo "POST =".json_encode($_POST)."<br>";
    }
?>
