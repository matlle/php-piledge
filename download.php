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

require_once('initwig.php');
require_once('Model/connect.php');
require_once('Helper/appvar.php');



if (isset($_GET['id']) && !empty($_GET['id'])) {
   $id_file = $_GET['id'];
   $sql = "SELECT file_id, file_name, file_type, file_size FROM files WHERE file_id = ?";

   $get = $bdd->prepare($sql);
   $get->execute(array($id_file));
   $get_file = $get->fetch();

   $file_name = $get_file['file_name'];
   $file_type = $get_file['file_type'];
   $file_size = $get_file['file_size'];

   $size = filesize(UPLOADPATH.$file_name);
   header('Content-Description: File Transfer');
   header("Content-Type: application/force-download; name=\"" .$file_name. "\"");
   header("Content-Disposition: attachment; filename=\"" .$file_name."\"");
   header("Content-Length: ".$size."");
   header('Content-Transfer-Encoding: binary');
   header('Expires: 0');
   header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
   header('Pragma: Public');
   //echo(readfile(UPLOADPATH.$file_name));

    function readfile_chunked($fname) {
       $file_path = UPLOADPATH.$fname;
       $chunksize = 1*(1024*1024);
       $buffer = '';
       $handle = fopen($file_path, 'rb');

       if ($handle === false) {
           return false;
       }

       while (!feof($handle)) {
           $buffer = fread($handle, $chunksize);
           print $buffer;
       }

       return fclose($handle);
   }
   
   readfile_chunked($file_name);


   $get->closeCursor();

}

