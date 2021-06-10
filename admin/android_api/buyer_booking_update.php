<?php include '../../config.php'; 
include 'header.php';$buyer=verifybuyer();
header('Content-type: application/json');
if (isset($_POST['booking_id']) && !empty($_POST['booking_id']) 
&& isset($_POST['locations']) && !empty($_POST['locations'])){

		$booking_id=$_POST['booking_id'];
		$status_track[]["new enquiry created"]=date('d-m-y h:i:s a');
		$locations= isset($_POST['locations'])?$_POST['locations']:'';
		$fields_data = array(
          'locations'  => $locations,
          'status'=>'enquiry created',
          'dateandtime'=>date('Y-m-d H:i:s'),
        );
          $result = $db->updateAry('sp_bookings', $fields_data,"where booking_id='$booking_id'");
			notification_insert("booking",$booking_id,$buyer['name']);

			$results = $db->getRow("select parts_id,variant_id,category,make_id from sp_bookings where booking_id='$booking_id'");
			if(count($results)>0){
				$parts_id = $results["parts_id"];
				$variant_id = $results["variant_id"];
				$category = $results["category"];
				$make_id=0;
				if($category=="car"){
					$make_id = $db->getVal("SELECT b.make_id from sp_car_variant a left join sp_car_make b on a.make_id=b.make_id where variant_id='$variant_id' limit 1");
				}
				elseif ($category=="bike") {
					$make_id = $db->getVal("SELECT b.make_id from sp_bike_variant a left join sp_bike_make b on a.make_id=b.make_id where variant_id='$variant_id' limit 1");
				}
				locationbasednotifications($locations,$parts_id,$category,$make_id);				
			}
			if(!is_null($result)){ 
				$arrResult2['status'] = 'success'; 
				$arrResult2['code'] = 200; 				
				$arrResult2['message'] = "Enquiry Updated Successfully !";	
				$arrResult2['booking_id'] = $booking_id;
			}
			else{
				$arrResult2['status'] = 'error'; 
				$arrResult2['code'] = 201; 				
				$arrResult2['message'] = "Location Already Updated !";
			}
			echo json_encode($arrResult2);
			exit;
}
else{
	error203();
}

function locationbasednotifications($locations,$parts_id,$category,$make_id){
	global $db;
	$time = $db->getRow("select value,value2 from settings where se_id='5'");
	$period = $db->getVal("select value from settings where se_id='1'");

	$from= date('YmdHi',strtotime($time["value"]));
	$to= date('YmdHi',strtotime($time["value2"]));
	$current_date = date('YmdHi');

	if($current_date>=$from && $current_date<=$to){
		$hold=1;
	}
	else{
					
		$ext='';
		if($category=="car"){
			$ext = 'and FIND_IN_SET('.$parts_id.',replace(replace(replace(sell.car_parts,"[",""),"]",""),"\"",""))>0 and FIND_IN_SET('.$make_id.',replace(replace(replace(sell.car_deal,"[",""),"]",""),"\"",""))>0';
		}
		elseif ($category=="bike") {
			$ext = 'and FIND_IN_SET('.$parts_id.',replace(replace(replace(sell.bike_parts,"[",""),"]","),"\"",""))>0  and FIND_IN_SET('.$make_id.',replace(replace(replace(sell.bike_deal,"[",""),"]",""),"\"",""))>0';
		}

		$result_datas = $db->getRows("select firebase_instance_id From sp_seller sell Where (FIND_IN_SET(sell.location, '$locations') > 0 or FIND_IN_SET(sell.city, '$locations') > 0) $ext LIMIT 1000");
		if(count($result_datas)>0){  
		    foreach ($result_datas as $keys => $values) {
				$registration_id[] = $values["firebase_instance_id"];	
			}
		}
		else{
			$registration_id[]="";
		}
		$title="New Enquiry!!";
		$body="Hurry Up! Quote Now and Grab The Order";
		sendfirebasenotification($registration_id,$body,$title,"NULL","main","NULL","false","NULL","seller");
	}
}