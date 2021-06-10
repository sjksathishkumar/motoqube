<?php if(isset($_GET["seller"])){$seller_id = $_GET["seller"];}else{header('Location: index.php');}  
include 'inc-meta.php';
$result_data = $db->getRow("select * from sp_seller where seller_id='".$seller_id."' Limit 1");
if(count($result_data) > 0){ } else{ header('Location: index.php'); }
?>
</head>
<body>
<!--------------------->
<div id="wrapper">
    <?php include 'inc_leftmenubar.php'; ?>
	<div id="page-wrapper">
		<div class="container-fluid">
	        <div class="row panel panel-default page-wrapper-panel">
		        <div class="gradient-card-header">
		            <h2 class="white-text mx-3">Seller - <?=$result_data['name']?></h2>
		        </div>
				<button class="btn btn-info" onclick="window.location.href='sellers.php'"><i class="fa fa-angle-left"></i> Go Back</button><br/><br/>
		         <ul class="nav nav-tabs custom-nav-tabs" id="myTab">
                      <li class="active"><a data-toggle="tab" href="#tab_menu1">Profile</a></li>
                      <li><a data-toggle="tab" href="#tab_menu2">Products</a></li>
                    </ul>

                    <div class="tab-content">                      
                      <div id="tab_menu1" class="tab-pane fade in active">
                      	<div class="col-lg-12 sp_edit top15"><button class="btn btn-primary  pull-right" data-toggle="modal" data-target="#edit_seller"><i class="fa fa-pen"></i> Edit</button></div>
                      		<div class="col-lg-6">
                                <div class="card-details custom-box-shadow" style="margin-bottom: 25px;">
                                  <div class="header">Personal Details</div>
	                                <div class="row" style="padding: 0px 22px 10px 22px;">
	                                	<p class="col-lg-12"><b>Date Of Joining: </b><?= date('d-m-Y h:i a',strtotime($result_data['dateandtime']));  ?></p>
		                                <p class="col-lg-12"><b>Seller ID: </b><?= sellerid($result_data['seller_id']);  ?></p>
		                                <p class="col-lg-12"><b>Name: </b><?= $result_data['name']; ?></p>
		                                <p class="col-lg-12"><b>Email: </b><?= $result_data['email']; ?></p>
		                                <p class="col-lg-12"><b>Mobile: </b><?= $result_data['mobile']; ?></p>
		                                <p class="col-lg-12"><b>Alternate Mobile: </b><?= $result_data['alternate_mobile']; ?></p>
		                                
										<form method="post" id="credential-update" >
		                                <div class="col-lg-12"><b class="col-md-2" style="padding: 5px 0 0 0;">Status: </b>
		                                <div class="col-md-4" style="padding: 0px">
			                                <select class="select2" name="status">
			                                	<option value="1" <?php if($result_data['status']==1){echo "selected";} ?>>Active</option>
			                                	<option value="0" <?php if($result_data['status']==0){echo "selected";} ?>>Inactive</option>		                                	
			                                </select>
			                            </div>
		                            	<br/>
		                               	</div>

		                               	<p class="col-lg-12"><label>Remarks: </label>
		                               		<textarea name="remarks" class="form-control" style="resize: vertical;padding: 10px 0px;"><?= $result_data['remarks']; ?></textarea></p>
		                                
		                                <div class="col-md-12 panel-default credential-panel" style="border:solid 1px #9aa99777;padding: 10px;">
		                                	<label>Username:</label>
		                                	<input type="text" name="username" class="form-control" value="<?= $result_data['username']; ?>" autocomplete="off" style="border: solid 1px #9aa99777;padding-right: 45px;" >
		                                	<label style="padding-top: 10px">Password:</label>
		                                	<div class="input-group" style="display: inline-flex;width: 100%">
		                                	<input type="password" name="password" id="password" class="form-control password" value="<?= base64_decode($result_data['password']) ?>" autocomplete="off" style="border:solid 1px #9aa99777;padding-right: 45px;" >
		                                	<button class="btn-primary btn togglepassword" type="button" style="float: right;position: absolute;right: 0;    z-index: 9;border-radius: 0 2px 2px 0;top: 1px;box-shadow: none;"><i class="fa fa-eye-slash"></i></button>
		                                	</div>
		                                </div>
		                                <div class="col-md-12 sp_edit">
		                                	<input type="text" name="seller_id" value="<?= $seller_id ?>" hidden="" />
		                                <button type="submit" name="submit_credential" class="btn btn-success center-block" style="margin-top: 20px;">Submit</button>
		                            	</div>
		                                </form>		                                
		                            </div>
		                        </div>
		                    </div>

		                    <div class="col-lg-6">
                                <div class="card-details custom-box-shadow" style="margin-bottom: 25px;">
                                  <div class="header">Shop Details</div>
	                                <div class="row" style="padding: 0px 22px 50px 22px;">
		                                <p class="col-lg-12"><b>Shop: </b><?= $result_data['shop']; ?></p>
	                                	<p class="col-lg-12"  style="line-height: 2.0"><b>Address: </b><?= $result_data['address']; ?></p>
		                                <p class="col-lg-12"><b>Landmark: </b><?= $result_data['landmark']; ?></p>
		                                <p class="col-lg-12"><b>Location: </b><?= $result_data['location']; ?></p>
		                                <p class="col-lg-12"><b>District: </b><?= $result_data['city']; ?></p>
		                                <p class="col-lg-12"><b>State: </b><?= $result_data['state']; ?></p>
		                                <p class="col-lg-12"><b>Pincode: </b><?= $result_data['pincode']; ?></p>
		                                <p class="col-lg-12"><b>Commission: </b><?= $result_data['business_percentage']; ?></p>
		                                <p class="col-lg-12"><b>Working Hours: </b><?= $result_data['hours']; ?></p>
		                                <p class="col-lg-12" style="line-height: 2.0"><b>Working Days: </b>
		                                	<?php $working_days = json_decode($result_data['working_days']);
											$monday = (isset($working_days->M) && !empty($working_days->M) && $working_days->M != null)?$working_days->M:"0";
											$tuesday = (isset($working_days->M) && !empty($working_days->T) && $working_days->T != null)?$working_days->T:"0";
											$wednesday = (isset($working_days->W) && !empty($working_days->W) && $working_days->W != null)?$working_days->W:"0";
											$thursday = (isset($working_days->Th) && !empty($working_days->Th) && $working_days->Th != null)?$working_days->Th:"0";
											$friday = (isset($working_days->F) && !empty($working_days->F) && $working_days->F != null)?$working_days->F:"0";
											$saturday = (isset($working_days->S) && !empty($working_days->S) && $working_days->S != null)?$working_days->S:"0";
											$sunday = (isset($working_days->Su) && !empty($working_days->Su) && $working_days->Su != null)?$working_days->Su:"0";

		                                	 ?>
		                                	<input type="checkbox" name="working_days" value="1"  <?php if($monday==1){ echo "checked";} ?> /> Monday
		                                	<input type="checkbox" name="working_days" value="1" <?php if($tuesday==1){ echo "checked";} ?> /> Tuesday
		                                	<input type="checkbox" name="working_days" value="1" <?php if($wednesday==1){ echo "checked";} ?> /> Wednesday
		                                	<input type="checkbox" name="working_days" value="1" <?php if($thursday==1){ echo "checked";} ?>/> Thursday
		                                	<input type="checkbox" name="working_days" value="1" <?php if($friday==1){ echo "checked";} ?> /> Friday
		                                	<input type="checkbox" name="working_days" value="1" <?php if($saturday==1){ echo "checked";} ?> /> Saturday
		                                	<input type="checkbox" name="working_days" value="1" <?php if($sunday==1){ echo "checked";} ?> /> Sunday
	                                </div>
	                            </div>
	                        </div>

	                        <div class="clearfix"></div>
		                    <?php $act_data = $db->getRow("select * from sp_seller_account where seller_id='".$seller_id."' ");
                            if(count($act_data) > 0)
                            {?>                              
		                     <div class="col-lg-6">
                                <div class="card-details custom-box-shadow" style="margin-bottom: 25px;">
                                  <div class="header">Account Details</div>
	                                <div class="row" style="padding: 0px 22px 47px 22px;">
		                                <p class="col-lg-12"><b>Account Name: </b><?= $act_data['account_name']; ?></p>
		                                <p class="col-lg-12"><b>Account Number: </b><?= $act_data['account_number']; ?></p>
		                                <p class="col-lg-12"><b>Bank: </b><?= $act_data['bank']; ?></p>
		                                <p class="col-lg-12"><b>IFSC: </b><?= $act_data['ifsc']; ?></p>
		                                <p class="col-lg-12"><b>G-Pay: </b><?= $act_data['gpay']; ?></p>
		                                <p class="col-lg-12"><b>Phonepe: </b><?= $act_data['phonepay']; ?></p>
		                            </div>
		                        </div>
		                    </div>
                            <?php } 
                            ?>   
                           
                      </div>
                      <div id="tab_menu2" class="tab-pane fade">
                      	<?php $carmodels =json_decode($result_data['car_deal']);
                      	 $car_model = isset($carmodels)&&!empty($carmodels)?implode("','", $carmodels):"0";
                      	 $carparts =json_decode($result_data['car_parts']);
                      	 $car_parts = isset($carparts)&&!empty($carparts)?implode("','", $carparts):"0";

                      	 $bikemodels =json_decode($result_data['bike_deal']);
                      	 $bike_model = isset($bikemodels)&&!empty($bikemodels)?implode("','", $bikemodels):"0";
                      	 $bikeparts =json_decode($result_data['bike_parts']);
                      	 $bike_parts = isset($bikeparts)&&!empty($bikeparts)?implode("','", $bikeparts):"0"; ?>
                      	  <div class="col-lg-6">
                                <div class="card-details custom-box-shadow" style="margin-bottom: 25px;">
                                  <div class="header">Car Deals</div>
	                                <div class="table table-responsive" style="padding: 10px;">
			                      	 <table id="car_details_table" class="table table-striped table-hover datatable" width="100%">
				                      <thead>
				                        <tr>
				                          <th>ID</th>   
				                          <th>Make</th>
				                          <!-- <th>Model</th>     	                           -->
				                        </tr>
				                      </thead>
				                      <tbody>                       
				                      	<?php 
			                      		// $ac_data = $db->getRows("select make,model from sp_car_model left join sp_car_make on sp_car_make.make_id = sp_car_model.make_id where model_id IN('".$car_model."')");
			                      		$ac_data = $db->getRows("select make from sp_car_make where make_id IN('".$car_model."')");
			                            if(count($ac_data) > 0)
			                            { $k=1;
			                            	foreach ($ac_data as $key => $value) { ?>
			                            		<tr>
			                            			<td><?=$k?></td>
			                            			<td><?=$value["make"]?></td>
			                            			<!-- <td><?=$value["model"]?></td>                            			 -->
			                            		</tr>
			                            	<?php $k++; }
			                            }
			                        	?>
				                      </tbody>
				                    </table>
				                <?php 
				                $ac_data = $db->getRows("select name from sp_car_parts where carparts_id IN('".$car_parts."')");
				                 if(count($ac_data) > 0)
			                     { $parts = "";$j=0; foreach ($ac_data as $key => $value) { $parts.=($j==0)?$value["name"]:", ".$value["name"]; $j++; } ?>
				                <div style="border-top:solid 1px #ded5d5;margin-top:15px;padding-top: 10px;"><p><b>Car Parts: </b><?=$parts?></p></div>
				            	<?php } ?>
				                </div>
				            </div>
				        </div>

				        <div class="col-lg-6">
                                <div class="card-details custom-box-shadow" style="margin-bottom: 25px;">
                                  <div class="header">Bike Deals</div>
	                                <div class="table table-responsive" style="padding: 10px;">
			                      	 <table id="car_details_table" class="table table-striped table-hover datatable" width="100%">
				                      <thead>
				                        <tr>
				                          <th>ID</th>   
				                          <th>Make</th>
				                          <!-- <th>Model</th> -->
				                        </tr>
				                      </thead>
				                      <tbody>                       
				                      	<?php 
			                      		// $ac_data = $db->getRows("select make,model from sp_bike_model left join sp_bike_make on sp_bike_make.make_id = sp_bike_model.make_id where model_id IN('".$bike_model."')");
			                      		$ac_data = $db->getRows("select make from sp_bike_make where make_id IN('".$bike_model."')");
			                            if(count($ac_data) > 0)
			                            { $k=1;
			                            	foreach ($ac_data as $key => $value) { ?>
			                            		<tr>
			                            			<td><?=$k?></td>
			                            			<td><?=$value["make"]?></td>
			                            			<!-- <td><?=$value["model"]?></td>                            			 -->
			                            		</tr>
			                            	<?php $k++; }
			                            }
			                        	?>
				                      </tbody>
				                    </table>
				                    <?php 
					                $ac_data = $db->getRows("select name from sp_bike_parts where bikeparts_id IN('".$bike_parts."')");
					                 if(count($ac_data) > 0)
				                     { $parts = "";$j=0; foreach ($ac_data as $key => $value) { $parts.=($j==0)?$value["name"]:", ".$value["name"]; $j++; } ?>
					                <div style="border-top:solid 1px #ded5d5;margin-top:15px;padding-top: 10px;"><p><b>Bike Parts: </b><?=$parts?></p></div>
					            	<?php } ?>
				                </div>
				            </div>
				        </div>


				    </div>
                    </div>
                  </div>
		       
	    	</div>
	    	<!-- table -->
		</div>	    
	</div>
</div>



  <!-- The Modal -->
  <div class="modal sp_edit" id="edit_seller">
    <div class="modal-dialog modal-dialog cascading-modal">
      <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header light-blue darken-3 white-text">
          <h4 class="modal-title">Edit Seller</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
        	<form method="post" id="seller_form">
   				<span class="badge-label ma-top20 p-2">Name:</span>
   				<input type="text" class="form-control" value="<?= $result_data['name']; ?>" name="name"  />

		        <span class="badge-label ma-top20 p-2">Email: </span>
		        <input type="text" class="form-control" value="<?= $result_data['email']; ?>" name="email" />

		        <span class="badge-label ma-top20 p-2">Mobile: </span>
		        <input type="text" class="form-control" value="<?= $result_data['mobile']; ?>" name="mobile"  />

		        <span class="badge-label ma-top20 p-2">Alternate Mobile: </span>
		        <input type="text" class="form-control" value="<?= $result_data['alternate_mobile']; ?>" name="alternate_mobile" />

		        <span class="badge-label ma-top20 p-2">Shop: </span>
		        <input type="text" class="form-control" value="<?= $result_data['shop']; ?>" name="shop"  />

		        <span class="badge-label ma-top20 p-2">Address: </span>
		        <textarea name="address"  class="form-control"><?= $result_data['address']; ?></textarea>

 				<span class="badge-label ma-top20 p-2">Landmark: </span>
		        <input type="text" class="form-control" value="<?= $result_data['landmark']; ?>" name="landmark"  />
			    <?php
	        	$state = $result_data['state'];
	        	$location = $result_data['location'];
	        	$district = $result_data['city'];
	        	$pincode = $result_data['pincode'];
				?>
	         	<span class="badge-label ma-top20 p-2">State</span>
	            <select name="state" id="state1" class="select2" >
                  <?php 
                  $options = $db->getRows("Select state from sp_locations group by state order by state");
                  if(count($options)>0){?>
                   <option>Choose State</option>
                  <?php foreach ($options as $key => $value) {
                  ?>
                  <option <?php if(strtolower($result_data['state'])==strtolower($value["state"])){ echo "selected"; } ?> ><?=$value["state"]?></option>
                  <?php } } ?>
                </select>
	     
          	    <span class="badge-label ma-top20 info-color p-2">District</span>
                    <select name="district" id="district1" class="select2" >
                    <?php 
                  $options = $db->getRows("Select district from sp_locations where state='$state' group by district order by district");
                  if(count($options)>0){ ?>
                   <option>Choose District</option>
                   <?php
                  foreach ($options as $key => $value) {
                  ?>
                  <option <?php if(strtolower($result_data['city'])==strtolower($value["district"])){ echo "selected"; } ?> ><?=$value["district"]?></option>
                  <?php } } ?>
                </select>
	        
            
                <span class="badge-label ma-top20 info-color p-2">Location</span>
                <select name="location" id="location1" class="select2" >
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
         

		        <span class="badge-label ma-top20 p-2">Pincode: </span>
		        <input type="text" class="form-control" value="<?= $result_data['pincode']; ?>" name="pincode"  />

		        <span class="badge-label ma-top20 p-2">Business Percentage: </span>
		        <input type="text" class="form-control" value="<?= $result_data['business_percentage']; ?>" name="business_percentage"  />

		        <span class="badge-label ma-top20 p-2">Working Hours: </span>
		        <input type="text" class="form-control" value="<?= $result_data['hours']; ?>" name="hours"  />

				<span class="badge-label ma-top20 p-2">Working Hours: </span><br/>
		        <?php $working_days = json_decode($result_data['working_days']);
				$monday = (isset($working_days->M) && !empty($working_days->M) && $working_days->M != null)?$working_days->M:"0";
				$tuesday = (isset($working_days->T) && !empty($working_days->T) && $working_days->T != null)?$working_days->T:"0";
				$wednesday = (isset($working_days->W) && !empty($working_days->W) && $working_days->W != null)?$working_days->W:"0";
				$thursday = (isset($working_days->Th) && !empty($working_days->Th) && $working_days->Th != null)?$working_days->Th:"0";
				$friday = (isset($working_days->F) && !empty($working_days->F) && $working_days->F != null)?$working_days->F:"0";
				$saturday = (isset($working_days->S) && !empty($working_days->S) && $working_days->S != null)?$working_days->S:"0";
				$sunday = (isset($working_days->Su) && !empty($working_days->Su) && $working_days->Su != null)?$working_days->Su:"0";
		        ?>
		        <input type="checkbox" name="monday"  value="1"  <?php if($monday==1){ echo "checked";} ?> /> Monday
		        <input type="checkbox" name="tuesday"  value="1" <?php if($tuesday==1){ echo "checked";} ?> /> Tuesday
		        <input type="checkbox" name="wednesday"  value="1" <?php if($wednesday==1){ echo "checked";} ?> /> Wednesday
		        <input type="checkbox" name="thursday"  value="1" <?php if($thursday==1){ echo "checked";} ?>/> Thursday
		        <input type="checkbox" name="friday"  value="1" <?php if($friday==1){ echo "checked";} ?> /> Friday
		        <input type="checkbox" name="saturday"  value="1" <?php if($saturday==1){ echo "checked";} ?> /> Saturday
		        <input type="checkbox" name="sunday"  value="1" <?php if($sunday==1){ echo "checked";} ?> /> Sunday<br/>

  		        <span class="badge-label ma-top20 p-2">Account Name: </span>
		        <input type="text" class="form-control" value="<?= $act_data['account_name']; ?>" name="account_name"  />

		        <span class="badge-label ma-top20 p-2">Account Number: </span>
		        <input type="text" class="form-control" value="<?= $act_data['account_number']; ?>" name="account_number"  />

		        <span class="badge-label ma-top20 p-2">Bank: </span>
		        <input type="text" class="form-control" value="<?= $act_data['bank']; ?>" name="bank"  />

		        <span class="badge-label ma-top20 p-2">IFSC: </span>
		        <input type="text" class="form-control" value="<?= $act_data['ifsc']; ?>" name="ifsc"  />

		        <span class="badge-label ma-top20 p-2">Gpay: </span>
		        <input type="text" class="form-control" value="<?= $act_data['gpay']; ?>" name="gpay"  />

				<span class="badge-label ma-top20 p-2">Phonepe: </span>
		        <input type="text" class="form-control" value="<?= $act_data['phonepay']; ?>" name="phonepay"  />

		        <br/><button type="submit" class="btn btn-success center-block">Submit</button>

		        <input type="text" hidden="" style="display: none;" name="seller_id" value="<?=$result_data["seller_id"]?>">
		    </form>
        </div>        
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


$('#seller_form').submit(function(e){
        e.preventDefault();
		var formData = new FormData(this);
		formData.append('action', 'update_seller_details');
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

$("#state, #location, #district").select2({
  tags: true
});

$(document).on('change','select[name=state]',function(){
  $.ajax({
    type: 'POST',
    url: 'ajax_load.php',
    data: 'action=get_district&state='+$(this).val(),
    dataType: "json",
    success: function(data){ 
    if(data['status'] == 'success'){ 
      $("select[name=district]").html(data["Data"]);
  }
  else{
    $("select[name=district]").html("<option value=''>No Data Found</option>");
    }
  },
  error: function(jqXHR, textStatus, errorThrown) {
    error_alertbox('','');
  }
  });
});

$(document).on('change','select[name=district]',function(){
  var state = $(this).parent().parent().find($("select[name=state]")).val();
  var district = $(this).val();

  $.ajax({
    type: 'POST',
    url: 'ajax_load.php',
    data: 'action=get_location&district='+district+'&state='+state,
    dataType: "json",
    success: function(data){ 
    if(data['status'] == 'success'){ 
      $("select[name=location]").html(data["Data"]);
  }
  else{
    $("select[name=location]").html("<option value=''>No Data Found</option>");
    }
  },
  error: function(jqXHR, textStatus, errorThrown) {
    error_alertbox('','');
  }
  });
});
</script>
</body>
</html>