<?php include '../../config.php'; 
include 'header.php';
header('Content-type: application/json');
if (isset($_POST['name']) && !empty($_POST['name']) 
&& isset($_POST['mobile']) && !empty($_POST['mobile'])
&& isset($_POST['shop']) && !empty($_POST['shop'])
&& isset($_POST['address']) && !empty($_POST['address'])
&& isset($_POST['district']) && !empty($_POST['district'])
&& isset($_POST['state']) && !empty($_POST['state'])
&& isset($_POST['pincode']) && !empty($_POST['pincode'])
&& isset($_POST['business_percentage']) && !empty($_POST['business_percentage'])
&& isset($_POST['working_days']) && !empty($_POST['working_days'])
&& isset($_POST['hours']) && !empty($_POST['hours']) ){
$g_apikey = implode('-', str_split(substr(strtolower(md5(microtime().rand(1000, 9999))), 0, 30), 6));

	$mobile = $_POST["mobile"];
	$email = $_POST["email"];

	$val = $db->getRow("Select seller_id from sp_seller where mobile = '$mobile' and email = '$email' Limit 1");

	if(count($val)>0){
		$arrResult['status'] = 'error'; 
		$arrResult['code'] = 201; 				
		$arrResult['message'] = 'Seller Already Exists';
		echo json_encode($arrResult);exit;
	}


		$fields_data = array(
          'name'  => isset($_POST['name'])?$_POST['name']:'',
          'mobile'  => isset($_POST['mobile'])?$_POST['mobile']:'',
          'alternate_mobile'  => isset($_POST['alternate_mobile'])?$_POST['alternate_mobile']:'',
          'email'  => isset($_POST['email'])?$_POST['email']:'',
          'shop'  => isset($_POST['shop'])?$_POST['shop']:'',
          'address'  => isset($_POST['address'])?$_POST['address']:'',
          'landmark'  => isset($_POST['landmark'])?$_POST['landmark']:'',
          'state'  => isset($_POST['state'])?$_POST['state']:'',
          'city'  => isset($_POST['district'])?$_POST['district']:'',
          'location'  => isset($_POST['location'])?$_POST['location']:'',
          'pincode'  => isset($_POST['pincode'])?$_POST['pincode']:'',
          'business_percentage'  => isset($_POST['business_percentage'])?$_POST['business_percentage']:'',
          'working_days'  => isset($_POST['working_days'])?$_POST['working_days']:'',
          'hours'  => isset($_POST['hours'])?$_POST['hours']:'',
          'car_deal' => isset($_POST['car_deal'])?$_POST['car_deal']:'',
          'bike_deal' => isset($_POST['bike_deal'])?$_POST['bike_deal']:'',
          'car_parts' => isset($_POST['car_parts'])?$_POST['car_parts']:'',
          'bike_parts' => isset($_POST['bike_parts'])?$_POST['bike_parts']:'',
          'firebase_instance_id' => isset($_POST['firebase_instance_id'])?$_POST['firebase_instance_id']:'', 
		  'device_name' => isset($_POST['device_name'])?$_POST['device_name']:'',  
		  'device_model' => isset($_POST['device_model'])?$_POST['device_model']:'', 
		  'os_version' => isset($_POST['os_version'])?$_POST['os_version']:'', 
		  'api_token' => $g_apikey, 
        );
          $result = $db->insertAry('sp_seller', $fields_data);
         	$seller_id = $db->getLastId();
			notification_insert("seller",$seller_id,$_POST['name']);
			if(!is_null($result)){ 
				$account_details = array(
				  'seller_id' => $seller_id,
		          'account_name' => isset($_POST['account_name'])?$_POST['account_name']:'',
		          'account_number' => isset($_POST['account_number'])?$_POST['account_number']:'',
				  'bank' => isset($_POST['bank'])?$_POST['bank']:'',
				  'ifsc' => isset($_POST['ifsc'])?$_POST['ifsc']:'',
				  'gpay' => isset($_POST['g-pay'])?$_POST['g-pay']:'',
				  'phonepay' => isset($_POST['phonepe'])?$_POST['phonepe']:'',
				);
				$result = $db->insertAry('sp_seller_account', $account_details);


				$arrResult2['status'] = 'success'; 
				$arrResult2['code'] = 200; 				
				$arrResult2['message'] = "Registered Successfully !";				
				$arrResult2['token'] = $g_apikey;	
				$arrResult2['seller_id'] = $seller_id;
				$arrResult2['Active'] = 0;
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
