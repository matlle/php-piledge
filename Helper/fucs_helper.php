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


require_once('initwig.php');
/**
 * Byte Convert
 * Convert file size into byte, kb, mb, gb and tb
 * @param int $size
 * @return string
 */
 function byte_convert($size) {
   # size smaller then 1kb
   if ($size < 1024) return $size . ' Byte';
   # size smaller then 1mb
   if ($size < 1048576) return sprintf("%4.2f KB", $size/1024);
   # size smaller then 1gb
   if ($size < 1073741824) return sprintf("%4.2f MB", $size/1048576);
   # size smaller then 1tb
   if ($size < 1099511627776) return sprintf("%4.2f GB", $size/1073741824);
   # size larger then 1tb
   else return sprintf("%4.2f TB", $size/1073741824);
 }

/* 
<!-- put this at the top of the page --> 
 
   $mtime = microtime(); 
   $mtime = explode(" ",$mtime); 
   $mtime = $mtime[1] + $mtime[0]; 
   $starttime = $mtime; 
 

<!-- put other code and html in here -->


<!-- put this code at the bottom of the page -->
 
   $mtime = microtime(); 
   $mtime = explode(" ",$mtime); 
   $mtime = $mtime[1] + $mtime[0]; 
   $endtime = $mtime; 
   $totaltime = ($endtime - $starttime); 
   echo "This page was created in ".$totaltime." seconds"; 

*/




function count_pages($pdfname) {
  $pdftext = file_get_contents($pdfname);
  $num = preg_match_all("/\/Page\W/", $pdftext, $dummy);
  return $num;
}


function getPDFPages($document)
{
    $cmd = "/usr/bin/pdfinfo";          // Linux
   //$cmd = "C:\\location\\pdfinfo.exe"; // Windows

    // Parse entire output
    exec("$cmd \"$document\"", $output);

    // Iterate through lines
    $pagecount = 0;
    foreach($output as $op)
    {
        // Extract the number
        if(preg_match("/Pages:\s*(\d+)/i", $op, $matches) === 1)
        {
            $pagecount = intval($matches[1]);
            break;
        }
    }

    return $pagecount;
}


/**
 * Calculate new image dimensions to new constraints
 *
 * @param Original X size in pixels
 * @param Original Y size in pixels
 * @return New X maximum size in pixels
 * @return New Y maximum size in pixels
 */
function scaleImage($x,$y,$cx,$cy) {
    //Set the default NEW values to be the old, in case it doesn't even need scaling
    list($nx,$ny)=array($x,$y);
    
    //If image is generally smaller, don't even bother
    if ($x>=$cx || $y>=$cx) {
            
        //Work out ratios
        if ($x>0) $rx=$cx/$x;
        if ($y>0) $ry=$cy/$y;
        
        //Use the lowest ratio, to ensure we don't go over the wanted image size
        if ($rx>$ry) {
            $r=$ry;
        } else {
            $r=$rx;
        }
        
        //Calculate the new size based on the chosen ratio
        $nx=intval($x*$r);
        $ny=intval($y*$r);
    }    
    
    //Return the results
    return array($nx,$ny);
}



$function = new Twig_SimpleFunction('ago', function($ptime) {
        
    $etime = time() - strtotime($ptime);

    if ($etime < 1)
    {
        return 'few seconds';
    }

    $a = array( 12 * 30 * 24 * 60 * 60  =>  'year',
                30 * 24 * 60 * 60       =>  'month',
                24 * 60 * 60            =>  'day',
                60 * 60                 =>  'hour',
                60                      =>  'minute',
                1                       =>  'second'
                );

    foreach ($a as $secs => $str)
    {
        $d = $etime / $secs;
        if ($d >= 1)
        {
            $r = round($d);
            return $r . ' ' . $str . ($r > 1 ? 's' : '') . ' ago';
        }
    }

});

$twig->addFunction($function);






/*
$lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
switch ($lang){
    case "fr":
        //echo "PAGE FR";
        include("index_fr.php");//include check session FR
        break;
    case "it":
        //echo "PAGE IT";
        include("index_it.php");
        break;
    case "en":
        //echo "PAGE EN";
        include("index_en.php");
        break;        
    default:
        //echo "PAGE EN - Setting Default";
        include("index_en.php");//include EN in all other cases of different lang detection
        break;
}*/


/*function getUserLanguage() {

    $langs = array();

    if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
        // break up string into pieces (languages and q factors)
        preg_match_all(‘/([a-z]{1,8}(-[a-z]{1,8})?)\s*(;\s*q\s*=\s*(1|0\.[0-9]+))?/i’, $_SERVER['HTTP_ACCEPT_LANGUAGE'], $lang_parse);

        if (count($lang_parse[1])) {
            // create a list like “en” => 0.8
            $langs = array_combine($lang_parse[1], $lang_parse[4]);
            // set default to 1 for any without q factor
            foreach ($langs as $lang => $val) {
                if ($val === ”) $langs[$lang] = 1;
            }
            // sort list based on value
            arsort($langs, SORT_NUMERIC);
        }
    }
    //extract most important (first)
    foreach ($langs as $lang => $val) { break; }
        //if complex language simplify it
        if (stristr($lang,”-”)) {$tmp = explode(“-”,$lang); $lang = $tmp[0]; }
            return $lang;
}*/






function getClientIP() {

if (isset($_SERVER)) {

    if (isset($_SERVER["HTTP_X_FORWARDED_FOR"]))
        return $_SERVER["HTTP_X_FORWARDED_FOR"];

    if (isset($_SERVER["HTTP_CLIENT_IP"]))
        return $_SERVER["HTTP_CLIENT_IP"];

    return $_SERVER["REMOTE_ADDR"];
}

if (getenv('HTTP_X_FORWARDED_FOR'))
    return getenv('HTTP_X_FORWARDED_FOR');

if (getenv('HTTP_CLIENT_IP'))
    return getenv('HTTP_CLIENT_IP');

return getenv('REMOTE_ADDR');
}



function getRealIpAddress() {
  return !empty($_SERVER['HTTP_CLIENT_IP']) ?
          $_SERVER['HTTP_CLIENT_IP'] : (!empty($_SERVER['HTTP_X_FORWARDED_FOR']) ?
                  $_SERVER['HTTP_X_FORWARDED_FOR'] : (!empty($_SERVER['REMOTE_ADDR']) ?
                          $_SERVER['REMOTE_ADDR'] : null));
}



function getIp() {

        $ip = $_SERVER['REMOTE_ADDR'];
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {

            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {

            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }

        return $ip;
    }







/*<?php
    set_time_limit(0);
    function MakePropertyValue($name,$value,$osm){
    $oStruct = $osm->Bridge_GetStruct("com.sun.star.beans.PropertyValue");
    $oStruct->Name = $name;
    $oStruct->Value = $value;
    return $oStruct;
    }
    function word2pdf($doc_url, $output_url){

    //Invoke the OpenOffice.org service manager
    $osm = new COM("com.sun.star.ServiceManager") or die ("Please be sure that OpenOffice.org is installed.\n");
    //Set the application to remain hidden to avoid flashing the document onscreen
    $args = array(MakePropertyValue("Hidden",true,$osm));
    //Launch the desktop
    $oDesktop = $osm->createInstance("com.sun.star.frame.Desktop");
    //Load the .doc file, and pass in the "Hidden" property from above
    $oWriterDoc = $oDesktop->loadComponentFromURL($doc_url,"_blank", 0, $args);
    //Set up the arguments for the PDF output
    $export_args = array(MakePropertyValue("FilterName","writer_pdf_Export",$osm));
    //print_r($export_args);
    //Write out the PDF
    $oWriterDoc->storeToURL($output_url,$export_args);
    $oWriterDoc->close(true);
    }

    $output_dir = "C:/wamp/www/projectfolder/";
    $doc_file = "C:/wamp/www/projectfolder/wordfile.docx";
    $pdf_file = "outputfile_name.pdf";

    $output_file = $output_dir . $pdf_file;
    $doc_file = "file:///" . $doc_file;
    $output_file = "file:///" . $output_file;
    word2pdf($doc_file,$output_file);
    ?>

*/





