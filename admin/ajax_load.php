<?php 
include("../config.php");
if( isset($_POST['action']) && !empty($_POST['action']) )
{
  $action = $_POST['action'];
	switch($action)
	{
		case 'edit_car_make':{ 		
		  	if( isset($_POST['id']) && !empty($_POST['id']) )
	      	{
	        
	        $make_id = $_POST['id'];
        	$result_data = $db->getRow("select * from sp_car_make where make_id='".$make_id."' Limit 1");
		   ?>

			<div id="priority_make" class="col-md-12 top15">
	          <span class="badge-label p-2">Priority <span class="redstar">*</span></span>
	          <input name="priority" id="priority" required="" class="form-control" placeholder="Priority" type="text" value="<?= $result_data['priority']; ?>"/>
	        </div>
	        <div id="vehicle_make" class="col-md-12 top15">
	          <span class="badge-label p-2">Make <span class="redstar">*</span></span>
	          <input name="make" id="make" required="" class="form-control" placeholder="Vehicle Make" type="text" value="<?= $result_data['make']; ?>"/>
	        </div>
	        <div id="vehicle_make_image" class="col-md-12 top15">
	          <span class="badge-label p-2">Make Image <span class="redstar">*</span></span><br/>  
	          <img src="../<?= $result_data['make_image']; ?>" style="max-width: 70px">       
	          <input  type="file" name="make_image1" style="margin-top: 10px;" />
	        </div>
	        <input name="make_image" id="make_image" hidden="" class="form-control" placeholder="Vehicle Make" type="text" value="<?= $result_data['make_image']; ?>"/>	        
	        <input name="make_id" id="make_id" hidden="" class="form-control" placeholder="Vehicle Make" type="text" value="<?= $result_data['make_id']; ?>"/>
			<?php 
			}
			break;
		}
		case 'edit_car_model':{ 		
		  	if( isset($_POST['id']) && !empty($_POST['id']) )
	      	{
	        
	        $model_id = $_POST['id'];
        	$result_data = $db->getRow("select * from sp_car_model where model_id='".$model_id."' Limit 1");
			?>
			<div id="vehicle_make" class="col-md-12 top15">
	          <span class="badge-label p-2">Model <span class="redstar">*</span></span>
	          <input name="model" id="model" required="" class="form-control" placeholder="Vehicle Model" type="text" value="<?= $result_data['model']; ?>"/>
	        </div>
	        <div id="vehicle_make_image" class="col-md-12 top15">
	          <span class="badge-label p-2">Model Image <span class="redstar">*</span></span><br/>  
	          <img src="../<?= $result_data['model_image']; ?>" style="max-width: 70px">       
	          <input  type="file" name="model_image1" style="margin-top: 10px;" />
	        </div>
	        <input name="model_image" id="model_image" hidden="" class="form-control" placeholder="Vehicle Model" type="text" value="<?= $result_data['model_image']; ?>"/>	        
	        <input name="model_id" id="model_id" hidden="" class="form-control" placeholder="Vehicle Model" type="text" value="<?= $result_data['model_id']; ?>"/>
			<?php 
			}
			break;
		}
		case 'edit_car_year':{ 		
		  	if( isset($_POST['id']) && !empty($_POST['id']) )
	      	{
	        
	        $year_id = $_POST['id'];
        	$result_data = $db->getRow("select * from sp_car_year where year_id='".$year_id."' Limit 1");
			?>
			<div id="vehicle_make" class="col-md-12 top15">
	          <span class="badge-label p-2">Year <span class="redstar">*</span></span>
	          <input name="year" id="year" required="" class="form-control" placeholder="Vehicle Year" type="text" value="<?= $result_data['year']; ?>"/>
	        </div>
	        
	        <input name="year_id" id="year_id" hidden="" class="form-control" placeholder="Vehicle Year" type="text" value="<?= $result_data['year_id']; ?>"/>
			<?php 
			}
			break;
		}

		case 'edit_car_variant':{ 		
		  	if( isset($_POST['id']) && !empty($_POST['id']) )
	      	{
	        
	        $variant_id = $_POST['id'];
        	$result_data = $db->getRow("select * from sp_car_variant where variant_id='".$variant_id."' Limit 1");
			?>
			<div id="vehicle_make" class="col-md-12 top15">
	          <span class="badge-label p-2">Variant <span class="redstar">*</span></span>
	          <input name="variant" id="variant" required="" class="form-control" placeholder="Vehicle Variant" type="text" value="<?= $result_data['variant']; ?>"/>
	        </div>
	        
	        <input name="variant_id" id="variant_id" hidden="" class="form-control" placeholder="Vehicle Variant" type="text" value="<?= $result_data['variant_id']; ?>"/>
			<?php 
			}
			break;
		}
		case 'edit_bike_make':{ 		
		  	if( isset($_POST['id']) && !empty($_POST['id']) )
	      	{
	        
	        $make_id = $_POST['id'];
        	$result_data = $db->getRow("select * from sp_bike_make where make_id='".$make_id."' Limit 1");
		   ?>
		   	<div id="priority_make" class="col-md-12 top15">
	          <span class="badge-label p-2">Priority <span class="redstar">*</span></span>
	          <input name="priority" id="priority" required="" class="form-control" placeholder="Priority" type="text" value="<?= $result_data['priority']; ?>"/>
	        </div>
			<div id="vehicle_make" class="col-md-12 top15">
	          <span class="badge-label p-2">Make <span class="redstar">*</span></span>
	          <input name="make" id="make" required="" class="form-control" placeholder="Vehicle Make" type="text" value="<?= $result_data['make']; ?>"/>
	        </div>
	        <div id="vehicle_make_image" class="col-md-12 top15">
	          <span class="badge-label p-2">Make Image <span class="redstar">*</span></span><br/>  
	          <img src="../<?= $result_data['make_image']; ?>" style="max-width: 70px">       
	          <input  type="file" name="make_image1" style="margin-top: 10px;" />
	        </div>
	        <input name="make_image" id="make_image" hidden="" class="form-control" placeholder="Vehicle Make" type="text" value="<?= $result_data['make_image']; ?>"/>	        
	        <input name="make_id" id="make_id" hidden="" class="form-control" placeholder="Vehicle Make" type="text" value="<?= $result_data['make_id']; ?>"/>
			<?php 
			}
			break;
		}
		case 'edit_bike_model':{ 		
		  	if( isset($_POST['id']) && !empty($_POST['id']) )
	      	{
	        
	        $model_id = $_POST['id'];
        	$result_data = $db->getRow("select * from sp_bike_model where model_id='".$model_id."' Limit 1");
			?>
			<div id="vehicle_make" class="col-md-12 top15">
	          <span class="badge-label p-2">Model <span class="redstar">*</span></span>
	          <input name="model" id="model" required="" class="form-control" placeholder="Vehicle Model" type="text" value="<?= $result_data['model']; ?>"/>
	        </div>
	        <div id="vehicle_make_image" class="col-md-12 top15">
	          <span class="badge-label p-2">Model Image <span class="redstar">*</span></span><br/>  
	          <img src="../<?= $result_data['model_image']; ?>" style="max-width: 70px">       
	          <input  type="file" name="model_image1" style="margin-top: 10px;" />
	        </div>
	        <input name="model_image" id="model_image" hidden="" class="form-control" placeholder="Vehicle Model" type="text" value="<?= $result_data['model_image']; ?>"/>	        
	        <input name="model_id" id="model_id" hidden="" class="form-control" placeholder="Vehicle Model" type="text" value="<?= $result_data['model_id']; ?>"/>
			<?php 
			}
			break;
		}
		case 'edit_bike_year':{ 		
		  	if( isset($_POST['id']) && !empty($_POST['id']) )
	      	{
	        
	        $year_id = $_POST['id'];
        	$result_data = $db->getRow("select * from sp_bike_year where year_id='".$year_id."' Limit 1");
			?>
			<div id="vehicle_make" class="col-md-12 top15">
	          <span class="badge-label p-2">Year <span class="redstar">*</span></span>
	          <input name="year" id="year" required="" class="form-control" placeholder="Vehicle Year" type="text" value="<?= $result_data['year']; ?>"/>
	        </div>
	        
	        <input name="year_id" id="year_id" hidden="" class="form-control" placeholder="Vehicle Year" type="text" value="<?= $result_data['year_id']; ?>"/>
			<?php 
			}
			break;
		}

		case 'edit_bike_variant':{ 		
		  	if( isset($_POST['id']) && !empty($_POST['id']) )
	      	{
	        
	        $variant_id = $_POST['id'];
        	$result_data = $db->getRow("select * from sp_bike_variant where variant_id='".$variant_id."' Limit 1");
			?>
			<div id="vehicle_make" class="col-md-12 top15">
	          <span class="badge-label p-2">Variant <span class="redstar">*</span></span>
	          <input name="variant" id="variant" required="" class="form-control" placeholder="Vehicle Variant" type="text" value="<?= $result_data['variant']; ?>"/>
	        </div>
	        
	        <input name="variant_id" id="variant_id" hidden="" class="form-control" placeholder="Vehicle Variant" type="text" value="<?= $result_data['variant_id']; ?>"/>
			<?php 
			}
			break;
		}
		case 'edit_popularlocation':{ 		
		  	if( isset($_POST['id']) && !empty($_POST['id']) )
	      	{
	        
	        $popular_location_id = $_POST['id'];
        	$result_data = $db->getRow("select * from sp_popular_locations where popular_location_id='".$popular_location_id."' Limit 1");
			?>
			<div id="vehicle_make" class="col-md-12 top15">
	          <span class="badge-label p-2">Popular Locations <span class="redstar">*</span></span>
	          <input name="popularlocation" id="popularlocation" required="" class="form-control" placeholder="Vehicle Year" type="text" value="<?= $result_data['location']; ?>"/>
	        </div>
	        
	        <input name="popular_location_id" id="popular_location_id" hidden="" class="form-control" placeholder="Vehicle Year" type="text" value="<?= $result_data['popular_location_id']; ?>"/>
			<?php 
			}
			break;
		}

		case 'edit_popularlocation_state':{ 		
		  	if( isset($_POST['id']) && !empty($_POST['id']) )
	      	{
	        
	        $state_location_id = $_POST['id'];
        	$result_data = $db->getRow("select * from sp_popular_locations_state where state_location_id='".$state_location_id."' Limit 1");
			?>

			<div class="col-md-12 top15">
                        <span class="badge-label info-color p-2">State<span class="redstar">*</span></span>                        
                        <select name="state" id="state1" class="select2" required="">
                          <option value="">Choose State</option>
                          <?php 
                          $options = $db->getRows("Select state from sp_locations group by state order by state");
                          if(count($options)>0){
                          foreach ($options as $key => $value) {
                          ?>
                          <option <?php if($result_data["state"]==$value["state"]){echo "selected";} ?> ><?=$value["state"]?></option>
                          <?php } } ?>
                        </select>
                      </div>

			<div id="popular_locations" class="col-md-12 top15">
	          <span class="badge-label p-2">Popular Locations <span class="redstar">*</span></span>
	          <input name="popularlocation" id="popularlocation" required="" class="form-control" placeholder="Popular Locations" type="text" value="<?= $result_data['district']; ?>"/>
	        </div>
	        
	        <input name="state_location_id" id="state_location_id" hidden="" class="form-control" placeholder="Vehicle Year" type="text" value="<?= $result_data['state_location_id']; ?>"/>
			<?php 
			}
			break;
		}
		case 'edit_location':{ 		
		  	if( isset($_POST['id']) && !empty($_POST['id']) )
	      	{
	        
	        $location_id = $_POST['id'];
        	$result_data = $db->getRow("select * from sp_locations where location_id='".$location_id."' Limit 1");
        	$state = $result_data['state'];
        	$location = $result_data['location'];
        	$district = $result_data['district'];
        	$pincode = $result_data['pincode'];
			?>
			<div class="col-md-12 top15">
	          <span class="badge-label p-2">State <span class="redstar">*</span></span>
	            <select name="state" id="state1" class="select2" required="">
                  <?php 
                  $options = $db->getRows("Select state from sp_locations group by state order by state");
                  if(count($options)>0){?>
                   <option>Choose State</option>
                  <?php foreach ($options as $key => $value) {
                  ?>
                  <option <?php if($result_data['state']==$value["state"]){ echo "selected"; } ?> ><?=$value["state"]?></option>
                  <?php } } ?>
                </select>
	        </div>

	        <div class="col-md-12 top15">
          	    <span class="badge-label info-color p-2">District<span class="redstar">*</span></span>
                    <select name="district" id="district1" class="select2" required="">
                    <?php 
                  $options = $db->getRows("Select district from sp_locations where state='$state' group by district order by district");
                  if(count($options)>0){ ?>
                   <option>Choose District</option>
                   <?php
                  foreach ($options as $key => $value) {
                  ?>
                  <option <?php if($result_data['district']==$value["district"]){ echo "selected"; } ?> ><?=$value["district"]?></option>
                  <?php } } ?>
                </select>
	        </div>
	        
            <div class="col-md-12 top15">
                <span class="badge-label info-color p-2">Location<span class="redstar">*</span></span>
                <select name="location" id="location1" class="select2" required="">
                  <?php 
                  $options = $db->getRows("Select location from sp_locations where state='$state' and district ='$district' group by location order by location");
                  if(count($options)>0){?>
                   <option>Choose Location</option>
                   <?php
                  foreach ($options as $key => $value) {
                  ?>
                  <option <?php if($result_data['location']==$value["location"]){ echo "selected"; } ?> ><?=$value["location"]?></option>
                  <?php } } ?>
                </select>
            </div>
                      
            <div class="col-md-12 top15">
                <span class="badge-label info-color p-2">Pincode<span class="redstar">*</span></span>
                <input type="text" name="pincode" id="pincode1" class="form-control" value="<?=$pincode?>">
		    </div>

	        <input name="location_id" id="location_id" hidden="" class="form-control" placeholder="" type="text" value="<?= $result_data['location_id']; ?>"/>
			<?php 
			}
			break;
		}

		case 'get_district':{
			if(isset($_POST["state"])){
				$state = $_POST["state"];
				$Details = $db->getRows("SELECT district FROM sp_locations where state='$state' group by district order by district");	
				if (count($Details) > 0) {
						$arrResult1['status'] = 'success'; 
						$arrResult1['code'] = 200; 			
						$arrResult1['Data'] = '';$districts='<option value="">Choose District</option>';
						foreach ($Details as $key => $value) {
							$district = $value["district"];
							$districts.="<option>".$district."</option>";
						}
						$arrResult1['Data']=$districts;
				}
					else{
						$arrResult1['status'] = 'error'; 
						$arrResult1['code'] = 201; 				
						$arrResult1['message'] = 'No Data Found !';				
					}
				echo json_encode($arrResult1);
				exit;
			}
			break;
		}

		case 'get_location':{
			if(isset($_POST["state"]) && isset($_POST["district"])){
				$state = $_POST["state"];
				$district = $_POST["district"];
				$Details = $db->getRows("SELECT location FROM sp_locations where state='$state' and district='$district' group by location order by location");	
				if (count($Details) > 0) {
						$arrResult1['status'] = 'success'; 
						$arrResult1['code'] = 200; 			
						$arrResult1['Data'] = '';$locations='<option value="">Choose Location</option>';
						foreach ($Details as $key => $value) {
							$location = $value["location"];
							$locations.="<option>".$location."</option>";
						}
						$arrResult1['Data']=$locations;
				}
					else{
						$arrResult1['status'] = 'error'; 
						$arrResult1['code'] = 201; 				
						$arrResult1['message'] = 'No Data Found !';				
					}
				echo json_encode($arrResult1);
				exit;
			}
			break;
		}
		case 'get_pincode':{
			if(isset($_POST["state"]) && isset($_POST["district"]) && isset($_POST["location"])){
			 	$state = $_POST["state"];
				$district = $_POST["district"];
				$location = $_POST["location"];
				$Details = $db->getRows("SELECT pincode FROM sp_locations where state='$state' and district='$district' and location='$location' group by pincode order by pincode");	
				if (count($Details) > 0) {
						$arrResult1['status'] = 'success'; 
						$arrResult1['code'] = 200; 			
						$arrResult1['Data'] = '';$pincodes='<option value="">Choose Pincode</option>';
						foreach ($Details as $key => $value) {
							$pincode = $value["pincode"];
							$pincodes.="<option>".$pincode."</option>";
						}
						$arrResult1['Data']=$pincodes;
				}
					else{
						$arrResult1['status'] = 'error'; 
						$arrResult1['code'] = 201; 				
						$arrResult1['message'] = 'No Data Found !';				
					}
				echo json_encode($arrResult1);
				exit;

			}
			break;
		}


		case 'get_buyer_district':{
			if(isset($_POST["state"])){
				$state = $_POST["state"];
				$Details = $db->getRows("SELECT district FROM sp_buyer_locations where state='$state' group by district order by district");	
				if (count($Details) > 0) {
						$arrResult1['status'] = 'success'; 
						$arrResult1['code'] = 200; 			
						$arrResult1['Data'] = '';$districts='<option value="">Choose District</option>';
						foreach ($Details as $key => $value) {
							$district = $value["district"];
							$districts.="<option>".$district."</option>";
						}
						$arrResult1['Data']=$districts;
				}
					else{
						$arrResult1['status'] = 'error'; 
						$arrResult1['code'] = 201; 				
						$arrResult1['message'] = 'No Data Found !';				
					}
				echo json_encode($arrResult1);
				exit;
			}
			break;
		}

		case 'get_buyer_location':{
			if(isset($_POST["state"]) && isset($_POST["district"])){
				$state = $_POST["state"];
				$district = $_POST["district"];
				$Details = $db->getRows("SELECT location FROM sp_buyer_locations where state='$state' and district='$district' group by location order by location");	
				if (count($Details) > 0) {
						$arrResult1['status'] = 'success'; 
						$arrResult1['code'] = 200; 			
						$arrResult1['Data'] = '';$locations='<option value="">Choose Location</option>';
						foreach ($Details as $key => $value) {
							$location = $value["location"];
							$locations.="<option>".$location."</option>";
						}
						$arrResult1['Data']=$locations;
				}
					else{
						$arrResult1['status'] = 'error'; 
						$arrResult1['code'] = 201; 				
						$arrResult1['message'] = 'No Data Found !';				
					}
				echo json_encode($arrResult1);
				exit;
			}
			break;
		}
		case 'get_buyer_pincode':{
			if(isset($_POST["state"]) && isset($_POST["district"]) && isset($_POST["location"])){
			 	$state = $_POST["state"];
				$district = $_POST["district"];
				$location = $_POST["location"];
				$Details = $db->getRows("SELECT pincode FROM sp_buyer_locations where state='$state' and district='$district' and location='$location' group by pincode order by pincode");	
				if (count($Details) > 0) {
						$arrResult1['status'] = 'success'; 
						$arrResult1['code'] = 200; 			
						$arrResult1['Data'] = '';$pincodes='<option value="">Choose Pincode</option>';
						foreach ($Details as $key => $value) {
							$pincode = $value["pincode"];
							$pincodes.="<option>".$pincode."</option>";
						}
						$arrResult1['Data']=$pincodes;
				}
					else{
						$arrResult1['status'] = 'error'; 
						$arrResult1['code'] = 201; 				
						$arrResult1['message'] = 'No Data Found !';				
					}
				echo json_encode($arrResult1);
				exit;

			}
			break;
		}

		case 'edit_content':{ 		
		  	if( isset($_POST['id']) && !empty($_POST['id']) )
	      	{
	        
	        $content_id = $_POST['id'];
        	$result_data = $db->getRow("select * from sp_content where content_id='".$content_id."' Limit 1");
        	$section = $result_data['section'];
        	$content = $result_data['content'];

			?>
            <h5 class="text-center"><?=$section?></h5>
            <div class="col-md-12 top15">
                <span class="badge-label info-color p-2">Content</span><br/>
                <textarea id="content" name="content"><?=$content?></textarea>
		    </div>

	        <input name="content_id" id="content_id" hidden="" class="form-control" placeholder="" type="text" value="<?= $result_data['content_id']; ?>"/>
			<?php 
			}
			break;
		}

		case 'edit_subadmin':{ 		
		  	if( isset($_POST['id']) && !empty($_POST['id']) )
	      	{
	        
	        $sb_id = $_POST['id'];
        	$result_data = $db->getRow("select * from sp_subadmin where sb_id='".$sb_id."' Limit 1");
        	$name = $result_data['name'];
        	$mobile = $result_data['mobile'];
        	$email = $result_data['email'];
        	$address = $result_data['address'];
        	$username = $result_data['username'];
        	$password = $result_data['password'];
			?>
             <div class="col-md-12 top15">
                <span class="badge-label info-color p-2">Name<span class="redstar">*</span></span>
                <input type="text" id="sub_name1" name="sub_name" class="form-control" placeholder="Name" value="<?=$name?>" required="">
              </div>
              <div class="col-md-12 top15">
                <span class="badge-label info-color p-2">Mobile<span class="redstar">*</span></span>
                <input type="number" id="sub_mobile1" name="sub_mobile" class="form-control" placeholder="Mobile" value="<?=$mobile?>" required="">
              </div>
              <div class="col-md-12 top15">
                <span class="badge-label info-color p-2">Email</span><br/>
                         <input type="email" id="sub_email1" name="sub_email" class="form-control" placeholder="Email" value="<?=$email?>">
              </div>
              <div class="col-md-12 top15">
                <span class="badge-label info-color p-2">Address</span><br/>
                 <textarea id="sub_address1" name="sub_address" class="form-control" placeholder="Address"><?=$address?></textarea>
              </div>
              <div class="col-md-12 top15">
                <span class="badge-label info-color p-2">Username<span class="redstar">*</span></span><br/>
                         <input type="text" id="sub_username1" name="sub_username" class="form-control" placeholder="Username" value="<?=$username?>" required="">
              </div>
              <div class="col-md-12 top15">
                <span class="badge-label info-color p-2">Password<span class="redstar">*</span></span><br/>
                <input type="password" id="sub_password1" name="sub_password" class="form-control" placeholder="Password" value="<?=$password?>" required="">
              </div>

	        <input name="sb_id" id="sb_id" hidden="" class="form-control" placeholder="" type="text" value="<?= $result_data['sb_id']; ?>"/>
			<?php 
			}
			break;
		}
	}
}
?>