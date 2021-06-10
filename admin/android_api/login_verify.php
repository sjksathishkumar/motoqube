<?php include '../../config.php'; 
include 'header.php';
header('Content-type: application/json');

	if (!empty($_POST['mobile'])){
		$mobile = $_POST['mobile'];
		$Details = $db->getRow("SELECT * FROM sp_seller where mobile='".$mobile."' LIMIT 1");	
		if (count($Details) > 0) {
			$g_apikey = implode('-', str_split(substr(strtolower(md5(microtime().rand(1000, 9999))), 0, 30), 6)); 
			
			$result = $db->updateAry("sp_seller", array('api_token'=>$Details['api_token']), "WHERE mobile='$mobile'");
			if(! is_null($result)){									
				$arrResult1['status'] = 'success'; 
				$arrResult1['code'] = 200; 				
				$arrResult1['message'] = 'Login Successfull !';	
				$arrResult1['token'] = $g_apikey;
				$arrResult1['id'] = $Details['seller_id'];
				$arrResult1['seller_id'] = sellerid($Details['seller_id']);			
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
			$arrResult1['message'] = 'User Not Exists!';
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