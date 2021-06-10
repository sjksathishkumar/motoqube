<?php if(isset($_GET["buyer"])){$buyer_id = $_GET["buyer"];}else{header('Location: index.php');}  
include 'inc-meta.php';
$result_data = $db->getRow("select * from sp_buyer where buyer_id='".$buyer_id."' Limit 1");
if(count($result_data) > 0){ } else{ header('Location: index.php'); }?>
</head>
<body>
<!--------------------->
<div id="wrapper">
    <?php include 'inc_leftmenubar.php'; ?>
	<div id="page-wrapper">
		<div class="container-fluid">
	        <div class="row panel panel-default page-wrapper-panel">
		        <div class="gradient-card-header">
		            <h2 class="white-text mx-3">Buyer - <?=$result_data['name']?></h2>
		        </div>
				<button class="btn btn-info" onclick="window.location.href='buyers.php'"><i class="fa fa-angle-left"></i> Go Back</button><br/><br/>

		         <ul class="nav nav-tabs custom-nav-tabs" id="myTab">
                      <li class="active"><a data-toggle="tab" href="#tab_menu1">Profile</a></li>
                      <!-- <li><a data-toggle="tab" href="#tab_menu2">Products</a></li> -->
                      <!-- <li><a data-toggle="tab" href="#tab_menu3">Orders</a></li> -->
                    </ul>

                    <div class="tab-content">                      
                      <div id="tab_menu1" class="tab-pane fade in active">
                      	  	<div class="col-lg-12 sp_edit top15"><button class="btn btn-primary  pull-right" data-toggle="modal" data-target="#edit_buyer"><i class="fa fa-pen"></i> Edit</button></div>
                      		<div class="col-lg-6">
                                <div class="card-details custom-box-shadow" style="margin-bottom: 25px;">
                                  <div class="header">Personal Details</div>
	                                <div class="row" style="padding: 0px 22px 10px 22px;">
	                                	<p class="col-lg-12"><b>Date Of Joining: </b><?= date('d-m-Y h:i a',strtotime($result_data['dateandtime']));  ?></p>
		                                <p class="col-lg-12"><b>Buyer ID: </b><?= buyerid($result_data['buyer_id']);  ?></p>
		                                <p class="col-lg-12"><b>Name: </b><?= $result_data['name']; ?></p>
		                                <p class="col-lg-12"><b>Email: </b><?= $result_data['email']; ?></p>
		                                <p class="col-lg-12"><b>Mobile: </b><?= $result_data['mobile']; ?></p>
		                                <p class="col-lg-12"  style="line-height: 2.0"><b>Address: </b><?= $result_data['address']; ?></p>
		                                <p class="col-lg-12"><b>Landmark: </b><?= $result_data['landmark']; ?></p>
		                                <p class="col-lg-12"><b>City: </b><?= $result_data['city']; ?></p>
		                                <p class="col-lg-12"><b>State: </b><?= $result_data['state']; ?></p>
		                                <p class="col-lg-12"><b>Pincode: </b><?= $result_data['pincode']; ?></p>
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
		                                <div class="col-md-12 sp_edit">
		                                	<input type="text" name="buyer_id" value="<?= $buyer_id ?>" hidden="" />
		                                	<button type="submit" name="submit_credential" class="btn btn-success center-block" style="margin-top: 20px;">Submit</button>
		                            	</div>
		                                </form>		                                
		                            </div>
		                        </div>
		                    </div>
                      </div>
                      <div id="tab_menu2" class="tab-pane fade">
                      </div>
                    </div>
                  </div>
		       
	    	</div>
	    	<!-- table -->
		</div>	    
	</div>
</div>




  <div class="modal sp_edit" id="edit_buyer">
    <div class="modal-dialog modal-dialog cascading-modal">
      <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header light-blue darken-3 white-text">
          <h4 class="modal-title">Edit Buyer</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
        	<form method="post" id="buyer_form">
   				<span class="badge-label ma-top20 p-2">Name:</span>
   				<input type="text" class="form-control" value="<?= $result_data['name']; ?>" name="name"  />

		        <span class="badge-label ma-top20 p-2">Email: </span>
		        <input type="text" class="form-control" value="<?= $result_data['email']; ?>" name="email" />

		        <span class="badge-label ma-top20 p-2">Mobile: </span>
		        <input type="text" class="form-control" value="<?= $result_data['mobile']; ?>" name="mobile"  />

		        <span class="badge-label ma-top20 p-2">Alternate Mobile: </span>
		        <input type="text" class="form-control" value="<?= $result_data['alternate_mobile']; ?>" name="alternate_mobile" />
		       
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

		        <br/><button type="submit" class="btn btn-success center-block">Submit</button>

		        <input type="text" hidden="" style="display: none;" name="buyer_id" value="<?=$result_data["buyer_id"]?>">
		    </form>
        </div>        
      </div>
    </div>
  </div>
<?php include 'inc-script.php'; ?>
<script type="text/javascript">
$('#credential-update').submit(function(e){
        e.preventDefault();
		var formData = new FormData(this);
		formData.append('action', 'update_buyer_credentials');
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


$('#buyer_form').submit(function(e){
        e.preventDefault();
		var formData = new FormData(this);
		formData.append('action', 'update_buyer_details');
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
    data: 'action=get_buyer_district&state='+$(this).val(),
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
    data: 'action=get_buyer_location&district='+district+'&state='+state,
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