<?php 
include '../../config.php'; 
include 'header.php';
header('Content-type: application/json');
verifyseller();
$seller_id= $_POST["seller_id"];
$result_data = $db->getRows("select x.*, y.*,z.*,u.*,v.*,w.name as buyer,w.profile_image From sp_bookings x 
	Left Join  (SELECT make as car_make,d.make_id,model as car_model,year as car_year,variant as car_variant,variant_id as car_variant_id from sp_car_variant a inner join sp_car_year b on a.year_id=b.year_id inner join sp_car_model c on b.model_id=c.model_id inner join sp_car_make d on c.make_id=d.make_id) as y on x.category='car' and y.car_variant_id=x.variant_id 
	LEFT JOIN  (SELECT make as bike_make,d.make_id,model as bike_model,year as bike_year,variant as bike_variant,variant_id as bike_variant_id from sp_bike_variant a inner join sp_bike_year b on a.year_id=b.year_id inner join sp_bike_model c on b.model_id=c.model_id inner join sp_bike_make d on c.make_id=d.make_id) as z on x.category='bike' and z.bike_variant_id=x.variant_id
	Left Join (Select carparts_id,name as carparts_name from sp_car_parts) as u on x.category='car' and u.carparts_id=x.parts_id
	Left Join (Select bikeparts_id,name as bikeparts_name from sp_bike_parts) as v on x.category='bike' and v.bikeparts_id=x.parts_id
	Left JOIN sp_buyer w on x.buyer_id=w.buyer_id
	Left JOIN sp_seller sell on sell.seller_id='$seller_id'
	Where (FIND_IN_SET(sell.location, x.locations) > 0 or FIND_IN_SET(sell.city, x.locations) > 0) and x.status='enquiry created' and (x.seller_id='$seller_id' or (x.category ='car' and FIND_IN_SET(u.carparts_id,replace(replace(replace(sell.car_parts,'[',''),']',''),'\"',''))>0  and FIND_IN_SET(y.make_id,replace(replace(replace(sell.car_deal,'[',''),']',''),'\"',''))>0  ) or (x.category ='bike' and FIND_IN_SET(bikeparts_id,replace(replace(replace(sell.bike_parts,'[',''),']',''),'\"',''))>0 and FIND_IN_SET(z.make_id,replace(replace(replace(sell.bike_deal,'[',''),']',''),'\"',''))>0 ))
	order by x.booking_id desc LIMIT 50
");


$time = $db->getRow("select value,value2 from settings where se_id='5'");
$period = $db->getVal("select value,value2 from settings where se_id='1'");

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
		$arrResults["booking_status"] = $value["status"];
		$arrResults["locations"] = $value["locations"];
		$to_time = strtotime($value["dateandtime"]);
		$from_time = strtotime(date('Y-m-d H:i:s'));
 		$minutes = round(abs($to_time - $from_time) / 60,2);


				$from= date('YmdHi',strtotime($time["value"]));
				$to= date('YmdHi',strtotime($time["value2"]));
				$current_date = date('YmdHi');

				if($current_date>=$from && $current_date<=$to){
					$hold=1;
				}
				else{
					$hold=0;
				}
				$cooling_time =$period;

 		if(($minutes>$cooling_time && $hold == 0) || $hold==1){
 			$arrResults["bidding_status"] = "Closed";
 		}
 		else{
 			$arrResults["bidding_status"] = "New";
 		}

		if($category=="car"){
			$arrResults["make"] = isset($value["car_make"])&&$value["car_make"]!=NULL?$value["car_make"]:"";
			$arrResults["model"] = isset($value["car_model"])&&$value["car_model"]!=NULL?$value["car_model"]:"";
			$arrResults["year"] = isset($value["car_year"])&&$value["car_year"]!=NULL?$value["car_year"]:"";
			$arrResults["variant"] = isset($value["car_variant"])&&$value["car_variant"]!=NULL?$value["car_variant"]:"";
			$arrResults["spare_parts"] = isset($value["carparts_name"])&&$value["carparts_name"]!=NULL?$value["carparts_name"]:"";
		}
		elseif ($category=="bike") {
			$arrResults["make"] = isset($value["bike_make"])&&$value["bike_make"]!=NULL?$value["bike_make"]:"";
			$arrResults["model"] = isset($value["bike_model"])&&$value["bike_model"]!=NULL?$value["bike_model"]:"";
			$arrResults["year"] = isset($value["bike_year"])&&$value["bike_year"]!=NULL?$value["bike_year"]:"";
			$arrResults["variant"] = isset($value["bike_variant"])&&$value["bike_variant"]!=NULL?$value["bike_variant"]:"";
			$arrResults["spare_parts"] = isset($value["bikeparts_name"])&&$value["bikeparts_name"]!=NULL?$value["bikeparts_name"]:"";
		}
		else{exit;}
		array_push($arrResult["Data"], $arrResults);
	}
}
else{
	$arrResult['status'] = 'error'; 
	$arrResult['code'] = 201; 	
	$arrResult['message'] = "No Data Found";
}

echo json_encode($arrResult);

