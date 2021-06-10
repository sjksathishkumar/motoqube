<?php include '../../config.php'; 
include 'header.php';
header('Content-type: application/json');
if (isset($_POST['buyer_id']) && !empty($_POST['buyer_id']) 
&& isset($_POST['name']) && !empty($_POST['name']) 
&& isset($_POST['address']) && !empty($_POST['address'])
&& isset($_POST['district']) && !empty($_POST['district'])
&& isset($_POST['state']) && !empty($_POST['state'])
&& isset($_POST['pincode']) && !empty($_POST['pincode'])){
	$email = $_POST["email"];
	$buyer_id=$_POST['buyer_id'];
     			$image_name = str_replace($base_url, '',isset($_POST['profile_image_old'])?$_POST['profile_image_old']:'');
      		// 	if( isset($_FILES['profile_image']['name']) && !empty($_FILES['profile_image']['name']) )
        //  		{
				    // $file_uploaded_result = upload_new_single_file('profile_image', '../../images/buyer/', '', 'yes');
		      //       if( $file_uploaded_result['file_upload_status'] == 'uploaded')
		      //       {
		      //         unlink_uploaded_old_single_file($image_name);
		      //         $image_name = 'images/buyer/'.$file_uploaded_result['new_file_name'];
		      //       }
		      //       else
		      //       {
		      //         $image_name = '';
		      //       }
		      //   }

		    if(isset($_POST["profile_image"]) && !empty($_POST["profile_image"])){
		    	$profile_image = $_POST["profile_image"];
		        $img = str_replace('data:image/png;base64,', '', $profile_image);   
			    $img = str_replace(' ', '+', $img);   
			    $data = base64_decode($img);   
			    $original_file = "images/buyer/". uniqid() . '.png';
			    $file = "../../".$original_file; 
			     
			    $success = file_put_contents($file, $data);   
			    if(file_exists($file))
			    {
			    	 $image_name = $original_file; 
			    }
			}
		$fields_data = array(
          'name'  => isset($_POST['name'])?$_POST['name']:'',
          'alternate_mobile'  => isset($_POST['alternate_mobile'])?$_POST['alternate_mobile']:'',
          'email'  => isset($_POST['email'])?$_POST['email']:'',
          'address'  => isset($_POST['address'])?$_POST['address']:'',
          'landmark'  => isset($_POST['landmark'])?$_POST['landmark']:'',
          'state'  => isset($_POST['state'])?$_POST['state']:'',
          'city'  => isset($_POST['district'])?$_POST['district']:'',
          'location'  => isset($_POST['location'])?$_POST['location']:'',
          'pincode'  => isset($_POST['pincode'])?$_POST['pincode']:'',
          'profile_image'  => isset($image_name)?$image_name:'',
        );
          $result = $db->updateAry('sp_buyer', $fields_data,"where buyer_id='$buyer_id'");

			if($db->getAffectedRows()>0){ 
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
