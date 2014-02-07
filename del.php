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


if (!session_id()) session_start();
require_once('initwig.php');
require_once('Model/connect.php');
require_once('Helper/appvar.php');
require_once('Helper/class.messages.php');

$msg = new Messages();

$action = $_SERVER['PHP_SELF'];

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id_get = (int) $_GET['id'];

    $sql = "SELECT file_id, file_name, file_type, file_size FROM files WHERE file_id = ?";
    $data = $bdd->prepare($sql);
    $data->execute(array($id_get));
    $file_get = $data->fetch();

    echo $twig->render('base/del.html', array(
            'file' => $file_get,
            'action' => $action
         ));

    $data->closeCursor();

} 

elseif (isset($_POST['yes'])) {
        
        $id_file = (int) $_POST['id'];
        
        $select_sql = "SELECT * FROM files WHERE file_id = ?";
        $select_data = $bdd->prepare($select_sql);
        $select_data->execute(array($id_file));

        $data_row = $select_data->fetch();
        
        $select_data->closeCursor();

        $del_sql = "DELETE FROM files WHERE file_id = ?";
        $del_data = $bdd->prepare($del_sql);
        $del_data->execute(array($id_file));
        
        $file_name = $data_row['file_name'];

        @unlink(UPLOADPATH . $file_name);


        $del_data->closeCursor();

        
       /* echo $twig->render('base/home.html', array(
             'flash' => $flash
             )); */
        $msg->add('s', 'The file has been deleted successfully');
        header('Location: index.php');

        

}

elseif (isset($_POST['no'])) {
        header('Location: index.php');
}

