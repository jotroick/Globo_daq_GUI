<?php
$path = "/home/kopero/public_html/interface/"; 

$latest_ctime = 0;
$latest_filename = '';    

$d = dir($path);
while (false !== ($entry = $d->read())) {
	if(strpos($entry,'Image') !== false){
		$filepath = "{$path}/{$entry}";
		// could do also other checks than just checking whether the entry is a file
		if (is_file($filepath) && filectime($filepath) > $latest_ctime) {
			$latest_ctime = filectime($filepath);
			$latest_filename = $entry;
		}
	}
}

echo $latest_filename;

?>
