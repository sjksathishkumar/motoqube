<?php include '../../config.php'; 
include 'header.php';$buyer=verifybuyer();
header('Content-type: application/json');
if (isset($_POST['buyer_id']) && !empty($_POST['buyer_id']) 
&& isset($_POST['category']) && !empty($_POST['category'])
&& isset($_POST['parts_id']) && !empty($_POST['parts_id'])){

$category = $_POST['category'];
$buyer_id = $_POST['buyer_id'];

	function upload_new_voice_file($field_name, $directory_path, $add_extensions='', $change_file_name='')
	{
	if( !empty($field_name) && !empty($directory_path) )
  	{
  		$field_name = trim($field_name);
  		$directory_path = trim($directory_path);
  		
		if( !file_exists($directory_path) )
		{
			mkdir($directory_path, 0777, true);
		}

		$new_file_name = '';
		$file_upload_status = '';
		              
		if( $_FILES[$field_name]['name'] != '' )
		{
			$file_extensions = '';

			if( empty($add_extensions) )
			{
			  	$file_extensions = array('wav', 'aif','mp3','mid','3gp');
			}
			else
			{
			  	$file_extensions = array('wav', 'aif','mp3','mid','3gp');
			  	$add_extensions = explode(",", $add_extensions);

			  	$file_extensions = array_merge($file_extensions, $add_extensions);
			}

			$file_name = $_FILES[$field_name]['name'];

			$extension = strtolower( substr($file_name, strrpos($file_name, '.') + 1) );

			if( in_array($extension, $file_extensions) )
			{
				if( !empty($change_file_name) && ($change_file_name == 'no') )
				{
					$new_file_name = $file_name;
				}
				else
				{
					$new_file_name = md5($_FILES[$field_name]['tmp_name']).".".$extension;
				}

				if( move_uploaded_file($_FILES[$field_name]['tmp_name'], $directory_path.$new_file_name) )
				{
					$file_upload_status = 'uploaded';
				}
				else
				{
					$file_upload_status = 'not_uploaded';
				}
			}
			else
			{
			  	$file_upload_status = 'invalid_format';
			}

			$result = array( 'new_file_name'=>$new_file_name, 'file_upload_status'=>$file_upload_status );
		}
		else
		{
			$file_upload_status = 'not_exist';

			$result = array( 'new_file_name'=>$new_file_name, 'file_upload_status'=>$file_upload_status );
		}

		return $result;
	}
	}
		$voice='';
		if( isset($_FILES['voice']['name']) && !empty($_FILES['voice']['name']) )
	    {
			$file_uploaded_result = upload_new_voice_file('voice', '../../document/booking_audio/', '', 'yes');
		     if($file_uploaded_result['file_upload_status'] == 'uploaded')
		     {
		       $voice = 'document/booking_audio/'.$file_uploaded_result['new_file_name'];
		     }
		     else
		     {
		       $voice = '';
		     }
		 }

		$image_name=array();
			/*if(isset($_FILES['images']['name']) && !empty($_FILES['images']['name'])){
			$countfiles = count($_FILES['images']['name']);				 
				 // Looping all files
				for($i=0;$i<$countfiles;$i++){

				    $file_uploaded_result = upload_new_multiple_file('images', '../../images/bookings/', $i, 'yes');
		            if( $file_uploaded_result['file_upload_status'] == 'uploaded')
		            {
		              $image_name[] = 'images/bookings/'.$file_uploaded_result['new_file_name'];
		            }
		            else
		            {
		              $image_name = array();
		            }
		        }
		    }*/

		   		  
	    $images = (array) $_POST['images'];				 
    	 // Looping all files
		foreach($images as $countfiles) {
		    $img = str_replace('data:image/png;base64,', '', $countfiles);   
		    $img = str_replace(' ', '+', $img);   
		    $data = base64_decode($img);   
		    $original_file = "images/bookings/". uniqid() . '.png';
		    $file = "../../".$original_file; 
		     
		    $success = file_put_contents($file, $data);   
		    if(file_exists($file))
		    {
		    	 $image_name[] = $original_file; 
		    }
		}
		$status_track[]["enquiry created"]=date('d-m-y h:i:s a');
		$parts_id = isset($_POST['parts_id'])?$_POST['parts_id']:'';
		$locations = isset($_POST['locations'])?$_POST['locations']:'';
		$category = isset($_POST['category'])?$_POST['category']:'';
		$variant_id = isset($_POST['variant_id'])?$_POST['variant_id']:'';
		$fields_data = array(
          'buyer_id'  => isset($_POST['buyer_id'])?$_POST['buyer_id']:'',
          'category'  => $category,
          'locations'  => $locations,
          'variant_id'  => $variant_id,
          'parts_id'  => $parts_id,
          'description'  => isset($_POST['description'])?$_POST['description']:'',
          'voice'  => isset($voice)?$voice:'',
          'images'  => json_encode($image_name),
          'status_track'=>json_encode($status_track),
          'status'=>'enquiry created',
        );
          $result = $db->insertAry('sp_bookings', $fields_data);
         	$booking_id = $db->getLastId();
			notification_insert("booking",$booking_id,$buyer['name']);
			$make_id=0;
			if($category=="car"){
				$make_id = $db->getVal("SELECT b.make_id from sp_car_variant a left join sp_car_make b on a.make_id=b.make_id where variant_id='$variant_id' limit 1");
			}
			elseif ($category=="bike") {
				$make_id = $db->getVal("SELECT b.make_id from sp_bike_variant a left join sp_bike_make b on a.make_id=b.make_id where variant_id='$variant_id' limit 1");
			}

			locationbasednotifications($locations,$parts_id,$category,$make_id);

			if(!is_null($result)){ 
				$arrResult2['status'] = 'success'; 
				$arrResult2['code'] = 200; 				
				$arrResult2['message'] = "Enquiry Created Successfully !";	
				$arrResult2['booking_id'] = $booking_id;
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
		//echo $db->getLastQuery();
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