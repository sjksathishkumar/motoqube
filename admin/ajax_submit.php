<?php 
	include("../config.php");
	
if( isset($_POST['action']) && !empty($_POST['action']) )
{
  $action = $_POST['action'];

	switch($action)
	{
		case "delete_customer":{

      if( isset($_POST['ID']) && !empty($_POST['ID']) && isset($_POST['table_name']) && !empty($_POST['table_name']) )
      {
  			$customer_id = $_POST['ID'];
        $table_name = $_POST['table_name'];


  			$result = $db->delete($table_name, "where customer_id='".$customer_id."'");

  			if( $db->getAffectedRows() > 0 )
  			{


          $my_orders = $db->getRows("select order_id from my_orders where customer_id='".$customer_id."'");
          if( count($my_orders) > 0 )
          { 
            foreach( $my_orders as $value ){
              $order_id = $value['order_id'];
              $results1 = $db->delete('recurring_payment_list', "where order_id='".$order_id."'");
              $results2 = $db->delete('reminder', "where order_id='".$order_id."'");
            }
          }

        $result1 = $db->delete('my_orders', "where customer_id='".$customer_id."'");
        $result2 = $db->delete('one_time_pay_my_orders', "where customer_id='".$customer_id."'");
        $result3 = $db->delete('customer_vehicles_internal_clean_details', "where customer_id='".$customer_id."'");        

        $customer_vehicles_data = $db->getRows("select vehicle_id from customer_vehicles where customer_id='".$customer_id."'");
        if( count($customer_vehicles_data) > 0 )
        {
          foreach( $customer_vehicles_data as $customer_vehicle_data_list )
          {
            $result4 = $db->delete('customer_vehicles_wash_details', "where vehicle_id='".$customer_vehicle_data_list['vehicle_id']."'");           
          }
        }
        $result5 = $db->delete('customer_vehicles', "where customer_id='".$customer_id."'");
        $result6 = $db->delete('assign_vehicles', "where customer_id='".$customer_id."'");        

  				echo json_encode( array('validation'=>'1', 'message'=>'Record deleted successfully') );
  			}
  			else
  			{
  				echo json_encode( array('validation'=>'0', 'message'=>'Action failed! Please try again.') );
  			}
      }

			break;
		}

    case "change_subscription_status_data":{

      if( isset($_POST['ID']) && !empty($_POST['ID']) && isset($_POST['subscription_status']) && !empty($_POST['subscription_status']) && isset($_POST['table_name']) && !empty($_POST['table_name']) )
      {
        $order_id = $_POST['ID'];
        $subscription_status = $_POST['subscription_status'];
        $table_name = $_POST['table_name'];

        if( $subscription_status == 'Cancelled' )
        {
          $my_orders_data = $db->getRow("select * from my_orders where order_id='".$order_id."'");
          $subscription_id = $my_orders_data['subscription_id'];
          $subscrip_status = $my_orders_data['status'];

          if( $subscrip_status == 'Cancelled' )
          {
            echo json_encode( array('validation'=>'0', 'message'=>'This subscription already Cancelled') );
            exit;
          }
          else
          {

            // $post = [
            //   'cancel_at_cycle_end' => '0',
            // ];

            // $ch = curl_init();
            // curl_setopt($ch, CURLOPT_URL,'https://'.$razorpay_keyid.':'.$razorpay_secretkey.'@api.razorpay.com/v1/subscriptions/'.$subscription_id.'/cancel');
            // curl_setopt($ch, CURLOPT_POST, true);
            // // curl_setopt($ch, CURLOPT_HTTPHEADER, "$headers");
            // curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
            // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            // curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($post));
            // $result = curl_exec($ch);
            // curl_close($ch);

            // $response = json_decode($result, true);

            // if( isset($response['error']['code']) )
            // {
            //   $error = $response['error']['code'];

            //   echo json_encode( array('validation'=>'0', 'message'=>'Action failed! Please try again.') );
            //   exit;
            // }
            // else
            // {
            //   $subscrip_id = $response['id'];
            //   $subs_status = ucfirst($response['status']);
            //   $update_and_time = date('Y-m-d h:i:s');
            //   $cancelled_date = date('Y-m-d h:i:s');

            //   $update_my_orders_data = $db->update("update ".$table_name." set status='".$subs_status."',updateandtime='".$update_and_time."',cancelled_date='".$cancelled_date."' where order_id='".$order_id."' and subscription_id='".$subscrip_id."'");
            



             $update_my_orders_data = $db->update("update ".$table_name." set status='".$subs_status."',updateandtime='".$update_and_time."',cancelled_date='".$cancelled_date."' where order_id='".$order_id."' ");


             $result = $db->delete('reminder', "where order_id='".$order_id."'");
          }
        }
        else
        {
          $update_and_time = date('Y-m-d H:i:s');

          $update_my_orders_data = $db->update("update ".$table_name." set status='".$subscription_status."',updateandtime='".$update_and_time."' where order_id='".$order_id."'");
        }

        if( $db->getAffectedRows() > 0 )
        {
          echo json_encode( array('validation'=>'1', 'message'=>'Record updated successfully') );
        }
        else
        {
          echo json_encode( array('validation'=>'0', 'message'=>'Action failed! Please try again.') );
        }
      }

      break;
    }

		case "edit_vehicle_details":{

      if( isset($_POST['ID']) && !empty($_POST['ID']) )
      {
        $vehicle_id = $_POST['ID'];

        $result_data = $db->getRow("select * from customer_vehicles where vehicle_id='".$vehicle_id."'");
			  ?>
        <div class="col-md-6 top15">
          <span class="badge-label p-2">Vehicle Type <span class="redstar">*</span></span>
          <select name="vehicle_type" id="vehicle_type" required="" class="form-control">
            <option value="">Select Vehicle Type</option>
            <?php
              $edit_vehicle_type_val = $result_data['vehicle_type'];
              get_vehicle_types_list($edit_vehicle_type_val);
            ?>
          </select>
        </div>

        <div id="vehicle_category" class="col-md-6 top15">
          <span class="badge-label p-2">Category <span class="redstar">*</span></span>
          <!-- <select name="category" id="vehicle_categories_list" required="" class="form-control select2">
            <?php
              $vehicle_make = $result_data['make'];
              $vehicle_model = $result_data['model'];
              $edit_vehicle_category_val = $result_data['category'];
              get_vehicle_categories_list($vehicle_make, $vehicle_model, $edit_vehicle_category_val);
            ?>
          </select> -->
          <select name="category" id="category" required="" class="form-control select2">
            <?php
              $vehicle_type = $result_data['vehicle_type'];
              $edit_vehicle_category_val = $result_data['category'];
              get_vehicle_cat_list($vehicle_type, $edit_vehicle_category_val);
            ?>
          </select>
        </div>

        <div id="vehicle_make" class="col-md-6 top15">
          <span class="badge-label p-2">Make <span class="redstar">*</span></span>
          <!-- <select name="make" id="vehicle_makes_list" required="" class="form-control select2">
            <option value="">Select Vehicle Make</option>
            <?php
              $edit_vehicle_make_val = $result_data['make'];
              get_vehicle_makes_list($edit_vehicle_make_val);
            ?>
          </select> -->
          <input name="make" id="make" required="" class="form-control" placeholder="Vehicle Make" type="text" value="<?= $result_data['make']; ?>"/>
        </div>

        <div id="vehicle_model" class="col-md-6 top15">
          <span class="badge-label p-2">Model <span class="redstar">*</span></span>
          <!-- <select name="model" id="vehicle_models_list" required="" class="form-control select2">
            <?php
              $vehicle_make = $result_data['make'];
              $edit_vehicle_model_val = $result_data['model'];
              get_vehicle_models_list($vehicle_make, $edit_vehicle_model_val);
            ?>
          </select> -->
          <input name="model" id="model" required="" class="form-control" placeholder="Vehicle Model" type="text" value="<?= $result_data['model']; ?>"/>
        </div>

        <div id="vehicle_make_and_model" class="col-md-12 top15">
          <span class="badge-label p-2">Make & Model <span class="redstar">*</span></span>
          <select id="make_and_model" class="form-control select2">
            <option value="">Select Vehicle Make & Model</option>
            <?php
              $vehicle_category = $result_data['category'];
              $edit_vehicle_make_and_model_val = $result_data['make'].' - '.$result_data['model'];
              get_vehicle_make_and_model_list($vehicle_category, $edit_vehicle_make_and_model_val);
            ?>
          </select>
        </div>

        <div class="col-md-6 top15">
          <span class="badge-label p-2">Vehicle No <span class="redstar">*</span></span>
          <input name="vehicle_no" id="vehicle_no" required="" class="form-control" placeholder="Vehicle No" type="text" value="<?= $result_data['vehicle_no']; ?>"/>
        </div>

        <!-- <div class="col-md-6 top15">
          <span class="badge-label p-2">Fuel Type <span class="redstar">*</span></span>
          <select name="fuel_type" id="fuel_type" required="" class="form-control">
            <option value="">Select Fuel Type</option>
            <?php
              $edit_vehicle_fuel_type_val = $result_data['fuel_type'];
              get_vehicle_fuel_types_list($edit_vehicle_fuel_type_val);
            ?>
          </select>
        </div> -->

        <input name="fuel_type" class="form-control" type="hidden" value="<?= $result_data['fuel_type']; ?>"/>

        <div class="col-md-6 top15">
          <span class="badge-label p-2">Vehicle Color <span class="redstar">*</span></span>
          <input name="color" id="color" required="" class="form-control" placeholder="Vehicle Color" type="text" value="<?= $result_data['color']; ?>"/>
        </div>

        <div class="col-md-6 top15">
          <span class="badge-label p-2">Apartment Name <span class="redstar">*</span></span>
          <select name="apartment_name" id="apartment_name" required="" class="form-control">
            <option value="">Select Apartment Name</option>
            <?php
              //$edit_customer_apartment_name_val = $result_data['apartment_name'];
              //get_customer_apartment_names_list($edit_customer_apartment_name_val);
            ?>

            <?php
              $edit_customer_apartment_name_val = $result_data['apartment_name'];
              get_apartment_names_list($edit_customer_apartment_name_val);
            ?>
          </select>
        </div>

        <div class="col-md-6 top15">
          <span class="badge-label p-2">Parking Lot No <span class="redstar">*</span></span>
          <input name="parking_lot_no" id="parking_lot_no" required="" class="form-control" placeholder="Parking Lot No" type="text" value="<?= $result_data['parking_lot_no']; ?>"/>
        </div>

        <div class="col-md-6 top15">
          <span class="badge-label p-2">Parking Area <span class="redstar">*</span></span>
          <select name="parking_area" id="parking_area" required="" class="form-control">
            <option value="">Select Parking Area</option>
            <?php
              $edit_vehicle_parking_area_val = $result_data['parking_area'];
              get_vehicle_parking_areas_list($edit_vehicle_parking_area_val);
            ?>
          </select>
        </div>

        <div class="col-md-6 top15">
          <span class="badge-label p-2">Preferred Schedule <span class="redstar">*</span></span>
          <select name="preferred_schedule" id="preferred_schedule" required="" class="form-control">
            <option value="">Select Preferred Schedule</option>
            <?php
              $edit_vehicle_preferred_schedule_val = $result_data['preferred_schedule'];
              get_vehicle_preferred_schedules_list($edit_vehicle_preferred_schedule_val);
            ?>
          </select>
        </div>

        <div class="col-md-6 top15">
          <span class="badge-label p-2">Preferred Time <span class="redstar">*</span></span>
          <select name="preferred_time" id="preferred_time" required="" class="form-control select2">
            <option value="">Select Preferred Time</option>
            <?php
              $preferred_schedule = $result_data['preferred_schedule'];
              $edit_vehicle_preferred_time_val = $result_data['preferred_time'];
              get_vehicle_preferred_times_list($preferred_schedule, $edit_vehicle_preferred_time_val);
            ?>
          </select>
        </div>

        <input type="hidden" name="vehicle_id" class="form-control mb-30" value="<?= $result_data['vehicle_id']; ?>">
        <input type="hidden" name="customer_id" class="form-control mb-30" value="<?= $result_data['customer_id']; ?>">
        
        <div class="clearfix"></div>
			  <?php
      }

      break;
		}

    case 'get_vehicle_category_data': {

      if( isset($_POST['vehicle_type']) && !empty($_POST['vehicle_type']) )
      {
        $vehicle_type = $_POST['vehicle_type'];
        
        get_vehicle_cat_list($vehicle_type);
      }
      
      break;  
    }

    case 'get_vehicle_make_and_model_data': {

      if( isset($_POST['category']) && !empty($_POST['category']) )
      {
        $vehicle_category = $_POST['category'];
        
        get_vehicle_make_and_model_list($vehicle_category);
      }
      
      break;  
    }

    case 'get_vehicle_models_data': {

      if( isset($_POST['vehicle_make']) && !empty($_POST['vehicle_make']) )
      {
        $vehicle_make = $_POST['vehicle_make'];
        
        get_vehicle_models_list($vehicle_make);
      }
      
      break;  
    }

    case 'get_vehicle_categories_data': {

      if( isset($_POST['vehicle_make']) && !empty($_POST['vehicle_make']) && isset($_POST['vehicle_model']) && !empty($_POST['vehicle_model']) )
      {
        $vehicle_make = $_POST['vehicle_make'];
        $vehicle_model = $_POST['vehicle_model'];

        get_vehicle_categories_list($vehicle_make,$vehicle_model);
      }
      
      break;  
    }

    case 'get_vehicle_preferred_schedule_times_data': {

      if( isset($_POST['preferred_schedule']) && !empty($_POST['preferred_schedule']) )
      {
        $preferred_schedule = $_POST['preferred_schedule'];

        get_vehicle_preferred_times_list($preferred_schedule);
      }
      
      break;  
    }

		case "delete_vehicle_details":{

      if( isset($_POST['ID']) && !empty($_POST['ID']) && isset($_POST['table_name']) && !empty($_POST['table_name']) )
      {
  			$vehicle_id = $_POST['ID'];
        $table_name = $_POST['table_name'];

  			$result = $db->delete($table_name, "where vehicle_id='".$vehicle_id."'");

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

    case "get_customers_names_data":{

      if( isset($_POST['apartment_name']) && !empty($_POST['apartment_name']) )
      {
        $apartment_name = $_POST['apartment_name'];

        //Get vehicles details from database
        $customer_vehicles_data = $db->getRows("select distinct(customer_id) from customer_vehicles where apartment_name='".$apartment_name."' and assign_status=0 order by id asc");

        if( count($customer_vehicles_data) > 0 )
        {
          ?>
          <option value="" hidden="">Select Customer</option>
          <?php
          
          foreach( $customer_vehicles_data as $customer_vehicle_data_list )
          {
            $customer_id = $customer_vehicle_data_list['customer_id'];
            $customer_name = $db->getVal("select name from customers where customer_id='".$customer_id."'");
            ?>
              <option value="<?= $customer_vehicle_data_list['customer_id']; ?>"><?= $customer_name; ?> (<?= $customer_vehicle_data_list['customer_id']; ?>)</option>
            <?php
          }
        }
      }

      break;
    }

    case "get_vehicles_names_data":{

      if( isset($_POST['apartment_name']) && !empty($_POST['apartment_name']) && isset($_POST['customer_id']) && !empty($_POST['customer_id']) )
      {
        $apartment_name = $_POST['apartment_name'];
        $customer_id = $_POST['customer_id'];

        //Get vehicles details from database
        $customer_vehicles_data = $db->getRows("select * from customer_vehicles where apartment_name='".$apartment_name."' and customer_id='".$customer_id."' and assign_status=0 order by id asc");

        if( count($customer_vehicles_data) > 0 )
        {
          foreach( $customer_vehicles_data as $customer_vehicle_data_list )
          {
            /*$vehicle_name = vehicle_make_to_ucwords($customer_vehicle_data_list['make']);*/
            $vehicle_name = $customer_vehicle_data_list['make'];
            ?>
              <option value="<?= $customer_vehicle_data_list['vehicle_id']; ?>"><?= $vehicle_name; ?> (<?= $customer_vehicle_data_list['vehicle_no']; ?>)</option>
            <?php
          }
        }
      }

      break;
    }

    case "delete_all_assigned_vehicles":{

      if( isset($_POST['ID']) && !empty($_POST['ID']) && isset($_POST['table_name']) && !empty($_POST['table_name']) )
      {
        $employee_id = $_POST['ID'];
        $table_name = $_POST['table_name'];

        $assign_vehicles_result_data = $db->getRows("select * from assign_vehicles where employee_id='".$employee_id."'");

        if( count($assign_vehicles_result_data) > 0 )
        {
          foreach( $assign_vehicles_result_data as $assign_vehicle_data_list )
          {
            $vehicle_id = $assign_vehicle_data_list['vehicle_id'];

            /*Update customer vehicles data*/
            $update_customer_vehicles_data = $db->update("update customer_vehicles set assign_status=0 where vehicle_id='".$vehicle_id."'");
          }
        }

        $result = $db->delete($table_name, "where employee_id='".$employee_id."'");

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

    case "delete_single_assigned_vehicle":{

      if( isset($_POST['ID']) && !empty($_POST['ID']) && isset($_POST['table_name']) && !empty($_POST['table_name']) )
      {
        $assign_vehicle_id = $_POST['ID'];
        $table_name = $_POST['table_name'];

        
        $assign_vehicle_result_data = $db->getRow("select * from assign_vehicles where assign_vehicle_id='".$assign_vehicle_id."'");

        if( count($assign_vehicle_result_data) > 0 )
        {
          $vehicle_id = $assign_vehicle_result_data['vehicle_id'];
          
          /*Update customer vehicle data*/
          $update_customer_vehicle_data = $db->update("update customer_vehicles set assign_status=0 where vehicle_id='".$vehicle_id."'");
        }

        $result = $db->delete($table_name, "where assign_vehicle_id='".$assign_vehicle_id."'");

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

    case "submit_customer_vehicles_wash_data":{

      if( isset($_POST['employee_id']) && !empty($_POST['employee_id']) && isset($_POST['vehicle_id']) && !empty($_POST['vehicle_id']) && isset($_POST['wash_status']) && !empty($_POST['wash_status']) && isset($_POST['vehicle_wash_submit_date']) && !empty($_POST['vehicle_wash_submit_date']) )
      {
        $employee_id = $_POST['employee_id'];
        $vehicle_id = $_POST['vehicle_id'];
        $wash_status = $_POST['wash_status'];
        $note = $_POST['note'];
        $vehicle_wash_submit_date = $_POST['vehicle_wash_submit_date'];
        $vehicle_wash_id = $_POST['vehicle_wash_id'];

        $vehicle_wash_id_found = 'no';

        if( empty($vehicle_wash_id) )
        {
          $get_id_val = $db->getVal("select Max(Cast(substring(vehicle_wash_id,3,100) AS SIGNED)) from customer_vehicles_wash_details");

          if( !is_null($get_id_val) )
          {
            $vehicle_wash_id = $get_id_val + 1;
          }
          else
          {
            $vehicle_wash_id = "100001";
          }

          $vehicle_wash_id = "VW".$vehicle_wash_id;
        }
        else
        {
          $vehicle_wash_id = $vehicle_wash_id;
          $vehicle_wash_id_found = 'yes';
        }
        
        if( $vehicle_wash_id_found == 'yes' )
        {
          if( isset($_FILES['vehicle_image']['name']) && !empty($_FILES['vehicle_image']['name']) )
          {
            /*Get vehicle image name*/
            $get_vehicle_image_name = $db->getVal("select vehicle_image from customer_vehicles_wash_details where vehicle_wash_id='".$vehicle_wash_id."'");

            if( !empty($get_vehicle_image_name) )
            {
              $delete_file_path = '../images/assigned-vehicles/'.$get_vehicle_image_name;
              unlink_uploaded_old_single_file($delete_file_path);
            }
            
            $file_uploaded_result = upload_new_single_file('vehicle_image', '../images/assigned-vehicles/', '', 'yes');

            if( $file_uploaded_result['file_upload_status'] == 'uploaded' )
            {
              $vehicle_image_name = $file_uploaded_result['new_file_name'];
            }
            else
            {
              $vehicle_image_name = '';
            }
          }
          else
          {
            $vehicle_image_name = '';
          }

          if( !empty($vehicle_image_name) )
          {
            /*Get vehicle image name*/
            $get_vehicle_img_name = $db->getVal("select vehicle_image from customer_vehicles_wash_details where vehicle_wash_id='".$vehicle_wash_id."'");

            if( !empty($get_vehicle_img_name) )
            {
              $vehicle_image_updateandtime_field_name = 'vehicle_image_updateandtime';
            }
            else
            {
              $vehicle_image_updateandtime_field_name = 'vehicle_image_dateandtime';
            }
            
            $update_array = array(
              'wash_status' => $wash_status,
              'note' => trim($note),
              'vehicle_image' => $vehicle_image_name,
              $vehicle_image_updateandtime_field_name => date('Y-m-d H:i:s'),
              'updateandtime' => date('Y-m-d H:i:s')
            );
          }
          else
          {
            $update_array = array(
              'wash_status' => $wash_status,
              'note' => trim($note),
              'updateandtime' => date('Y-m-d H:i:s')
            );
          }

          $action_result = $db->updateAry('customer_vehicles_wash_details', $update_array, "where vehicle_wash_id='".$vehicle_wash_id."'");
          
          $data_message_action_name = 'updated';
        }
        else
        {
          if( isset($_FILES['vehicle_image']['name']) && !empty($_FILES['vehicle_image']['name']) )
          {
            $file_uploaded_result = upload_new_single_file('vehicle_image', '../images/assigned-vehicles/', '', 'yes');

            if( $file_uploaded_result['file_upload_status'] == 'uploaded' )
            {
              $vehicle_image_name = $file_uploaded_result['new_file_name'];
              $vehicle_image_dateandtime = date('Y-m-d H:i:s');
            }
            else
            {
              $vehicle_image_name = '';
              $vehicle_image_dateandtime = '0000-00-00 00:00:00';
            }
          }
          else
          {
            $vehicle_image_name = '';
            $vehicle_image_dateandtime = '0000-00-00 00:00:00';
          }

          $insert_array = array(
            'vehicle_wash_id' => $vehicle_wash_id,
            'employee_id' => $employee_id,          
            'vehicle_id' => $vehicle_id,
            'wash_status' => $wash_status,
            'note' => trim($note),
            'vehicle_image' => $vehicle_image_name,
            'vehicle_image_dateandtime' => $vehicle_image_dateandtime,
            'dateandtime' => date('Y-m-d H:i:s', strtotime($vehicle_wash_submit_date))
          );

          $action_result = $db->insertAry('customer_vehicles_wash_details', $insert_array);

          $data_message_action_name = 'added';
        }

        if( !is_null($action_result) && !empty($action_result) )
        {
          $data_message = "Customer vehicle wash details $data_message_action_name successfully";

          echo json_encode( array('message'=>'success','result'=>$data_message) );
          exit;
        }
        else
        {
          $data_message = "Customer vehicle wash details is not $data_message_action_name successfully. Please try again";

          echo json_encode( array('message'=>'error','result'=>$data_message) );
          exit;
        }
      }
      
      break;
    }

    case "delete_employee":{

      if( isset($_POST['ID']) && !empty($_POST['ID']) && isset($_POST['table_name']) && !empty($_POST['table_name']) )
      {
        $employee_id = $_POST['ID'];
        $table_name = $_POST['table_name'];

        $result = $db->delete($table_name, "where employee_id='".$employee_id."'");

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


    case "delete_make_model":{

      if( isset($_POST['ID']) && !empty($_POST['ID']) && isset($_POST['table_name']) && !empty($_POST['table_name']) )
      {
        $employee_id = $_POST['ID'];
        $table_name = $_POST['table_name'];

        $result = $db->delete($table_name, "where id='".$employee_id."'");

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

      case "delete_with_id":{

      if( isset($_POST['ID']) && !empty($_POST['ID']) && isset($_POST['table_name']) && !empty($_POST['table_name']) )
      {
        $id = $_POST['ID'];
        $table_name = $_POST['table_name'];

        $result = $db->delete($table_name, "where id='".$id."'");

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

    case "edit_customer_vehicle_wash_details":{

      if( isset($_POST['ID']) && !empty($_POST['ID']) )
      {
        $vehicle_wash_id = $_POST['ID'];

        $result_data = $db->getRow("select * from customer_vehicles_wash_details where vehicle_wash_id='".$vehicle_wash_id."'");
        ?>
        <div class="col-md-12 top15">
          <span class="badge-label p-2">Wash Status <span class="redstar">*</span></span>
          <select name="wash_status" id="wash_status" required="" class="form-control">
            <?php
              $wash_status = $result_data['wash_status'];

              if( $wash_status == 'Yes' )
              {
                $selected = 'selected';
              }
              else
              {
                $selected = '';
              }
            ?>
            <option value="No">No</option>
            <option value="Yes" <?= $selected; ?>>Yes</option>
          </select>
        </div>

        <div class="col-md-12 top15">
          <span class="badge-label p-2">Note <span class="redstar">*</span></span>
          <textarea name="note" id="note" class="form-control mb-30" maxlength="255" required=""><?= $result_data['note']; ?></textarea>
        </div>

        <div class="col-md-12 top15">
          <span class="badge-label p-2">Vehicles Image</span><br/>
          <img src="../images/assigned-vehicles/<?= $result_data['vehicle_image']; ?>" width="175" height="135">
          <input type="file" name="vehicle_image" id="vehicle_image" class="form-control mb-30">
        </div>

        <input type="hidden" name="employee_id" class="form-control mb-30" value="<?= $result_data['employee_id']; ?>">
        <input type="hidden" name="vehicle_id" class="form-control mb-30" value="<?= $result_data['vehicle_id']; ?>">
        <input type="hidden" name="vehicle_wash_id" class="form-control mb-30" value="<?= $result_data['vehicle_wash_id']; ?>">
        
        <div class="clearfix"></div>
        <?php
      }

      break;
    }

    case "delete_customer_vehicle_wash_details":{

      if( isset($_POST['ID']) && !empty($_POST['ID']) && isset($_POST['table_name']) && !empty($_POST['table_name']) )
      {
        $vehicle_wash_id = $_POST['ID'];
        $table_name = $_POST['table_name'];

        $result = $db->delete($table_name, "where vehicle_wash_id='".$vehicle_wash_id."'");

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

    case "delete_contact_us":{

      if( isset($_POST['ID']) && !empty($_POST['ID']) && isset($_POST['table_name']) && !empty($_POST['table_name']) )
      {
        $contact_us_id = $_POST['ID'];
        $table_name = $_POST['table_name'];

        $result = $db->delete($table_name, "where contact_us_id='".$contact_us_id."'");

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

    case "delete_car_machine_polish":{

      if( isset($_POST['ID']) && !empty($_POST['ID']) && isset($_POST['table_name']) && !empty($_POST['table_name']) )
      {
        $car_machine_polish_id = $_POST['ID'];
        $table_name = $_POST['table_name'];

        $result = $db->delete($table_name, "where car_machine_polish_id='".$car_machine_polish_id."'");

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

    case "delete_car_insurance":{

      if( isset($_POST['ID']) && !empty($_POST['ID']) && isset($_POST['table_name']) && !empty($_POST['table_name']) )
      {
        $car_insurance_id = $_POST['ID'];
        $table_name = $_POST['table_name'];

        $result = $db->delete($table_name, "where car_insurance_id='".$car_insurance_id."'");

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

    case "delete_help_and_support":{

      if( isset($_POST['ID']) && !empty($_POST['ID']) && isset($_POST['table_name']) && !empty($_POST['table_name']) )
      {
        $id = $_POST['ID'];
        $table_name = $_POST['table_name'];

        $result = $db->delete($table_name, "where id='".$id."'");

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

    case "edit_page_seo_content_details":{

      if( isset($_POST['ID']) && !empty($_POST['ID']) )
      {
        $page_seo_id = $_POST['ID'];

        $result_data = $db->getRow("select * from page_seo_contents where page_seo_id='".$page_seo_id."'");
        ?>
        <div class="col-md-12 top15">
          <span class="badge-label p-2">Page Name <span class="redstar">*</span></span>
          <input type="text" name="page_name" class="form-control mb-30" placeholder="Note: Name should be same with case sensitive (Ex: about-us)" value="<?= $result_data['page_name']; ?>" required="">
        </div>

        <div class="col-md-12 top15">
          <span class="badge-label p-2">Meta Title <span class="redstar">*</span></span>
          <textarea name="meta_title" class="form-control mb-30" placeholder="Note : Character Length 55 to 90" maxlength="90" required=""><?= $result_data['meta_title']; ?></textarea>
        </div>

        <div class="col-md-12 top15">
          <span class="badge-label p-2">Meta Description <span class="redstar">*</span></span>
          <textarea name="meta_description" class="form-control mb-30" placeholder="Note : Character Length 150 to 220" maxlength="220" required=""><?= $result_data['meta_description']; ?></textarea>
        </div>

        <div class="col-md-12 top15">
          <span class="badge-label p-2">Meta Keywords <span class="redstar">*</span></span>
          <textarea name="meta_keywords" class="form-control mb-30" placeholder="Note : Maximum 30 Keywords ( Separate by comma ' , ' )" maxlength="255" required=""><?= $result_data['meta_keywords']; ?></textarea>
        </div>

        <input type="hidden" name="page_seo_id" class="form-control mb-30" value="<?= $result_data['page_seo_id']; ?>">
        
        <div class="clearfix"></div>
        <?php
      }

      break;
    }

    case "delete_page_seo_content_details":{

      if( isset($_POST['ID']) && !empty($_POST['ID']) && isset($_POST['table_name']) && !empty($_POST['table_name']) )
      {
        $page_seo_id = $_POST['ID'];
        $table_name = $_POST['table_name'];

        $result = $db->delete($table_name, "where page_seo_id='".$page_seo_id."'");

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

    case "submit_order_details_filter_values":{

      if( isset($_POST['from_date']) && !empty($_POST['from_date']) && isset($_POST['to_date']) && !empty($_POST['to_date']) )
      {
        $from_date = $_POST['from_date'];
        $to_date = $_POST['to_date'];

        //Get data from database
        $filter_query = "(date(dateandtime) >='".$from_date."' and date(dateandtime) <='".$to_date."')";

        if( isset($_POST['get_filter_query_data']) && !empty($_POST['get_filter_query_data']) )
        {
          $orders_query = "select date(dateandtime) as date_and_time, count(order_id) as no_of_orders, paid_count,payment_type,sum(total_amount) as tot_amt from my_orders where ".$filter_query." and status!='Cancel Requested' and status!='Cancelled' and status!='Refunded' group by date(dateandtime)  UNION select date(dateandtime) as date_and_time, count(order_id) as no_of_orders, Null as paid_count, payment_type,sum(total_amount) as tot_amt from one_time_pay_my_orders where ".$filter_query." group by date(dateandtime) order by date_and_time desc";

          echo json_encode( array('message'=>'success','orders_query'=>$orders_query) );
          exit;
        }
        else
        {
          $result_data = $db->getRows("select date(dateandtime) as date_and_time, count(order_id) as no_of_orders, paid_count,payment_type,sum(total_amount) as tot_amt from my_orders where ".$filter_query." and status!='Cancel Requested' and status!='Cancelled' and status!='Refunded' group by date(dateandtime)  UNION select date(dateandtime) as date_and_time, count(order_id) as no_of_orders, Null as paid_count, payment_type,sum(total_amount) as tot_amt from one_time_pay_my_orders where ".$filter_query." group by date(dateandtime) order by date_and_time desc");

          if( count($result_data) > 0 )
          {
             foreach( $result_data as $data_list )
                            {
                              $ordered_date = date('d-m-Y', strtotime($data_list['date_and_time']));
                              $no_of_orders = $data_list['no_of_orders'];
                              $total_amount = $data_list['tot_amt'];
                              $paid_count = $data_list['paid_count'];
                              $payment_type = $data_list['payment_type'];

                            ?>
                              <tr class="odd gradeX">
                                <td data-sort="<?= date('Ymd', strtotime($data_list['date_and_time'])) ?>"><?= $ordered_date; ?></td>
                                <td><?= $no_of_orders; ?></td>
                                <td><?= $payment_type; ?></td>
                                <td><?= $paid_count; ?></td>                                
                                <td><?= $total_amount; ?></td>
                              </tr>
                            <?php
                            }
          }
        }
        // echo $db->getLastquery();
      }

      break;
    }

    case "submit_order_details_advanced_filter_values":{

      $advanced_filter_query = "1=1";$advanced_filter_query1 = "1=1";

      if( isset($_POST['from_date']) && !empty($_POST['from_date']) && isset($_POST['to_date']) && !empty($_POST['to_date']) )
      {
        $from_date = $_POST['from_date'];
        $to_date = $_POST['to_date'];

        $advanced_filter_query.= " and (date(dateandtime)>='".$from_date."' and date(dateandtime)<='".$to_date."')";


         $advanced_filter_query1.= " and (date(dateandtime)>='".$from_date."' and date(dateandtime)<='".$to_date."')";
      }

      if( isset($_POST['customer_id']) && !empty($_POST['customer_id']) )
      {
        $customer_id = $_POST['customer_id'];

        $advanced_filter_query.= " and customer_id='".$customer_id."'";
        $advanced_filter_query1.= " and customer_id='".$customer_id."'";

      }

      if( isset($_POST['plan_amount']) && !empty($_POST['plan_amount']) )
      {
        $plan_amount = $_POST['plan_amount'];

        $advanced_filter_query.= " and plan_amount='".$plan_amount."'";
        $advanced_filter_query1.= " and total_amount='".$plan_amount."'";

      }

      if( isset($_POST['status']) && !empty($_POST['status']) )
      {
        $status = $_POST['status'];

        $advanced_filter_query.= " and status='".$status."'";
        $advanced_filter_query1.= " and package_type='".$status."'";

      }

      if( isset($_POST['get_advanced_filter_query_data']) && !empty($_POST['get_advanced_filter_query_data']) )
      {
        $orders_query = "select date(dateandtime) as date_and_time,order_id,customer_id,vehicle_id,plan_amount,total_amount,status,no_of_count from my_orders where ".$advanced_filter_query." union select date(dateandtime) as date_and_time,order_id,customer_id,vehicle_id,Null as plan_amount,total_amount,payment_type as status,Null as no_of_count from one_time_pay_my_orders where ".$advanced_filter_query1." order by date_and_time desc";

        echo json_encode( array('message'=>'success','orders_query'=>$orders_query) );
        exit;
      }
      else
      {
        $result_data = $db->getRows("select date(dateandtime) as date_and_time,order_id,customer_id,vehicle_id,plan_amount,total_amount,status from my_orders where ".$advanced_filter_query." union select date(dateandtime) as date_and_time,order_id,customer_id,vehicle_id,Null as plan_amount,total_amount,payment_type as status from one_time_pay_my_orders where ".$advanced_filter_query1." order by date_and_time desc");

        if( count($result_data) > 0 )
        {
          foreach( $result_data as $data_list )
          {
            $dts =$data_list['date_and_time'];
            $ordered_date = date('d-m-Y', strtotime($dts));
            $order_id = $data_list['order_id'];
            $customer_id = $data_list['customer_id'];
            $vehicle_id = $data_list['vehicle_id'];
            $plan_amount = $data_list['plan_amount'];
            $total_amount = $data_list['total_amount'];
            $status = $data_list['status'];
            if(empty($no_of_count) || $no_of_count ==''){
                $no_of_count=0;
            }
            $valid = date('d-m-Y', strtotime("$dts+$no_of_count month"));
            $sortvalid = date('Ymd', strtotime("$dts+$no_of_count month"));
          ?>
            <tr class="odd gradeX">
              <td data-sort="<?= date('Ymd', strtotime($data_list['date_and_time'])) ?>"><?= $ordered_date; ?></td>
              <td data-sort="<?= $dts ?>"><?= $order_id; ?></td>
              <td><?= $customer_id; ?></td>
              <td><?= $vehicle_id; ?></td>
              <td><?= $plan_amount; ?></td>
              <td><?= $total_amount; ?></td>
              <td data-order="<?= $sortvalid ?>"><?= $valid; ?></td>
              <td><?= $status; ?></td>
            </tr>
          <?php
          }
        }
      }

      break;
    }

    case 'submit_internal_clean_schedule_data': {

      if( isset($_POST['ID']) && !empty($_POST['ID']) && isset($_POST['order_id']) && !empty($_POST['order_id']) && isset($_POST['customer_id']) && !empty($_POST['customer_id']) && isset($_POST['vehicle_id']) && !empty($_POST['vehicle_id']) )
      {
        $ID = $_POST['ID'];
        $order_id = $_POST['order_id'];
        $customer_id = $_POST['customer_id'];
        $vehicle_id = $_POST['vehicle_id'];

        $schedule_date = '';
        $schedule_time = '';
        $schedule_work_status = '';
        $note = '';
        $vehicle_image_name = '';

        $schedule_date_field_name = '';
        $schedule_time_field_name = '';
        $schedule_work_status_field_name = '';
        $note_field_name = '';
        $vehicle_image_field_name = '';
        
        if( isset($_POST['schedule_work_status1']) )
        {
          $schedule_work_status = $_POST['schedule_work_status1'];

          $schedule_work_status_field_name = 'schedule_work_status1';
        }

        if( isset($_POST['schedule_work_status2']) )
        {
          $schedule_work_status = $_POST['schedule_work_status2'];

          $schedule_work_status_field_name = 'schedule_work_status2';
        }

        if( isset($_POST['note1']) )
        {
          $note = $_POST['note1'];

          $note_field_name = 'note1';
        }

        if( isset($_POST['note2']) )
        {
          $note = $_POST['note2'];

          $note_field_name = 'note2';
        }

        if( isset($_FILES['vehicle_image1']) )
        {
          $vehicle_image_field_name = 'vehicle_image1';
        }

        if( isset($_FILES['vehicle_image2']) )
        {
          $vehicle_image_field_name = 'vehicle_image2';
        }

        $schedule_date_found = 'no';

        if( isset($_POST['schedule_date1']) && !empty($_POST['schedule_date1']) && ($_POST['schedule_date1'] != 'undefined') && isset($_POST['schedule_time1']) && !empty($_POST['schedule_time1']) && ($_POST['schedule_time1'] != 'undefined') )
        {
          $schedule_date_found = 'yes';

          $schedule_date = date('Y-m-d', strtotime($_POST['schedule_date1']));
          $schedule_time = $_POST['schedule_time1'];

          $schedule_date_field_name = 'schedule_date1';
          $schedule_time_field_name = 'schedule_time1';
        }

        if( isset($_POST['schedule_date2']) && !empty($_POST['schedule_date2']) && ($_POST['schedule_date2'] != 'undefined') && isset($_POST['schedule_time2']) && !empty($_POST['schedule_time2']) && ($_POST['schedule_time2'] != 'undefined') )
        {
          $schedule_date_found = 'yes';

          $schedule_date = date('Y-m-d', strtotime($_POST['schedule_date2']));
          $schedule_time = $_POST['schedule_time2'];

          $schedule_date_field_name = 'schedule_date2';
          $schedule_time_field_name = 'schedule_time2';
        }

        if( $schedule_date_found == 'yes' )
        {
          $today_date = date('Y-m-d');

          /*Get next due data*/
          $next_due = $db->getVal("select next_due from customer_vehicles_internal_clean_details where id='".$ID."' and order_id='".$order_id."' and customer_id='".$customer_id."' and vehicle_id='".$vehicle_id."'");

          $next_due_date = date('Y-m-d', strtotime($next_due));

          if( strtotime($schedule_date) > strtotime($today_date) && strtotime($schedule_date) < strtotime($next_due_date) )
          {
            
          }
          else
          {
            $Today_Date = date('d-m-Y', strtotime($today_date));
            $Next_Due_Date = date('d-m-Y', strtotime($next_due_date));

            $data_message = "You can choose preferred date only between ".$Today_Date." and ".$Next_Due_Date;

            echo json_encode( array('message'=>'error','result'=>$data_message) );
            exit;
          }
        }
              
        if( isset($_FILES[$vehicle_image_field_name]['name']) && !empty($_FILES[$vehicle_image_field_name]['name']) )
        {
          /*Get vehicle image name*/
          $get_vehicle_image_name = $db->getVal("select $vehicle_image_field_name from customer_vehicles_internal_clean_details where id='".$ID."' and order_id='".$order_id."' and customer_id='".$customer_id."' and vehicle_id='".$vehicle_id."'");

          if( !empty($get_vehicle_image_name) )
          {
            $delete_file_path = '../images/page-content/my-order-details/internal-clean/'.$get_vehicle_image_name;
            unlink_uploaded_old_single_file($delete_file_path);
          }

          $file_uploaded_result = upload_new_single_file($vehicle_image_field_name, '../images/page-content/my-order-details/internal-clean/', '', 'yes');

          if( $file_uploaded_result['file_upload_status'] == 'uploaded' )
          {
            $vehicle_image_name = $file_uploaded_result['new_file_name'];
          }
          else
          {
            $vehicle_image_name = '';
          }
        }
        else
        {
          $vehicle_image_name = '';
        }

        if( !empty($vehicle_image_name) )
        {
          /*Get vehicle image name*/
          $get_vehicle_img_name = $db->getVal("select $vehicle_image_field_name from customer_vehicles_internal_clean_details where id='".$ID."' and order_id='".$order_id."' and customer_id='".$customer_id."' and vehicle_id='".$vehicle_id."'");

          if( !empty($get_vehicle_img_name) )
          {
            $vehicle_image_updateandtime_field_name = $vehicle_image_field_name.'_updateandtime';
          }
          else
          {
            $vehicle_image_updateandtime_field_name = $vehicle_image_field_name.'_dateandtime';
          }

          if( $schedule_date_found == 'yes' )
          {
            $update_array = array(
              $schedule_date_field_name => $schedule_date,
              $schedule_time_field_name => $schedule_time,
              $schedule_work_status_field_name => $schedule_work_status,
              $note_field_name => trim($note),
              $vehicle_image_field_name => $vehicle_image_name,
              $vehicle_image_updateandtime_field_name => date('Y-m-d H:i:s'),
              'updateandtime' => date('Y-m-d H:i:s')
            );
          }
          else
          {
            $update_array = array(
              $schedule_work_status_field_name => $schedule_work_status,
              $note_field_name => trim($note),
              $vehicle_image_field_name => $vehicle_image_name,
              $vehicle_image_updateandtime_field_name => date('Y-m-d H:i:s'),
              'updateandtime' => date('Y-m-d H:i:s')
            );
          }
        }
        else
        {
          if( $schedule_date_found == 'yes' )
          {
            $update_array = array(
              $schedule_date_field_name => $schedule_date,
              $schedule_time_field_name => $schedule_time,
              $schedule_work_status_field_name => $schedule_work_status,
              $note_field_name => trim($note),
              'updateandtime' => date('Y-m-d H:i:s')
            );
          }
          else
          {
            $update_array = array(
              $schedule_work_status_field_name => $schedule_work_status,
              $note_field_name => trim($note),
              'updateandtime' => date('Y-m-d H:i:s')
            );
          }
        }

        $update_result = $db->updateAry('customer_vehicles_internal_clean_details', $update_array, "where id='".$ID."' and order_id='".$order_id."' and customer_id='".$customer_id."' and vehicle_id='".$vehicle_id."'");

        if( !is_null($update_result) )
        {
          $data_message = "Internal clean details updated successfully";

          echo json_encode( array('message'=>'success','result'=>$data_message) );
          exit;
        }
        else
        {
          $data_message = "Internal clean details is not updated successfully. Please try again";

          echo json_encode( array('message'=>'error','result'=>$data_message) );
          exit;
        }
      }
      
      break;  
    }

    case 'submit_extra_interior_schedule_data': {

      if( isset($_POST['order_id']) && !empty($_POST['order_id']) && isset($_POST['customer_id']) && !empty($_POST['customer_id']) && isset($_POST['vehicle_id']) && !empty($_POST['vehicle_id']) && isset($_POST['schedule_work_status']) && !empty($_POST['schedule_work_status']) )
      {
        $order_id = $_POST['order_id'];
        $customer_id = $_POST['customer_id'];
        $vehicle_id = $_POST['vehicle_id'];
        $schedule_work_status = $_POST['schedule_work_status'];
        $note = $_POST['note'];
        $schedule_time = $_POST['schedule_time'];
        $schedule_date_found = 'no';

        if( isset($_POST['schedule_date']) && !empty($_POST['schedule_date']) && ($_POST['schedule_date'] != 'undefined') )
        {
          $schedule_date_found = 'yes';

          $schedule_date = date('Y-m-d H:i:s', strtotime($_POST['schedule_date']));
          
          $check_schedule_date = date('Y-m-d', strtotime($_POST['schedule_date']));
          $today_date = date('Y-m-d');

          if( strtotime($check_schedule_date) > strtotime($today_date) )
          {
            
          }
          else
          {
            $Today_Date = date('d-m-Y', strtotime($today_date));

            $data_message = "You can choose preferred date only above the ".$Today_Date;

            echo json_encode( array('message'=>'error','result'=>$data_message) );
            exit;
          }
        }
              
        if( isset($_FILES['vehicle_image']['name']) && !empty($_FILES['vehicle_image']['name']) )
        {
          /*Get vehicle image name*/
          $get_vehicle_image_name = $db->getVal("select vehicle_image from one_time_pay_my_orders where order_id='".$order_id."' and customer_id='".$customer_id."' and vehicle_id='".$vehicle_id."'");

          if( !empty($get_vehicle_image_name) )
          {
            $delete_file_path = '../images/page-content/my-order-details/extra-interior/'.$get_vehicle_image_name;
            unlink_uploaded_old_single_file($delete_file_path);
          }

          $file_uploaded_result = upload_new_single_file('vehicle_image', '../images/page-content/my-order-details/extra-interior/', '', 'yes');

          if( $file_uploaded_result['file_upload_status'] == 'uploaded' )
          {
            $vehicle_image_name = $file_uploaded_result['new_file_name'];
          }
          else
          {
            $vehicle_image_name = '';
          }
        }
        else
        {
          $vehicle_image_name = '';
        }

        if( !empty($vehicle_image_name) )
        {
          /*Get vehicle image name*/
          $get_vehicle_img_name = $db->getVal("select vehicle_image from one_time_pay_my_orders where order_id='".$order_id."' and customer_id='".$customer_id."' and vehicle_id='".$vehicle_id."'");

          if( !empty($get_vehicle_img_name) )
          {
            $vehicle_image_updateandtime_field_name = 'vehicle_image_updateandtime';
          }
          else
          {
            $vehicle_image_updateandtime_field_name = 'vehicle_image_dateandtime';
          }

          if( $schedule_date_found == 'yes' )
          {
            $update_array = array(
              'schedule_date' => $schedule_date,
              'schedule_time' => $schedule_time,              
              'schedule_work_status' => $schedule_work_status,
              'note' => trim($note),
              'vehicle_image' => $vehicle_image_name,
              $vehicle_image_updateandtime_field_name => date('Y-m-d H:i:s'),
              'updateandtime' => date('Y-m-d H:i:s')
            );
          }
          else
          {
            $update_array = array(
              'schedule_work_status' => $schedule_work_status,
              'note' => trim($note),
              'vehicle_image' => $vehicle_image_name,
              $vehicle_image_updateandtime_field_name => date('Y-m-d H:i:s'),
              'updateandtime' => date('Y-m-d H:i:s')
            );
          }
        }
        else
        {
          if( $schedule_date_found == 'yes' )
          {
            $update_array = array(
              'schedule_date' => $schedule_date,
              'schedule_time' => $schedule_time,                            
              'schedule_work_status' => $schedule_work_status,
              'note' => trim($note),
              'updateandtime' => date('Y-m-d H:i:s')
            );
          }
          else
          {
            $update_array = array(
              'schedule_work_status' => $schedule_work_status,
              'note' => trim($note),
              'updateandtime' => date('Y-m-d H:i:s')
            );
          }
        }

        $update_result = $db->updateAry('one_time_pay_my_orders', $update_array, "where order_id='".$order_id."' and customer_id='".$customer_id."' and vehicle_id='".$vehicle_id."'");

        if( !is_null($update_result) )
        {
          $data_message = "Extra interior details updated successfully";

          echo json_encode( array('message'=>'success','result'=>$data_message) );
          exit;
        }
        else
        {
          $data_message = "Extra interior details is not updated successfully. Please try again";

          echo json_encode( array('message'=>'error','result'=>$data_message) );
          exit;
        }
      }
      
      break;  
    }
	


    case "delete_internal_clean":{

      if( isset($_POST['ID']) && !empty($_POST['ID']) && isset($_POST['table_name']) && !empty($_POST['table_name']) )
      {
        $vehicle_id = $_POST['ID'];
        $table_name = $_POST['table_name'];

        $result = $db->delete($table_name, "where id='".$vehicle_id."'");

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

    case 'sendotp':{
      

      $random_no = mt_rand(10000, 99999);
          $forgot_pass_otp = base64_encode($random_no);
          $numbers = array($AdminMobileNumber);
          $message = rawurlencode("Your OTP is ".$random_no.". OTP is confidential for security reasons. Please don't share this OTP with anyone.");
          $numbers = implode(',', $numbers);
          $data = array('apikey' => $SMSapiKey, 'numbers' => $numbers, "sender" => $senderID, "message" => $message);
          $ch = curl_init('https://api.textlocal.in/send/');
          curl_setopt($ch, CURLOPT_POST, true);
          curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          $response = curl_exec($ch);
          curl_close($ch);
          $DecodeResponse = json_decode($response);
          // print_r($DecodeResponse);
          $data_message = "OTP sent";

          echo json_encode( array('message'=>'success','result'=>$data_message,'number'=>$forgot_pass_otp) );

      break;
    }


    case "viewpayments":{

      if( isset($_POST['order_id']) && !empty($_POST['order_id']) )
      {
        $order_id = $_POST['order_id'];

        $result_data = $db->getRows("select * from recurring_payment_list where order_id='".$order_id."'");
        ?>
       
        <?php if(count($result_data)){ 
          foreach($result_data as $value){ ?>        
          <tr>
            <td data-order="<?= date('YmdHi', strtotime($value['date'])) ?>"><?= date('d-m-Y h:i:s a', strtotime($value['date'])) ?></td>           
            <td><?= $value['razorpay_order_id'] ?></td>
            <td><?= $value['razorpay_payment_id'] ?></td>
            <td><?= $value['razorpay_token_id'] ?></td>   
            <td><?= $value['razorpay_customer_id'] ?></td>            
            <td><?= $value['amount'] ?></td>            
            <td><?= $value['status'] ?></td> 
          </tr>          
        <?php } } ?>
        <?php
      }
      break;
    }

  }
}