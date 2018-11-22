<?php
//http://127.0.0.1/celtac/download.php?source=export_excel/outputExcel/celtac/export_list_personal.xls
											  //export_excel/outputExcel/celtac/export_list_personal.xls
//header('Content-Type: text/html; charset=utf-8');
//var_dump($_GET['source']);exit;
/*if (isset($_GET['source'])) {
	//$source = iconv("utf-8", "tis-620", $_GET['source']);
	$source = $_GET['source'];
} else {
	exit;
}*/
// *Lots* of security in here...


$source = 'export_excel/outputExcel/celtac/export_list_personal.xls';
function downloadFile($source){
	$mime = 'application/octet-stream';
	header('Pragma: public'); 	
	header('Expires: 0');		
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	header('Cache-Control: private',false);
	header('Content-Type: '.$mime);
	header('Content-Disposition: attachment; filename="'.basename($source).'"');
	header('Content-Transfer-Encoding: binary');
	header('Connection: close');
	readfile($source);	
	exit();
}

downloadFile($source);