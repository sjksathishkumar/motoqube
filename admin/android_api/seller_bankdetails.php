<?php include '../../config.php'; 
include 'header.php';
header('Content-type: application/json');

	if (!empty($_POST['seller_id']) && !empty($_POST['seller_id'])){
		$seller_id= $_POST['seller_id'];
		$value = $db->getRow("SELECT * FROM sp_seller_account where seller_id='".$seller_id."' LIMIT 1");	
		if (count($value) > 0) {
			$arrResult['status'] = 'success'; 
			$arrResult['code'] = 200; 				
			$arrResult['message'] = 'Fetched !';
			$arrResult['Data'] = array();
				$result["account_name"]=$value["account_name"];
				$result["account_number"]=$value["account_number"];
				$result["bank"]=$value["bank"];
				$result["ifsc"]=$value["ifsc"];
				$result["gpay"]=$value["g-pay"];
				$result["phonepe"]=$value["phonepay"];
				array_push($arrResult["Data"],$result);			
			echo json_encode($arrResult);
		}
		else{
			$arrResult1['status'] = 'error'; 
			$arrResult1['code'] = 201; 				
			$arrResult1['message'] = 'Bank Details Not Found !';	
		}
	}