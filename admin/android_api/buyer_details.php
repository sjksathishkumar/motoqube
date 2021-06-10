<?php include '../../config.php'; 
include 'header.php';
header('Content-type: application/json');
verifybuyer();
	if (!empty($_POST['buyer_id']) && !empty($_POST['buyer_id'])){
		$buyer_id= $_POST['buyer_id'];
		$value = $db->getRow("SELECT * FROM sp_buyer where buyer_id='".$buyer_id."' LIMIT 1");	
		if (count($value) > 0) {
			$arrResult['status'] = 'success'; 
			$arrResult['code'] = 200; 				
			$arrResult['message'] = 'Fetched !';
			$arrResult['Data'] = array();
			$result["name"]=$value["name"];
			$result["mobile"]=$value["mobile"];
			$result["alternate_mobile"]=$value["alternate_mobile"];
			$result["email"]=$value["email"];
			$result["address"]=$value["address"];
			$result["landmark"]=$value["landmark"];
			$result["location"]=$value["location"];
			$result["district"]=$value["city"];
			$result["state"]=$value["state"];
			$result["pincode"]=$value["pincode"];
			$result["status"]=($value["status"]==1)?"Active":"Inactive";
			$result["profile_image"]=(isset($value["profile_image"])&&!empty($value["profile_image"]))?$base_url_slash.$value["profile_image"]:'';
			array_push($arrResult["Data"],$result);
			
			echo json_encode($arrResult);
		}
		else{
			$arrResult1['status'] = 'error'; 
			$arrResult1['code'] = 201; 				
			$arrResult1['message'] = 'Buyer Not Found !';
			echo json_encode($arrResult1);

		}
	}