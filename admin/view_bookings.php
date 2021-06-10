<?php if(isset($_GET["booking"])){$booking_id = $_GET["booking"];}else{header('Location: index.php');}  
include 'inc-meta.php';
 if($bookings_edit==1){
//show sellerlist---------
if(isset($_POST["sellerlist_booking_id"])){
	$sellerlist_booking_id = $_POST["sellerlist_booking_id"];$booking_status="sent seller list";

	$result_data = $db->getRow("select status_track,firebase_instance_id,x.buyer_id From sp_bookings x left join sp_buyer y on x.buyer_id=y.buyer_id Where x.booking_id='$sellerlist_booking_id' Limit 1");
	if(count($result_data)>0){
			$status_track = array();
			$status_track = (array) json_decode($result_data["status_track"]);
			$registration_id[] = $result_data["firebase_instance_id"];	
			$buyer_id = $result_data["buyer_id"];			

			$element_exist=0;
			foreach ($status_track as $key => $value) {
				foreach ($value as $keys => $values){
					if($keys==$booking_status){	
						$element_exist=1;
					}
				}
			}
			$sellerlist = isset($_POST["enable_sellerlist"])?$_POST["enable_sellerlist"]:"0";
			$status_track[][$booking_status]=date('d-m-y h:i:s a');
			if($element_exist==0){
				// active status-------------
				$datas = array(
				'status_track'=>json_encode($status_track),
				'status'=>$booking_status,
				'show_sellerlist'=>$sellerlist,
				);
				$value = $db->updateAry('sp_bookings',$datas,"where booking_id='$sellerlist_booking_id'");
				if($sellerlist==1){
					$title="Received Seller List!!";
					$body="You have received seller list for your new booking. Click to view List";
					sendfirebasenotification($registration_id,$body,$title,"NULL","booking_details",$sellerlist_booking_id);
				}
			}
			else{
				$sellerlist = isset($_POST["enable_sellerlist"])?$_POST["enable_sellerlist"]:"0";
				$data=array('show_sellerlist'=>$sellerlist);
				$value=$db->updateAry("sp_bookings",$data,"where booking_id='$sellerlist_booking_id'");	
				if($sellerlist==1){
					$title="Received Seller List!!";
					$body="You have received seller list for your new booking. Click to view List";
					sendfirebasenotification($registration_id,$body,$title,"NULL","booking_details",$sellerlist_booking_id);
				}		
			}
	}
	$_SESSION["success"]="Updated Successfully";
	$session_status = unset_session_success_and_session_error();
	unset($_POST);
}

//allow payment---------
if(isset($_POST["payment_booking_id"])){
	$payment_booking_id = $_POST["payment_booking_id"];$booking_status="payment allowed";
	$result_data = $db->getRow("select status_track,firebase_instance_id,x.buyer_id From sp_bookings x left join sp_buyer y on x.buyer_id=y.buyer_id Where x.booking_id='$payment_booking_id'");
	if(count($result_data)>0){
			$status_track = array();
			$status_track = (array) json_decode($result_data["status_track"]);
			$registration_id[] = $result_data["firebase_instance_id"];	
			$buyer_id = $result_data["buyer_id"];
			$element_exist=0;
			foreach ($status_track as $key => $value) {
				foreach ($value as $keys => $values){
					if($keys==$booking_status){	
						$element_exist=1;
					}
				}
			}

			$status_track[][$booking_status]=date('d-m-y h:i:s a');
			if($element_exist==0){
				// active status-------------
				$payment_enabled=isset($_POST["enable_payment"])?$_POST["enable_payment"]:"0";

				$datas = array(
				'status_track'=>json_encode($status_track),
				'status'=>$booking_status,
				'allow_payment'=>$payment_enabled,
				);
				$value = $db->updateAry('sp_bookings',$datas,"where booking_id='$payment_booking_id'");
				if($payment_enabled==1){
					$title="Now Pay For Your New Booking!!";
					$body="The restriction to the payment is now unblocked. Please proceed to pay for your new booking";
					sendfirebasenotification($registration_id,$body,$title,"NULL","booking_details",$payment_booking_id);
				}
			}
			else{
				$payment_enabled=isset($_POST["enable_payment"])?$_POST["enable_payment"]:"0";
				$data=array('allow_payment'=>$payment_enabled);
				$value=$db->updateAry("sp_bookings",$data,"where booking_id='$payment_booking_id'");
				if($payment_enabled==1){
					$title="Now Pay For Your New Booking!!";
					$body="The restriction to the payment is now unblocked. Please proceed to pay for your new booking";
					sendfirebasenotification($registration_id,$body,$title,"NULL","booking_details",$payment_booking_id);
				}
			}
	}
	$_SESSION["success"]="Updated Successfully";
	$session_status = unset_session_success_and_session_error();
	unset($_POST);
}

if(isset($_POST["bid_id"]) && isset($_POST["seller_id"]) && isset($_POST["bid_status"])){
	$extra_denote = "Admin - ";
	$bid_status=$_POST["bid_status"];$bid_id=$_POST["bid_id"];$seller_id=$_POST["seller_id"];
	$result_data = $db->getRow("select status_track,firebase_instance_id,x.buyer_id From sp_bookings x left join sp_buyer y on x.buyer_id=y.buyer_id Where x.booking_id='$booking_id'");
	if(count($result_data)>0){
			$status_track = array();
			$status_track = (array) json_decode($result_data["status_track"]);
			$status_track[][$extra_denote.$bid_status]=date('d-m-y h:i:s a');
			$registration_id[] = $result_data["firebase_instance_id"];	
			$buyer_id = $result_data["buyer_id"];
				// active status-------------
			
				if($bid_status=="Matched"){
					$bid_status=1;

					$firebase_id = $db->getVal("select firebase_instance_id From sp_seller where seller_id='$seller_id'");
					$registration_id[] = $firebase_id;	
					$title="Order Confirmed!!..";
					$body="Buyer confirmed your order. Please visit booking details to see more..";
					sendfirebasenotification($registration_id,$body,$title,"NULL","enquiry",$seller_id,"false","NULL","seller");		

				}
				elseif ($bid_status=="Need Product Images"){
					$bid_status=2;
					$firebase_id = $db->getVal("select firebase_instance_id From sp_seller where seller_id='$seller_id'");
					$registration_id[] = $firebase_id;	
					$buyer_id = $result_data["buyer_id"];
					$title="Buyer Requested Product Image!!";
					$body="Buyer requested product image for their bookings. Please send that to proceed further.";
					sendfirebasenotification($registration_id,$body,$title,"NULL","enquiry",$seller_id,"false","NULL","seller");
				}
				elseif ($bid_status=="Sent Images"){
					$bid_status=3;
					$registration_id[] = $result_data["firebase_instance_id"];	
					$buyer_id = $result_data["buyer_id"];
					$title="Seller Sent Product Image!!";
					$body="As per the request seller sent image. Please click here to see the details.";
					sendfirebasenotification($registration_id,$body,$title,"NULL","booking_details",$booking_id);
				}
				elseif ($bid_status=="Not Matched"){
					$bid_status=0;$bid_id='';$seller_id='';
				}

				$datas = array(
				'status_track'=>json_encode($status_track),
				'bid_id'=>$bid_id,	
				'seller_id'=>$seller_id,											
				);
				$value = $db->updateAry('sp_bookings',$datas,"where booking_id='$booking_id'");

				$data=array('bid_status'=>$bid_status);
				$value=$db->updateAry("sp_bid",$data,"where bid_id='$bid_id'");

				 $_SESSION["success"]="Updated Successfully";
        
    $session_status = unset_session_success_and_session_error();
				// echo $db->getLastQuery();
	}
}


if(isset($_POST["status"])){
$status= $_POST["status"];
	$result_data = $db->getRow("select status_track,firebase_instance_id,x.buyer_id,x.seller_id From sp_bookings x left join sp_buyer y on x.buyer_id=y.buyer_id Where x.booking_id='$booking_id'");
	if(count($result_data)>0){
			$status_track = array();
			$status_track = (array) json_decode($result_data["status_track"]);
			$status_track[]["Admin - ".$status]=date('d-m-y h:i:s a');
			$registration_id[] = $result_data["firebase_instance_id"];	
			$buyer_id = $result_data["buyer_id"];
				// active status-------------
				$datas = array(
					'status_track'=>json_encode($status_track),
					'status'=>$status,											
				);
				$value = $db->updateAry('sp_bookings',$datas,"where booking_id='$booking_id'");
 				

				$notification_status=array("ready for shipment","received","shipped","received","cancelled","returned");
				if(in_array($status,$notification_status)){
					$title="New Update For Your Booking!!";
					$body="Your Booking is now in the state of '".$status."'. For further details please visit booking details.";
					sendfirebasenotification($registration_id,$body,$title,"NULL","booking_details",$booking_id);
				}

				if($status=="paid"){
					$seller_id = $result_data["seller_id"];
					$firebase_id = $db->getVal("select firebase_instance_id From sp_seller where seller_id='$seller_id'");
					$registration_id[]= $firebase_id;
					$title="Buyer Paid For The Order!!..";
					$body="Now you can proceed for shipment";
					sendfirebasenotification($registration_id,$body,$title,"NULL","shipment",$seller_id,"false","NULL","seller");
				}
				elseif ($booking_status=="cancel requested" || $booking_status=="return requested" || $booking_status=="cancelled" || $booking_status=="returned"){
					$seller_id = $result_data["seller_id"];
					$firebase_id = $db->getVal("select firebase_instance_id From sp_seller where seller_id='$seller_id'");
					$registration_id[] = $firebase_id;
					$title=ucfirst($booking_status)." For Booking ID: ".bookingid($booking_id)." !!..";
					$body="Please visit booking details to see more..";
					sendfirebasenotification($registration_id,$body,$title,"NULL","cancel",$seller_id,"false","NULL","seller");
				}

		}
		$_SESSION["success"]="Updated Successfully";
        
			    $session_status = unset_session_success_and_session_error();

}

// 
if(isset($_POST["submit_remarks"]) && isset($_POST["remarks"]) && isset($_POST["booking_id"])){
	$bookingid= $_POST["booking_id"];
 	$update_array = array(     
	              'remarks' => $_POST["remarks"],          
	            );
	          
	          	$action_result = $db->updateAry('sp_bookings', $update_array, "where booking_id='".$booking_id."'");
	          	 if( !is_null($action_result) )
		        {
		          $data_message = "Details updated successfully";
				  $_SESSION["success"]="Updated Successfully";
		          
		        }
		        else
		        {
		          $data_message = "Details is not updated successfully. Please try again";
				  $_SESSION["error"]="Already Updated";
		        }
		    $session_status = unset_session_success_and_session_error();
}
unset($_POST);
}
$result_data = $db->getRow("select a.*,b.name,b.mobile,b.alternate_mobile,b.email,b.address,b.landmark,b.city,b.state,b.pincode from sp_bookings a left join sp_buyer b on  a.buyer_id=b.buyer_id where booking_id='".$booking_id."' Limit 1");
if(count($result_data) > 0){ } else{ header('Location: index.php'); }
$image_val = json_decode($result_data["images"]);
$package_images = json_decode($result_data["package_images"]);
$shipping_images = json_decode($result_data["shipping_images"]);

?>

<style type="text/css">
.tk-timeline {
  position: relative;
  width: 100%;
  max-width: 1140px;
  /*margin: 0 auto;*/
  padding: 15px 0;
}

.tk-timeline::after {
  content: '';
  position: absolute;
  width: 2px;
  background: #006E51;
  top: 0;
  bottom: 0;
  /*left: 50%;*/
  left:125px;/*temperory*/
  margin-left: -1px;
}

.tm-container {
  padding: 15px 50px;
  position: relative;
  background: inherit;
  width: 50%;
}

.tm-container.left {
  left: 0;
}

.tm-container.right {
  /*left: 50%;*/
  left:125px;/*temperory*/
}

.tm-container::after {
  content: '';
  position: absolute;
  width: 16px;
  height: 16px;
  top: calc(50% - 8px);
  right: -8px;
  background: #ffffff;
  border: 2px solid #006E51;
  border-radius: 16px;
  z-index: 1;
}

.tm-container.right::after {
  left: -8px;
}

.tm-container::before {
  content: '';
  position: absolute;
  width: 50px;
  height: 2px;
  top: calc(50% - 1px);
  right: 8px;
  background: #006E51;
  z-index: 1;
}

.tm-container.right::before {
  left: 8px;
}

.tm-container .date {
  position: absolute;
  display: inline-block;
  top: calc(50% - 8px);
  text-align: center;
  font-size: 14px;
  font-weight: bold;
  color: #006E51;
  text-transform: uppercase;
  letter-spacing: 1px;
  z-index: 1;margin: -15px 0px 0 0;
}

.tm-container.left .date {
  right: -100px;max-width: 100px;
}

.tm-container.right .date {
  left: -100px;max-width: 100px;
}

.tm-container .icon {
	position: absolute;
    display: inline-block;
    width: 30px;
    height: 30px;
    padding: 7px 0;
    top: calc(57% - 21px);
    background: #F6D155;
    border: 2px solid #006E51;
    border-radius: 40px;
    text-align: center;
    font-size: 13px;
    color: #006E51;
    z-index: 1;
}

.tm-container.left .icon {
  right: 56px;
}

.tm-container.right .icon {
  left: 56px;
}

.tm-container .content {
  padding: 10px 10px 8px 60px;
  background: #F6D155;
  position: relative;
  /*border-radius: 0 500px 500px 0;*/
  padding: 10px 5px 10px 70px;
    border-radius: 51px;
}

.tm-container.right .content {
  /*padding: 30px 30px 30px 90px;*/
  /*border-radius: 500px 0 0 500px;*/
      max-width: 250px;
}

.tm-container .content h2 {
  margin: 0 0 10px 0;
  font-size: 18px;
  font-weight: normal;
  color: #006E51;
}

.tm-container .content p {
  margin: 0;
  font-size: 16px;
  line-height: 22px;
  color: #000000;
}

@media (max-width: 767.98px) {
  .tk-timeline::after {
    left: 90px;
  }

  .tm-container {
    width: 100%;
    padding-left: 120px;
    padding-right: 30px;
  }

  .tm-container.right {
    left: 0%;
  }

  .tm-container.left::after, 
  .tm-container.right::after {
    left: 82px;
  }

  .tm-container.left::before,
  .tm-container.right::before {
    left: 100px;
    border-color: transparent #006E51 transparent transparent;
  }

  .tm-container.left .date,
  .tm-container.right .date {
    right: auto;
   left: -15px;
    max-width: 100px;
  }

  .tm-container.left .icon,
  .tm-container.right .icon {
    right: auto;
    left: 146px;
  }

  .tm-container.left .content,
  .tm-container.right .content {
    /*padding: 30px 30px 30px 90px;*/
    /*border-radius: 500px 0 0 500px;*/
  }
}
</style>
</head>
<body>
<!--------------------->
<div id="wrapper">
    <?php include 'inc_leftmenubar.php'; ?>
	<div id="page-wrapper">
		<div class="container-fluid">
	        <div class="row panel panel-default page-wrapper-panel">
	        	<?php
              /*Session Alert Message*/
              if( isset($session_status) && !empty($session_status) )
              {
                echo msg($session_status);
              }
            ?>
		        <div class="gradient-card-header">
		            <h2 class="white-text mx-3">Booking Id - <?=bookingid($booking_id);?></h2>
		        </div>
				<button class="btn btn-info" onclick="window.location.href='bookings.php'"><i class="fa fa-angle-left"></i> Go Back</button><br/><br/>

		         	<ul class="nav nav-tabs custom-nav-tabs" id="myTab">
                      <li class="active"><a data-toggle="tab" href="#tab_menu1">Details</a></li>
                      <li><a data-toggle="tab" href="#tab_menu2">Bids</a></li>
                      
                      <li><a data-toggle="tab" href="#tab_menu3">Track</a></li>
                    </ul>
                    <?php 
                    $variant_id = $result_data['variant_id'];
                    $parts_id = $result_data['parts_id'];$partname ="";                  
                    if($result_data['category']=="car"){
                    	$datas = $db->getRow("SELECT make,model ,year ,variant from sp_car_variant a inner join sp_car_year b on a.year_id=b.year_id inner join sp_car_model c on b.model_id=c.model_id inner join sp_car_make d on c.make_id=d.make_id and variant_id='".$variant_id."' Limit 1");


                    	$body = $db->getRow("select name from sp_car_parts where carparts_id='".$parts_id."' Limit 1");
                    	if(count($body)>0){$partname =$body["name"];}
                	}
                	else{
                	$datas = $db->getRow("SELECT make,model ,year ,variant from sp_car_variant a inner join sp_car_year b on a.year_id=b.year_id inner join sp_car_model c on b.model_id=c.model_id inner join sp_car_make d on c.make_id=d.make_id and variant_id='".$variant_id."' Limit 1");
                	$body = $db->getRow("select name from sp_bike_parts where bikeparts_id='".$parts_id."' Limit 1");
                    	if(count($body)>0){$partname =$body["name"];}
                	}
					?>
                    <div class="tab-content">                      
                      <div id="tab_menu1" class="tab-pane fade in active">

                      	<?php if(count($datas) > 0){  ?>
                      		<div class="col-lg-6">
                                <div class="card-details custom-box-shadow" style="margin-bottom: 25px;">
                                  <div class="header">Booking Details</div>
	                                <div class="row" style="padding: 0px 22px 10px 22px;">
		                                <p class="col-lg-12"><b>Booking Date: </b><?= date('d-m-Y h:i:s a' , strtotime($result_data['dateandtime'])) ?></p>
		                                <p class="col-lg-12"><b>Category: </b><?= $result_data['category']; ?></p>
		                                <p class="col-lg-12"><b>Make: </b><?= $datas['make']; ?></p>
		                                <p class="col-lg-12"><b>Model: </b><?= $datas['model']; ?></p>
		                                <p class="col-lg-12"><b>Year: </b><?= $datas['year']; ?></p>
		                                <p class="col-lg-12"><b>Variant: </b><?= $datas['variant']; ?></p>
		                                <p class="col-lg-12"><b>Body Part: </b><?= $partname; ?></p>
		                                <p class="col-lg-12"><b>Description: </b><?= $result_data['description']; ?></p>		                                

		                                <?php if(!empty($result_data["images"])){ ?>
		                                <p class="col-lg-6"><b>Sample Images: </b>
		                                	<?php
		                                	foreach ($image_val as $key => $value) { ?>
		                                	<img src="../<?=$value?>" style="max-width: 150px;">
		                                	<?php } ?>
		                                </p>
		                                <?php } 		                              
		                                if(!empty($result_data["voice"])){?>		                            	
		                                <p class="col-lg-12"><br/>
		                                	<b>Voice Notes: </b><br/>
		                                	<audio controls>
		                                	<source src="../<?=$result_data["voice"]?>" type="audio/mpeg">
		                                	</audio>
		                                </p>
		                            	<?php } 
		                            	if(!empty($result_data["package_images"])){ ?>
		                                <p class="col-lg-12"><b>Package Images: <br/></b>
		                                	<?php
		                                	foreach ($package_images as $key => $value) { ?>
		                                	<img src="../<?=$value?>" style="max-width: 150px;">
		                                	<?php } ?>
		                                </p>
		                                <?php } 

		                                if(!empty($result_data["shipping_images"])){ ?>
		                                <p class="col-lg-12"><b>Shipping Images: <br/></b>
		                                	<?php
		                                	foreach ($shipping_images as $key => $value) { ?>
		                                	<img src="../<?=$value?>" style="max-width: 150px;">
		                                	<?php } ?>
		                                </p>
		                                <?php } ?>
		                               
		                            	<div class="col-lg-12"><b class="col-md-2" style="padding: 5px 0 0 0;">Active Status: </b>
		                            	<form method="post">
		                            	 <div class="col-md-8" style="padding: 0px">
		                            	 	
				                                <select class="select2" name="status" onchange="changeactivestatus(this)">
				                                <?php
				                                $bk_status = $db->getRows("select status_name from sp_booking_status order by priority");
						                    	if(count($bk_status)>0){
						                    	foreach ($bk_status as $key => $value) { ?>
				                                	<option value="<?=$value['status_name']?>" <?php if($value['status_name']==$result_data["status"]){echo "selected";} ?>><?=$value['status_name']?></option>
				                                <?php } } ?>                 	
				                                </select>
			                            	
			                            </div>
			                        </form>
			                        </div>
			                         <form method="post">
			                        <div class="col-lg-12"><b class="col-md-2" style="padding: 5px 0 0 0;">Remarks: </b>
			                        	<textarea class="form-control" name="remarks" rows="3"><?= $result_data["remarks"] ?></textarea>
			                        </div>
 									<div class="col-md-12 sp_edit">
		                                <input type="text" name="booking_id" value="<?= $booking_id ?>" hidden="" />
		                                <button type="submit" name="submit_remarks" class="btn btn-success center-block" style="margin-top: 20px;">Submit</button>
		                            </div>
		                            </form>
		                            </div>
		                        </div>
		                    </div>
		                <?php } ?>

		                    <div class="col-lg-6">
                                <div class="card-details custom-box-shadow" style="margin-bottom: 15px;">
                                  <div class="header">Buyer Details</div>
	                                <div class="row" style="padding: 0px 22px 10px 22px;">
		                                <p class="col-lg-12"><b>Buyer Id: </b><?= buyerid($result_data['buyer_id']); ?></p>
		                                <p class="col-lg-12"><b>Name: </b><?= $result_data['name']; ?></p>
		                                <p class="col-lg-12"><b>Email: </b><?= $result_data['email']; ?></p>
		                                <p class="col-lg-12"><b>Mobile: </b><?= $result_data['mobile']; ?></p>
		                                <p class="col-lg-12"><b>Alternate Mobile: </b><?= $result_data['alternate_mobile']; ?></p>
		                                <p class="col-lg-12"  style="line-height: 2.0"><b>Address: </b><?= $result_data['address']; ?></p>
		                                <p class="col-lg-12"><b>Landmark: </b><?= $result_data['landmark']; ?></p>
		                                <p class="col-lg-12"><b>City: </b><?= $result_data['city']; ?></p>
		                                <p class="col-lg-12"><b>State: </b><?= $result_data['state']; ?></p>
		                                <p class="col-lg-12"><b>Pincode: </b><?= $result_data['pincode']; ?></p>	
		                            </div>
		                        </div>
		                    </div>


		                    <div class="col-lg-6">
                                <div class="card-details custom-box-shadow" style="margin-bottom: 15px;">
                                  <div class="header">Seller Details</div>
	                                <div class="row" style="padding: 0px 22px 10px 22px;">

	                                	<?php if($result_data['seller_id']!=''&&$result_data['buyer_id']!='NULL'){
	                                		$seller_id = $result_data['seller_id'];
	                                		$seller = $db->getRow("select * from sp_seller where seller_id='".$seller_id."' Limit 1");
                    						if(count($seller)>0){
	                                		?>
			                                <p class="col-lg-12"><b>Seller Id: </b><?= sellerid($seller['seller_id']); ?></p>
			                                <p class="col-lg-12"><b>Name: </b><?= $seller['name']; ?></p>
			                                <p class="col-lg-12"><b>Shop: </b><?= $seller['shop']; ?></p>
			                                <p class="col-lg-12"><b>Email: </b><?= $seller['email']; ?></p>
			                                <p class="col-lg-12"><b>Mobile: </b><?= $seller['mobile']; ?></p>
			                                <p class="col-lg-12"><b>Alternate Mobile: </b><?= $seller['alternate_mobile']; ?></p>
			                                <p class="col-lg-12"  style="line-height: 2.0"><b>Address: </b><?= $seller['address']; ?></p>
			                                <p class="col-lg-12"><b>Landmark: </b><?= $seller['landmark']; ?></p>
			                                <p class="col-lg-12"><b>City: </b><?= $seller['city']; ?></p>
			                                <p class="col-lg-12"><b>State: </b><?= $seller['state']; ?></p>
			                                <p class="col-lg-12"><b>Pincode: </b><?= $seller['pincode']; ?></p>	
		                            	<?php }
		                            	else{
		                            		echo "No Data Found";
		                            	} } ?>
		                            </div>
		                        </div>
		                    </div>

                      </div>
                      <div id="tab_menu2" class="tab-pane fade"><br/>
			            
			            <div class="row">
			            	<div class="col-md-offset-8">
			            		<form method="post" id="enable_sellerlist_form">
						            <div class="pure-checkbox col-md-6">
							          	<input type="checkbox" id="enable_sellerlist" value="1" style="opacity:2" name="enable_sellerlist" <?php if($result_data['show_sellerlist']==1){echo "checked";} ?> >
							          <label for="enable_sellerlist" style="font-size: 12px;margin-left: 10px;float: left;font-weight: bold;">Show Seller List</label>
							      	</div>
							      	<input type="text" name="sellerlist_booking_id" value="<?=$booking_id?>" style="display: none">
							      </form>
							      <form method="post" id="enable_payment_form">
						         	<div class="pure-checkbox  col-md-6">
						          		<input type="checkbox" id="enable_payment" value="1" style="opacity:2" name="enable_payment" <?php if($result_data['allow_payment']==1){echo "checked";} ?>>
						         		<label for="enable_payment" style="font-size: 12px;margin-left: 10px;float: left;font-weight: bold;">Allow For Payment</label>
						         	</div>
					         		<input type="text" name="payment_booking_id" value="<?=$booking_id?>" style="display: none">
							      </form>
					    	</div>
					    </div><br/>
                      	<div class="table-responsive">
                      	 <table id="bid_table" class="table table-striped table-hover" width="100%">
	                      <thead>
	                        <tr>
	                          <th>Id</th>  
                              <th>Seller_Id</th>                                
	                          <th>Name</th>
	                          <th>Mobile</th>                          
                              <th>Amount</th>
                              <th>Return Days</th> 
                              <th>Image</th>                                
                              <th>Bid Status</th>   	                         
	                          <th class="sp_delete">Delete</th>	                          
	                        </tr>
	                      </thead>
	                      <tbody>          
	                        <?php 
	                        $booking_seller_id = $result_data["seller_id"];$i=1;
	                        $bids = $db->getRows("select b.seller_id,b.name, b.mobile, a.* from sp_bid a left join sp_seller b on a.seller_id = b.seller_id where booking_id='$booking_id'");
	                        foreach ($bids as $key => $value) {
						 	$seller_id=$value["seller_id"];
							$highlight="";
							if($booking_seller_id==$seller_id){
								$highlight = "highlight-row";
										if($value["bid_status"]==1){
											$bid_status="Matched";
										}
										elseif ($value["bid_status"]==2){
											$bid_status="Need Product Images";
										}
										elseif ($value["bid_status"]==3){
											$bid_status="Sent Images";
										}
										else{
											$bid_status="Pending";
										}
									}
									elseif (is_null($booking_seller_id) || empty($booking_seller_id) || $booking_seller_id =='') {
										$bid_status="Pending";
									}
									else{
										$bid_status="Not Matched";
									}
									 $image1 = json_decode($value["product_images"]);
	                         ?>
			                <tr class="<?=$highlight?>">
			                	<td><?=$i?></td>
			                	<td><?=sellerid($seller_id)?></td>		                	
			                	<td><?=$value["name"]?></td>		                	
			                	<td><?=$value["mobile"]?></td>
			                	<td><?=$value["amount"]?></td>		               				                			                	
			                	<td><?=$value["return_days"]?></td>	
			                	<td><?php if(is_array($image1)){?><img src="../<?=array_values($image1)[0]?>" style="max-width:70px"/><?php if(isset(array_values($image1)[1])){?><img src="../<?=array_values($image1)[1]?>" style="max-width:70px"/><?php } } ?></td>		
			                	<td>
			                		<form method="post">
			                		<select class="select2" name="bid_status" onchange="return confirmbid_status(this);">
			                            <?php
			                                $bk_status=array('Matched','Need Product Images','Sent Images','Not Matched');
					                    	if(count($bk_status)>0){
					                    	foreach ($bk_status as $key => $value_status) { ?>
			                               	<option value="<?=$value_status?>" <?php if($value_status==$bid_status){echo "selected";} ?>><?=$value_status?></option>
			                            <?php } } ?>                 	
			                        </select>
			                        <input type="text" name="bid_id" value="<?=$value['bid_id']?>" style="display: none">
			                        <input type="text" name="seller_id" value="<?=$value['seller_id']?>" style="display: none">
			                    	</form>
			                	</td>
			                	<td><button type="button" class=" btn btn-danger btn-circle btnTableDelete sp_delete" onclick='delete_tablerow(this,"sp_bid","delete_row","bid_id","<?=$value['bid_id']?>")' name="delete" value='<?=$value["bid_id"]?>' title="Delete"><i class="fa fa-times"></i></button>
			                	</td>
			                </tr>
			            <?php $i++; } ?>
	                      </tbody>
	                    </table>
	                	</div>
				    </div>
                    <div id="tab_menu3" class="tab-pane fade"><br/>
						<div class="tk-timeline col-md-offset-4">
							<?php $status_track = (array) json_decode($result_data["status_track"]);
						foreach ($status_track as $key => $value) {
							foreach ($value as $keys => $values){ ?>			
						  <div class="tm-container right">
						    <div class="date"><?= $values ?></div>
						    <i class="icon fa fa-hand-point-right"></i>
						    <div class="content">
						      <p><?=$keys?></p>
						    </div>
						  </div>
						<?php } } ?>
						</div>
                    </div>
                    </div>
                  </div>
		       
	    	</div>
	    	<!-- table -->
		</div>	    
	</div>
</div>
<?php include 'inc-script.php'; ?>
<script type="text/javascript">
	$('.togglepassword').click(function(){
		var ipt = $('#password').prop('type');
		if(ipt=="text"){
			$('#password').prop('type','password');
			$(this).html('<i class="fa fa-eye-slash"></i>');
		}
		else{
			$('#password').prop('type','text');
			$(this).html('<i class="fa fa-eye"></i>');			
		}
	});
$('#credential-update').submit(function(e){
        e.preventDefault();
		var formData = new FormData(this);
		formData.append('action', 'update_seller_credentials');
        $.ajax({
            type: 'POST',
            url: 'ajax.php',
            data: formData,
            contentType: false,
            cache: false,
            processData:false, 
            dataType: "json",
            success: function(data){ 
            if(data['status'] == 'success'){ 
          		success_alertbox('','Update');
	        }
	        else{
          		error_alertbox('','Update');
	          }
            },
	        error: function(jqXHR, textStatus, errorThrown) {
          	error_alertbox('','');
	    }
    });
});
$(document).ready(function(e){
  $('#bid_table').dataTable({
    "destroy": true,
    "retrieve": true,
    "responsive": true,
    "ordering": true,
    "searching": true,
    "lengthChange": true,
  });
  $('#enable_sellerlist').on('change',function(){
  	$('#enable_sellerlist_form').submit();
  });
  $('#enable_payment').on('change',function(){
  	$('#enable_payment_form').submit();
  });
});
<?php if($bookings_edit==1){ ?>
function confirmbid_status(element){
   $.confirm({
    icon: 'fa fa-check',
	    title: '',
	    content: 'Are You Sure To Change Bid Status?',
	    type: 'green',
	   
	    buttons: {
	      Yes: function () {
	        $(element).closest('form').submit();
	      },
	      cancel: function () {
	       return true;
	      }
	    }
	  }); 
   }

function changeactivestatus(element){
	$.confirm({
    	icon: 'fa fa-check',
	    title: '',
	    content: 'Are You Sure To Change Active Status?',
	    type: 'green',	   
	    buttons: {
	      Yes: function () {
	        $(element).closest('form').submit();
	      },
	      cancel: function () {
	       return true;
	      }
	    }
	  }); 
}
<?php } ?>
</script>
</body>
</html>