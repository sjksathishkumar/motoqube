<?php 
include '../../config.php'; 
include 'header.php';
header('Content-type: application/json');
verifyseller();
$seller_id= $_POST["seller_id"];
if(isset($_POST["booking_id"])&&!empty($_POST["booking_id"])&&isset($_POST["booking_status"])&&!empty($_POST["booking_status"]) ){
	$booking_id=$_POST["booking_id"];
	$booking_status=$_POST["booking_status"];

$value = $db->getRow("select status_track,package_images,shipping_images,firebase_instance_id,x.buyer_id,y.name From sp_bookings x left join sp_buyer y on x.buyer_id=y.buyer_id Where x.booking_id='$booking_id' Limit 1 ");

	if(count($value)>0){
			$arrResult['status'] = 'success'; 
			$arrResult['code'] = 200; 	
			$arrResult['message'] = "Data Found";
			$arrResult['Data'] = array();
			$status_track = array();
			$status_track = json_decode($value["status_track"]);
			$pack_image = (!empty($value["package_images"]))?json_decode($value["package_images"]):array();
			$ship_image = (!empty($value["shipping_images"]))?json_decode($value["shipping_images"]):array();


			foreach ($status_track as $key => $track) {
				foreach ($track as $keys => $values){
					if($keys==$booking_status){
						$arrResult2['status'] = 'error'; 
						$arrResult2['code'] = 201; 				
						$arrResult2['message'] = "Updation Failed! Already Updated";	
						echo json_encode($arrResult2);exit;
					}
				}
			}

			$pack_image_name=$pack_image;
			// if(isset($_FILES['pack_image']['name'])&&!empty($_FILES['pack_image']['name'])){
			// $countfiles = count($_FILES['pack_image']['name']);
				 
			// 	 // Looping all files
			// 	for($i=0;$i<$countfiles;$i++){

			// 	    $file_uploaded_result = upload_new_multiple_file('pack_image', '../../images/product_shipment/', $i, 'yes');
		 //            if( $file_uploaded_result['file_upload_status'] == 'uploaded')
		 //            {
		 //              $pack_image_name[] = 'images/product_shipment/'.$file_uploaded_result['new_file_name'];
		 //            }
		 //            else
		 //            {
		 //              $pack_image_name = '';
		 //            }
		 //        }
		 //    }
			if(isset($_POST['pack_image'])){
		     	$pack_image = (array) $_POST['pack_image'];				 
		    	 // Looping all files
				foreach($pack_image as $countfiles) {
				    $img = str_replace('data:image/png;base64,', '', $countfiles);   
				    $img = str_replace(' ', '+', $img);   
				    $data = base64_decode($img);   
				    $original_file = "images/product_shipment/". uniqid() . '.png';
				    $file = "../../".$original_file; 
				     
				    $success = file_put_contents($file, $data);   
				    if(file_exists($file))
				    {
				    	 $pack_image_name[] = $original_file; 
				    }
				}
			}


		    $shipping_image_name=$ship_image;
			// if(isset($_FILES['ship_image']['name'])&&!empty($_FILES['ship_image']['name'])){
			// $countfiles = count($_FILES['ship_image']['name']);
				 
			// 	 // Looping all files
			// 	for($i=0;$i<$countfiles;$i++){

			// 	    $file_uploaded_result = upload_new_multiple_file('ship_image', '../../images/product_shipment/', $i, 'yes');
		 //            if( $file_uploaded_result['file_upload_status'] == 'uploaded')
		 //            {
		 //            	$file_uploaded_result['new_file_name'];
		 //              $shipping_image_name[] = 'images/product_shipment/'.$file_uploaded_result['new_file_name'];
		 //            }
		 //            else
		 //            {
		 //              $shipping_image_name = '';
		 //            }
		 //        }
		 //    }
		    if(isset($_POST['ship_image'])){
		     	$ship_image = (array) $_POST['ship_image'];				 
		    	 // Looping all files
				foreach($ship_image as $countfiles) {
				    $img = str_replace('data:image/png;base64,', '', $countfiles);   
				    $img = str_replace(' ', '+', $img);   
				    $data = base64_decode($img);   
				    $original_file = "images/product_shipment/". uniqid() . '.png';
				    $file = "../../".$original_file; 
				     
				    $success = file_put_contents($file, $data);   
				    if(file_exists($file))
				    {
				    	 $shipping_image_name[] = $original_file; 
				    }
				}
			}
	
			// print_r(json_encode($status_track));
			$status_track[][$booking_status]=date('d-m-y h:i:s a');
			$datas = array(
			'status_track'=>json_encode($status_track),
			'package_images'=>json_encode($pack_image_name),
			'shipping_images'=>json_encode($shipping_image_name),
			'status'=>$booking_status,
			);
			$bookupd = $db->updateAry('sp_bookings',$datas,"where booking_id='$booking_id'");
			if($db->getAffectedRows()>0){ 

				$registration_id[] = $value["firebase_instance_id"];	
				$buyer_id = $value["buyer_id"];
				$buyer_name = $value["name"];

				$title="New Update For Your Booking!!";
				$body="Your Booking is now in the state of '".$booking_status."'. For further details please visit booking details.";
				sendfirebasenotification($registration_id,$body,$title,"NULL","booking_details",$booking_id);
				if($booking_status=="shipped"){
					notification_insert("shipped",$booking_id,$buyer_name);				
				}

				$arrResult2['status'] = 'success'; 
				$arrResult2['code'] = 200; 				
				$arrResult2['message'] = "Updated Successfully !";	
			}
			else{
				$arrResult2['status'] = 'error'; 
				$arrResult2['code'] = 201; 				
				$arrResult2['message'] = "Updation Failed !";
			}
			echo json_encode($arrResult2);
			exit;
		
	}
}