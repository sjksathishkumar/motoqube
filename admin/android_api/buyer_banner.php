<?php include '../../config.php'; 
include 'header.php';
header('Content-type: application/json');

		$Details = $db->getRows("SELECT * FROM sp_buyer_banner");	
		if (count($Details) > 0) {
				$arrResult1['status'] = 'success'; 
				$arrResult1['code'] = 200; 			
				$arrResult1['Data'] = array();
				foreach ($Details as $key => $value) {
					$arrResult["id"] = $value["id"];
					$arrResult["image"] = $base_url_slash.$value["image"];
					array_push($arrResult1["Data"],$arrResult);
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