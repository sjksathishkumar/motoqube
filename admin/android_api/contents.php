<?php 
include '../../config.php'; 
include 'header.php';
header('Content-type: application/json');
if(isset($_POST["screen"])){
$screen= $_POST["screen"];
$result_data = $db->getRow("Select * from sp_content where section='$screen' Limit 1");
if(count($result_data)>0){
	$arrResult['status'] = 'success'; 
	$arrResult['code'] = 200; 	
	$arrResult['message'] = "Data Found"; 	
	$arrResult['Data'] = $result_data["content"]; 
	echo json_encode($arrResult);	
}
else{
	$arrResult['status'] = 'error'; 
	$arrResult['code'] = 201; 	
	$arrResult['message'] = "No Data Found";
	echo json_encode($arrResult);	
}
}
else{
	error203();
}
