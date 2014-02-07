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

$action = "index.php";

if (isset($_GET['id']) && !empty($_GET['id'])) {
   $id_get = (int) $_GET['id'];

   $sql = "SELECT file_id, file_title, file_description, file_type, file_size FROM files WHERE file_id = ?";
   $data = $bdd->prepare($sql);
   $data->execute(array($id_get));
   $file_get = $data->fetch();
   
   //$file_name = $file_get['file_name'];
   //$file_path = UPLOADPATH . $file_name;



   echo $twig->render('base/edit.html', array(
          'file' => $file_get,
          'cible' => $action,
          'maxsize' => MAXFILESIZE
        ));

}
