<?php
defined('PATH_LIB') or die("Restricted Access");

function download_mobile_app_div()
{
    echo '<div class="col-lg-12 col-md-12 col-sm-6">
        <div class="icon-bx-wraper bx-style-1 p-a30 center m-b15">
            <div class="icon-bx-sm text-primary bg-white radius border-2 m-b20"> <a href="#" class="icon-cell"><i class="ti-user"></i></a> </div>
            <div class="icon-content">
                <h5 class="dlab-tilte text-uppercase">Mobile App</h5>
                <p>Available on Android</p>
                <a href="#" class="site-button m-r15">Download App</a>
            </div>
        </div>
    </div>';
}

function get_vehicle_types_list($edit_vehicle_type_val='')
{
	$vehicle_types = array(
		'Car'=>'Car',
		'Bike'=>'Bike'
	);

	$selected = '';

	foreach( $vehicle_types as $vt_key => $vt_value )
	{
		if( !empty($edit_vehicle_type_val) )
		{
			if( $vt_key == $edit_vehicle_type_val )
			{
				$selected = 'selected';
			}
			else
			{
				$selected = '';
			}
		}
		?>
			<option value="<?= $vt_key; ?>" <?= $selected; ?>><?= $vt_value; ?></option>
		<?php
	}
}

function get_vehicle_cat_list($vehicle_type, $edit_vehicle_category_val='')
{
	if( $vehicle_type == 'Car' )
	{
		$vehicle_categories = array(
			'Hatchback'=>'Hatchback',
			'Sedan'=>'Sedan',
			'SUV'=>'SUV'
		);
	}
	else if( $vehicle_type == 'Bike' )
	{
		$vehicle_categories = array(
			'Bike'=>'Bike'
		);
	}

	$selected = '';

	?>
		<option value="">Select Vehicle Category</option>
	<?php

	foreach( $vehicle_categories as $vc_key => $vc_value )
	{
		if( !empty($edit_vehicle_category_val) )
		{
			if( $vc_key == $edit_vehicle_category_val )
			{
				$selected = 'selected';
			}
			else
			{
				$selected = '';
			}
		}

		if( $vc_key == 'Bike' )
		{
			$selected = 'selected';
		}
		?>
		<option value="<?= $vc_key; ?>" <?= $selected; ?>><?= $vc_value; ?></option>
		<?php
	}
}

function get_vehicle_make_and_model_list($vehicle_category, $edit_vehicle_make_and_model_val='')
{
	global $db;

	if( $vehicle_category == 'SUV' )
	{
		$where_condition = "body IN('SUV','MPV')";
	}
	else
	{
		$where_condition = "body='".$vehicle_category."'";
	}

	//Get vehicle makes and models from database
    $vehicle_makes_and_models_data = $db->getRows("select make,model from car_data where ".$where_condition." order by id asc");

    if( count($vehicle_makes_and_models_data) > 0 )
    {
		$selected = '';

		?>
			<option value="">Select Vehicle Make & Model</option>
		<?php
			foreach( $vehicle_makes_and_models_data as $vehicle_make_and_model_list )
			{
				$vehicle_make = $vehicle_make_and_model_list['make'];
				$vehicle_model = $vehicle_make_and_model_list['model'];

				$vmm_value = $vehicle_make.' - '.$vehicle_model;
				
				if( !empty($edit_vehicle_make_and_model_val) )
				{
					if( $vmm_value == $edit_vehicle_make_and_model_val )
					{
						$selected = 'selected';
					}
					else
					{
						$selected = '';
					}
				}
		?>
				<option value="<?= $vmm_value; ?>" <?= $selected; ?>><?= $vmm_value; ?></option>
		<?php
			}
	}
}

function get_vehicle_makes_list($edit_vehicle_make_val='')
{
	$selected = '';
	
	/*Get vehicle makes data*/
	$cur_ini = curl_init();
	curl_setopt($cur_ini, CURLOPT_URL,'http://www.carqueryapi.com/api/0.3/?cmd=getMakes');      
	curl_setopt($cur_ini, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
	curl_setopt($cur_ini, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($cur_ini, CURLOPT_SSL_VERIFYPEER, false);
	$vehicle_makes_result = curl_exec($cur_ini);
	curl_close($cur_ini);
	$vehicle_makes_response = json_decode($vehicle_makes_result, true);

	$vehicle_makes_arr = $vehicle_makes_response['Makes'];

	if( !empty($vehicle_makes_arr) )
	{
		foreach( $vehicle_makes_arr as $vehicle_make_arr_list )
		{
			$vehicle_make_id = $vehicle_make_arr_list['make_id'];
			$vehicle_make_display = $vehicle_make_arr_list['make_display'];

			if( !empty($edit_vehicle_make_val) )
			{
				if( $vehicle_make_id == $edit_vehicle_make_val )
				{
					$selected = 'selected';
				}
				else
				{
					$selected = '';
				}
			}
			?>
				<option value="<?= $vehicle_make_id; ?>" <?= $selected; ?>><?= $vehicle_make_display; ?></option>
			<?php
		}
	}
}

function get_vehicle_models_list($vehicle_make, $edit_vehicle_model_val='')
{
	if( !empty($vehicle_make) )
	{
		$vehicle_make = trim($vehicle_make);

		$selected = '';

		/*Get vehicle models data*/
		$cur_ini = curl_init();
		curl_setopt($cur_ini, CURLOPT_URL,'http://www.carqueryapi.com/api/0.3/?cmd=getModels&make='.$vehicle_make);      
		curl_setopt($cur_ini, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
		curl_setopt($cur_ini, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($cur_ini, CURLOPT_SSL_VERIFYPEER, false);
		$vehicle_models_data_result = curl_exec($cur_ini);
		curl_close($cur_ini);
		$vehicle_models_data_response = json_decode($vehicle_models_data_result, true);

		$vehicle_models_data_arr = $vehicle_models_data_response['Models'];

		if( !empty($vehicle_models_data_arr) )
		{
		?>
			<option value="">Select Vehicle Model</option>
		<?php

			foreach( $vehicle_models_data_arr as $vehicle_model_data_arr_list ) 
			{
				$vehicle_model_name = $vehicle_model_data_arr_list['model_name'];

				if( !empty($edit_vehicle_model_val) )
				{
					if( $vehicle_model_name == $edit_vehicle_model_val )
					{
						$selected = 'selected';
					}
					else
					{
						$selected = '';
					}
				}
				?>
					<option value="<?= $vehicle_model_name; ?>" <?= $selected; ?>><?= $vehicle_model_name; ?></option>
				<?php
			}
		}
		else
		{
			?>
				<option value="">Select Vehicle Model</option>
			<?php
		}
	}
}

function get_vehicle_categories_list($vehicle_make, $vehicle_model, $edit_vehicle_category_val='')
{
	if( !empty($vehicle_make) && !empty($vehicle_model) )
	{
		$vehicle_make = trim($vehicle_make);
		$vehicle_model = trim($vehicle_model);

		$vehicle_model_bodies_arr = array();

		$selected = '';

		/*Get vehicle categories data*/
		$cur_ini = curl_init();
		curl_setopt($cur_ini, CURLOPT_URL,'http://www.carqueryapi.com/api/0.3/?cmd=getTrims&model='.$vehicle_model.'&make='.$vehicle_make);
		curl_setopt($cur_ini, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
		curl_setopt($cur_ini, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($cur_ini, CURLOPT_SSL_VERIFYPEER, false);
		$vehicle_categories_data_result = curl_exec($cur_ini);
		curl_close($cur_ini);
		$vehicle_categories_data_response = json_decode($vehicle_categories_data_result, true);

		$vehicle_categories_data_arr = $vehicle_categories_data_response['Trims'];

		if( !empty($vehicle_categories_data_arr) )
		{
			foreach( $vehicle_categories_data_arr as $vehicle_category_data_arr_list ) 
			{
				$vehicle_model_bodies_arr[] = $vehicle_category_data_arr_list['model_body'];
			}

			$final_vehicle_model_bodies_arr = array_unique($vehicle_model_bodies_arr);
			
			?>
				<option value="">Select Vehicle Category</option>
			<?php
			
			foreach( $final_vehicle_model_bodies_arr as $fvmbkey => $fvmbvalue ) 
			{
				$vehicle_model_body = $fvmbvalue;

				if( !empty($edit_vehicle_category_val) )
				{
					if( $vehicle_model_body == $edit_vehicle_category_val )
					{
						$selected = 'selected';
					}
					else
					{
						$selected = '';
					}
				}
				?>
					<option value="<?= $vehicle_model_body; ?>" <?= $selected; ?>><?= $vehicle_model_body; ?></option>
				<?php
			}
		}
		else
		{
			?>
				<option value="">Select Vehicle Category</option>
			<?php
		}
	}
}

function get_vehicle_fuel_types_list($edit_vehicle_fuel_type_val='')
{
	$fuel_types = array(
		'Petrol'=>'Petrol',
		'Diesel'=>'Diesel',
		'Gas'=>'Gas',
		'Electric'=>'Electric'
	);

	$selected = '';

	foreach( $fuel_types as $ft_key => $ft_value )
	{
		if( !empty($edit_vehicle_fuel_type_val) )
		{
			if( $ft_key == $edit_vehicle_fuel_type_val )
			{
				$selected = 'selected';
			}
			else
			{
				$selected = '';
			}
		}
		?>
			<option value="<?= $ft_key; ?>" <?= $selected; ?>><?= $ft_value; ?></option>
		<?php
	}
}

function get_customer_apartment_names_list($edit_customer_apartment_name_val='')
{
	$customer_apartment_names = array(
		'Apartment 1'=>'Apartment 1',
		'Apartment 2'=>'Apartment 2',
		'Apartment 3'=>'Apartment 3',
		'Apartment 4'=>'Apartment 4',
		'Apartment 5'=>'Apartment 5'
	);

	$selected = '';

	foreach( $customer_apartment_names as $can_key => $can_value )
	{
		if( !empty($edit_customer_apartment_name_val) )
		{
			if( $can_key == $edit_customer_apartment_name_val )
			{
				$selected = 'selected';
			}
			else
			{
				$selected = '';
			}
		}
		?>
		<option value="<?= $can_key; ?>" <?= $selected; ?>><?= $can_value; ?></option>
		<?php
	}
}

function get_vehicle_parking_areas_list($edit_vehicle_parking_area_val='')
{
	$vehicle_parking_areas = array(
		'Basement 1'=>'Basement 1',
		'Basement 2'=>'Basement 2',
		'Open Area'=>'Open Area',
		'Visitor Parking'=>'Visitor Parking'
	);

	$selected = '';

	foreach( $vehicle_parking_areas as $vpa_key => $vpa_value )
	{
		if( !empty($edit_vehicle_parking_area_val) )
		{
			if( $vpa_key == $edit_vehicle_parking_area_val )
			{
				$selected = 'selected';
			}
			else
			{
				$selected = '';
			}
		}
		?>
			<option value="<?= $vpa_key; ?>" <?= $selected; ?>><?= $vpa_value; ?></option>
		<?php
	}
}

function get_vehicle_preferred_schedules_list($edit_vehicle_preferred_schedule_val='')
{
	$vehicle_preferred_schedules = array(
		'Morning'=>'Morning',
		'Evening'=>'Evening'
	);

	$selected = '';

	foreach( $vehicle_preferred_schedules as $vps_key => $vps_value )
	{
		if( !empty($edit_vehicle_preferred_schedule_val) )
		{
			if( $vps_key == $edit_vehicle_preferred_schedule_val )
			{
				$selected = 'selected';
			}
			else
			{
				$selected = '';
			}
		}
		?>
			<option value="<?= $vps_key; ?>" <?= $selected; ?>><?= $vps_value; ?></option>
		<?php
	}
}

function get_vehicle_preferred_times_list($preferred_schedule, $edit_vehicle_preferred_time_val='')
{
	if( $preferred_schedule == 'Morning' )
	{
		$vehicle_preferred_times = array(
			'Any Time'=>'Any Time',
			'5:00 AM - 6:00 AM'=>'5:00 AM - 6:00 AM',
			'6:00 AM - 7:00 AM'=>'6:00 AM - 7:00 AM',
			'7:00 AM - 8:00 AM'=>'7:00 AM - 8:00 AM',
			'8:00 AM - 9:00 AM'=>'8:00 AM - 9:00 AM',
			'9:00 AM - 10:00 AM'=>'9:00 AM - 10:00 AM'
		);
	}
	else if( $preferred_schedule == 'Evening' )
	{
		$vehicle_preferred_times = array(
			'Any Time'=>'Any Time',
			'5:00 PM - 6:00 PM'=>'5:00 PM - 6:00 PM',
			'6:00 PM - 7:00 PM'=>'6:00 PM - 7:00 PM',
			'7:00 PM - 8:00 PM'=>'7:00 PM - 8:00 PM',
			'8:00 PM - 9:00 PM'=>'8:00 PM - 9:00 PM'
		);
	}

	$selected = '';

	foreach( $vehicle_preferred_times as $vpt_key => $vpt_value )
	{
		if( !empty($edit_vehicle_preferred_time_val) )
		{
			if( $vpt_key == $edit_vehicle_preferred_time_val )
			{
				$selected = 'selected';
			}
			else
			{
				$selected = '';
			}
		}
		?>
		<option value="<?= $vpt_key; ?>" <?= $selected; ?>><?= $vpt_value; ?></option>
		<?php
	}
}

function get_apartment_names_list($edit_apartment_name_val='')
{
	// $apartment_names = array(
	// 	'Metro Zone - Jawaharlal Nehru Salai, Anna Nagar, Chennai, Tamil Nadu 600040'=>'Metro Zone - Jawaharlal Nehru Salai, Anna Nagar, Chennai, Tamil Nadu 600040',
	// 	'Prestige Bella Vista - Kattupakkam, Chennai, Tamil Nadu 600056'=>'Prestige Bella Vista - Kattupakkam, Chennai, Tamil Nadu 600056',
	// 	'Kochar Panchell - Sidco Industrial Estate, Thirumalai Colony, Chennai, Tamil Nadu 600098'=>'Kochar Panchell - Sidco Industrial Estate, Thirumalai Colony, Chennai, Tamil Nadu 600098'
	// );
	global $db;
	$apartment_names = array();
	$result_data = $db->getRows("select * from apartments");
    if( count($result_data) > 0 )
    {
        foreach( $result_data as $data_list )
        { array_push($apartment_names, $data_list['name']); }
	}	

	$selected = '';

	foreach( $apartment_names as $vps_key => $vps_value )
	{
		if( !empty($edit_apartment_name_val) )
		{
			if( $vps_key == $edit_apartment_name_val )
			{
				$selected = 'selected';
			}
			else
			{
				$selected = '';
			}
		}
		?>
			<option value="<?= $vps_key; ?>" <?= $selected; ?>><?= $vps_value; ?></option>
		<?php
	}
}

function update_customer_my_orders_data($customer_id, $razorpay_keyid, $razorpay_secretkey)
{
	$extradate = "0 day";
	/*Update customer order details*/
	if( !empty($customer_id) && !empty($razorpay_keyid) && !empty($razorpay_secretkey) )
	{
		global $db;
		
		$customer_my_orders_data = $db->getRows("select * from my_orders where customer_id='".$customer_id."' and subscription_id!='' and payment_type='Monthly' and (status='Active' or status = 'Created' or status = 'Authenticated') ");

		if( count($customer_my_orders_data) > 0 )
		{
			foreach( $customer_my_orders_data as $my_order_data_list )
			{
				$order_id = $my_order_data_list['order_id'];
				$subscription_id = $my_order_data_list['subscription_id'];
				$vehicle_id = $my_order_data_list['vehicle_id'];


				/*Get vehicle type*/
	            	$vehicle_type = $db->getVal("select vehicle_type from customer_vehicles where vehicle_id='".$vehicle_id."' limit 1");

	          if($vehicle_type != 'Bike'){

				$ch = curl_init();
	            curl_setopt($ch, CURLOPT_URL,'https://'.$razorpay_keyid.':'.$razorpay_secretkey.'@api.razorpay.com/v1/subscriptions/'.$subscription_id);
	            //curl_setopt($ch, CURLOPT_POST, true);
	            // curl_setopt($ch, CURLOPT_HTTPHEADER, "$headers");
	            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
	            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	            /*curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($post));*/
	            $result = curl_exec($ch);
	            curl_close($ch);

	            $response = json_decode($result, true);

	            if( isset($response['error']['code']) )
	            {
	              $error = $response['error']['code'];
	            }
	            else
	            {
	              	$subscrip_id = $response['id'];
	              	$no_of_count = $response['total_count'];
					$paid_count = $response['paid_count'];
					$next_due = date('Y-m-d', $response['charge_at']);
					$subs_status = ucwords($response['status']);

					$my_order_fields_data = array(                      
                        'no_of_count' => $no_of_count,
                        'paid_count' => $paid_count,
                        'next_due' => $next_due,
                        'status' => $subs_status,
                        'updateandtime' => date('Y-m-d h:i:s')
                    );

	              	$update_customer_my_orders_data = $db->updateAry('my_orders', $my_order_fields_data, "where order_id='".$order_id."' and subscription_id='".$subscrip_id."' and customer_id='".$customer_id."' and vehicle_id='".$vehicle_id."'");

	              	/*Get last next due date*/
	            	$next_due_date = $db->getVal("select next_due from customer_vehicles_internal_clean_details where order_id='".$order_id."' and customer_id='".$customer_id."' and vehicle_id='".$vehicle_id."' order by id desc limit 1");

	            	if( $next_due_date != '0000-00-00' && $next_due_date != '' )
	            	{
	            		$next_due_date = date('Y-m-d', strtotime($next_due_date));

	            		if( strtotime($next_due) > strtotime($next_due_date) )
	            		{
	            			$insert_cvicd_arr = array(
								'order_id' => $order_id,
								'customer_id' => $customer_id,
								'vehicle_id' => $vehicle_id,
								'schedule_work_status1' => 'No',
								'schedule_work_status2' => 'No',
								'next_due' => date('Y-m-d', strtotime($next_due)),
								'dateandtime' => date('Y-m-d h:i:s')
							);

							$insert_customer_vehicle_internal_clean_result = $db->insertAry('customer_vehicles_internal_clean_details', $insert_cvicd_arr);
	            		}
	            	}
	            }
			}
		 	}
		}

		// Updating Onetime Payment Wash Details-------
		$customer_my_orders_data = $db->getRows("select * from my_orders where customer_id='".$customer_id."' and payment_type='One Time' and (status='Active') ");
	              

		if( count($customer_my_orders_data) > 0 )
		{
			foreach( $customer_my_orders_data as $my_order_data_list )
			{
				$id = $my_order_data_list['id'];
				$order_id = $my_order_data_list['order_id'];
				$next_due = $my_order_data_list['next_due'];
				$no_of_count = $my_order_data_list['no_of_count'];
				$paid_count = $my_order_data_list['paid_count'];
				$vehicle_id = $my_order_data_list['vehicle_id'];				

			  $vehicle_type = $db->getVal("select vehicle_type from customer_vehicles where vehicle_id='".$vehicle_id."' limit 1");

	          if($vehicle_type != 'Bike'){

				 $current_date = date('Y-m-d');
				 if(strtotime($next_due) <= strtotime($current_date) && ($paid_count < $no_of_count)){
				 	$paid_count = $paid_count+1;
	            	$next_due = date('Y-m-d', strtotime("$next_due +1 month"));

				 	$my_order_fields_data = array( 
                        'paid_count' => $paid_count,
                        'next_due' => $next_due,
                        'updateandtime' => date('Y-m-d h:i:s')
                    );

	              	$update_customer_my_orders_data = $db->updateAry('my_orders', $my_order_fields_data, "where order_id='".$order_id."' and customer_id='".$customer_id."' and id ='".$id."' ");

	              	// echo $db->getLastQuery();
				 }

				if(strtotime($next_due) < strtotime($current_date) && ($paid_count == $no_of_count)){
				 	
				 	if(strtotime("$next_due +$extradate") > strtotime($current_date) ){
	            	$subs_status = "Over Due";
	            	}
	            	else{
	            	$subs_status = "Closed";	            		
	            	}
				 	$my_order_fields_data = array( 
                        'status' => $subs_status
                    );

	              	$update_customer_my_orders_data = $db->updateAry('my_orders', $my_order_fields_data, "where order_id='".$order_id."' and customer_id='".$customer_id."' and id ='".$id."' ");
				 }
	              	/*Get last next due date*/
				$paid_count = $my_order_data_list['paid_count'];				
	            	$next_due_date = $db->getVal("select next_due from customer_vehicles_internal_clean_details where order_id='".$order_id."' and customer_id='".$customer_id."' and vehicle_id='".$vehicle_id."' order by id desc limit 1");
	              	// echo $db->getLastQuery();

	            	if( $next_due_date != '0000-00-00' && $next_due_date != '' )
	            	{
	            		$next_due_date = date('Y-m-d', strtotime($next_due_date));

	            		if( strtotime($next_due) > strtotime($next_due_date) )
	            		{
	            			$insert_cvicd_arr = array(
								'order_id' => $order_id,
								'customer_id' => $customer_id,
								'vehicle_id' => $vehicle_id,
								'schedule_work_status1' => 'No',
								'schedule_work_status2' => 'No',
								'next_due' => date('Y-m-d', strtotime($next_due)),
								'dateandtime' => date('Y-m-d h:i:s')
							);

							$insert_customer_vehicle_internal_clean_result = $db->insertAry('customer_vehicles_internal_clean_details', $insert_cvicd_arr);
	              	// echo $db->getLastQuery();exit;

	            		}
	            	}
			
	            }
			}
		}
		// -------


		// close overdue--------------
		$current_date = date('Y-m-d');
		$customer_my_orders_datas = $db->getRows("select * from my_orders where customer_id='".$customer_id."' and payment_type='One Time' and (status='Over Due') ");              
		if( count($customer_my_orders_datas) > 0)
		{

			foreach( $customer_my_orders_datas as $my_order_data_list )
			{
			$next_due = $my_order_data_list['next_due'];
			$id = $my_order_data_list['id'];
			$order_id = $my_order_data_list['order_id'];

			if(strtotime("$next_due +$extradate") > strtotime($current_date) ){
	            	$subs_status = "Over Due";
	            	}
	            	else{
	            	$subs_status = "Closed";	            		
	            	
				 	$my_order_fields_data = array( 
                        'status' => $subs_status
                    );

	              	$update_customer_my_orders_data = $db->updateAry('my_orders', $my_order_fields_data, "where order_id='".$order_id."' and customer_id='".$customer_id."' and id ='".$id."' ");
	              	}
	        }
		}
	}
}

// new recurring update-------------------------------
function create_internal_clean_details($order_id){
	global $db;	
	$customer_my_orders_data = $db->getRows("select id, next_due, vehicle_id from my_orders where order_id='".$order_id."' and payment_type='Monthly' and (status='Active') and service_type = 'Wash'");             

		if( count($customer_my_orders_data) > 0 )
		{
			foreach( $customer_my_orders_data as $my_order_data_list )
			{
				$id = $my_order_data_list['id'];
				$next_due = $my_order_data_list['next_due'];
				$vehicle_id = $my_order_data_list['vehicle_id'];				

			  $vehicle_type = $db->getVal("select vehicle_type from customer_vehicles where vehicle_id='".$vehicle_id."' limit 1");

	        if($vehicle_type != 'Bike'){

			/*Get last next due date*/
	            $next_due_date = $db->getVal("select next_due from customer_vehicles_internal_clean_details where order_id='".$order_id."' and vehicle_id='".$vehicle_id."' order by id desc limit 1");

	            	if( $next_due_date != '0000-00-00' && $next_due_date != '' )
	            	{
	            		$next_due_date = date('Y-m-d', strtotime($next_due_date));

	            		if( strtotime($next_due) > strtotime($next_due_date) )
	            		{
	            			$insert_cvicd_arr = array(
								'order_id' => $order_id,
								'customer_id' => $customer_id,
								'vehicle_id' => $vehicle_id,
								'schedule_work_status1' => 'No',
								'schedule_work_status2' => 'No',
								'next_due' => date('Y-m-d', strtotime($next_due)),
								'dateandtime' => date('Y-m-d H:i:s')
							);

							$insert_customer_vehicle_internal_clean_result = $db->insertAry('customer_vehicles_internal_clean_details', $insert_cvicd_arr);
	            		}
	            	}

	            }
			}		 	
		}

}

function update_recurring_payments($razorpay_keyid, $razorpay_secretkey, $customer_id){
	global $db;
	if($customer_id != '' && isset($customer_id) && !empty($customer_id)){ $extra = " and a.customer_id = '$customer_id'"; }
	else{ $extra = ""; }
    $customer_my_orders_data = $db->getRows("select a.id, a.razorpay_payment_id, a.order_id, b.service_type from recurring_payment_list as a left join my_orders as b on a.order_id = b.order_id where a.status != 'paid' and a.status !='captured' and a.status !='success' and a.status !='failed' and b.status !='Cancelled' and b.status !='Closed' $extra ");

	if( count($customer_my_orders_data) > 0 )
	{
		foreach( $customer_my_orders_data as $my_order_data_list )
		{
			$razorpay_payment_id = $my_order_data_list['razorpay_payment_id'];
			$order_id = $my_order_data_list['order_id'];			
			$recurring_id = $my_order_data_list['id'];
			$service_type = $my_order_data_list['service_type'];			

			$ch = curl_init();
	        curl_setopt($ch, CURLOPT_URL,'https://'.$razorpay_keyid.':'.$razorpay_secretkey.'@api.razorpay.com/v1/payments/'.$razorpay_payment_id);
	        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	        $result = curl_exec($ch);
	        curl_close($ch);
	        $response = json_decode($result, true);
	        if( isset($response['error']['code']) )
		    {
		        $error = $response['error']['code'];
		        $data_message = $response['error']['description'];
		        json_encode( array('validation'=>'0','result'=>$data_message) );
		    }
		    else{

		    	$payment_id = $response['id'];
		    	$razorpay_order_id = $response['order_id'];
		    	$status = $response['status'];

		    	if($status == "created"){ $status = "pending"; }
		    	// if success-------------
		    	if($status == "captured"){ 	    		

		    		$status = "success";

		    		$my_order_fields_data = array( 
                        'razorpay_order_id' => $razorpay_order_id,
                        'status' => $status,
                    );

	            	$update_recurrings_data = $db->updateAry('recurring_payment_list', $my_order_fields_data, "where id='".$recurring_id."' ");

		    		$paidcounts = $db->getVal("select count(id) from recurring_payment_list where order_id = '$order_id' and status = 'success'");

		    		if($paidcounts == 0){

		    			// update my orders---
						$update_array = array(	
						    'status' => 'Pending'
						);
						$result_count = $db->updateAry('my_orders', $update_array, "where order_id='".$order_id."'");

		    		}
		    		else{

		    			$next_due = $db->getVal("select DATE_ADD(dateandtime,INTERVAL $paidcounts month) as next_due from my_orders where order_id='".$order_id."' order by id desc limit 1");

		    			$paid_count = $db->getVal("select paid_count from my_orders where order_id='".$order_id."' order by id desc limit 1");

			    		// update my orders---
						$update_array = array(		          
						    'paid_count' => $paid_count+1,
						    'next_due' => $next_due,
						    'status' => 'Active',
						    'updateandtime' => date('Y-m-d H:i:s')
						);
						$result_count = $db->updateAry('my_orders', $update_array, "where order_id='".$order_id."'");

						$last_payment_id = $db->getRows("select last_payment_id from reminder where last_payment_id='".$payment_id."' limit 1");
						if(count($last_payment_id) > 0){
							//update reminder
				    		$reminder_data = array( 
		                        'last_payment_id' => '',
								'attempts' => 0,
		                        'date' => $next_due,
		                    );
		                    $update_recurrings_data = $db->updateAry('reminder', $reminder_data, "where order_id='".$order_id."'");
	                	}

		    		}

		    		if($service_type == "Wash"){ create_internal_clean_details($order_id); }		    		
                }
                else{
                	// for other status-----------------
                	$my_order_fields_data = array( 
                        'razorpay_order_id' => $razorpay_order_id,
                        'status' => $status,
                    );

	            	$update_recurrings_data = $db->updateAry('recurring_payment_list', $my_order_fields_data, "where id='".$recurring_id."' ");

	            	if($status == "failed"){
	            		// cancel orders------
						$update_array = array(	
						    'status' => 'Cancelled'
						);
						$result_count = $db->updateAry('my_orders', $update_array, "where order_id='".$order_id."'");
						$results2 = $db->delete('reminder', "where order_id='".$order_id."'");

	            	}

                }

			}
		}
	}

}

function vehicle_make_to_ucwords($vehicle_make)
{
	$vehicle_make = str_replace('-', ' ', $vehicle_make);
	$new_vehicle_make = ucwords($vehicle_make);
	$new_vehicle_make = str_replace(' ', '-', $new_vehicle_make);

	return $new_vehicle_make;
}



 function sendfcm($registration_ids, $message) {
        // echo 'registration id :'.$registration_ids;
        $fields = array(
            'registration_ids' => $registration_ids,
            'data' => $message,
        );
        return sendPushNotification($fields);
    }
    
    /*
    * This function will make the actuall curl request to firebase server
    * and then the message is sent 
    */
     function sendPushNotification($fields) {
        
        // firebase server url to send the curl request
        $url = 'https://fcm.googleapis.com/fcm/send';

        global $db;
		//Get vehicle makes and models from database
    	$fcmkey = $db->getVal("select value from settings where name='fcm'");

        define("FIREBASE_API_KEY",$fcmkey);
        
        //building headers for the request
        $headers = array(
            'Authorization: key=' . FIREBASE_API_KEY,
            'Content-Type: application/json'
        );

        //Initializing curl to open a connection
        $ch = curl_init();
 
        //Setting the curl url
        curl_setopt($ch, CURLOPT_URL, $url);
        
        //setting the method as post
        curl_setopt($ch, CURLOPT_POST, true);

        //adding headers 
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 
        //disabling ssl support
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        //adding the fields in json format 
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        //finally executing the curl request 
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
 
        //Now close the connection
        curl_close($ch);
        return $result;
    }
?>
