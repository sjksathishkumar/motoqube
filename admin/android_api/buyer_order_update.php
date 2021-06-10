<?php 
include '../../config.php'; 
include 'header.php';
header('Content-type: application/json');
verifybuyer();	      
$buyer_id= $_POST["buyer_id"];    

if(isset($_POST["booking_id"]) && !empty($_POST["booking_id"]) && isset($_POST["booking_status"]) && !empty($_POST["booking_status"]) ){
	$booking_id=$_POST["booking_id"];$booking_status=$_POST["booking_status"];
	$result_data = $db->getRow("select status_track,firebase_instance_id,x.buyer_id,y.name From sp_bookings x left join sp_buyer y on x.buyer_id=y.buyer_id Where x.booking_id='$booking_id'");
	if(count($result_data)>0){
	$status_track = array();
			$status_track = (array) json_decode($result_data["status_track"]);
			$buyer_name = $result_data["name"];

			foreach ($status_track as $key => $value) {
				foreach ($value as $keys => $values){
					if($keys==$booking_status){						
						$arrResult2['status'] = 'error'; 
						$arrResult2['code'] = 201; 				
						$arrResult2['message'] = "Updation Failed! Already Updated";	
						echo json_encode($arrResult2);exit;
					}
				}
			}


			$status_track[][$booking_status]=date('d-m-y h:i:s a');		

			if($booking_status=="choosed seller" && isset($_POST["bid_id"]) && !empty($_POST["bid_id"]) && isset($_POST["seller_id"]) && !empty($_POST["seller_id"])){
				$seller_id=$_POST["seller_id"];
				$bid_id=$_POST["bid_id"];
				$datas = array(
				'status_track'=>json_encode($status_track),
				'status'=>$booking_status,
				'seller_id'=>$seller_id,
				'bid_id'=>$bid_id,
				'allow_payment'=>"1"
				);
				$value = $db->updateAry('sp_bookings',$datas,"where booking_id='$booking_id'");
				// echo $db->getLastQuery();
				if($db->getAffectedRows()>0){ 
					
					$firebase_id = $db->getVal("select firebase_instance_id From sp_seller where seller_id='$seller_id'");
					$registration_id[] = $firebase_id;
					$title="Order Confirmed!!..";
					$body="Buyer confirmed your order. Please visit booking details to see more..";
					sendfirebasenotification($registration_id,$body,$title,"NULL","enquiry",$seller_id,"false","NULL","seller");
					notification_insert("seller choosed",$booking_id,$buyer_name);

					$datas = array(
					  'bid_status'=>1,
					);
					$values = $db->updateAry('sp_bid',$datas,"where bid_id='$bid_id'");
				
					$arrResult['status'] = 'success'; 
					$arrResult['code'] = 200; 				
					$arrResult['message'] = "Updated Successfully !";	
				}
				else{
					$arrResult['status'] = 'error'; 
					$arrResult['code'] = 201; 				
					$arrResult['message'] = "Updation Failed !";
				}
			}
			elseif ($booking_status=="payment pending" && isset($_POST["payment_method"]) && isset($_POST["paid_amount"])){
				$payment_method=$_POST["payment_method"];
				$paid_amount=$_POST["paid_amount"];		
				$datas = array(
					'status_track'=>json_encode($status_track),
					'status'=>$booking_status,
					'paid_amount'=>$paid_amount,	
				);
				$value = $db->updateAry('sp_bookings',$datas,"where booking_id='$booking_id'");
				if($db->getAffectedRows()>0){ 
					notification_insert("payment pending",$booking_id,$buyer_name);
					$arrResult['status'] = 'success'; 
					$arrResult['code'] = 200; 				
					$arrResult['message'] = "Updated Successfully !";	
				}
				else{
					$arrResult['status'] = 'error'; 
					$arrResult['code'] = 201; 				
					$arrResult['message'] = "Updation Failed !";
				}
			}
			elseif ($booking_status=="paid" && isset($_POST["payment_method"]) && isset($_POST["payment_id"]) && isset($_POST["paid_amount"]) && isset($_POST["seller_id"]) && !empty($_POST["seller_id"])){
				$payment_method=$_POST["payment_method"];
				$payment_id=$_POST["payment_id"];				
				$paid_amount=$_POST["paid_amount"];		
				$seller_id=$_POST["seller_id"];		
				$datas = array(
				'status_track'=>json_encode($status_track),
				'status'=>$booking_status,
				'paid_amount'=>$paid_amount,
				'payment_id'=>$payment_id,				
				);
				$value = $db->updateAry('sp_bookings',$datas,"where booking_id='$booking_id'");
				if($db->getAffectedRows()>0){ 					
					notification_insert("paid",$booking_id,$buyer_name);

					$firebase_id = $db->getVal("select firebase_instance_id From sp_seller where seller_id='$seller_id'");
					$registration_id[]= $firebase_id;
					$title="Buyer Paid For The Order!!..";
					$body="Now you can proceed for shipment";
					sendfirebasenotification($registration_id,$body,$title,"NULL","shipment",$seller_id,"false","NULL","seller");

					$arrResult['status'] = 'success'; 
					$arrResult['code'] = 200; 				
					$arrResult['message'] = "Updated Successfully !";	
				}
				else{
					$arrResult['status'] = 'error'; 
					$arrResult['code'] = 201; 				
					$arrResult['message'] = "Updation Failed !";
				}
			}

			elseif ($booking_status=="cancel requested" || $booking_status=="return requested"){					
				$datas = array(
				'status_track'=>json_encode($status_track),
				'status'=>$booking_status	
				);
				$value = $db->updateAry('sp_bookings',$datas,"where booking_id='$booking_id'");
				if($db->getAffectedRows()>0){ 
					$seller_id=$_POST["seller_id"];
					$firebase_id = $db->getVal("select firebase_instance_id From sp_seller where seller_id='$seller_id'");					
					$registration_id[] = $firebase_id;
					$title=ucfirst($booking_status)." For Booking ID: ".bookingid($booking_id)." !!..";
					$body="Please visit booking details to see more..";
					sendfirebasenotification($registration_id,$body,$title,"NULL","cancel",$seller_id,"false","NULL","seller");

					notification_insert($booking_status,$booking_id,$buyer_name);

					$arrResult['status'] = 'success'; 
					$arrResult['code'] = 200; 				
					$arrResult['message'] = "Updated Successfully !";	
				}
				else{
					$arrResult['status'] = 'error'; 
					$arrResult['code'] = 201; 				
					$arrResult['message'] = "Updation Failed !";
				}
			}
	}
	else{
		$arrResult['status'] = 'error'; 
		$arrResult['code'] = 201; 				
		$arrResult['message'] = 'No Data Found !';
	}
	echo json_encode($arrResult);
}
elseif (isset($_POST["booking_id"]) && !empty($_POST["booking_id"]) && isset($_POST["bid_status"]) && $_POST["bid_status"]=="Need Product Images" && isset($_POST["bid_id"]) && !empty($_POST["bid_id"]) ){
	$bid_status = 2;$bid_id=$_POST["bid_id"];$booking_status="need product images";
	$booking_id=$_POST["booking_id"];
	$result_data = $db->getRow("select status_track,firebase_instance_id,x.seller_id From sp_bookings x left join sp_seller y on x.seller_id=y.seller_id Where x.booking_id='$booking_id'");
	if(count($result_data)>0){
			$status_track = (array) json_decode($result_data["status_track"]);
			foreach ($status_track as $key => $value) {
				foreach ($value as $keys => $values){
					if($keys==$booking_status){
						$arrResult['status'] = 'error'; 
						$arrResult['code'] = 201; 				
						$arrResult['message'] = "Updation Failed! Already Updated";	
						echo json_encode($arrResult);exit;
					}
				}
			}

			$datas = array(
			  'bid_status'=>$bid_status,
			);
			$value = $db->updateAry('sp_bid',$datas,"where bid_id='$bid_id'");

				$status_track[][$booking_status]=date('d-m-y h:i:s a');	
				$datas = array(
				'status_track'=>json_encode($status_track),
				);
				$value = $db->updateAry('sp_bookings',$datas,"where booking_id='$booking_id'");

			$registration_id[] = $result_data["firebase_instance_id"];	
			$seller_id = $result_data["seller_id"];
			$title="Buyer Requested Product Image!!";
			$body="Buyer requested product image for their bookings. Please send that to proceed further.";
			sendfirebasenotification($registration_id,$body,$title,"NULL","enquiry",$seller_id,"false","NULL","seller");

			if($db->getAffectedRows()>0){ 
				$arrResult['status'] = 'success'; 
				$arrResult['code'] = 200; 				
				$arrResult['message'] = "Updated Successfully !";	
			}
			else{
				$arrResult['status'] = 'error'; 
				$arrResult['code'] = 201; 				
				$arrResult['message'] = "Updation Failed !";
			}
	}
	else{
		$arrResult['status'] = 'error'; 
		$arrResult['code'] = 201; 				
		$arrResult['message'] = 'No Data Found !';
	}
	echo json_encode($arrResult);

}
else{
	error203();
}