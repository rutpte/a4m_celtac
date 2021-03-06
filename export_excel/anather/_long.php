<?php
header('Content-Type: text/html; charset=UTF-8');
date_default_timezone_set('Asia/Bangkok');

/** Include PHPExcel */
require_once 'Classes/PHPExcel.php';

// Create a PDO object
$dsn = "pgsql:host=uniti.pte.co.th;dbname=gis_integration_dev;";
define('DB_CLD_LINK','dbname=drr_cld_db user=postgres port=5435 password=pgpteadmin');
try {
    $pdo = new PDO($dsn, "postgres", "pgpteadmin");
} catch(PDOException $e) {
    echo 'Connection failed: <pre>' .  $e->getMessage();
}
$province  = isset($_GET["province"]) ? trim($_GET["province"]) : "aya";
$provinces = array(
    "npt" =>"นครปฐม",
    "pbi" =>"เพชรบุรี",
    "rbr" =>"ราชบุรี",
    "stn" =>"สตูล",
    "kri" =>"กาญจนบุรี",
    "cri" =>"เชียงราย",
    "nma" =>"นครราชสีมา",
    "pt" =>"ปทุมธานี",
    "spb" =>"สุพรรณบุรี",
    "udn" =>"อุดรธานี",
    "cpm" =>"ชัยภูมิ",
    "ska" =>"สงขลา",
    "sni" =>"สุราษฎร์ธานี",
    "cmi" =>"เชียงใหม่",
    "ret" =>"ร้อยเอ็ด",
    "nsn" =>"นครสวรรค์",
    "kkn" =>"ขอนแก่น",
    "ubn" =>"อุบลราชธานี",
    "cbi" =>"ชลบุรี",
    "kpp" =>"กำแพงเพชร",
	
	"aya" => "พระนครศรีอยุธยา"
);

$province_name = $provinces[$province];

$way_type    = array('Route','MSP');//loop file



foreach ($way_type as $key => $value) {
	if($value=='Route'){
		$way_grop    = array('main','c1','c2','l1','l2');
	}else{
		$way_grop    = array('main','c1');
	}
	
}
exit;


$objPHPExcel = new PHPExcel();
$objPHPExcel->getDefaultStyle()->getFont()->setName('Cordia New')->setSize(13);
$objPHPExcel->getProperties()->setTitle($way_grop)->setDescription($way_grop);

$objPHPExcel->setActiveSheetIndex(0);

// Field names in the first row
// $fields = $query->list_fields();

// $fields = array(
    // 'seq' => 'ลำดับที่', 'amphur_name' => 'อำเภอ', 'org_res' => 'หน่วยงานรับผิดชอบ',
    // 'road_name' => 'ชื่อสายทาง', 'road_integration' => 'ประเภทถนนบูรณาการ',
    // 'distance' => 'ระยะทาง  (กม.)', 'km_begin' => 'กม.เริ่มต้น', 'km_end' => 'กม.สิ้นสุด',
    // 'activity' => 'กิจกรรมที่ดำเนินการ', 'l_cost' => 'ราคากลางค่าก่อสร้าง (บาท)',
    // 'scores' => 'คะแนนสายทาง', 'road_seq' => 'ลำดับที่สายทาง', 'way_track_id' => 'way_track_id'
// );

$fields = array(
    'seq' => 'ลำดับที่', 'amphur_name' => 'อำเภอ', 'org_res' => 'หน่วยงานรับผิดชอบ',
    'road_name' => 'ชื่อสายทาง', 'road_integration' => 'ประเภทถนนบูรณาการ',
    'distance' => 'ระยะทาง  (กม.)', 'km_begin' => 'กม.เริ่มต้น', 'km_end' => 'กม.สิ้นสุด',
    'activity' => 'กิจกรรมที่ดำเนินการ', 'l_cost' => 'ราคากลางค่าก่อสร้าง (บาท)',
    'scores' => 'คะแนนสายทาง', 'road_seq' => 'ลำดับที่สายทาง', 'way_track_id' => 'way_track_id'
);

$objPHPExcel->getActiveSheet()->mergeCells('A1:O1')->getStyle('A1:O1')->getFont()->setSize(15)->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A1:O1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "test..." . $province_name);

$col = 0;
foreach ($fields as $field)
{
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, 2, $field);
    $col++;
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////


$db_pro = DB_CLD_LINK;


//$bull = "'<span style=\"font-size: 30px\">&bull;</span>'";
$bull = 1;
$is_main = $way_grop == 'main' ? $bull : "''";
$is_c1 = $way_grop == 'c1' ? $bull : "''";
$is_c2 = $way_grop == 'c2' ? $bull : "''";
$is_l1 = $way_grop == 'l1' ? $bull : "''";
$is_l2 = $way_grop == 'l2' ? $bull : "''";

$sumCase = "";
if ($way_type == 'MSP') {
    $sumCase = " pjo.reference = 'MP' or pjo.reference = 'SPC'";    
} else {
    $sumCase = " pjo.reference = '{$way_type}'";
}
$trackCond = null;

$tracks = array(
   'pbi', 'npt', 'rbr', 'kri', 'cri', 'nma', 'pt', 'spb', 'udn', 'cpm',
   'ska', 'sni', 'cmi', 'ret', 'nsn', 'kkn', 'ubn', 'cbi', 'kpp'
);

if (in_array($province, $tracks)) {
    $trackCond = ", CASE WHEN pjo.join IN (
						SELECT {$province}_track_join_process.join FROM {$province}_track_join_process
					) 
					THEN '&radic;' 
					ELSE '' 
					END AS is_track";
}

if ($way_type == 'MSP') {
    $sql = "
        SELECT
            pjo.num
            , '{$province}' as province
            , array_to_string(array_agg(pjo.gid), ',') gids
            , pjo.route_no
            , pjo.road_name AS route_name
            , amp.amphur_name
            , pjo.org_res
            , pjo.\"join\"
            , COALESCE(round(SUM(ST_Length(CASE WHEN  pjo.reference = 'MP' or pjo.reference = 'SPC' THEN ST_Transform(pjo.the_geom,  32647) ELSE NULL END) / 1000)::numeric, 3),0) AS distance
            , ST_Astext(ST_Envelope(ST_Extent(pjo.the_geom))) as bound
            , ST_Astext(ST_Envelope(ST_Extent({$province}_{$way_grop}.the_geom))) as bound2
            , {$is_main} AS is_main
            , {$is_c1} AS is_c1
            , {$is_c2} AS is_c2
            , {$is_l1} AS is_l1
            , {$is_l2} AS is_l2
            {$trackCond}
            , MAX({$province}_{$way_grop}.status) AS status
            , MAX(tpa.scores) AS scores
        FROM
            {$province}_join pjo
            INNER JOIN {$province}_{$way_grop} ON pjo.join = {$province}_{$way_grop}.join
            LEFT JOIN {$province}_process_all tpa ON tpa.\"join\"={$province}_{$way_grop}.\"join\"
            LEFT JOIN (
                SELECT way.*
                    FROM dblink('{$db_pro}','SELECT way_id, orgc_id FROM way')
                AS way(way_id BIGINT, orgc_id BIGINT)
            ) AS way ON way.way_id = pjo.way_id
            LEFT JOIN (
                SELECT way.*
                    FROM dblink('{$db_pro}','SELECT orgc_id, amphur_id, orgc_name FROM org_comunity')
                AS way(orgc_id BIGINT, amphur_id BIGINT, orgc_name varchar(255))
            ) AS  org ON org.orgc_id = way.orgc_id

            LEFT JOIN (
                SELECT way.*
                    FROM dblink('{$db_pro}','SELECT province_id, amphur_id, amphur_name FROM amphur ')
                AS way(province_id BIGINT, amphur_id BIGINT, amphur_name varchar(255))
            ) AS amp ON amp.amphur_id = org.amphur_id
        WHERE 1=1
    ";
    if($way_type == 'MSP'){ //msp
        $sql .= " AND (pjo.reference = 'MP' or pjo.reference = 'SPC')";    
    }else{
        $sql .= " AND pjo.reference = '{$way_type}'";
    }

    $sql .= "
        GROUP BY
            pjo.route_no
            , pjo.road_name
            , pjo.\"join\"
            , pjo.org_res
            , amp.amphur_name
            , pjo.road_name
            , pjo.num
    ";
// echo $sql; exit;
} else {
    $sql = " 
        SELECT
            pjo.num AS num
            , '{$province}' as province
            , array_to_string(array_agg(pjo.gid), ',') gids
            , pjo.route_no
            , pjo.road_name AS route_name
            , pjo.org_res
            , pjo.\"join\"
            , COALESCE(round(SUM(ST_Length(CASE WHEN {$sumCase} THEN ST_Transform(pjo.the_geom,  32647) ELSE NULL END) / 1000)::numeric, 3),0) AS distance
            , ST_Astext(ST_Envelope(ST_Extent(pjo.the_geom))) as bound
            , ST_Astext(ST_Envelope(ST_Extent({$province}_{$way_grop}.the_geom))) as bound2
            , {$is_main} AS is_main
            , {$is_c1} AS is_c1
            , {$is_c2} AS is_c2
            , {$is_l1} AS is_l1
            , {$is_l2} AS is_l2
            {$trackCond}
            , MAX({$province}_{$way_grop}.status) AS status
            , MAX(tpa.scores) AS scores
        FROM
            {$province}_join pjo
            INNER JOIN {$province}_{$way_grop} ON pjo.join = {$province}_{$way_grop}.join
            LEFT JOIN {$province}_process_all tpa ON tpa.\"join\"={$province}_{$way_grop}.\"join\"
            LEFT JOIN (
                SELECT way.*
                    FROM dblink('{$db_pro}','SELECT way_id, orgc_id FROM way')
                AS way(way_id BIGINT, orgc_id BIGINT)
            ) AS way ON way.way_id = pjo.way_id
            LEFT JOIN (
                SELECT way.*
                    FROM dblink('{$db_pro}','SELECT orgc_id, amphur_id, orgc_name FROM org_comunity')
                AS way(orgc_id BIGINT, amphur_id BIGINT, orgc_name varchar(255))
            ) AS  org ON org.orgc_id = way.orgc_id

            LEFT JOIN (
                SELECT way.*
                    FROM dblink('{$db_pro}','SELECT province_id, amphur_id, amphur_name FROM amphur ')
                AS way(province_id BIGINT, amphur_id BIGINT, amphur_name varchar(255))
            ) AS amp ON amp.amphur_id = org.amphur_id
        WHERE 1=1
    ";
    if($way_type == 'MSP'){
        $sql .= " AND (pjo.reference = 'MP' or pjo.reference = 'SPC')";    
    }else{
        $sql .= " AND pjo.reference = '{$way_type}'";
    }

    $sql .= "
        GROUP BY
            pjo.route_no
            , pjo.road_name
            , pjo.\"join\"
            , pjo.org_res
            , amp.amphur_name
            , pjo.road_name
            , pjo.num
    ";

}
//  echo $sql; exit;
 
///////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////


// echo '<pre>'; echo $sql; echo '<br /------------------------------------<br />';exit;
// Fetching the table data
$row = 3;
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

$objPHPExcel->setActiveSheetIndex(0);

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

$objWriter->save('./PHPExcel/outputExcel/_long/' . $province_name . '.xls');

echo 'ทำแผนปฏิบัติการระยะยาว (กิจกรรมก่อสร้าง) จังหวัด', $province_name, ' เรียบร้อย.<br />'."\n";