<?php include '../../config.php'; 
include 'header.php';
header('Content-type: application/json');
if (isset($_POST['action']) && !empty($_POST['action'])){
$action = $_POST["action"];
switch ($action) {
	case 'get_car_make':{
		$Details = $db->getRows("SELECT * FROM `sp_car_make` order by priority");	
		if (count($Details) > 0) {
			$arrResult1['status'] = 'success'; 
			$arrResult1['code'] = 200; 	
			$arrResult1['Data'] = array(); 				

			foreach ($Details as $key => $value) {
				$arrResults['make_id'] = $value['make_id'];	
				$arrResults['make'] = $value['make'];
				$arrResults['make_image'] = $base_url_slash.$value['make_image'];	
				array_push($arrResult1['Data'], $arrResults);
			}
		}
		else{
			$arrResult1['status'] = 'error'; 
			$arrResult1['code'] = 201; 				
			$arrResult1['message'] = 'No Data Found';
		}
		echo json_encode($arrResult1);
		exit;
	}

	case 'get_car_model':{
		if(isset($_POST["make_id"])){
			$make_id= json_decode($_POST["make_id"]);
			$make_id = isset($make_id)&&!empty($make_id)?implode("','", $make_id):"0";
			$Details = $db->getRows("SELECT * FROM `sp_car_model` where make_id IN('$make_id')");	
			if (count($Details) > 0) {
				$arrResult1['status'] = 'success'; 
				$arrResult1['code'] = 200; 	
				$arrResult1['Data'] = array(); 				

				foreach ($Details as $key => $value) {
					$arrResults['model_id'] = $value['model_id'];	
					$arrResults['model'] = $value['model'];
					$arrResults['model_image'] = $base_url_slash.$value['model_image'];	
					array_push($arrResult1['Data'], $arrResults);
				}
			}
			else{
				$arrResult1['status'] = 'error'; 
				$arrResult1['code'] = 201; 				
				$arrResult1['message'] = 'No Data Found';
			}
			echo json_encode($arrResult1);
			exit;
		}
		else{
			error203();
		}
	}
	case 'get_car_year':{
		if(isset($_POST["model_id"])){
			$model_id= json_decode($_POST["model_id"]);
			$model_id = isset($model_id)&&!empty($model_id)?implode("','", $model_id):"0";
			$Details = $db->getRows("SELECT * FROM `sp_car_year` where model_id IN('$model_id')");	
			if (count($Details) > 0) {
				$arrResult1['status'] = 'success'; 
				$arrResult1['code'] = 200; 	
				$arrResult1['Data'] = array(); 				

				foreach ($Details as $key => $value) {
					$arrResults['year_id'] = $value['year_id'];	
					$arrResults['year'] = $value['year'];	
					array_push($arrResult1['Data'], $arrResults);
				}
			}
			else{
				$arrResult1['status'] = 'error'; 
				$arrResult1['code'] = 201; 				
				$arrResult1['message'] = 'No Data Found';
			}
			echo json_encode($arrResult1);
			exit;
		}
		else{
			error203();
		}
	}
	case 'get_car_variant':{
		if(isset($_POST["year_id"])){
			$year_id= json_decode($_POST["year_id"]);
			$year_id = isset($year_id)&&!empty($year_id)?implode("','", $year_id):"0";
			$Details = $db->getRows("SELECT * FROM `sp_car_variant` where year_id IN('$year_id')");	
			if (count($Details) > 0) {
				$arrResult1['status'] = 'success'; 
				$arrResult1['code'] = 200; 	
				$arrResult1['Data'] = array(); 				

				foreach ($Details as $key => $value) {
					$arrResults['variant_id'] = $value['variant_id'];	
					$arrResults['variant'] = $value['variant'];	
					array_push($arrResult1['Data'], $arrResults);
				}
			}
			else{
				$arrResult1['status'] = 'error'; 
				$arrResult1['code'] = 201; 				
				$arrResult1['message'] = 'No Data Found';
			}
			echo json_encode($arrResult1);
			exit;
		}
		else{
			error203();
		}
	}
	case 'get_car_parts':{
		$Details = $db->getRows("SELECT * FROM `sp_car_parts`");	
		if (count($Details) > 0) {
			$arrResult1['status'] = 'success'; 
			$arrResult1['code'] = 200; 	
			$arrResult1['Data'] = array(); 				

			foreach ($Details as $key => $value) {
				$arrResults['carparts_id'] = $value['carparts_id'];	
				$arrResults['name'] = $value['name'];
				$arrResults['info'] = $value['info'];
				$arrResults['image'] = $base_url_slash.$value['image'];	
				array_push($arrResult1['Data'], $arrResults);
			}
		}
		else{
			$arrResult1['status'] = 'error'; 
			$arrResult1['code'] = 201; 				
			$arrResult1['message'] = 'No Data Found';
		}
		echo json_encode($arrResult1);
		exit;
	}

	// bike-------------------------------
		case 'get_bike_make':{
		$Details = $db->getRows("SELECT * FROM `sp_bike_make` order by priority");	
		if (count($Details) > 0) {
			$arrResult1['status'] = 'success'; 
			$arrResult1['code'] = 200; 	
			$arrResult1['Data'] = array(); 				

			foreach ($Details as $key => $value) {
				$arrResults['make_id'] = $value['make_id'];	
				$arrResults['make'] = $value['make'];
				$arrResults['make_image'] = $base_url_slash.$value['make_image'];	
				array_push($arrResult1['Data'], $arrResults);
			}
		}
		else{
			$arrResult1['status'] = 'error'; 
			$arrResult1['code'] = 201; 				
			$arrResult1['message'] = 'No Data Found';
		}
		echo json_encode($arrResult1);
		exit;
	}

	case 'get_bike_model':{
		if(isset($_POST["make_id"])){
			$make_id= json_decode($_POST["make_id"]);
			$make_id = isset($make_id)&&!empty($make_id)?implode("','", $make_id):"0";
			$Details = $db->getRows("SELECT * FROM `sp_bike_model` where make_id IN('$make_id')");	
			if (count($Details) > 0) {
				$arrResult1['status'] = 'success'; 
				$arrResult1['code'] = 200; 	
				$arrResult1['Data'] = array(); 				

				foreach ($Details as $key => $value) {
					$arrResults['model_id'] = $value['model_id'];	
					$arrResults['model'] = $value['model'];
					$arrResults['model_image'] = $base_url_slash.$value['model_image'];	
					array_push($arrResult1['Data'], $arrResults);
				}
			}
			else{
				$arrResult1['status'] = 'error'; 
				$arrResult1['code'] = 201; 				
				$arrResult1['message'] = 'No Data Found';
			}
			echo json_encode($arrResult1);
			exit;
		}
		else{
			error203();
		}
	}
	case 'get_bike_year':{
		if(isset($_POST["model_id"])){
			$model_id= json_decode($_POST["model_id"]);
			$model_id = isset($model_id)&&!empty($model_id)?implode("','", $model_id):"0";
			$Details = $db->getRows("SELECT * FROM `sp_bike_year` where model_id IN('$model_id')");	
			if (count($Details) > 0) {
				$arrResult1['status'] = 'success'; 
				$arrResult1['code'] = 200; 	
				$arrResult1['Data'] = array(); 				

				foreach ($Details as $key => $value) {
					$arrResults['year_id'] = $value['year_id'];	
					$arrResults['year'] = $value['year'];	
					array_push($arrResult1['Data'], $arrResults);
				}
			}
			else{
				$arrResult1['status'] = 'error'; 
				$arrResult1['code'] = 201; 				
				$arrResult1['message'] = 'No Data Found';
			}
			echo json_encode($arrResult1);
			exit;
		}
		else{
			error203();
		}
	}
	case 'get_bike_variant':{
		if(isset($_POST["year_id"])){
			$year_id= json_decode($_POST["year_id"]);
			$year_id = isset($year_id)&&!empty($year_id)?implode("','", $year_id):"0";
			$Details = $db->getRows("SELECT * FROM `sp_bike_variant` where year_id IN('$year_id')");	
			if (count($Details) > 0) {
				$arrResult1['status'] = 'success'; 
				$arrResult1['code'] = 200; 	
				$arrResult1['Data'] = array(); 				

				foreach ($Details as $key => $value) {
					$arrResults['variant_id'] = $value['variant_id'];	
					$arrResults['variant'] = $value['variant'];	
					array_push($arrResult1['Data'], $arrResults);
				}
			}
			else{
				$arrResult1['status'] = 'error'; 
				$arrResult1['code'] = 201; 				
				$arrResult1['message'] = 'No Data Found';
			}
			echo json_encode($arrResult1);
			exit;
		}
		else{
			error203();
		}
	}
	case 'get_bike_parts':{
		$Details = $db->getRows("SELECT * FROM `sp_bike_parts`");	
		if (count($Details) > 0) {
			$arrResult1['status'] = 'success'; 
			$arrResult1['code'] = 200; 	
			$arrResult1['Data'] = array(); 				

			foreach ($Details as $key => $value) {
				$arrResults['bikeparts_id'] = $value['bikeparts_id'];	
				$arrResults['name'] = $value['name'];
				$arrResults['info'] = $value['info'];
				$arrResults['image'] = $base_url_slash.$value['image'];	
				array_push($arrResult1['Data'], $arrResults);
			}
		}
		else{
			$arrResult1['status'] = 'error'; 
			$arrResult1['code'] = 201; 				
			$arrResult1['message'] = 'No Data Found';
		}
		echo json_encode($arrResult1);
		exit;
	}
	// ---------------------
}
}
else{
	error203();
}
?>