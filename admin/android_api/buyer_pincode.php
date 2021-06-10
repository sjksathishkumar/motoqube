<?php include '../../config.php'; 
include 'header.php';
header('Content-type: application/json');
if(isset($_POST["state"]) && isset($_POST["district"]) && isset($_POST["location"])){
	$state = $_POST["state"];
	$district = $_POST["district"];
	$location = $_POST["location"];

		$Details = $db->getRows("SELECT pincode FROM sp_buyer_locations where state='$state' and district='$district' and location='$location' group by pincode order by pincode");	
		if (count($Details) > 0) {
				$arrResult1['status'] = 'success'; 
				$arrResult1['code'] = 200; 			
				$arrResult1['Data'] = array();
				foreach ($Details as $key => $value) {
					$state = $value["pincode"];
					$arrResults["pincode"] =$state;
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
}
else{
	error203();
}
?>