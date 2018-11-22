<?php
	$filename = './outputExcel/aa';

	if (file_exists($filename)) {
		if(rmdir($filename)){
		}else{
			echo 'can not delete folder '.$filename;
			exit;
		}
	} else {
		if(mkdir($filename)){
		}else{
			echo 'can not create folder '.$filename;
			exit;
		}
	} 
?>