<?php 
include("../config.php");
if( isset($_POST['action']) && !empty($_POST['action']) )
{
	$action = $_POST['action'];
	switch($action)
	{	
		case 'delete_row':{ 	

			if( isset($_POST['table_name']) && !empty($_POST['table_name']) && isset($_POST['column_name']) && !empty($_POST['column_name']) && isset($_POST['value']) && !empty($_POST['value']) )
      		{
      			$table_name = $_POST['table_name'];$column_name =$_POST['column_name'];$column_value=$_POST['value'];				
      			// buyer---------------
      			if($table_name=="sp_buyer" || $table_name=="sp_bookings"){

      				$ext="1!=2";
      				if($table_name=="sp_buyer"){$ext="buyer_id='$column_value'";}
      				if($table_name=="sp_bookings"){$ext="a.booking_id='$column_value'";}

      				$options = $db->getRows("Select images,product_images,a.booking_id,package_images,shipping_images,voice from sp_bookings a left join sp_bid b on a.booking_id = b.booking_id  where $ext");
                    if(count($options)>0){
                    	foreach ($options as $key => $value) {
						//images----------
						$images =  (array) json_decode($value["images"]);$i=1;
						foreach ($images as $key => $values) {
							$id=$i++;
							$img="../".$values;
							unlink_uploaded_old_single_file($img);							
						}

						//product images----------
						$product_images =  (array) json_decode($value["product_images"]);$i=1;
						foreach ($product_images as $key => $values) {
							$id=$i++;
							$img="../".$values;
							unlink_uploaded_old_single_file($img);		
						}

						//package images----------
						$package_images = (array) json_decode($value["package_images"]);$i=1;
						foreach ($package_images as $key => $values) {
							$id=$i++;
							$img="../".$values;
							unlink_uploaded_old_single_file($img);
						}

						//Shipping images----------
						$shipping_images = (array) json_decode($value["shipping_images"]);$i=1;
						foreach ($shipping_images as $key => $values) {
							$id=$i++;
							$img="../".$values;
							unlink_uploaded_old_single_file($img);							
						}

						// voice----
						$voice = $value["voice"];
						if(!empty($voice)){	unlink_uploaded_old_single_file($base_url_slash.$voice);}


						$booking_id = $value["booking_id"];
						 $result1 = $db->delete("sp_bookings", "where buyer_id='".$column_value."'");
						 $result2 = $db->delete("sp_bid", "where booking_id='".$booking_id."'");
	      			}
	      			}
	      		}

	      		if($table_name=="sp_buyer_banner" || $table_name=="sp_seller_banner"){
      				if($table_name=="sp_buyer_banner"){
      					$image = $db->getVal("Select image from sp_buyer_banner where $column_name='".$column_value."'");
      				}
      				if($table_name=="sp_seller_banner"){
      					$image = $db->getVal("Select image from sp_seller_banner where $column_name='".$column_value."'");
      				}
					unlink_uploaded_old_single_file("../".$image);							
      			}

				$result = $db->delete($table_name, "where $column_name='".$column_value."'");

		        if( $db->getAffectedRows() > 0 )
		        {
		          echo json_encode( array('validation'=>'1', 'message'=>'Record deleted successfully') );
		        }
		        else
		        {
		          echo json_encode( array('validation'=>'0', 'message'=>'Action failed! Please try again.') );
		        }
	    	}
	    	break;	
		}

		case 'insert_car_make':{ 	

			if( isset($_POST['make']) && !empty($_POST['make']) && isset($_POST["priority"]))
      		{	
      			$image_name = '';
      			$make = $_POST['make'];
      			$priority = $_POST['priority'];      			


      			if( isset($_FILES['make_image']['name']) && !empty($_FILES['make_image']['name']) )
         		{
				    $file_uploaded_result = upload_new_single_file('make_image', '../images/cars/', '', 'yes');

		            if( $file_uploaded_result['file_upload_status'] == 'uploaded' )
		            {
		              $image_name = 'images/cars/'.$file_uploaded_result['new_file_name'];
		            }
		            else
		            {
		              $image_name = '';
		            }
		        }

			    $data_array = array(
	              'make' => $make,
	              'make_image' => $image_name, 
	              'priority' => $priority
	            );
	          
	          	$action_result = $db->insertAry('sp_car_make', $data_array);

	           if( !is_null($action_result) )
		        {
		          $data_message = "Details added successfully";

		          echo json_encode( array('status'=>'success','result'=>$data_message) );
		          exit;
		        }
		        else
		        {
		          $data_message = "Details is not added successfully. Please try again";

		          echo json_encode( array('status'=>'error','result'=>$data_message) );
		          exit;
		        }
	        }
	        break;	
		}
		case 'update_car_make':{ 	

			if( isset($_POST['make']) && !empty($_POST['make']) && isset($_POST['make_id']) && !empty($_POST['make_id']) && isset($_POST['make_image']) && isset($_POST['priority']) )
      		{	
      			$image_name = $_POST['make_image'];
      			$make = $_POST['make'];
	        	$make_id = $_POST['make_id'];
      			$priority = $_POST['priority'];


      			if( isset($_FILES['make_image1']['name']) && !empty($_FILES['make_image1']['name']) )
         		{
				    $file_uploaded_result = upload_new_single_file('make_image1', '../images/cars/', '', 'yes');

		            if( $file_uploaded_result['file_upload_status'] == 'uploaded' )
		            {
		              $image_name = 'images/cars/'.$file_uploaded_result['new_file_name'];
		            }
		            else
		            {
		              $image_name = '';
		            }
		        }

			    $update_array = array(
			      'priority'=>$priority,
	              'make' => $make,
	              'make_image' => $image_name,              
	            );
	          
	          	$action_result = $db->updateAry('sp_car_make', $update_array, "where make_id='".$make_id."'");

	           if( !is_null($action_result) )
		        {
		          $data_message = "Details updated successfully";

		          echo json_encode( array('status'=>'success','result'=>$data_message) );
		          exit;
		        }
		        else
		        {
		          $data_message = "Details is not updated successfully. Please try again";

		          echo json_encode( array('status'=>'error','result'=>$data_message) );
		          exit;
		        }
	        }	
	        break;
		}

		case 'insert_car_model':{ 	

			if( isset($_POST['make']) && !empty($_POST['make']) && isset($_POST['model']) && !empty($_POST['model']) )
      		{	
      			$image_name = '';
      			$model = $_POST['model'];
      			$make_id = $_POST['make'];

      			if( isset($_FILES['model_image']['name']) && !empty($_FILES['model_image']['name']) )
         		{
				    $file_uploaded_result = upload_new_single_file('model_image', '../images/cars/models/', '', 'yes');

		            if( $file_uploaded_result['file_upload_status'] == 'uploaded' )
		            {
		              $image_name = 'images/cars/models/'.$file_uploaded_result['new_file_name'];
		            }
		            else
		            {
		              $image_name = '';
		            }
		        }

			    $data_array = array(
	              'model' => $model,
	              'model_image' => $image_name,
	              'make_id' => $make_id,	                            
	            );
	          
	          	$action_result = $db->insertAry('sp_car_model', $data_array);

	           if( !is_null($action_result) )
		        {
		          $data_message = "Details added successfully";

		          echo json_encode( array('status'=>'success','result'=>$data_message) );
		          exit;
		        }
		        else
		        {
		          $data_message = "Details is not added successfully. Please try again";

		          echo json_encode( array('status'=>'error','result'=>$data_message) );
		          exit;
		        }
	        }	
	        break;
		}
		case 'update_car_model':{ 	

			if(isset($_POST['model_id']) && !empty($_POST['model_id']) && isset($_POST['model_image']) )
      		{	
      			$image_name = $_POST['model_image'];
      			$model = $_POST['model'];
	        	$model_id = $_POST['model_id'];

      			if( isset($_FILES['model_image1']['name']) && !empty($_FILES['model_image1']['name']) )
         		{
				    $file_uploaded_result = upload_new_single_file('model_image1', '../images/cars/models/', '', 'yes');

		            if( $file_uploaded_result['file_upload_status'] == 'uploaded' )
		            {
		              $image_name = 'images/cars/models/'.$file_uploaded_result['new_file_name'];
		            }
		            else
		            {
		              $image_name = '';
		            }
		        }

			    $update_array = array(
	              'model' => $model,
	              'model_image' => $image_name,              
	            );
	          
	          	$action_result = $db->updateAry('sp_car_model', $update_array, "where model_id='".$model_id."'");

	           if( !is_null($action_result) )
		        {
		          $data_message = "Details updated successfully";

		          echo json_encode( array('status'=>'success','result'=>$data_message) );
		          exit;
		        }
		        else
		        {
		          $data_message = "Details is not updated successfully. Please try again";

		          echo json_encode( array('status'=>'error','result'=>$data_message) );
		          exit;
		        }
	        }
	        break;	
		}

		case 'insert_car_year':{ 	

			if( isset($_POST['make']) && !empty($_POST['make']) && isset($_POST['model']) && !empty($_POST['model']) && isset($_POST['year']) && !empty($_POST['year']) )
      		{	
      			$model_id = $_POST['model'];
      			$make_id = $_POST['make'];
      			$year = $_POST['year'];
      			
			    $data_array = array(
	              'year' => $year,
	              'make_id' => $make_id,	                            
	              'model_id' => $model_id,		                            
	            );
	          
	          	$action_result = $db->insertAry('sp_car_year', $data_array);
	           	if(!is_null($action_result))
		        {
		          $data_message = "Details added successfully";
		          echo json_encode( array('status'=>'success','result'=>$data_message) );
		          exit;
		        }
		        else
		        {
		          $data_message = "Details is not added successfully. Please try again";

		          echo json_encode( array('status'=>'error','result'=>$data_message) );
		          exit;
		        }
	        }
	        break;	
		}
		case 'update_car_year':{ 	

			if(isset($_POST['year']) && !empty($_POST['year'])  && isset($_POST['year_id']) && !empty($_POST['year_id']) )
      		{	
      			$year = $_POST['year'];
	        	$year_id = $_POST['year_id'];

			    $update_array = array(
	              'year' => $year,          
	            );
	          
	          	$action_result = $db->updateAry('sp_car_year', $update_array, "where year_id='".$year_id."'");

	           if( !is_null($action_result) )
		        {
		          $data_message = "Details updated successfully";

		          echo json_encode( array('status'=>'success','result'=>$data_message) );
		          exit;
		        }
		        else
		        {
		          $data_message = "Details is not updated successfully. Please try again";

		          echo json_encode( array('status'=>'error','result'=>$data_message) );
		          exit;
		        }
	        }	
	        break;
		}
		case 'insert_car_variant':{ 	

			if( isset($_POST['make']) && !empty($_POST['make']) && isset($_POST['model']) && !empty($_POST['model']) && isset($_POST['year']) && !empty($_POST['year']) && isset($_POST['variant']) && !empty($_POST['variant']) )
      		{	
      			$model_id = $_POST['model'];
      			$make_id = $_POST['make'];
      			$year_id = $_POST['year'];
      			$variant = $_POST['variant'];      			
      			
			    $data_array = array(
	              'variant' => $variant,
	              'make_id' => $make_id,	                            
	              'model_id' => $model_id,	
	              'year_id' => $year_id,

	            );
	          
	          	$action_result = $db->insertAry('sp_car_variant', $data_array);
	           	if(!is_null($action_result))
		        {
		          $data_message = "Details added successfully";
		          echo json_encode( array('status'=>'success','result'=>$data_message) );
		          exit;
		        }
		        else
		        {
		          $data_message = "Details is not added successfully. Please try again";

		          echo json_encode( array('status'=>'error','result'=>$data_message) );
		          exit;
		        }
	        }	
	        break;
		}
		case 'update_car_year':{ 	

			if(isset($_POST['variant']) && !empty($_POST['variant'])  && isset($_POST['variant_id']) && !empty($_POST['variant_id']) )
      		{	
      			$variant = $_POST['variant'];
	        	$variant_id = $_POST['variant_id'];

			    $update_array = array(
	              'variant' => $variant,          
	            );
	          
	          	$action_result = $db->updateAry('sp_car_variant', $update_array, "where variant_id='".$variant_id."'");

	           if( !is_null($action_result) )
		        {
		          $data_message = "Details updated successfully";

		          echo json_encode( array('status'=>'success','result'=>$data_message) );
		          exit;
		        }
		        else
		        {
		          $data_message = "Details is not updated successfully. Please try again";

		          echo json_encode( array('status'=>'error','result'=>$data_message) );
		          exit;
		        }
	        }
	        break;	
		}
		case 'insert_bike_make':{ 	

			if( isset($_POST['make']) && !empty($_POST['make']) && isset($_POST['priority']) )
      		{	
      			$image_name = '';
      			$make = $_POST['make'];
      			$priority = $_POST['priority'];      			

      			if( isset($_FILES['make_image']['name']) && !empty($_FILES['make_image']['name']) )
         		{
				    $file_uploaded_result = upload_new_single_file('make_image', '../images/bikes/', '', 'yes');

		            if( $file_uploaded_result['file_upload_status'] == 'uploaded' )
		            {
		              $image_name = 'images/bikes/'.$file_uploaded_result['new_file_name'];
		            }
		            else
		            {
		              $image_name = '';
		            }
		        }

			    $data_array = array(
	              'make' => $make,
	              'make_image' => $image_name,
	              'priority'=>$priority,              
	            );
	          
	          	$action_result = $db->insertAry('sp_bike_make', $data_array);

	           if( !is_null($action_result) )
		        {
		          $data_message = "Details added successfully";

		          echo json_encode( array('status'=>'success','result'=>$data_message) );
		          exit;
		        }
		        else
		        {
		          $data_message = "Details is not added successfully. Please try again";

		          echo json_encode( array('status'=>'error','result'=>$data_message) );
		          exit;
		        }
	        }
	        break;	
		}
		case 'update_bike_make':{ 	

			if( isset($_POST['make']) && !empty($_POST['make']) && isset($_POST['make_id']) && !empty($_POST['make_id']) && isset($_POST['make_image']) && isset($_POST['priority']) )
      		{	
      			$image_name = $_POST['make_image'];
      			$make = $_POST['make'];
	        	$make_id = $_POST['make_id'];
      			$priority = $_POST['priority'];      			

      			if( isset($_FILES['make_image1']['name']) && !empty($_FILES['make_image1']['name']) )
         		{
				    $file_uploaded_result = upload_new_single_file('make_image1', '../images/bikes/', '', 'yes');

		            if( $file_uploaded_result['file_upload_status'] == 'uploaded' )
		            {
		              $image_name = 'images/bikes/'.$file_uploaded_result['new_file_name'];
		            }
		            else
		            {
		              $image_name = '';
		            }
		        }

			    $update_array = array(
	              'make' => $make,
	              'make_image' => $image_name,     
	              'priority'=>$priority,              
	            );
	          
	          	$action_result = $db->updateAry('sp_bike_make', $update_array, "where make_id='".$make_id."'");

	           if( !is_null($action_result) )
		        {
		          $data_message = "Details updated successfully";

		          echo json_encode( array('status'=>'success','result'=>$data_message) );
		          exit;
		        }
		        else
		        {
		          $data_message = "Details is not updated successfully. Please try again";

		          echo json_encode( array('status'=>'error','result'=>$data_message) );
		          exit;
		        }
	        }
	        break;	
		}

		case 'insert_bike_model':{ 	

			if( isset($_POST['make']) && !empty($_POST['make']) && isset($_POST['model']) && !empty($_POST['model']) )
      		{	
      			$image_name = '';
      			$model = $_POST['model'];
      			$make_id = $_POST['make'];

      			if( isset($_FILES['model_image']['name']) && !empty($_FILES['model_image']['name']) )
         		{
				    $file_uploaded_result = upload_new_single_file('model_image', '../images/bikes/models/', '', 'yes');

		            if( $file_uploaded_result['file_upload_status'] == 'uploaded' )
		            {
		              $image_name = 'images/bikes/models/'.$file_uploaded_result['new_file_name'];
		            }
		            else
		            {
		              $image_name = '';
		            }
		        }

			    $data_array = array(
	              'model' => $model,
	              'model_image' => $image_name,
	              'make_id' => $make_id,	                            
	            );
	          
	          	$action_result = $db->insertAry('sp_bike_model', $data_array);

	           if( !is_null($action_result) )
		        {
		          $data_message = "Details added successfully";

		          echo json_encode( array('status'=>'success','result'=>$data_message) );
		          exit;
		        }
		        else
		        {
		          $data_message = "Details is not added successfully. Please try again";

		          echo json_encode( array('status'=>'error','result'=>$data_message) );
		          exit;
		        }
	        }	
	        break;
		}
		case 'update_bike_model':{ 	

			if(isset($_POST['model_id']) && !empty($_POST['model_id']) && isset($_POST['model_image']) )
      		{	
      			$image_name = $_POST['model_image'];
      			$model = $_POST['model'];
	        	$model_id = $_POST['model_id'];

      			if( isset($_FILES['model_image1']['name']) && !empty($_FILES['model_image1']['name']) )
         		{
				    $file_uploaded_result = upload_new_single_file('model_image1', '../images/bikes/models/', '', 'yes');

		            if( $file_uploaded_result['file_upload_status'] == 'uploaded' )
		            {
		              $image_name = 'images/bikes/models/'.$file_uploaded_result['new_file_name'];
		            }
		            else
		            {
		              $image_name = '';
		            }
		        }

			    $update_array = array(
	              'model' => $model,
	              'model_image' => $image_name,              
	            );
	          
	          	$action_result = $db->updateAry('sp_bike_model', $update_array, "where model_id='".$model_id."'");

	           if( !is_null($action_result) )
		        {
		          $data_message = "Details updated successfully";

		          echo json_encode( array('status'=>'success','result'=>$data_message) );
		          exit;
		        }
		        else
		        {
		          $data_message = "Details is not updated successfully. Please try again";

		          echo json_encode( array('status'=>'error','result'=>$data_message) );
		          exit;
		        }
	        }	
	        break;
		}

		case 'insert_bike_year':{ 	

			if( isset($_POST['make']) && !empty($_POST['make']) && isset($_POST['model']) && !empty($_POST['model']) && isset($_POST['year']) && !empty($_POST['year']) )
      		{	
      			$model_id = $_POST['model'];
      			$make_id = $_POST['make'];
      			$year = $_POST['year'];
      			
			    $data_array = array(
	              'year' => $year,
	              'make_id' => $make_id,	                            
	              'model_id' => $model_id,		                            
	            );
	          
	          	$action_result = $db->insertAry('sp_bike_year', $data_array);
	           	if(!is_null($action_result))
		        {
		          $data_message = "Details added successfully";
		          echo json_encode( array('status'=>'success','result'=>$data_message) );
		          exit;
		        }
		        else
		        {
		          $data_message = "Details is not added successfully. Please try again";

		          echo json_encode( array('status'=>'error','result'=>$data_message) );
		          exit;
		        }
	        }
	        break;	
		}
		case 'update_bike_year':{ 	

			if(isset($_POST['year']) && !empty($_POST['year'])  && isset($_POST['year_id']) && !empty($_POST['year_id']) )
      		{	
      			$year = $_POST['year'];
	        	$year_id = $_POST['year_id'];

			    $update_array = array(
	              'year' => $year,          
	            );
	          
	          	$action_result = $db->updateAry('sp_bike_year', $update_array, "where year_id='".$year_id."'");

	           if( !is_null($action_result) )
		        {
		          $data_message = "Details updated successfully";

		          echo json_encode( array('status'=>'success','result'=>$data_message) );
		          exit;
		        }
		        else
		        {
		          $data_message = "Details is not updated successfully. Please try again";

		          echo json_encode( array('status'=>'error','result'=>$data_message) );
		          exit;
		        }
	        }
	        break;	
		}
		case 'insert_bike_variant':{ 	

			if( isset($_POST['make']) && !empty($_POST['make']) && isset($_POST['model']) && !empty($_POST['model']) && isset($_POST['year']) && !empty($_POST['year']) && isset($_POST['variant']) && !empty($_POST['variant']) )
      		{	
      			$model_id = $_POST['model'];
      			$make_id = $_POST['make'];
      			$year_id = $_POST['year'];
      			$variant = $_POST['variant'];      			
      			
			    $data_array = array(
	              'variant' => $variant,
	              'make_id' => $make_id,	                            
	              'model_id' => $model_id,	
	              'year_id' => $year_id,

	            );
	          
	          	$action_result = $db->insertAry('sp_bike_variant', $data_array);
	           	if(!is_null($action_result))
		        {
		          $data_message = "Details added successfully";
		          echo json_encode( array('status'=>'success','result'=>$data_message) );
		          exit;
		        }
		        else
		        {
		          $data_message = "Details is not added successfully. Please try again";

		          echo json_encode( array('status'=>'error','result'=>$data_message) );
		          exit;
		        }
	        }
	        break;	
		}
		case 'update_bike_year':{ 	

			if(isset($_POST['variant']) && !empty($_POST['variant'])  && isset($_POST['variant_id']) && !empty($_POST['variant_id']) )
      		{	
      			$variant = $_POST['variant'];
	        	$variant_id = $_POST['variant_id'];

			    $update_array = array(
	              'variant' => $variant,          
	            );
	          
	          	$action_result = $db->updateAry('sp_bike_variant', $update_array, "where variant_id='".$variant_id."'");

	           if( !is_null($action_result) )
		        {
		          $data_message = "Details updated successfully";

		          echo json_encode( array('status'=>'success','result'=>$data_message) );
		          exit;
		        }
		        else
		        {
		          $data_message = "Details is not updated successfully. Please try again";

		          echo json_encode( array('status'=>'error','result'=>$data_message) );
		          exit;
		        }
	        }	
	        break;
		}

		case 'update_seller_credentials':{
			if(isset($_POST["status"]) && isset($_POST["username"]) && isset($_POST["password"]) && isset($_POST["seller_id"])){ 
				$seller_id = $_POST["seller_id"];
			 $update_array = array(
	              'username' => $_POST["username"],  
	              'password' => base64_encode($_POST["password"]),          
	              'status' => $_POST["status"],     
	              'remarks' => $_POST["remarks"],          
	            );
	          
	          	$action_result = $db->updateAry('sp_seller', $update_array, "where seller_id='".$seller_id."'");
	          	 if( !is_null($action_result) )
		        {
		          $data_message = "Details updated successfully";

		          echo json_encode( array('status'=>'success','result'=>$data_message) );
		          exit;
		        }
		        else
		        {
		          $data_message = "Details is not updated successfully. Please try again";

		          echo json_encode( array('status'=>'error','result'=>$data_message) );
		          exit;
		        }
			}

			break;
		}

		case 'update_buyer_credentials':{
			if(isset($_POST["status"]) && isset($_POST["buyer_id"])){ 
				$buyer_id = $_POST["buyer_id"];
			 	$update_array = array(       
	              'status' => $_POST["status"],     
	              'remarks' => $_POST["remarks"],          
	            );
	          
	          	$action_result = $db->updateAry('sp_buyer', $update_array, "where buyer_id='".$buyer_id."'");
	          	 if( !is_null($action_result) )
		        {
		          $data_message = "Details updated successfully";

		          echo json_encode( array('status'=>'success','result'=>$data_message) );
		          exit;
		        }
		        else
		        {
		          $data_message = "Details is not updated successfully. Please try again";

		          echo json_encode( array('status'=>'error','result'=>$data_message) );
		          exit;
		        }
			}

			break;
		}

		case 'insert_popularlocation':{ 	

			if( isset($_POST['popularlocation']) && !empty($_POST['popularlocation']) )
      		{	
      			$popularlocation = $_POST['popularlocation'];
      			
			    $data_array = array(                            
	              'location' => $popularlocation,		                            
	            );
	          
	          	$action_result = $db->insertAry('sp_popular_locations', $data_array);
	           	if(!is_null($action_result))
		        {
		          $data_message = "Details added successfully";
		          echo json_encode( array('status'=>'success','result'=>$data_message) );
		          exit;
		        }
		        else
		        {
		          $data_message = "Details is not added successfully. Please try again";

		          echo json_encode( array('status'=>'error','result'=>$data_message) );
		          exit;
		        }
	        }	
	        break;
		}
		case 'update_popularlocation':{ 	

			if(isset($_POST['popularlocation']) && !empty($_POST['popularlocation'])  && isset($_POST['popular_location_id']) && !empty($_POST['popular_location_id']) )
      		{	
      			$popularlocation = $_POST['popularlocation'];
	        	$popular_location_id = $_POST['popular_location_id'];

			    $update_array = array(
	              'location' => $popularlocation,          
	            );
	          
	          	$action_result = $db->updateAry('sp_popular_locations', $update_array, "where popular_location_id='".$popular_location_id."'");

	           if( !is_null($action_result) )
		        {
		          $data_message = "Details updated successfully";

		          echo json_encode( array('status'=>'success','result'=>$data_message) );
		          exit;
		        }
		        else
		        {
		          $data_message = "Details is not updated successfully. Please try again";

		          echo json_encode( array('status'=>'error','result'=>$data_message) );
		          exit;
		        }
	        }	
	        break;
		}

		case 'insert_location':{ 	

			if( isset($_POST['state']) && !empty($_POST['state']) && isset($_POST['district']) && !empty($_POST['district'])  && isset($_POST['location']) && !empty($_POST['location']) && isset($_POST['pincode']) && !empty($_POST['pincode']) )
      		{	
      			$state = $_POST['state'];
      			$district = $_POST['district'];
      			$location = $_POST['location'];
      			$pincode = $_POST['pincode'];

			    $data_array = array(        
	              'state' => $state,		                            
	              'district' => $district,		                            
	              'location' => $location,
	              'pincode' => $pincode		                            
	            );
	          
	          	$action_result = $db->insertAry('sp_locations', $data_array);
	           	if(!is_null($action_result))
		        {
		          $data_message = "Details added successfully";
		          echo json_encode( array('status'=>'success','result'=>$data_message) );
		          exit;
		        }
		        else
		        {
		          $data_message = "Details is not added successfully. Please try again";

		          echo json_encode( array('status'=>'error','result'=>$data_message) );
		          exit;
		        }
	        }	
	        break;
		}
		case 'update_location':{ 	

			if(isset($_POST['state']) && !empty($_POST['state']) && isset($_POST['district']) && !empty($_POST['district'])  && isset($_POST['location']) && !empty($_POST['location']) && isset($_POST['pincode']) && !empty($_POST['pincode']) && isset($_POST['location_id']) && !empty($_POST['location_id']) )
      		{	
      			$state = $_POST['state'];
      			$district = $_POST['district'];
      			$location = $_POST['location'];
      			$pincode = $_POST['pincode'];
	        	$location_id = $_POST['location_id'];

			    $update_array = array(
			      'state' => $state,		                            
	              'district' => $district,		                            
	              'location' => $location,    
	              'pincode' => $pincode		                            
	            );
	          
	          	$action_result = $db->updateAry('sp_locations', $update_array, "where location_id='".$location_id."'");

	           if( !is_null($action_result) )
		        {
		          $data_message = "Details updated successfully";

		          echo json_encode( array('status'=>'success','result'=>$data_message) );
		          exit;
		        }
		        else
		        {
		          $data_message = "Details is not updated successfully. Please try again";

		          echo json_encode( array('status'=>'error','result'=>$data_message) );
		          exit;
		        }
	        }	
	        break;
		}


		case 'insert_buyer_location':{ 	

			if( isset($_POST['state']) && !empty($_POST['state']) && isset($_POST['district']) && !empty($_POST['district'])  && isset($_POST['location']) && !empty($_POST['location']) && isset($_POST['pincode']) && !empty($_POST['pincode']) )
      		{	
      			$state = $_POST['state'];
      			$district = $_POST['district'];
      			$location = $_POST['location'];
      			$pincode = $_POST['pincode'];

			    $data_array = array(        
	              'state' => $state,		                            
	              'district' => $district,		                            
	              'location' => $location,
	              'pincode' => $pincode		                            
	            );
	          
	          	$action_result = $db->insertAry('sp_buyer_locations', $data_array);
	           	if(!is_null($action_result))
		        {
		          $data_message = "Details added successfully";
		          echo json_encode( array('status'=>'success','result'=>$data_message) );
		          exit;
		        }
		        else
		        {
		          $data_message = "Details is not added successfully. Please try again";

		          echo json_encode( array('status'=>'error','result'=>$data_message) );
		          exit;
		        }
	        }	
	        break;
		}
		case 'update_buyer_location':{ 	

			if(isset($_POST['state']) && !empty($_POST['state']) && isset($_POST['district']) && !empty($_POST['district'])  && isset($_POST['location']) && !empty($_POST['location']) && isset($_POST['pincode']) && !empty($_POST['pincode']) && isset($_POST['location_id']) && !empty($_POST['location_id']) )
      		{	
      			$state = $_POST['state'];
      			$district = $_POST['district'];
      			$location = $_POST['location'];
      			$pincode = $_POST['pincode'];
	        	$location_id = $_POST['location_id'];

			    $update_array = array(
			      'state' => $state,		                            
	              'district' => $district,		                            
	              'location' => $location,    
	              'pincode' => $pincode		                            
	            );
	          
	          	$action_result = $db->updateAry('sp_buyer_locations', $update_array, "where location_id='".$location_id."'");

	           if( !is_null($action_result) )
		        {
		          $data_message = "Details updated successfully";

		          echo json_encode( array('status'=>'success','result'=>$data_message) );
		          exit;
		        }
		        else
		        {
		          $data_message = "Details is not updated successfully. Please try again";

		          echo json_encode( array('status'=>'error','result'=>$data_message) );
		          exit;
		        }
	        }	
	        break;
		}
		case 'insert_popularlocation_state':{ 	

			if( isset($_POST['popularlocation_state']) && !empty($_POST['popularlocation_state']) && isset($_POST['state']) && !empty($_POST['state']) )
      		{	
      			$popularlocation_state = $_POST['popularlocation_state'];
      			$state = $_POST['state'];
      			
			    $data_array = array(                        
	              'state' => $state,		                            
	              'district' => $popularlocation_state,		                            
	            );
	          
	          	$action_result = $db->insertAry('sp_popular_locations_state', $data_array);
	           	if(!is_null($action_result))
		        {
		          $data_message = "Details added successfully";
		          echo json_encode( array('status'=>'success','result'=>$data_message) );
		          exit;
		        }
		        else
		        {
		          $data_message = "Details is not added successfully. Please try again";

		          echo json_encode( array('status'=>'error','result'=>$data_message) );
		          exit;
		        }
	        }	
	        break;
		}
		case 'update_popularlocation_state':{ 	
			if( isset($_POST['popularlocation']) && !empty($_POST['popularlocation']) && isset($_POST['state']) && !empty($_POST['state'])  && isset($_POST['state_location_id']) && !empty($_POST['state_location_id']))
      		{
      			$popularlocation = $_POST['popularlocation'];
	        	$state_location_id = $_POST['state_location_id'];
      			$state = $_POST['state'];

			    $update_array = array(
	              'state' => $state,		                            
	              'district' => $popularlocation,         
	            );
	          
	          	$action_result = $db->updateAry('sp_popular_locations_state', $update_array, "where state_location_id='".$state_location_id."'");

	           if( !is_null($action_result) )
		        {
		          $data_message = "Details updated successfully";

		          echo json_encode( array('status'=>'success','result'=>$data_message) );
		          exit;
		        }
		        else
		        {
		          $data_message = "Details is not updated successfully. Please try again";

		          echo json_encode( array('status'=>'error','result'=>$data_message) );
		          exit;
		        }
	        }	
	        break;
	    }

	    case 'update_content':{ 	
			if(isset($_POST['content_id']) && !empty($_POST['content_id']) && isset($_POST['content']) && !empty($_POST['content']))
      		{
      			$content = $_POST['content'];
	        	$content_id = $_POST['content_id'];

			    $update_array = array(                            
	              'content' => $content,
	            );
	          	$action_result = $db->updateAry('sp_content', $update_array, "where content_id='".$content_id."'");

	           if($db->getAffectedRows()>0 )
		        {
		          $data_message = "Details updated successfully";

		          echo json_encode( array('status'=>'success','result'=>$data_message) );
		          exit;
		        }
		        else
		        {
		          $data_message = "Details is not updated successfully. Please try again";

		          echo json_encode( array('status'=>'error','result'=>$data_message) );
		          exit;
		        }
	        }	
	        break;
		}

		case 'update_seller_details':{
			if(isset($_POST['seller_id']) && !empty($_POST['seller_id']) && isset($_POST['name']) && !empty($_POST['name']))
      		{
      			$name = $_POST['name'];
	        	$seller_id = $_POST['seller_id'];

	        	$working_days = (object) array();

	        	$working_days->M = (isset($_POST["monday"]) && !empty($_POST["monday"]) && $_POST["monday"] != null)?"1":"0";
				$working_days->T = (isset($_POST["tuesday"]) && !empty($_POST["tuesday"]) && $_POST["tuesday"] != null)?"1":"0";
				$working_days->W = (isset($_POST["wednesday"]) && !empty($_POST["wednesday"]) && $_POST["wednesday"] != null)?"1":"0";
				$working_days->Th = (isset($_POST["thursday"]) && !empty($_POST["thursday"]) && $_POST["thursday"] != null)?"1":"0";
				$working_days->F = (isset($_POST["friday"]) && !empty($_POST["friday"]) && $_POST["friday"] != null)?"1":"0";
				$working_days->S = (isset($_POST["saturday"]) && !empty($_POST["saturday"]) && $_POST["saturday"] != null)?"1":"0";
				$working_days->Su = (isset($_POST["sunday"]) && !empty($_POST["sunday"]) && $_POST["sunday"] != null)?"1":"0";

				$working_days = json_encode($working_days);

			    $update_array = array(                            
	              'name' => $name,
	              'email'  => isset($_POST['email'])?$_POST['email']:'',
	              'mobile'  => isset($_POST['mobile'])?$_POST['mobile']:'',
	              'alternate_mobile'  => isset($_POST['alternate_mobile'])?$_POST['alternate_mobile']:'',
	              'shop'  => isset($_POST['shop'])?$_POST['shop']:'',
	              'address'  => isset($_POST['address'])?$_POST['address']:'',
	              'landmark'  => isset($_POST['landmark'])?$_POST['landmark']:'',
	              'state'  => isset($_POST['state'])?$_POST['state']:'',
	              'city'  => isset($_POST['district'])?$_POST['district']:'',
	              'location'  => isset($_POST['location'])?$_POST['location']:'',
	              'pincode'  => isset($_POST['pincode'])?$_POST['pincode']:'',
	              'business_percentage'  => isset($_POST['business_percentage'])?$_POST['business_percentage']:'',
	              'hours'  => isset($_POST['hours'])?$_POST['hours']:'',
	              'working_days'  => $working_days);
	          	$action_result = $db->updateAry('sp_seller', $update_array, "where seller_id='".$seller_id."'");
	          	// echo $db->getLastQuery();
	           if($db->getAffectedRows()>0 )
		        {

		          $update_array = array( 
	              'account_name'  => isset($_POST['account_name'])?$_POST['account_name']:'',
	              'account_number'  => isset($_POST['account_number'])?$_POST['account_number']:'',
	              'bank'  => isset($_POST['bank'])?$_POST['bank']:'',
	              'ifsc'  => isset($_POST['ifsc'])?$_POST['ifsc']:'',
	              'gpay'  => isset($_POST['gpay'])?$_POST['gpay']:'',
	              'phonepay'  => isset($_POST['phonepay'])?$_POST['phonepay']:'');

	              $action_result = $db->updateAry('sp_seller_account', $update_array, "where seller_id='".$seller_id."'");


		          $data_message = "Details updated successfully";

		          echo json_encode( array('status'=>'success','result'=>$data_message) );
		          exit;
		        }
		        else
		        {

               	 $update_array = array( 
	              'account_name'  => isset($_POST['account_name'])?$_POST['account_name']:'',
	              'account_number'  => isset($_POST['account_number'])?$_POST['account_number']:'',
	              'bank'  => isset($_POST['bank'])?$_POST['bank']:'',
	              'ifsc'  => isset($_POST['ifsc'])?$_POST['ifsc']:'',
	              'gpay'  => isset($_POST['gpay'])?$_POST['gpay']:'',
	              'phonepay'  => isset($_POST['phonepay'])?$_POST['phonepay']:'');

	              $action_result = $db->updateAry('sp_seller_account', $update_array, "where seller_id='".$seller_id."'");
		            if($db->getAffectedRows()>0 )
			        {

			          $data_message = "Details updated successfully";

			          echo json_encode( array('status'=>'success','result'=>$data_message) );
			          exit;
			      }
			      else{
			          $data_message = "Details is not updated successfully. Please try again";

			          echo json_encode( array('status'=>'error','result'=>$data_message) );
			          exit;
			      }
		        }
	        }
			break;
		}


		case 'update_buyer_details':{
			if(isset($_POST['buyer_id']) && !empty($_POST['buyer_id']) && isset($_POST['name']) && !empty($_POST['name']))
      		{
      			$name = $_POST['name'];
	        	$buyer_id = $_POST['buyer_id'];
	        
			    $update_array = array(                            
	              'name' => $name,
	              'email'  => isset($_POST['email'])?$_POST['email']:'',
	              'mobile'  => isset($_POST['mobile'])?$_POST['mobile']:'',
	              'alternate_mobile'  => isset($_POST['alternate_mobile'])?$_POST['alternate_mobile']:'',
	              'address'  => isset($_POST['address'])?$_POST['address']:'',
	              'landmark'  => isset($_POST['landmark'])?$_POST['landmark']:'',
	              'state'  => isset($_POST['state'])?$_POST['state']:'',
	              'city'  => isset($_POST['district'])?$_POST['district']:'',
	              'location'  => isset($_POST['location'])?$_POST['location']:'',
	              'pincode'  => isset($_POST['pincode'])?$_POST['pincode']:'');
	          	$action_result = $db->updateAry('sp_buyer', $update_array, "where buyer_id='".$buyer_id."'");
	          	// echo $db->getLastQuery();
	           if($db->getAffectedRows()>0 )
		        {

		        
		          $data_message = "Details updated successfully";
		          echo json_encode( array('status'=>'success','result'=>$data_message) );
		          exit;
		        }
		        else
		        {
              
			          $data_message = "Details is not updated successfully. Please try again";
			          echo json_encode( array('status'=>'error','result'=>$data_message) );
			          exit;			      
		        }
	        }
			break;
		}


		case 'insert_subadmin':{ 	

			if( isset($_POST['sub_name']) && !empty($_POST['sub_name']) && isset($_POST['sub_mobile']) && !empty($_POST['sub_mobile']))
      		{	
      			$name = $_POST['sub_name'];
      			$mobile = $_POST['sub_mobile'];  
      			$email = $_POST['sub_email'];      			
      			$address = $_POST['sub_address'];      			
      			$username = $_POST['sub_username'];      			
      			$password = password_hash($_POST['sub_password'],PASSWORD_DEFAULT);;      			

			    $data_array = array(
	              'name' => $name,
	              'mobile' => $mobile,
	              'email' => $email,
	              'address' => $address,
	              'username' => $username,
	              'password' => $password, 
	            );
	          
	          	$action_result = $db->insertAry('sp_subadmin', $data_array);

	           if( !is_null($action_result) )
		        {
		          $data_message = "Details added successfully";

		          echo json_encode( array('status'=>'success','result'=>$data_message) );
		          exit;
		        }
		        else
		        {
		          $data_message = "Details is not added successfully. Please try again";

		          echo json_encode( array('status'=>'error','result'=>$data_message) );
		          exit;
		        }
	        }
	        break;	
		}
		case 'update_subadmin':{ 	

			if( isset($_POST['sb_id']) && !empty($_POST['sb_id']) && isset($_POST['sub_mobile']) && !empty($_POST['sub_mobile']))
      		{	
      			$sb_id = $_POST['sb_id'];      			
      			$name = $_POST['sub_name'];
      			$mobile = $_POST['sub_mobile'];  
      			$email = $_POST['sub_email'];      			
      			$address = $_POST['sub_address'];      			
      			$username = $_POST['sub_username'];      			
      			$password = password_hash($_POST['sub_password'],PASSWORD_DEFAULT);;      			

			    $data_array = array(
	              'name' => $name,
	              'mobile' => $mobile,
	              'email' => $email,
	              'address' => $address,
	              'username' => $username,
	              'password' => $password, 
	            );
	          
	          	$action_result = $db->updateAry('sp_subadmin', $data_array, "where sb_id='".$sb_id."'");

	           if( !is_null($action_result) )
		        {
		          $data_message = "Details updated successfully";

		          echo json_encode( array('status'=>'success','result'=>$data_message) );
		          exit;
		        }
		        else
		        {
		          $data_message = "Details is not updated successfully. Please try again";

		          echo json_encode( array('status'=>'error','result'=>$data_message) );
		          exit;
		        }
	        }	
	        break;
		}
		case 'insert_buyer_banner':{ 	
		
      			$image_name = '';

      			if( isset($_FILES['image']['name']) && !empty($_FILES['image']['name']) )
         		{
				    $file_uploaded_result = upload_new_single_file('image', '../images/banner/buyer/', '', 'yes');

		            if( $file_uploaded_result['file_upload_status'] == 'uploaded' )
		            {
		              $image_name = 'images/banner/buyer/'.$file_uploaded_result['new_file_name'];

		                	$data_array = array(
				              'image' => $image_name, 
				            );
				          
				          	$action_result = $db->insertAry('sp_buyer_banner', $data_array);

				           if( !is_null($action_result) )
					        {
					          $data_message = "Details added successfully";

					          echo json_encode( array('status'=>'success','result'=>$data_message) );
					          exit;
					        }
					        else
					        {
					          $data_message = "Details is not added successfully. Please try again";

					          echo json_encode( array('status'=>'error','result'=>$data_message) );
					          exit;
					        }
		            }
		            else
		            {
		              $image_name = '';
		            }
		        }
	        
	        break;	
		}
		case 'insert_seller_banner':{ 	
		
      			$image_name = '';

      			if( isset($_FILES['image']['name']) && !empty($_FILES['image']['name']) )
         		{
				    $file_uploaded_result = upload_new_single_file('image', '../images/banner/seller/', '', 'yes');

		            if( $file_uploaded_result['file_upload_status'] == 'uploaded' )
		            {
		              $image_name = 'images/banner/seller/'.$file_uploaded_result['new_file_name'];

		                	$data_array = array(
				              'image' => $image_name, 
				            );
				          
				          	$action_result = $db->insertAry('sp_seller_banner', $data_array);

				           if( !is_null($action_result) )
					        {
					          $data_message = "Details added successfully";

					          echo json_encode( array('status'=>'success','result'=>$data_message) );
					          exit;
					        }
					        else
					        {
					          $data_message = "Details is not added successfully. Please try again";

					          echo json_encode( array('status'=>'error','result'=>$data_message) );
					          exit;
					        }
		            }
		            else
		            {
		              $image_name = '';
		            }
		        }
	        
	        break;	
		}
	
	}
}