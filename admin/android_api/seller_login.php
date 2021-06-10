<?php include '../../config.php'; 
include 'header.php';
header('Content-type: application/json');

	if (!empty($_POST['username']) && !empty($_POST['password'])){
		$username = $_POST['username'];
		$password = base64_encode($_POST['password']);

		$Details = $db->getRow("SELECT * FROM sp_seller where username='".$username."' and password='".$password."' LIMIT 1");	
		if (count($Details) > 0) {
			if($Details['status']==1){
				$g_apikey = implode('-', str_split(substr(strtolower(md5(microtime().rand(1000, 9999))), 0, 30), 6)); 
				
				$fields_data = array(
				  'api_token'=>$g_apikey,
				  'firebase_instance_id' => isset($_POST['firebase_instance_id'])?$_POST['firebase_instance_id']:'', 
				  'device_name' => isset($_POST['device_name'])?$_POST['device_name']:'',  
				  'device_model' => isset($_POST['device_model'])?$_POST['device_model']:'', 
				  'os_version' => isset($_POST['os_version'])?$_POST['os_version']:'', 
				);
				$result = $db->updateAry("sp_seller", $fields_data, "WHERE username='".$username."' and password='".$password."' ");
				if(! is_null($result)){									
					$arrResult1['status'] = 'success'; 
					$arrResult1['code'] = 200; 				
					$arrResult1['message'] = 'Login Successfull !';	
					$arrResult1['token'] = $g_apikey;
					$arrResult1['id'] = $Details['seller_id'];
					$arrResult1['seller_id'] = sellerid($Details['seller_id']);		
					$arrResult1['Active'] = $Details['status'];
				}
				else{
					$arrResult1['status'] = 'error'; 
					$arrResult1['code'] = 201; 				
					$arrResult1['message'] = 'Login Failed !';				
				}
			}
			else{
				$arrResult1['status'] = 'error'; 
				$arrResult1['code'] = 201; 				
				$arrResult1['message'] = 'Account Inactive! Please Try Later';		
			}

		}
		else{
			$arrResult1['status'] = 'error'; 
			$arrResult1['code'] = 201; 				
			$arrResult1['message'] = 'Username or Password is Wrong!';
		}
		echo json_encode($arrResult1);
		exit;
	}else{
		$arrResult1['status'] = 'error'; 
		$arrResult1['code'] = 203; 				
		$arrResult1['message'] = 'Please Fill the Mandatory Fields !';
		echo json_encode($arrResult1);
		exit;
	}
?>