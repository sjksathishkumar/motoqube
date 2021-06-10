<?php 
include '../../config.php'; 
include 'header.php';
header('Content-type: application/json');
verifyseller();
$seller_id= $_POST["seller_id"];
		if(isset($_POST["bid_id"]) ){
			$bid_id= $_POST["bid_id"];

			$Details = $db->getRow("SELECT * FROM `sp_bid` where bid_id ='$bid_id' Limit 1");	
			if (count($Details) > 0) {
			$pack_image_name=json_decode($Details["product_images"]);
			}
			else{
			$pack_image_name=array();
			}

			// if(isset($_FILES['product_images']['name'])&&!empty($_FILES['product_images']['name'])){
			// $countfiles = count($_FILES['product_images']['name']);				 
			// 	// Looping all files
			// 	for($i=0;$i<$countfiles;$i++){

			// 	    $file_uploaded_result = upload_new_multiple_file('product_images', '../../images/bid_images/', $i, 'yes');
		 //            if( $file_uploaded_result['file_upload_status'] == 'uploaded')
		 //            {
		 //              $pack_image_name[] = 'images/bid_images/'.$file_uploaded_result['new_file_name'];
		 //            }
		 //            else
		 //            {
		 //              $pack_image_name = '';
		 //            }
		 //        }

		      if(isset($_POST["product_images"])){
		    	$product_images = $_POST["product_images"];
		       foreach($product_images as $countfiles) {
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
			

			$datas = array(
			 'product_images'=>json_encode($pack_image_name),
			 'bid_status'=>3,			 
			);
			$value = $db->updateAry('sp_bid',$datas,"where bid_id='$bid_id'");
			if($db->getAffectedRows()>0){ 

				$result_data = $db->getRow("select y.firebase_instance_id,x.buyer_id,booking_id From sp_bookings x left join sp_buyer y on x.buyer_id=y.buyer_id Where x.bid_id='$bid_id' Limit 1");

				if(count($result_data)>0){
					$registration_id[]=$result_data["firebase_instance_id"];
					$buyer_id=$result_data["buyer_id"];
					$booking_id=$result_data["booking_id"];					
					$title="New Update For Your Booking!!";
					$body="You have received sample product image from the seller.";
					sendfirebasenotification($registration_id,$body,$title,"NULL","booking_details",$booking_id);
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
		    else{
		    	error203();
		    }
		}
		else{
			error203();
		}
