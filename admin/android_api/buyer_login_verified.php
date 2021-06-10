<?php include '../../config.php'; 
include 'header.php';
header('Content-type: application/json');
	if (isset($_POST['mobile']) && !empty($_POST['mobile'])){
		$mobile = $_POST['mobile'];
		$mobile1 = "+91".$mobile;
		$Details = $db->getRow("SELECT mobile,status,api_token,buyer_id,state FROM sp_buyer where mobile='".$mobile."' or mobile='".$mobile1."' LIMIT 1");	
		if (count($Details) > 0) {
			$g_apikey = implode('-', str_split(substr(strtolower(md5(microtime().rand(1000, 9999))), 0, 30), 6)); 
			$fields_data = array(
			  'api_token'=>$g_apikey,
			  'firebase_instance_id' => isset($_POST['firebase_instance_id'])?$_POST['firebase_instance_id']:'', 
			  'device_name' => isset($_POST['device_name'])?$_POST['device_name']:'',  
			  'device_model' => isset($_POST['device_model'])?$_POST['device_model']:'', 
			  'os_version' => isset($_POST['os_version'])?$_POST['os_version']:'', 
			);
				
			$result = $db->updateAry("sp_buyer", $fields_data, "WHERE mobile='".$mobile."' or mobile='".$mobile1."' ");

			$arrResult1['status'] = 'success'; 
			$arrResult1['code'] = 200; 				
			$arrResult1['message'] = "Updated Successfully";
			$arrResult1['token'] = $g_apikey;	
		}
		else{
	      $arrResult1['status'] = 'error'; 
		  $arrResult1['code'] = 201; 				
		  $arrResult1['message'] = 'User Not Exists !';
		}
		echo json_encode($arrResult1);		
	}
	else{
		error203();
	}
?>