<?php include '../../config.php'; 
include 'header.php';
header('Content-type: application/json');

		$Details = $db->getRows("SELECT * FROM sp_popular_locations");	
		if (count($Details) > 0) {
				$arrResult1['status'] = 'success'; 
				$arrResult1['code'] = 200; 			
				$arrResult1['Data'] = array();
				foreach ($Details as $key => $value) {
					$arrResult["popular_location_id"] = $value["popular_location_id"];
					$arrResult["popular_location"] = $value["location"];
					array_push($arrResult1["Data"],$arrResult);
				}			
			}
			else{
				$arrResult1['status'] = 'error'; 
				$arrResult1['code'] = 201; 				
				$arrResult1['message'] = 'Login Failed !';				
			}
		echo json_encode($arrResult1);
		exit;

?>