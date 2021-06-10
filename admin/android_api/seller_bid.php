<?php include '../../config.php'; 
include 'header.php';verifyseller();
header('Content-type: application/json');
if (isset($_POST['seller_id']) && !empty($_POST['seller_id']) 
&& isset($_POST['booking_id']) && !empty($_POST['booking_id'])
&& isset($_POST['amount']) && !empty($_POST['amount'])
&& isset($_POST['return_days'])){

$booking_id = $_POST['booking_id'];
$seller_id = $_POST['seller_id'];

	$val = $db->getRow("Select seller_id from sp_bid where booking_id = '$booking_id' and seller_id = '$seller_id' Limit 1");

	if(count($val)>0){
		$arrResult['status'] = 'error'; 
		$arrResult['code'] = 201; 				
		$arrResult['message'] = 'Already Bidded!';
		echo json_encode($arrResult);exit;
	}
		$fields_data = array(
          'seller_id'  => isset($_POST['seller_id'])?$_POST['seller_id']:'',
          'booking_id'  => isset($_POST['booking_id'])?$_POST['booking_id']:'',
          'amount'  => isset($_POST['amount'])?$_POST['amount']:'',
          'return_days'  => isset($_POST['return_days'])?$_POST['return_days']:'',
        );
          $result = $db->insertAry('sp_bid', $fields_data);
         	$bid_id = $db->getLastId();

			if(!is_null($result)){ 
				$arrResult2['status'] = 'success'; 
				$arrResult2['code'] = 200; 				
				$arrResult2['message'] = "Bidded Successfully !";	
				$arrResult2['bid_id'] = $bid_id;
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
