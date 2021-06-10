<?php 
include '../../config.php'; 
include 'header.php';
header('Content-type: application/json');
verifybuyer();
$buyer_id= $_POST["buyer_id"];
$result_data = $db->getRows("select x.*, y.*,z.*,u.*,v.*,w.name as buyer,w.profile_image,bid.bid_id,bid.amount,bid.return_days,bid.product_images, bid.bid_status,package_images, shipping_images,x.dateandtime as bookingdate From sp_bookings x 
	Left Join  (SELECT make as car_make,model as car_model,year as car_year,variant as car_variant,variant_id as car_variant_id from sp_car_variant a inner join sp_car_year b on a.year_id=b.year_id inner join sp_car_model c on b.model_id=c.model_id inner join sp_car_make d on c.make_id=d.make_id) as y on x.category='car' and y.car_variant_id=x.variant_id 
	LEFT JOIN  (SELECT make as bike_make,model as bike_model,year as bike_year,variant as bike_variant,variant_id as bike_variant_id from sp_bike_variant a inner join sp_bike_year b on a.year_id=b.year_id inner join sp_bike_model c on b.model_id=c.model_id inner join sp_bike_make d on c.make_id=d.make_id) as z on x.category='bike' and z.bike_variant_id=x.variant_id
	Left Join (Select carparts_id,name as carparts_name,image as carparts_image from sp_car_parts) as u on x.category='car' and u.carparts_id=x.parts_id
	Left Join (Select bikeparts_id,name as bikeparts_name,image as bikeparts_image from sp_bike_parts) as v on x.category='bike' and v.bikeparts_id=x.parts_id
	Left JOIN sp_buyer w on x.buyer_id=w.buyer_id
	Left JOIN sp_bid bid on bid.bid_id=x.bid_id
	Where x.buyer_id='$buyer_id' 
	order by x.booking_id desc LIMIT 100
");

if(count($result_data)>0){
		$arrResult['status'] = 'success'; 
		$arrResult['code'] = 200; 	
		$arrResult['message'] = "Data Found"; 	
		$arrResult['Data'] = array();
	foreach ($result_data as $key => $value) {
		$arrResults["booking_id"]=$value["booking_id"];
		$arrResults["display_booking_id"]=bookingid($value["booking_id"]);
		$arrResults["booking_date"]=date('d-m-Y H:i:s',strtotime($value["bookingdate"]));		
		$category=$value["category"];
		$arrResults["category"] = $category;
		$arrResults["buyer"] = $value["buyer"];
		$arrResults["profile_image"] =(isset($value["profile_image"])&&!empty($value["profile_image"]))?$base_url_slash.$value["profile_image"]:'';
		$arrResults["description"] = $base_url_slash.$value["description"];
		$arrResults["images"] = array();

		$images =  (array) json_decode($value["images"]);$i=1;
		foreach ($images as $key => $values) {
			$img["id"]=$i++;
			$img["img"]=$base_url_slash.$values;
			array_push($arrResults["images"],$img);
		}

		$arrResults["product_images"] = array();

		$product_images = (array) json_decode($value["product_images"]);$i=1;
		foreach ($product_images as $key => $values) {
			$img["id"]=$i++;
			$img["img"]=$base_url_slash.$values;
			array_push($arrResults["product_images"],$img);
		}
		
		$arrResults["description"] = $value["description"];
		$arrResults["voice"] = (isset($value["voice"])&&!empty($value["voice"]))?$base_url_slash.$value["voice"]:'';
		$arrResults["locations"] = $value["locations"];
		$arrResults["booking_status"] = (isset($value["status"])&&!empty($value["status"])&&$value["status"]!='NULL')?$value["status"]:'';
		$arrResults["show_sellerlist"] = $value["show_sellerlist"];


		if($category=="car"){
			$arrResults["make"] = $value["car_make"];
			$arrResults["model"] = $value["car_model"];
			$arrResults["year"] = $value["car_year"];
			$arrResults["variant"] = $value["car_variant"];
			$arrResults["spare_parts"] = $value["carparts_name"];
			$arrResults["booking_image"] = (isset($value["carparts_image"])&&!empty($value["carparts_image"]))?$base_url_slash.$value["carparts_image"]:'';

		}
		elseif ($category=="bike") {
			$arrResults["make"] = $value["bike_make"];
			$arrResults["model"] = $value["bike_model"];
			$arrResults["year"] = $value["bike_year"];
			$arrResults["variant"] = $value["bike_variant"];
			$arrResults["spare_parts"] = $value["bikeparts_name"];
			$arrResults["booking_image"] = (isset($value["bikeparts_image"])&&!empty($value["bikeparts_image"]))?$base_url_slash.$value["bikeparts_image"]:'';

		}
		else{exit;}
		
		$arrResults["bid_id"]=(isset($value["bid_id"])&&!empty($value["bid_id"])&&$value["bid_id"]!='NUll')?$value["bid_id"]:'';
		$arrResults["seller_id"]=(isset($value["seller_id"])&&!empty($value["seller_id"])&&$value["seller_id"]!='NUll')?$value["seller_id"]:'';
		$arrResults["display_seller_id"]=(isset($value["seller_id"])&&!empty($value["seller_id"])&&$value["seller_id"]!='NUll')?sellerid($value["seller_id"]):'';

		if(!empty($value["paid_amount"]) && $value["paid_amount"]!=NULL){
			$arrResults["show_seller_details"]=1;
		}
		else{
			$arrResults["show_seller_details"]=0;
		}
		
		
		$arrResults["package_images"] = array();
		$package_images =  json_decode($value["package_images"]);$i=1;
		if(is_array($package_images)){
			foreach ($package_images as $key => $values) {
				$img["id"]=$i++;
				$img["img"]=$base_url_slash.$values;
				array_push($arrResults["package_images"],$img);
			}
		}


		$arrResults["shipping_images"] = array();		
		$shipping_images =  json_decode($value["shipping_images"]);$i=1;
		if(is_array($shipping_images)){			
			foreach ($shipping_images as $key => $values) {
				$img["id"]=$i++;
				$img["img"]=$base_url_slash.$values;

				array_push($arrResults["shipping_images"],$img);
			}
		}
		

		$arrResults["bid_amount"]=(isset($value["amount"])&&!empty($value["amount"])&&$value["amount"]!='NUll')?$value["amount"]:'';
		$arrResults["bid_return_days"]=(isset($value["return_days"])&&!empty($value["return_days"])&&$value["return_days"]!='NUll')?$value["return_days"]:'';
		$booking_seller_id = $value["seller_id"];
		if(!is_null($booking_seller_id) && !empty($booking_seller_id) && $booking_seller_id !=''){
			if($value["bid_status"]==1){
				$arrResults["bid_status"]="Matched";
			}
			elseif ($value["bid_status"]==2){
				$arrResults["bid_status"]="Need Product Images";
			}
			elseif ($value["bid_status"]==3){
				$arrResults["bid_status"]="Sent Images";
			}
			else{
				$arrResults["bid_status"]="Pending";
			}
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


