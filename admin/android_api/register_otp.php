<?php include '../../config.php'; 
include 'header.php';
header('Content-type: application/json');
	if (isset($_POST['mobile']) && !empty($_POST['mobile'])){
		$mobile = $_POST['mobile'];
		$mobile1 = "+91".$mobile;
		$Details = $db->getRow("SELECT mobile FROM sp_seller where mobile='".$mobile."' or mobile='".$mobile1."' LIMIT 1");	
		if (count($Details) > 0) {
			$arrResult1['status'] = 'error'; 
			$arrResult1['code'] = 201; 				
			$arrResult1['message'] = 'User Already Exists !';
		}
		else{
		  $Number = $mobile;
      	  $random_no = mt_rand(10000, 99999);
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
		  }		
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