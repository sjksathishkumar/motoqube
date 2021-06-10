<?php include 'inc-meta.php';
if(isset($_GET["id"])){  $sb_id = $_GET["id"]; }
else{  header('Location: index.php'); }

if (isset($_POST['update'])) {
$roles = (object)[];
  $roles->dashboard_view=isset($_REQUEST['dashboard_view'])?$_REQUEST['dashboard_view']:"0";

  $roles->vehicle_view=isset($_REQUEST['vehicle_view'])?$_REQUEST['vehicle_view']:"0";
  $roles->vehicle_add=isset($_REQUEST['vehicle_add'])?$_REQUEST['vehicle_add']:"0";
  $roles->vehicle_edit=isset($_REQUEST['vehicle_edit'])?$_REQUEST['vehicle_edit']:"0";
  $roles->vehicle_delete=isset($_REQUEST['vehicle_delete'])?$_REQUEST['vehicle_delete']:"0";
  $roles->sellers_view=isset($_REQUEST['sellers_view'])?$_REQUEST['sellers_view']:"0";
  $roles->sellers_edit=isset($_REQUEST['sellers_edit'])?$_REQUEST['sellers_edit']:"0";
  $roles->sellers_delete=isset($_REQUEST['sellers_delete'])?$_REQUEST['sellers_delete']:"0";
  $roles->buyers_view=isset($_REQUEST['buyers_view'])?$_REQUEST['buyers_view']:"0";
  $roles->buyers_edit=isset($_REQUEST['buyers_edit'])?$_REQUEST['buyers_edit']:"0";
  $roles->buyers_delete=isset($_REQUEST['buyers_delete'])?$_REQUEST['buyers_delete']:"0";
  $roles->banners_view=isset($_REQUEST['banners_view'])?$_REQUEST['banners_view']:"0";
  $roles->banners_add=isset($_REQUEST['banners_add'])?$_REQUEST['banners_add']:"0";
  $roles->banners_delete=isset($_REQUEST['banners_delete'])?$_REQUEST['banners_delete']:"0";
  $roles->bookings_view=isset($_REQUEST['bookings_view'])?$_REQUEST['bookings_view']:"0";
  $roles->bookings_edit=isset($_REQUEST['bookings_edit'])?$_REQUEST['bookings_edit']:"0";
  $roles->bookings_delete=isset($_REQUEST['bookings_delete'])?$_REQUEST['bookings_delete']:"0";
  $roles->locations_view=isset($_REQUEST['locations_view'])?$_REQUEST['locations_view']:"0";
  $roles->locations_add=isset($_REQUEST['locations_add'])?$_REQUEST['locations_add']:"0";
  $roles->locations_edit=isset($_REQUEST['locations_edit'])?$_REQUEST['locations_edit']:"0";
  $roles->locations_delete=isset($_REQUEST['locations_delete'])?$_REQUEST['locations_delete']:"0";
  $roles->popular_view=isset($_REQUEST['popular_view'])?$_REQUEST['popular_view']:"0";
  $roles->popular_add=isset($_REQUEST['popular_add'])?$_REQUEST['popular_add']:"0";
  $roles->popular_edit=isset($_REQUEST['popular_edit'])?$_REQUEST['popular_edit']:"0";
  $roles->popular_delete=isset($_REQUEST['popular_delete'])?$_REQUEST['popular_delete']:"0";
  $roles->contents_view=isset($_REQUEST['contents_view'])?$_REQUEST['contents_view']:"0";
  $roles->contents_edit=isset($_REQUEST['contents_edit'])?$_REQUEST['contents_edit']:"0";
  $roles->contents_delete=isset($_REQUEST['contents_delete'])?$_REQUEST['contents_delete']:"0";
  $roles->settings_view=isset($_REQUEST['settings_view'])?$_REQUEST['settings_view']:"0";
  $roles->settings_edit=isset($_REQUEST['settings_edit'])?$_REQUEST['settings_edit']:"0";

  $roles =json_encode($roles);

    $update_array = array(
      'rights' => $roles,          
    );
            
    $action_result = $db->updateAry('sp_subadmin', $update_array, "where sb_id='".$sb_id."'");
    if( !is_null($action_result) )
    {
      $data_message = "Details updated successfully";

       json_encode( array('status'=>'success','result'=>$data_message) );
    }
    else
    {
      $data_message = "Details is not updated successfully. Please try again";

       json_encode( array('status'=>'error','result'=>$data_message) );
    }
}
unset($_POST);


$result_data = $db->getRow("select * from sp_subadmin where sb_id='".$sb_id."' Limit 1");
  if(count($result_data) > 0){ } else{ header('Location: index.php'); }
  $rights = (object) json_decode($result_data['rights']);
  $dashboard_view = (isset($rights->dashboard_view) && !empty($rights->dashboard_view) && $rights->dashboard_view != null)?$rights->dashboard_view:"0";

  $vehicle_view = (isset($rights->vehicle_view) && !empty($rights->vehicle_view) && $rights->vehicle_view != null)?$rights->vehicle_view:"0";
  $vehicle_add = (isset($rights->vehicle_add) && !empty($rights->vehicle_add) && $rights->vehicle_add != null)?$rights->vehicle_add:"0";
  $vehicle_edit = (isset($rights->vehicle_edit) && !empty($rights->vehicle_edit) && $rights->vehicle_edit != null)?$rights->vehicle_edit:"0";
  $vehicle_delete = (isset($rights->vehicle_delete) && !empty($rights->vehicle_delete) && $rights->vehicle_delete != null)?$rights->vehicle_delete:"0";

  $sellers_view= (isset($rights->sellers_view) && !empty($rights->sellers_view) && $rights->sellers_view != null)?$rights->sellers_view:"0";
  $sellers_edit= (isset($rights->sellers_edit) && !empty($rights->sellers_edit) && $rights->sellers_edit != null)?$rights->sellers_edit:"0";
  $sellers_delete= (isset($rights->sellers_delete) && !empty($rights->sellers_delete) && $rights->sellers_delete != null)?$rights->sellers_delete:"0";
  $buyers_view= (isset($rights->buyers_view) && !empty($rights->buyers_view) && $rights->buyers_view != null)?$rights->buyers_view:"0";
  $buyers_edit= (isset($rights->buyers_edit) && !empty($rights->buyers_edit) && $rights->buyers_edit != null)?$rights->buyers_edit:"0";
  $buyers_delete= (isset($rights->buyers_delete) && !empty($rights->buyers_delete) && $rights->buyers_delete != null)?$rights->buyers_delete:"0";
  $banners_view= (isset($rights->banners_view) && !empty($rights->banners_view) && $rights->banners_view != null)?$rights->banners_view:"0";
  $banners_add= (isset($rights->banners_add) && !empty($rights->banners_add) && $rights->banners_add != null)?$rights->banners_add:"0";
  $banners_delete= (isset($rights->banners_delete) && !empty($rights->banners_delete) && $rights->banners_delete != null)?$rights->banners_delete:"0";
  $bookings_view= (isset($rights->bookings_view) && !empty($rights->bookings_view) && $rights->bookings_view != null)?$rights->bookings_view:"0";
  $bookings_edit= (isset($rights->bookings_edit) && !empty($rights->bookings_edit) && $rights->bookings_edit != null)?$rights->bookings_edit:"0";
  $bookings_delete= (isset($rights->bookings_delete) && !empty($rights->bookings_delete) && $rights->bookings_delete != null)?$rights->bookings_delete:"0";
  $locations_view= (isset($rights->locations_view) && !empty($rights->locations_view) && $rights->locations_view != null)?$rights->locations_view:"0";
  $locations_add= (isset($rights->locations_add) && !empty($rights->locations_add) && $rights->locations_add != null)?$rights->locations_add:"0";
  $locations_edit= (isset($rights->locations_edit) && !empty($rights->locations_edit) && $rights->locations_edit != null)?$rights->locations_edit:"0";
  $locations_delete= (isset($rights->locations_delete) && !empty($rights->locations_delete) && $rights->locations_delete != null)?$rights->locations_delete:"0";
  $popular_view= (isset($rights->popular_view) && !empty($rights->popular_view) && $rights->popular_view != null)?$rights->popular_view:"0";
  $popular_add= (isset($rights->popular_add) && !empty($rights->popular_add) && $rights->popular_add != null)?$rights->popular_add:"0";
  $popular_edit= (isset($rights->popular_edit) && !empty($rights->popular_edit) && $rights->popular_edit != null)?$rights->popular_edit:"0";
  $popular_delete= (isset($rights->popular_delete) && !empty($rights->popular_delete) && $rights->popular_delete != null)?$rights->popular_delete:"0";
  $contents_view= (isset($rights->contents_view) && !empty($rights->contents_view) && $rights->contents_view != null)?$rights->contents_view:"0";
  $contents_edit= (isset($rights->contents_edit) && !empty($rights->contents_edit) && $rights->contents_edit != null)?$rights->contents_edit:"0";
  $contents_delete= (isset($rights->contents_delete) && !empty($rights->contents_delete) && $rights->contents_delete != null)?$rights->contents_delete:"0";
  $settings_view= (isset($rights->settings_view) && !empty($rights->settings_view) && $rights->settings_view != null)?$rights->settings_view:"0";
  $settings_edit= (isset($rights->settings_edit) && !empty($rights->settings_edit) && $rights->settings_edit != null)?$rights->settings_edit:"0";
?>
<style type="text/css">
  .table-bordered>thead>tr>th, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>tbody>tr>td, .table-bordered>tfoot>tr>td{
    border: 1px solid #ddd !important;
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
            <div class="gradient-card-header">
                <h2 class="white-text mx-3">Roles & Rights</h2>
            </div>
            <!-- table -->
            <div class="row">
                  <div class="panel-default">
                    <div class="panel-body">
                      <form method="post">

                        <div class="pull-right">
                          <button class="btn blue-gradient button-save" title="Save" type="submit" name="update"><i class="fa fa-check" aria-hidden="true"></i>Save</button>
                          <button type="reset" title="Cancel" class="btn danger-gradient button-cancel"><i class="fa fa-times" aria-hidden="true"></i>Cancel</button><br/><br/>
                        </div>

                      <table id="subadmin_table" class="table table-bordered table-striped table-hover" width="100%">
                        <thead>
                          <tr>
                            <th>Name</th>                       
                            <th>View</th>
                            <th>Add</th>                            
                            <th>Edit</th>
                            <th>Delete</th>                           
                          </tr>
                        </thead>
                        <tbody>                       
                          <tr>
                            <th>Dashboard</th>
                            <td colspan="4"> 
                              <label class="container1">            
                                <input type="checkbox" name="dashboard_view" value="1" <?php if($dashboard_view=="1"){ echo "checked";} ?>>
                                <span class="checkmark"></span>
                              </label>
                            </td>                            
                          </tr>
                          <tr>
                            <th>Vehicle Details</th>
                            <td>
                               <label class="container1">            
                                <input type="checkbox" name="vehicle_view" value="1" <?php if($vehicle_view=="1"){ echo "checked";} ?>>
                                <span class="checkmark"></span>
                              </label>
                            </td>
                            <td>
                               <label class="container1">            
                                <input type="checkbox" name="vehicle_add" value="1" <?php if($vehicle_add=="1"){ echo "checked";} ?>>
                                <span class="checkmark"></span>
                              </label>
                            </td>                          
                            <td>
                               <label class="container1">            
                                <input type="checkbox" name="vehicle_edit" value="1" <?php if($vehicle_edit=="1"){ echo "checked";} ?>>
                                <span class="checkmark"></span>
                              </label>
                            </td>
                            <td>
                               <label class="container1">            
                                <input type="checkbox" name="vehicle_delete" value="1" <?php if($vehicle_delete=="1"){ echo "checked";} ?>>
                                <span class="checkmark"></span>
                              </label>
                            </td>                          
                          </tr>
                          <tr>
                            <th>Sellers</th>
                            <td>
                               <label class="container1">            
                                <input type="checkbox" name="sellers_view" value="1" <?php if($sellers_view=="1"){ echo "checked";} ?>>
                                <span class="checkmark"></span>
                              </label>
                            </td>
                            <td colspan="2">
                              <label class="container1">            
                                <input type="checkbox" name="sellers_edit" value="1" <?php if($sellers_edit=="1"){ echo "checked";} ?>>
                                <span class="checkmark"></span>
                              </label>
                            </td>
                            <td>
                               <label class="container1">            
                                <input type="checkbox" name="sellers_delete" value="1" <?php if($sellers_delete=="1"){ echo "checked";} ?>>
                                <span class="checkmark"></span>
                              </label>
                            </td>                             
                          </tr>
                          <tr>
                            <th>Buyers</th>
                            <td>
                               <label class="container1">            
                                <input type="checkbox" name="buyers_view" value="1" <?php if($buyers_view=="1"){ echo "checked";} ?>>
                                <span class="checkmark"></span>
                              </label>
                            </td>
                            <td colspan="2">
                              <label class="container1">            
                                <input type="checkbox" name="buyers_edit" value="1" <?php if($buyers_edit=="1"){ echo "checked";} ?>>
                                <span class="checkmark"></span>
                              </label>
                            </td>
                            <td>
                               <label class="container1">            
                                <input type="checkbox" name="buyers_delete" value="1" <?php if($buyers_delete=="1"){ echo "checked";} ?>>
                                <span class="checkmark"></span>
                              </label>
                            </td> 
                          </tr>
                          <tr>
                            <th>Banners</th>
                            <td>
                               <label class="container1">            
                                <input type="checkbox" name="banners_view" value="1" <?php if($banners_view=="1"){ echo "checked";} ?>>
                                <span class="checkmark"></span>
                              </label>
                            </td>
                            <td colspan="2">
                               <label class="container1">            
                                <input type="checkbox" name="banners_add" value="1" <?php if($banners_add=="1"){ echo "checked";} ?>>
                                <span class="checkmark"></span>
                              </label>
                            </td>
                            <td>
                               <label class="container1">            
                                <input type="checkbox" name="banners_delete" value="1" <?php if($banners_delete=="1"){ echo "checked";} ?>>
                                <span class="checkmark"></span>
                              </label>
                            </td> 
                          </tr>
                          <tr>
                            <th>Bookings</th>
                            <td>
                               <label class="container1">            
                                <input type="checkbox" name="bookings_view" value="1" <?php if($bookings_view=="1"){ echo "checked";} ?>>
                                <span class="checkmark"></span>
                              </label>
                            </td>
                            <td colspan="2">
                               <label class="container1">            
                                <input type="checkbox" name="bookings_edit" value="1" <?php if($bookings_edit=="1"){ echo "checked";} ?>>
                                <span class="checkmark"></span>
                              </label>
                            </td>
                            <td>
                              <label class="container1">            
                                <input type="checkbox" name="bookings_delete" value="1" <?php if($bookings_delete=="1"){ echo "checked";} ?>>
                                <span class="checkmark"></span>
                              </label>
                            </td> 
                          </tr>
                          <tr>
                            <th>Locations</th>
                            <td>
                               <label class="container1">            
                                <input type="checkbox" name="locations_view" value="1" <?php if($locations_view=="1"){ echo "checked";} ?>>
                                <span class="checkmark"></span>
                              </label>
                            </td>
                            <td>
                               <label class="container1">            
                                <input type="checkbox" name="locations_add" value="1" <?php if($locations_add=="1"){ echo "checked";} ?>>
                                <span class="checkmark"></span>
                              </label>
                            </td>
                            <td>
                               <label class="container1">            
                                <input type="checkbox" name="locations_edit" value="1" <?php if($locations_edit=="1"){ echo "checked";} ?>>
                                <span class="checkmark"></span>
                              </label>
                            </td>
                            <td>
                               <label class="container1">            
                                <input type="checkbox" name="locations_delete" value="1" <?php if($locations_delete=="1"){ echo "checked";} ?>>
                                <span class="checkmark"></span>
                              </label>
                            </td> 
                          </tr>
                          <tr>
                            <th>Popular Locations</th>
                            <td>
                              <label class="container1">            
                                <input type="checkbox" name="popular_view" value="1" <?php if($popular_view=="1"){ echo "checked";} ?>>
                                <span class="checkmark"></span>
                              </label>
                            </td>
                            <td>
                               <label class="container1">            
                                <input type="checkbox" name="popular_add" value="1" <?php if($popular_add=="1"){ echo "checked";} ?>>
                                <span class="checkmark"></span>
                              </label>
                            </td>
                            <td>
                              <label class="container1">            
                                <input type="checkbox" name="popular_edit" value="1" <?php if($popular_edit=="1"){ echo "checked";} ?>>
                                <span class="checkmark"></span>
                              </label>
                            </td> 
                            <td>
                              <label class="container1">            
                                <input type="checkbox" name="popular_delete" value="1" <?php if($popular_delete=="1"){ echo "checked";} ?>>
                                <span class="checkmark"></span>
                              </label>
                            </td>
                          </tr> 
                          <tr>
                            <th>Contents</th>
                            <td>
                              <label class="container1">            
                                <input type="checkbox" name="contents_view" value="1" <?php if($contents_view=="1"){ echo "checked";} ?>>
                                <span class="checkmark"></span>
                              </label>
                            </td>
                            <td colspan="2">
                              <label class="container1">            
                                <input type="checkbox" name="contents_edit" value="1" <?php if($contents_edit=="1"){ echo "checked";} ?>>
                                <span class="checkmark"></span>
                              </label>
                            </td>
                            <td>
                              <label class="container1">            
                                <input type="checkbox" name="contents_delete" value="1" <?php if($contents_delete=="1"){ echo "checked";} ?>>
                                <span class="checkmark"></span>
                              </label>
                            </td>
                          </tr> 
                          <tr>
                            <th>Settings</th>
                             <td>
                              <label class="container1">            
                                <input type="checkbox" name="settings_view" value="1" <?php if($settings_view=="1"){ echo "checked";} ?>>
                                <span class="checkmark"></span>
                              </label>
                            </td>
                            <td colspan="3">
                              <label class="container1">            
                                <input type="checkbox" name="settings_edit" value="1" <?php if($settings_edit=="1"){ echo "checked";} ?>>
                                <span class="checkmark"></span>
                              </label>
                            </td>
                          </tr>                          
                        </tbody>
                      </table>
                      </form>
                    </div>
                  </div>
              </div>
        </div>
        <!-- table -->
    </div>      
  </div>
</div>


    <!-- Modal -->
<div class="modal fade sp_edit" id="edit_custom_model" role="dialog">
  <div class="modal-dialog cascading-modal" role="document">
    <div class="modal-content">
      <div class="modal-header light-blue darken-3 white-text">
          <button type="button" class="close waves-effect waves-light" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
          <h4 class="title"><i class="fa fa-pencil-alt"></i> EDIT</h4>
      </div>
      <div class="modal-body mb-0">
        <form id="edit_custom_form" method="post" enctype="multipart/form-data">
          <div style="margin-bottom: 15px" ><div class="row" id="edit_details"></div></div>
          <div class="text-center">
            <button type="submit" name="update"  class=" btn btn-success button-update btnModalEdit"><i class="fa fa-check" aria-hidden="true"></i>Update</button>
            <button type="button" data-dismiss="modal" class="btn btn-warning button-cancel"><i class="fa fa-times"></i>Cancel</button>
          </div>
          <br/>
        </form>
       </div>
    </div>
  </div>
</div>
<?php include 'inc-script.php'; ?>
<script type="text/javascript">
$(document).on('click', '.btnTableEdit', function( event ) {
    event.preventDefault();
    var value = $(this).attr('data-id');
    $.ajax({
        url: 'ajax_load.php',
        type: 'POST',
        data: 'action=edit_subadmin&id='+value,
        dataType: 'html'
    })
    .done(function(data){
       $('#edit_details').empty().append(data); 
    })
    $('#myModal').modal('show');
    return false;
});

$(document).ready(function(e){
    $("#content_add").on('submit', function(e){
        e.preventDefault();
    var formData = new FormData(this);
    formData.append('action', 'insert_subadmin');
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
              success_alertbox('','Insert');
          }
          else{
              error_alertbox('','Insert');
            }
            },
          error: function(jqXHR, textStatus, errorThrown) {
            error_alertbox('','');
             
          }
      })
  });
    $("#edit_custom_form").on('submit', function(e){
        e.preventDefault();
    var formData = new FormData(this);
    formData.append('action', 'update_subadmin');
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
    })
});
});
</script>
</body>
</html>