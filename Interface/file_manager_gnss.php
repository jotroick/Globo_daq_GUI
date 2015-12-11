<?php

$path = "/home/kopero/public_html/interface/"; 
//$path = "/home/kopero/public_html/datagps/";
$file_name = "PARSER_T.gpx";
$totalfile = $path.$file_name;
$header_file_string = "<?xml version=\"1.0\"?>\r\n<gpx creator=\"Globodaq_JPT\">\r\n<trk>\r\n<name>PARSER</name>\r\n  <trkseg>\r\n";
$footer_file_string = "</trkseg></trk></gpx>";

$latest_ctime = 0;
$latest_filename = ''; 
$entry_before = '';   

$d = dir($path);
$files = array();
$var_temp=0;

while (false !== ($entry = $d->read())) {
// put header if is the first file coming  and delete the file 'borrar'
		if(strpos($entry,'borrar') !== false){
			$file_borrar=$entry;
			file_put_contents($file_name, $header_file_string);
			file_put_contents($file_name, $footer_file_string,FILE_APPEND | LOCK_EX);
			unlink($file_borrar);	
			//$var_temp = 1;
		}
		// recognition of the parser files
		if (strpos($entry,'Parser') !== false) {
			$files[]=$entry;
		}
}
//footer array
$search_footer = array("</trkseg>","</trk>","</gpx>");
$replace_footer = array("","","");

sort($files);
	$content=file($file_name);
	$content=str_replace($search_footer,$replace_footer,$content);
	file_put_contents($file_name, $content);
	
$search_array=array("<?xml version=\"1.0\"?>","<gpx creator=\"Globodaq_JPT\">","<trk>","<name>PARSER</name>"," <trkseg>","</trkseg>", "</trk>","</gpx>");
$replace_array=array(" "," "," "," "," "," "," "," ");



if(sizeof($files)!=0){
	foreach ($files as $file){
		
		//$content = file($file);
		$content=file_get_contents($file);
		$trkpt_bool=substr_count($content, '<trkpt')==substr_count($content, '</trkpt>');
		$ele_bool=substr_count($content, '<ele>')==substr_count($content, '</ele>');
		$time_bool=substr_count($content, '<time>')==substr_count($content, '</time>');
		$sat_bool=substr_count($content, '<sat>')==substr_count($content, '</sat>');
		$hdop_bool=substr_count($content, '<hdop>')==substr_count($content, '</hdop>');
		
		//$number_bool=(substr_count($content, '<hdop>')==substr_count($content, '<sat>'))&&(substr_count($content, '<time>')==substr_count($content, '<ele>'));
		
	
		
		if($trkpt_bool && $ele_bool && $time_bool && $sat_bool && $hdop_bool){
		
				
			
			// take out footer and header
			$content=str_replace($search_array,$replace_array,$content);
		// delete file 	
			
		// copy just the points into the PARSER_T	
			file_put_contents($file_name, $content,FILE_APPEND | LOCK_EX);
			
		}
		unlink($file);
	}
}

file_put_contents($file_name, $footer_file_string,FILE_APPEND | LOCK_EX);

//ob_clean();
echo $file_name;
?> 
