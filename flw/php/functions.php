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


function clean_input($input) {
	$search = array(
		'@<script[^>]*?>.*?</script>@si',   
		'@<[\/\!]*?[^<>]*?>@si',            
		'@<style[^>]*?>.*?</style>@siU',    
		'@<![\s\S]*?--[ \t\n\r]*>@'         
	);

	$output = preg_replace($search, '', $input);
	return $output;
}


function crypto_rand_secure($min, $max) {
	$range = $max - $min;
		if($range < 0) return $min; 
	$log = log($range, 2);
	$bytes = (int) ($log / 8) + 1; 
	$bits = (int) $log + 1; 
	$filter = (int) (1 << $bits) - 1; 
		do {
			$rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
			$rnd = $rnd & $filter; 
		} while ($rnd >= $range);

	return $min + $rnd;
}

function get_token($length) {
	$token = '';
	$codeAlphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$codeAlphabet .= 'abcdefghijklmnopqrstuvwxyz';
	$codeAlphabet .= '0123456789';
		for($i=0; $i<$length; $i++) {
			$token .= $codeAlphabet[crypto_rand_secure(0, strlen($codeAlphabet))];
		}

	return $token;
}

