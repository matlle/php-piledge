<noscript>
<div align="center"><a href="index.php">Go Back To Upload Form</a></div><!-- If javascript is disabled -->
</noscript>
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

    require_once 'Helper/autoload.inc.php';
    require_once 'initwig.php';

//ini_set('display_errors', 1);
//error_reporting(E_ALL);
    
    $db = DBFactory::PgDAO();
    $amanager = new AuthorsManager($db);
    $fmanager = new FilesManager($db);

    $amanager->logged_out_protected();

    $author_id = $amanager->get_session_id();
    


if(isset($_POST['submitDoc']))
{
	 //Some Settings
	$ThumbSquareSize 		= 200; //Thumbnail will be 200x200
	$BigImageMaxSize 		= 500; //Image Maximum height or width
	$ThumbPrefix			= "thumb_"; //Normal thumb Prefix
	$DestinationDirectory	= 'photos/thumbnails/';
	$Quality 				= 90;

	if(!isset($_FILES['docFile']) || !is_uploaded_file($_FILES['docFile']['tmp_name']))
	{
			die('Please choose a document!'); 
	}
	
	
	$RandomNumber 	= rand(0, 9999999999); 

	$ImageName 		= str_replace(' ','-',strtolower($_FILES['docFile']['name'])); 
	$ImageSize 		= $_FILES['docFile']['size']; 
	$TempSrc	 	= $_FILES['docFile']['tmp_name']; 
	$ImageType	 	= $_FILES['docFile']['type']; 
    

    $myext = array('pdf', 'docx');


	
	
	
	$ImageExt = substr($ImageName, strrpos($ImageName, '.'));
  	$ImageExt = str_replace('.','',$ImageExt);
	
	
	$ImageName 		= preg_replace("/\\.[^.\\s]{3,4}$/", "", $ImageName);
    $clean_title      = preg_replace('/\W|_/', ' ', $ImageName);
    $clean_title = ucfirst($clean_title);

	
	
	$NewImageName = $ImageName.'-'.$RandomNumber.'.'.$ImageExt;
	
	$thumb_DestRandImageName 	= $DestinationDirectory.$ThumbPrefix.$NewImageName; 
	$DestRandImageName 			= $DestinationDirectory.$NewImageName;
	
	
	if(in_array($ImageExt, $myext))
	{
		
		
         
         $file_name =  $_FILES['docFile']['name'];
         $file_type =  $_FILES['docFile']['name'];
         $file_size = $_FILES['docFile']['size'];
         $file_ext  = $ImageExt;
         $file_tmp_name  = $TempSrc;
         $file_error = $_FILES['docFile']['error'];

         $file = new Files(array(                              
                              'file_name' => $file_name,
                              'file_type' => $file_type,
                              'file_size' => $file_size,
                              'file_ext' => $file_name,
                              'file_tmp_name' => $file_tmp_name,
                              'file_error' => $file_error,
                              'author_id' => $author_id
                          ));
             
            

                $file->set_file_pdf_name($file->get_file_name());
                $file->set_file_thumb_name($file->get_file_name());

                $pdf_name = $file->get_file_pdf_name();
                $file_thumb_name = $file->get_file_thumb_name();

                $fthumb = $fmanager->get_preview_file_thumbnail($TempSrc, $pdf_name, $file_thumb_name);

                 

		
		
		//echo '<table width="100%" border="0" cellpadding="4" cellspacing="0">';
		//echo '<tr>';
		//echo '<td align="center"><img src="photos/thumbnails/'.$ThumbPrefix.$NewImageName.'" alt="Thumbnail" height="'.$ThumbSquareSize.'" width="'.$ThumbSquareSize.'"></td>';
		//echo '</tr><tr>';
	//	echo '<td align="center"><img src="photos/thumbnails/'.$NewImageName.'" alt="Resized Image" height="'.$ResizedHeight.'" width="'.$ResizedWidth.'"></td>';
		//echo '</tr>';
		//echo '</table>';



         echo '<form class="form-horizontal" style="width: 400px; margin-left: -450px; margin-top: -130px; " name="formShr" enctype="multipart/form-data" action="" method="POST" id="formShr">
         <input type="hidden" name="MAX_FILE_SIZE" value="{{ maxsize }}"/>
         <div class="control-group">
         <div><img src="'.$fthumb.'" alt="Thumbnail" height="" width="" style="border: 1px solid #F5F5F5;" /></div><br/>
         <label class="control-label" for="title">Title</label>
         <div class="controls">
         <input type="text" class="input-xlarge" id="title" name="title" value="'.$clean_title.'" placeholder="Title">
         </div>
         </div>
         <div class="control-group">
         <label class="control-label" for="content-shr">Description</label>
         <div class="controls">
         <textarea id="content-shr" name="description"  placeholder="Description" style="height: 100px; width: 290px;"></textarea>
                   
         <span class="profile-er"></span>
         </div>
         </div>
         <div class="control-group">
         <div class="controls" id="ctner">
      
          <button type="submit" id="button-shr" name="button-shr" class="btn">Share now</button><img src="Public/img/small_loader.gif" id="loaderDoc" alt="loader" style="margin-left: 20px;">
          </div>
          </div>
           </form>';

        


		
		// other post variables
	//	echo '<pre>Other Post Variables:';
   	// print_r($_POST);
      //echo $fthumb;
      //echo $ImageName.'<br/>';
      //echo $prefilethumb.'<br/>';
      //echo $pdf_name;
    //echo $thumb_DestRandImageName;
	//	echo '</pre>';

     
     /*echo $twig->render('file/share.html', array(
          'formshr' => $formshr
          ));*/
     

	}else{
		die('Unsupperted file!'); 
	}


}
