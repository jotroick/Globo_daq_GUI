<?php

//$path = "/home/kopero/public_html/interface/"; 
$path = "/home/kopero/public_html/datagps/";
$totalfile = $path.$file_name;
$header_file_string = "<?xml version=\"1.0\"?>\r\n<gpx creator=\"Globodaq_JPT\">\r\n<trk>\r\n<name>PARSER</name>\r\n  <trkseg>\r\n";
$footer_file_string = "</trkseg> \r\n</trk>\r\n </gpx>";

$file_name_temporal = "PARSER_T_temp.gpx"; // Temporal file
file_put_contents($file_name_temporal,$header_file_string); // Temporal file
file_put_contents($file_name_temporal,$footer_file_string,FILE_APPEND | LOCK_EX); // Temporal file


?> 
