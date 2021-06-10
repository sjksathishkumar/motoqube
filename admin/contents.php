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
		            <h2 class="white-text mx-3">Contents List</h2>
		        </div>
		        <!-- table -->
		        <div class="row">
	                <div class="panel-default">
	                  <div class="panel-body">
	                    <table id="content_table" class="table table-striped table-hover" width="100%">
	                      <thead>
	                        <tr>
	                           <th>ID</th>   
	                            <th>Section</th>
	                          	<th>Content</th>
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
  <div class="modal-dialog cascading-modal modal-lg" role="document">
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
  $('#content_table').dataTable({
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
    "ajax": "ajax_table_load.php?action=content_table",
    "dom": 'ldfrtip',
    "stateSave": true,
  });
});
$(document).on('click', '.btnTableEdit', function( event ) {
    event.preventDefault();
    var value = $(this).attr('data-id');
    $.ajax({
        url: 'ajax_load.php',
        type: 'POST',
        data: 'action=edit_content&id='+value,
        dataType: 'html'
    })
    .done(function(data){
       $('#edit_details').empty().append(data); 

       CKEDITOR.replace('content');

    })
    $('#myModal').modal('show');
    return false;
});

$(document).ready(function(e){
    $("#edit_custom_form").on('submit', function(e){
        e.preventDefault();
         for ( instance in CKEDITOR.instances )
        CKEDITOR.instances[instance].updateElement();
    		var formData = new FormData(this);
    		formData.append('action', 'update_content');
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