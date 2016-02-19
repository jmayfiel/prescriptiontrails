<?php
require("/nfs/users/clind/public_html/prescriptiontrails.org/admin/db.php"); 
require("PHPExcel.php");
$exportTrails = new trails;
$export = $exportTrails->getAllSheet();
$count = $export['totalMatched'];
$export = $export['trails'];

// Instantiate a new PHPExcel object
$objPHPExcel = new PHPExcel(); 

$objPHPExcel->getProperties()->setCreator("PT Webserver")
							 ->setLastModifiedBy("Jacob Mayfield")
							 ->setTitle("Prescription Trails Data Export")
							 ->setSubject("Prescription Trails Data Export")
							 ->setCategory("Data Dump");


// Set the active Excel worksheet to sheet 0
$objPHPExcel->setActiveSheetIndex(0); 

// Initialise the Excel row number
$rowCount = 1; 

// Iterate through each result from the SQL query in turn
// We fetch each database result row into $row in turn
foreach($export as $id => $trail) {
		if($trail['loopcount'] == 1) {
			$distance 	= $trail['loops'][1]['distance'];
			$steps 		= $trail['loops'][1]['steps'];
		} else {
				$looptext	= $trail['loopcount']." loops";
				$distance = 0;
				$steps = 0;
				foreach($trail['loops'] as $id => $details) {
					$distance 	= $trail['loops'][$id]['distance'] + $distance;
					$steps 		= $trail['loops'][$id]['steps'] + $steps;
				}
		}
	 
    $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $trail['id']); 
    $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $trail['name']); 
    $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $trail['city']); 
    $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $trail['zip']); 
    $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $trail['crossstreets']); 
    $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $trail['address']); 
    $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $trail['transit']); 
    $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $trail['lat'] .", ".$row['lng']); 
    $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, rawurldecode($trail['desc'])); 
    $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $trail['lighting']); 
    $objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, $trail['difficulty']); 
    $objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, $trail['surface']); 
    $objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, $trail['parking']); 
    $objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, $trail['facilities']); 
    $objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount, $trail['hours']); 
    $objPHPExcel->getActiveSheet()->SetCellValue('P'.$rowCount, $trail['loopcount']); 
    $objPHPExcel->getActiveSheet()->SetCellValue('Q'.$rowCount, $trail['distance']); 
    $objPHPExcel->getActiveSheet()->SetCellValue('R'.$rowCount, $trail['steps']); 
    $objPHPExcel->getActiveSheet()->SetCellValue('S'.$rowCount, $trail['surface']); 
    $objPHPExcel->getActiveSheet()->SetCellValue('T'.$rowCount, $trail['published']); 
    $objPHPExcel->getActiveSheet()->SetCellValue('U'.$rowCount, $trail['rating']); 
    $objPHPExcel->getActiveSheet()->SetCellValue('V'.$rowCount, $trail['ratings']); 
    $objPHPExcel->getActiveSheet()->SetCellValue('W'.$rowCount, $trail['favorites']); 
    $objPHPExcel->getActiveSheet()->SetCellValue('X'.$rowCount, $trail['url']); 

	if($trail['translations'] != "none") {
		$translations = json_encode($trail['translations']);
		$objPHPExcel->getActiveSheet()->SetCellValue('Y'.$rowCount, $translations); 
	} else {
		$objPHPExcel->getActiveSheet()->SetCellValue('Y'.$rowCount, $trail['translations']); 
	}
	
    $rowCount++; 
} 

$objPHPExcel->getActiveSheet()->setTitle('Trail Data');

header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

header('Content-Type: application/vnd.ms-excel'); 
header('Content-Disposition: attachment;filename="PrescriptionTrailsDATA.xls"'); 
header('Cache-Control: max-age=0'); 
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); 
$objWriter->save('php://output');

?>