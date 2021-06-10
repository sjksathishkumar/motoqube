<?php include '../../config.php'; 
include 'header.php';
header('Content-type: application/json');
		$Details = $db->getRows("SELECT state FROM sp_locations group by state order by state");	
		if (count($Details) > 0) {
				$arrResult1['status'] = 'success'; 
				$arrResult1['code'] = 200; 			
				$arrResult1['Data'] = array();
				foreach ($Details as $key => $value) {
					$state = $value["state"];
				$arrResults["state"] =strtolower($state);
				array_push($arrResult1['Data'], $arrResults);
			}
		}
			else{
				$arrResult1['status'] = 'error'; 
				$arrResult1['code'] = 201; 				
				$arrResult1['message'] = 'No Data Found !';				
			}
		echo json_encode($arrResult1);
		exit;

?>