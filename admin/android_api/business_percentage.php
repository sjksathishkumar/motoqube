<?php include '../../config.php'; 
include 'header.php';
header('Content-type: application/json');
				$arrResult1['status'] = 'success'; 
				$arrResult1['code'] = 200; 	
				$Percentage = $db->getVal("select value from settings where se_id='4'");
				$arrResult1['Business Percentage'] = $Percentage;
		echo json_encode($arrResult1);
		exit;

?>