<?php
	include '../../config.php'; 
	$time = $db->getRow("select value,value2 from settings where se_id='5'");
	$period = $db->getVal("select value from settings where se_id='1'");

	$from= date('YmdHi',strtotime($time["value"]));
	$to= date('YmdHi',strtotime("+".$period." minutes",strtotime($time["value2"])));
	
	$seller_notify = date('YmdHi',strtotime($time["value2"]));

	$current_date = date('YmdHi');

	if($current_date>=$from && $current_date<=$to){
		$hold=1;

		if($current_date<=$seller_notify){
			
		}
	}
	else{					
		$result_datas = $db->getRows("select distinct a.booking_id, a.buyer_id, b.firebase_instance_id, a.dateandtime From sp_bookings a inner join sp_buyer b on a.buyer_id=b.buyer_id inner join sp_bid c on a.booking_id=c.booking_id  Where a.status ='enquiry created' and show_sellerlist='0'  ");
		if(count($result_datas)>0){ 
		foreach ($result_datas as $key => $values) {
			$booking_id = $values["booking_id"];
			$booking_date = date('YmdHi',strtotime("+".$period." minutes",strtotime($values["dateandtime"]))); 
			$current_date = date('YmdHi');

			if($current_date>$booking_date){
				$update_array = array(
				   'show_sellerlist'=>1,  
   			    'status'=>'sent seller list'          
		        );
		          
		        $action_result = $db->updateAry('sp_bookings', $update_array, "where booking_id='".$booking_id."'");
		    
				$buyer_id = $values["buyer_id"];
				$registration_id[] = $values["firebase_instance_id"];			

				$title="Received Seller List!!";
				$body="You have received seller list for your new booking. Click to view List";
				sendfirebasenotification($registration_id,$body,$title,"NULL","booking_details",$booking_id);
			}

	     }
		}
	}
?>