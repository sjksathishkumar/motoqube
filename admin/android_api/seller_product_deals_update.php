<?php include '../../config.php'; 
include 'header.php';
header('Content-type: application/json');
verifyseller();
$seller_id= $_POST["seller_id"];
if(isset($_POST["category"]) && !empty($_POST["category"])){

if($_POST["category"]=="bike"){
$fields_data = array(
          'bike_deal' => isset($_POST['bike_deal'])?$_POST['bike_deal']:'',
          'bike_parts' => isset($_POST['bike_parts'])?$_POST['bike_parts']:'',
         );
}
elseif ($_POST["category"]=="car") {

	$fields_data = array(
		'car_deal' => isset($_POST['car_deal'])?$_POST['car_deal']:'',
          'car_parts' => isset($_POST['car_parts'])?$_POST['car_parts']:'',
      );

}
else{
	error203();
}
	 $result = $db->updateAry('sp_seller', $fields_data,"where seller_id='$seller_id'");
			if($db->getAffectedRows()>0){ 
				$arrResult2['status'] = 'success'; 
				$arrResult2['code'] = 200; 				
				$arrResult2['message'] = "Updated Successfully !";	
			}
			else{
				$arrResult2['status'] = 'error'; 
				$arrResult2['code'] = 201; 				
				$arrResult2['message'] = "No Changes Applied";
			}
			echo json_encode($arrResult2);
			exit;
}
else{
	error203();
}


