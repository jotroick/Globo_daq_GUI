<?php

$path = "/home/kopero/public_html/interface/"; 
$file_name = "plot_speed_T.xml";
$totalfile = $path.$file_name;
$header_file_string = "<?xml version=\"1.0\"?>\r\n<chart>\r\n<series>\r\n<name>Speed</name>\r\n<data>\r\n";
//$footer_file_string = "\r\n</data>\r\n</series>\r\n</chart>\r\n";
$footer_file_string = "</data></series></chart>";

$latest_ctime = 0;
$latest_filename = ''; 
$entry_before = '';   

$d = dir($path);
$files = array();
$var_temp=0;

$response='ok';
while (false !== ($entry = $d->read())) {
// put header if is the first file coming  and delete the file 'borrar'
		if(strpos($entry,'del_p4') !== false){
			//unlink($file_name);
			unlink($entry);
			file_put_contents($file_name, $header_file_string);
			file_put_contents($file_name, $footer_file_string,FILE_APPEND | LOCK_EX);
			$response='deleted';
			//unlink($file_borrar);	
			//$var_temp = 1;
		}
		// recognition of the parser files
		if (strpos($entry,'Speed') !== false) {
			$files[]=$entry;
		}
}

sort($files);
$content=file($file_name);
/*$search_array_footer=array('</data>','</series>','</chart>');
$replace_array_footer=array("","","");
$content=str_replace($search_array_footer,$replace_array_footer,$content);*/
$content=str_replace($footer_file_string,"",$content);
//$regex_footer='</series>';
//$content=preg_replace ( $regex_footer , "" ,$content);
file_put_contents($file_name, $content);
	
/*$search_array=array("<?xml version=\"1.0\"?>","<gpx creator=\"Globodaq_JPT\">","<trk>","<name>PARSER</name>"," <trkseg>","</trkseg>", "</trk>","</gpx>");
//$replace_array=array(" "," "," "," "," "," "," "," ");
*/
//var_dump($files);

// INSERT HEADER
//file_put_contents($file_name, $header_file_string);

if(sizeof($files)!=0){
	foreach ($files as $file){
		
		$content = file($file);
		// take out footer and header
		//$content=str_replace($search_array,$replace_array,$content);
	// delete file 	
		unlink($file);
	// copy just the points into the PARSER_T	
		file_put_contents($file_name, $content,FILE_APPEND | LOCK_EX);
	}
}

file_put_contents($file_name, $footer_file_string,FILE_APPEND | LOCK_EX);
//echo sizeof($files);
//echo file_get_contents($file_name);
echo json_encode($response);
?> 
