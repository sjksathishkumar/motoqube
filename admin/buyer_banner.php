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
		            <h2 class="white-text mx-3">Buyer App Banner</h2>
		        </div>
				<div class="sp_add">
				    <button id="add_form" class="btn btn-info button-addnew pull-right" data-toggle="collapse" data-target="#add_content" ><i class="fa fa-plus-circle" aria-hidden="true"></i>Add New <i class="fa fa-angle-down" aria-hidden="true"></i></button>
		            <br/><br/>

		            <div id="add_content" class="panel panel-default collapse">
		              <div class="panel-body">
		                <form method="post" id="content_add"   enctype="multipart/form-data">
		                  <div class="col-md-3 top15">
		                    <span class="badge-label info-color p-2">Image<span class="redstar">*</span></span><br/>
		                    <input  type="file" name="image" style="margin-top: 10px;" required="" />
		                  </div>
		                  <div class="col-md-3 pull-right" style="padding-top:5px;">
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
	                    <table id="buyer_banner_table" class="table table-striped table-hover" width="100%">
	                      <thead>
	                        <tr>
	                          <th>Id</th>   
	                          <th>Image</th>             
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

<?php include 'inc-script.php'; ?>
<script type="text/javascript">
  window.addEventListener('load', function(){
  $('#buyer_banner_table').dataTable({
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
    "ajax": "ajax_table_load.php?action=buyer_banner_table",
    "dom": 'ldfrtip'
  });
});
$(document).ready(function(e){
    $("#content_add").on('submit', function(e){
        e.preventDefault();
		var formData = new FormData(this);
		formData.append('action', 'insert_buyer_banner');
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
    
});
</script>
</body>
</html>