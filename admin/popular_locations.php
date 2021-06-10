<?php include 'inc-meta.php'; ?>
</head>
<body>
<!--------------------->
<div id="wrapper">
    <?php include 'inc_leftmenubar.php'; ?>
	<div id="page-wrapper">
		<div class="container-fluid">
	        <div class="row panel panel-default page-wrapper-panel">
		        <div class="gradient-card-header">
		            <h2 class="white-text mx-3">Popular Locations In India</h2>
		        </div>
				<div class="sp_add">
				    <button id="add_form" class="btn btn-info button-addnew pull-right" data-toggle="collapse" data-target="#add_content" ><i class="fa fa-plus-circle" aria-hidden="true"></i>Add New <i class="fa fa-angle-down" aria-hidden="true"></i></button>
		            <br/><br/>

		            <div id="add_content" class="panel panel-default collapse">
		              <div class="panel-body">
		                <form method="post" id="content_add"   enctype="multipart/form-data">
		                  <div class="col-md-4 top15">
		                    <span class="badge-label info-color p-2">Popular Location<span class="redstar">*</span></span>
		                    <input type="text" id="popularlocation" name="popularlocation" class="form-control" placeholder="Popular Location" value="" required="">
		                  </div>
		                 
		                  <div class="col-md-4 pull-right" style="padding-top:5px;">
		                    <button type="submit" name="create" class="btn btn-primary btn-circle btn-lg"><i class="fa fa-check" aria-hidden="true"></i></button>
		                    <button type="reset" name="reset" class="btn btn-warning btn-circle btn-lg"><i class="fa fa-times" aria-hidden="true"></i></button>
		                  </div>
		                </form>
		              </div>
		            </div>
		        </div>
		        <!-- table -->
		        <div class="row">
	                <div class="panel-default">
	                  <div class="panel-body">
	                    <table id="location_table" class="table table-striped table-hover" width="100%">
	                      <thead>
	                        <tr>
	                          <th>ID</th>   
	                          <th>Popular Location</th>
	                          <th class="sp_edit">Edit</th>
	                          <th class="sp_delete">Delete</th>	                          
	                        </tr>
	                      </thead>
	                      <tbody>                       
	                      </tbody>
	                    </table>
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
  window.addEventListener('load', function(){
  $('#location_table').dataTable({
    "destroy": true,
    "retrieve": true,
    "responsive": true,
    "ordering": true,
    "searching": true,
    "sDom":"tpr",
    "lengthChange": true,
    "lengthMenu": [[25, 50, 100, 500, 1000],[25, 50, 100, 500, 1000]],
    "pageLength": 100,
    "processing": true,
    "serverSide": true,
    "bAutoWidth": false,
    "ajax": "ajax_table_load.php?action=popularlocation_table",
    "dom": 'ldfrtip'
  });
});
$(document).on('click', '.btnTableEdit', function( event ) {
    event.preventDefault();
    var value = $(this).attr('data-id');
    $.ajax({
        url: 'ajax_load.php',
        type: 'POST',
        data: 'action=edit_popularlocation&id='+value,
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
		formData.append('action', 'insert_popularlocation');
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
		formData.append('action', 'update_popularlocation');
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