<?php include '../../config.php'; 
include 'header.php';
header('Content-type: application/json');
	if (isset($_POST['mobile']) && !empty($_POST['mobile'])){
		$mobile = $_POST['mobile'];
		$mobile1 = "+91".$mobile;
		$Details = $db->getRow("SELECT mobile,status,api_token,buyer_id,state FROM sp_buyer where mobile='".$mobile."' or mobile='".$mobile1."' LIMIT 1");	
		if (count($Details) > 0) {

			// $g_apikey = implode('-', str_split(substr(strtolower(md5(microtime().rand(1000, 9999))), 0, 30), 6)); 


			if($Details["status"]==1){
			  $Number = $mobile;
	      	  $random_no = mt_rand(1000, 9999);
	          $pass_otp = $random_no;
	          $numbers = array($Number);
	          $message = rawurlencode("Your OTP is ".$random_no.". OTP is confidential for security reasons. Please don't share this OTP with anyone.");
	          $numbers = implode(',', $numbers);
	          $data = array('apikey' => $SMSapiKey, 'numbers' => $numbers, "sender" => $senderID, "message" => $message);
	          $ch = curl_init('https://api.textlocal.in/send/');
	          curl_setopt($ch, CURLOPT_POST, true);
	          curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	          $response = curl_exec($ch);
	          curl_close($ch);
	          $DecodeResponse = json_decode($response);
	          // echo $DecodeResponse->status;
	          if($DecodeResponse->status!="success"){
		         $data_message = "Failed To Send OTP";
	          	 $arrResult1['status'] = 'error'; 
				 $arrResult1['code'] = 201; 				
				 $arrResult1['message'] = $data_message;
	          }
	          else{
		          $data_message = "OTP sent";
				  $arrResult1['status'] = 'success'; 
				  $arrResult1['code'] = 200; 				
				  $arrResult1['message'] = $data_message;
				  $arrResult1['OTP'] = $pass_otp;
				  $arrResult1['token'] = $Details["api_token"];	
				  $arrResult1['buyer_id'] = $Details["buyer_id"];
				  $arrResult1['display_buyer_id'] = buyerid($Details["buyer_id"]);				  
				  $arrResult1['Active'] = $Details["status"];
				  $arrResult1['state'] = $Details["state"];
			  }	
			}
			else{
			  $arrResult1['status'] = 'error'; 
			  $arrResult1['code'] = 201; 				
			  $arrResult1['message'] = 'Unauthorized Entry !';
			}
		}
		else{
		  $arrResult1['status'] = 'error'; 
		  $arrResult1['code'] = 201; 				
		  $arrResult1['message'] = 'User Not Exists, Kindly Register !';
		}
		echo json_encode($arrResult1);
		exit;

	}
	else{
		$arrResult1['status'] = 'error'; 
		$arrResult1['code'] = 203; 				
		$arrResult1['message'] = 'Please Fill the Mandatory Fields !';
		echo json_encode($arrResult1);
		exit;
	}
?>