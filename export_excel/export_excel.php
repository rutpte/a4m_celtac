<?php
set_time_limit(0);
header('Content-Type: text/html; charset=UTF-8');
date_default_timezone_set('Asia/Bangkok');

/** Include PHPExcel */
require_once 'Classes/PHPExcel.php';

//Create a PDO object
$dsn = "pgsql:host=localhost; dbname=a4m_celtac;";

$file_name 	= 'export_list_personal';
$title 		= 'personal';
try {
    $pdo = new PDO($dsn, "postgres", "1234");
} catch(PDOException $e) {
    echo 'Connection failed: <pre>' .  $e->getMessage();
}


//--------------------------------------------------------------------------------------------------

		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getDefaultStyle()->getFont()->setName('Cordia New')->setSize(13);
		$objPHPExcel->getProperties()->setTitle("xxx")->setDescription("xxx");
		$objPHPExcel->removeSheetByIndex(0);
		$i = 0;
			
        $objPHPExcel->createSheet($i);
        $objPHPExcel->setActiveSheetIndex($i);
        $objPHPExcel->getActiveSheet()->setTitle($title);
        
        $objPHPExcel->getActiveSheet()->mergeCells('A1:O1')->getStyle('A1:O1')->getFont()->setSize(15)->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A1:O1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "subject4");
		
		$objPHPExcel->getActiveSheet()->getStyle('A2:S2')->getFont()->setSize(15)->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('A2:S2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        //--> set-fields
        $fields = array(
			'_no' 				=>	'NO',	
			'title'				=>	'Title',		
			'name'				=>	'Name',		
			'surname'			=>	'Surname',		
			'address1'			=>	'Address1',		
			'address2'			=>	'Address2',		
			'region'			=>	'Region',		
			'phone'				=>	'Phone',		
			'mphone'			=>	'Mobile phone',		
			'email'				=>	'E-mail',		
			'amount'			=>	'Amount',		
			'currency'			=>	'Currency',		
			'registration_date'	=>	'Registration date',
			'payment_date'		=>	'Payment date',
			'payment_by'		=>	'Payment by',
			'payment_method'	=>	'Payment method',
			'payment_process'	=>	'Payment process',
			'status'			=>	'Status',
			'remark'			=>	'Remark'
        );
        
        //--> set field to row 2
        $col = 0;
        foreach ($fields as $field)
        {
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, 2, $field);
            $col++;
        }

        ///////////////////////////////////////////////////////////////////////////////////////////////////////////
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////

		//THEN '&radic';

				$sql = "
					select
						_no 				
						,title				
						,name				
						,surname			
						,address1			
						,address2			
						,region			
						,phone				
						,mphone			
						,email				
						,amount			
						,currency			
						,registration_date	
						,payment_date		
						,payment_by		
						,payment_method	
						,payment_process	
						,status			
						,remark
					FROM
                        customer
					WHERE 1=1
				";
// 				$sql .= "
// 					--GROUP BY 
// 				";
 				$sql .= " ORDER BY id";
 				$sql .= ' ASC';
			// echo $sql; exit;

			// echo $key_wgrop;echo '<br>';
			// echo $key_wtype;echo '<br>';
			//echo '<pre>';print_r($sql); exit;
			 
			///////////////////////////////////////////////////////////////////////////////////////////////////////////
			///////////////////////////////////////////////////////////////////////////////////////////////////////////
			///////////////////////////////////////////////////////////////////////////////////////////////////////////


			
			$query = $pdo->query($sql)->fetchAll(PDO::FETCH_OBJ);

			// // Fetching the table data
			$row = 3;
			foreach($query as $data)
			{
				$col = 0;
				foreach ($fields as $key=>$field)
				{
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $data->$key);
					$col++;
				}

				$row++;
			}
			 
			//--> $i = $i + 1;//change sheet active by $i
		// $objPHPExcel->setActiveSheetIndex($key);
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		////////////////////////////////////////////////////////////////////////////////
// 		$pro_name = iconv('UTF-8', 'TIS-620', $province_name);
// 		$filename = './outputExcel/celtac/'.$pro_name;
// 		//$filename = './outputExcel/current/'.$pro_name;
// 
// 		if (file_exists($filename)) {
// 			if(rmdir($filename)){
// 			}else{
// 				echo 'you have been folder '.$filename;
// 				
// 			}
// 		} else {
// 			if(mkdir($filename)){
// 			}else{
// 				echo 'can not create folder '.$filename;
// 				exit;
// 			}
// 		} 
		////////////////////////////////////////////////////////////////////////////////
		//--> convert encoding text
		$file_name = iconv('UTF-8', 'TIS-620', $file_name);
		$objWriter->save('./outputExcel/celtac/'.$file_name.'.xls');
		// $objWriter->save('./outputExcel/current/'.$pro_name.'/'.$file_name.'.xls');

// echo 'export successfully and return file_name.<br />'."\n";
//header('location : ../download.php?source=export_excel/outputExcel/celtac/export_list_personal.xls');
$rs = array(
    'success'       => true,
    'file_name'     => $file_name
);
echo json_encode($rs);