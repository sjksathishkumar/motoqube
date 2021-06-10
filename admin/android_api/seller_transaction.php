<?php 
include '../../config.php'; 
include 'header.php';
header('Content-type: application/json');
verifyseller();
$seller_id= $_POST["seller_id"];
$result_data = $db->getRows("select x.*, y.*,z.*,u.*,v.*,w.name as buyer,w.profile_image,bid.amount,bid.return_days From sp_bookings x 
	Left Join  (SELECT make as car_make,model as car_model,year as car_year,variant as car_variant,variant_id as car_variant_id from sp_car_variant a inner join sp_car_year b on a.year_id=b.year_id inner join sp_car_model c on b.model_id=c.model_id inner join sp_car_make d on c.make_id=d.make_id) as y on x.category='car' and y.car_variant_id=x.variant_id 
	LEFT JOIN  (SELECT make as bike_make,model as bike_model,year as bike_year,variant as bike_variant,variant_id as bike_variant_id from sp_bike_variant a inner join sp_bike_year b on a.year_id=b.year_id inner join sp_bike_model c on b.model_id=c.model_id inner join sp_bike_make d on c.make_id=d.make_id) as z on x.category='bike' and z.bike_variant_id=x.variant_id
	Left Join (Select carparts_id,name as carparts_name from sp_car_parts) as u on x.category='car' and u.carparts_id=x.parts_id
	Left Join (Select bikeparts_id,name as bikeparts_name from sp_bike_parts) as v on x.category='bike' and v.bikeparts_id=x.parts_id
	Left JOIN sp_buyer w on x.buyer_id=w.buyer_id
	Left JOIN sp_bid bid on bid.booking_id=x.booking_id
	Where x.seller_id='$seller_id' and bid.seller_id='$seller_id' and x.paid_amount!='' and x.paid_amount is not null and x.paid_amount>=bid.amount and (bid.bid_status='1' or bid.bid_status='3') and (x.status!='cancelled' and x.status!='cancel requested' and x.status!='returned' and x.status!='return requested')
	order by x.booking_id desc LIMIT 100");

if(count($result_data)>0){
		$arrResult['status'] = 'success'; 
		$arrResult['code'] = 200; 	
		$arrResult['message'] = "Data Found"; 	
		$arrResult['Data'] = array();
	foreach ($result_data as $key => $value) {
		$arrResults["booking_id"]=$value["booking_id"];
		$arrResults["display_booking_id"]=bookingid($value["booking_id"]);
		$category=$value["category"];
		$arrResults["category"] = $category;
		$arrResults["buyer"] = $value["buyer"];
		$arrResults["profile_image"] = (isset($value["profile_image"])&&!empty($value["profile_image"]))?$base_url_slash.$value["profile_image"]:'';
		$arrResults["description"] = $base_url_slash.$value["description"];
		$arrResults["images"] = array();

		$images =  json_decode($value["images"]);$i=1;
		foreach ($images as $key => $values) {
			$img["id"]=$i++;
			$img["img"]=$base_url_slash.$values;

			array_push($arrResults["images"],$img);
		}
		
		$arrResults["description"] = $value["description"];
		$arrResults["voice"] = (isset($value["voice"])&&!empty($value["voice"]))?$base_url_slash.$value["voice"]:'';
		$arrResults["locations"] = $value["locations"];
		$arrResults["booking_status"] = $value["status"];

		if($category=="car"){
			$arrResults["make"] = $value["car_make"];
			$arrResults["model"] = $value["car_model"];
			$arrResults["year"] = $value["car_year"];
			$arrResults["variant"] = $value["car_variant"];
			$arrResults["spare_parts"] = $value["carparts_name"];
		}
		elseif ($category=="bike") {
			$arrResults["make"] = $value["bike_make"];
			$arrResults["model"] = $value["bike_model"];
			$arrResults["year"] = $value["bike_year"];
			$arrResults["variant"] = $value["bike_variant"];
			$arrResults["spare_parts"] = $value["bikeparts_name"];
		}
		else{exit;}
		$arrResults["bid_amount"]=$value["amount"];
		$arrResults["bid_return_days"]=$value["return_days"];
		$booking_seller_id = $value["seller_id"];
		if($booking_seller_id==$seller_id){
			$arrResults["bid_status"]="Matched";
		}
		elseif (is_null($booking_seller_id) || empty($booking_seller_id) || $booking_seller_id ='') {
			$arrResults["bid_status"]="Pending";
		}
		else{
			$arrResults["bid_status"]="Not Matched";
		}
		array_push($arrResult["Data"], $arrResults);
	}
}
else{
	$arrResult['status'] = 'error'; 
	$arrResult['code'] = 201; 	
	$arrResult['message'] = "No Data Found";
}
echo json_encode($arrResult);


