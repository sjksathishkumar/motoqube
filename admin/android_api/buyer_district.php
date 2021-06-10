<?php include '../../config.php'; 
include 'header.php';
header('Content-type: application/json');
if(isset($_POST["state"])){
	$state = $_POST["state"];
		$Details = $db->getRows("SELECT district FROM sp_buyer_locations where state='$state' group by district order by district");	
		if (count($Details) > 0) {
				$arrResult1['status'] = 'success'; 
				$arrResult1['code'] = 200; 			
				$arrResult1['Data'] = array();
				foreach ($Details as $key => $value) {
					$state = $value["district"];
					$arrResults["district"] =strtolower($state);
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