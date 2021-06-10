<?php 
include '../../config.php'; 
include 'header.php';
header('Content-type: application/json');
verifybuyer();	      
$buyer_id= $_POST["buyer_id"];   

// =============================
    $time = $db->getRow("select value,value2 from settings where se_id='5'");
	$period = $db->getVal("select value from settings where se_id='1'");

	$from= date('YmdHi',strtotime($time["value"]));
	$to= date('YmdHi',strtotime("+".$period." minutes",strtotime($time["value2"])));
	$current_date = date('YmdHi');

	if($current_date>=$from && $current_date<=$to){
		$hold=1;
	}
	else{					
		$result_datas = $db->getRows("select distinct a.booking_id, a.buyer_id, b.firebase_instance_id, a.dateandtime From sp_bookings a inner join sp_buyer b on a.buyer_id=b.buyer_id inner join sp_bid c on a.booking_id=c.booking_id  Where a.buyer_id='$buyer_id' and a.status ='enquiry created' and show_sellerlist='0'");
		if(count($result_datas)>0){ 
		foreach ($result_datas as $key => $values) {
			$booking_id = $values["booking_id"];
			$booking_date = date('YmdHi',strtotime("+".$period." minutes",strtotime($values["dateandtime"]))); 
			$current_date = date('YmdHi');

			if($current_date>$booking_date){
				$update_array = array(
				   'show_sellerlist'=>1,           
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
// =============

$result_datas = $db->getRows("select x.*, y.*,z.*,u.*,v.* From sp_bookings x 
	Left Join  (SELECT make as car_make,model as car_model,year as car_year,variant as car_variant,variant_id as car_variant_id from sp_car_variant a inner join sp_car_year b on a.year_id=b.year_id inner join sp_car_model c on b.model_id=c.model_id inner join sp_car_make d on c.make_id=d.make_id) as y on x.category='car' and y.car_variant_id=x.variant_id 
	LEFT JOIN  (SELECT make as bike_make,model as bike_model,year as bike_year,variant as bike_variant,variant_id as bike_variant_id from sp_bike_variant a inner join sp_bike_year b on a.year_id=b.year_id inner join sp_bike_model c on b.model_id=c.model_id inner join sp_bike_make d on c.make_id=d.make_id) as z on x.category='bike' and z.bike_variant_id=x.variant_id
	Left Join (Select carparts_id,name as carparts_name from sp_car_parts) as u on x.category='car' and u.carparts_id=x.parts_id
	Left Join (Select bikeparts_id,name as bikeparts_name from sp_bike_parts) as v on x.category='bike' and v.bikeparts_id=x.parts_id 
	Where show_sellerlist='1' and (paid_amount is NULL or paid_amount=NULL or paid_amount='') and buyer_id='$buyer_id' order by x.booking_id desc  LIMIT 1000");
	if(count($result_datas)>0){  
		$arrResult1['status'] = 'success'; 
		$arrResult1['code'] = 200; 				
		$arrResult1['message'] = "Data Found"; 
		$arrResult1['booking'] = array(); 

	    foreach ($result_datas as $keys => $values) {
	    	$seller_id=$values["seller_id"];
	    	$arrResults['booking_id']=$values["booking_id"];
	    	$arrResults['booking_status']=$values["status"];
	    	$arrResults['display_booking_id']=bookingid($values["booking_id"]);
	    	$arrResults['category']=$values["category"];
	    	$arrResults['choosed_seller_id']=isset($values["seller_id"])&&!empty($values["seller_id"])?$values["seller_id"]:"";
	    	$category=$values["category"];
	    	if($category=="car"){
				$arrResults["make"] = $values["car_make"];
				$arrResults["model"] = $values["car_model"];
				$arrResults["year"] = $values["car_year"];
				$arrResults["variant"] = $values["car_variant"];
				$arrResults["spare_parts"] = $values["carparts_name"];
			}
			elseif ($category=="bike") {
				$arrResults["make"] = $values["bike_make"];
				$arrResults["model"] = $values["bike_model"];
				$arrResults["year"] = $values["bike_year"];
				$arrResults["variant"] = $values["bike_variant"];
				$arrResults["spare_parts"] = $values["bikeparts_name"];
			}
			else{exit;}
			$arrResults["allow_payment"] = $values["allow_payment"];
			$arrResults["bids"]=array();
	    	$booking_id = $values["booking_id"];
			$bids = $db->getRows("select a.*,b.state,b.location,b.city from sp_bid a left join sp_seller b on a.seller_id=b.seller_id where booking_id='$booking_id'");
		    foreach ($bids as $key => $value) {
				$arrResult["bid_id"]=$value["bid_id"];
				$arrResult["bid_amount"]=$value["amount"];
				$arrResult["bid_return_days"]=$value["return_days"];
				$booking_seller_id = $value["seller_id"];
				$arrResult["seller_id"] = $value["seller_id"];				
				$arrResult["state"] = $value["state"];
				$arrResult["location"] = $value["location"];
				$arrResult["district"] = $value["city"];

				if($booking_seller_id==$seller_id){
					if($value["bid_status"]==1){
						$arrResult["bid_status"]="Matched";
					}
					elseif ($value["bid_status"]==2){
						$arrResult["bid_status"]="Need Product Images";
					}
					elseif ($value["bid_status"]==3){
						$arrResult["bid_status"]="Sent Images";
					}
					else{
						$arrResult["bid_status"]="Pending";
					}
				}
				elseif (is_null($booking_seller_id) || empty($booking_seller_id) || $booking_seller_id ='') {
					$arrResult["bid_status"]="Pending";
				}
				else{
					$arrResult["bid_status"]="Not Matched";
				}

				$arrResult["product_images"] = array();

				$product_images =  json_decode($value["product_images"]);$i=1;
				if($product_images!='' && count($product_images)>0){
					foreach ($product_images as $key => $values) {
						$img["id"]=$i++;
						$img["img"]=$base_url_slash.$values;
						array_push($arrResult["product_images"],$img);
					}
				}
				array_push($arrResults["bids"], $arrResult);
			}
			array_push($arrResult1["booking"], $arrResults);

		}
		echo json_encode($arrResult1);
	}
	else{
		$arrResult['status'] = 'error'; 
		$arrResult['code'] = 201; 	
		$arrResult['message'] = "No Data Found";
		echo json_encode($arrResult);
	}
?>