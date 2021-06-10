<?php include '../../config.php'; 
include 'header.php';
header('Content-type: application/json');
if (isset($_POST['name']) && !empty($_POST['name']) 
&& isset($_POST['mobile']) && !empty($_POST['mobile'])
&& isset($_POST['district']) && !empty($_POST['district'])
&& isset($_POST['state']) && !empty($_POST['state'])
&& isset($_POST['pincode']) && !empty($_POST['pincode'])){
$g_apikey = implode('-', str_split(substr(strtolower(md5(microtime().rand(1000, 9999))), 0, 30), 6));

	$mobile = $_POST["mobile"];
	$mobile1 = "+91".$mobile;

	$val = $db->getRow("Select buyer_id from sp_buyer where mobile = '$mobile' or mobile='".$mobile1."' Limit 1");
	if(count($val)>0){
		$arrResult['status'] = 'error'; 
		$arrResult['code'] = 201; 				
		$arrResult['message'] = 'Buyer Already Exists';
		echo json_encode($arrResult);exit;
	}

		$fields_data = array(
          'name'  => isset($_POST['name'])?$_POST['name']:'',
          'mobile'  => isset($_POST['mobile'])?$_POST['mobile']:'',
          'alternate_mobile'  => isset($_POST['alternate_mobile'])?$_POST['alternate_mobile']:'',
          'state'  => isset($_POST['state'])?$_POST['state']:'',
          'city'  => isset($_POST['district'])?$_POST['district']:'',
          'location'  => isset($_POST['location'])?$_POST['location']:'',
          'pincode'  => isset($_POST['pincode'])?$_POST['pincode']:'',
          'firebase_instance_id' => isset($_POST['firebase_instance_id'])?$_POST['firebase_instance_id']:'', 
		  'device_name' => isset($_POST['device_name'])?$_POST['device_name']:'',  
		  'device_model' => isset($_POST['device_model'])?$_POST['device_model']:'', 
		  'os_version' => isset($_POST['os_version'])?$_POST['os_version']:'', 
		  'api_token' => $g_apikey, 
		  'status' => 1, 
        );
          $result = $db->insertAry('sp_buyer', $fields_data);
         	$buyer_id = $db->getLastId();
			notification_insert("buyer",$buyer_id,$_POST['name']);
			if(!is_null($result)){ 
				$arrResult2['status'] = 'success'; 
				$arrResult2['code'] = 200; 				
				$arrResult2['message'] = "Registered Successfully !";				
				$arrResult2['token'] = $g_apikey;	
				$arrResult2['buyer_id'] = $buyer_id;
				$arrResult2['display_buyer_id'] = buyerid($Details["buyer_id"]);		  
				$arrResult2['Active'] = 1;
			}
			else{
				$arrResult2['status'] = 'error'; 
				$arrResult2['code'] = 201; 				
				$arrResult2['message'] = "Insert Failed !";
			}
			echo json_encode($arrResult2);
			exit;
}
else{
	error203();
}
