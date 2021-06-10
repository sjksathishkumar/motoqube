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
		            <h2 class="white-text mx-3">Sellers</h2>
		        </div>
				<!-- <div class="sp_add">
				    <button id="add_form" class="btn btn-info button-addnew pull-right" data-toggle="collapse" data-target="#add_content" ><i class="fa fa-plus-circle" aria-hidden="true"></i>Add New <i class="fa fa-angle-down" aria-hidden="true"></i></button>
		            <br/><br/>

		            <div id="add_content" class="panel panel-default collapse">
		              <div class="panel-body">
		                <form method="post" id="content_add"   enctype="multipart/form-data">
		                  <div class="col-md-4 top15">
		                    <span class="badge-label info-color p-2">Make<span class="redstar">*</span></span>
		                    <input type="text" id="make" name="make" class="form-control" placeholder="Make" value="" required="">
		                  </div>
		                  <div class="col-md-4 top15">
		                    <span class="badge-label info-color p-2">Make Image<span class="redstar">*</span></span><br/>
		                    <input  type="file" name="make_image" style="margin-top: 10px;" />
		                  </div>
		                  <div class="col-md-4 pull-right" style="padding-top:5px;">
		                    <button type="submit" name="create" class="btn btn-primary btn-circle btn-lg"><i class="fa fa-check" aria-hidden="true"></i></button>
		                    <button type="reset" name="reset" class="btn btn-warning btn-circle btn-lg"><i class="fa fa-times" aria-hidden="true"></i></button>
		                  </div>
		                </form>
		              </div>
		            </div>
		        </div> -->
		        <!-- table -->
		        <div class="row">
	                <div class="panel-default">
	                  <div class="panel-body">
	                    <table id="seller_table" class="table table-striped table-hover" width="100%">
	                      <thead>
	                        <tr>
	                          <th>Id</th>  
                            <th>Seller_Id</th>                                
	                          <th>Name</th>
	                          <th>Mobile</th>                          
                            <th>Email</th>
                            <th>Shop Name</th> 
                            <th>Address</th>  
                            <th>Landmark</th> 
                            <th>Location</th>  
                            <th>District</th>  
                            <th>State</th>  
                            <th>Pincode</th> 
                            <th>Alternate Mobile</th>                          
                            <th>Commision</th>    
                            <th>Category</th>                                
                            <th>Status</th>   
	                          <th class="sp_view">View</th>
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
    function newexportaction(e, dt, button, config) {
         var self = this;
         var oldStart = dt.settings()[0]._iDisplayStart;
         dt.one('preXhr', function (e, s, data) {
             // Just this once, load all data from the server...
             data.start = 0;
             data.length = 2147483647;
             dt.one('preDraw', function (e, settings) {
                 // Call the original action function
                 if (button[0].className.indexOf('buttons-copy') >= 0) {
                     $.fn.dataTable.ext.buttons.copyHtml5.action.call(self, e, dt, button, config);
                 } else if (button[0].className.indexOf('buttons-excel') >= 0) {
                     $.fn.dataTable.ext.buttons.excelHtml5.available(dt, config) ?
                         $.fn.dataTable.ext.buttons.excelHtml5.action.call(self, e, dt, button, config) :
                         $.fn.dataTable.ext.buttons.excelFlash.action.call(self, e, dt, button, config);
                 } else if (button[0].className.indexOf('buttons-csv') >= 0) {
                     $.fn.dataTable.ext.buttons.csvHtml5.available(dt, config) ?
                         $.fn.dataTable.ext.buttons.csvHtml5.action.call(self, e, dt, button, config) :
                         $.fn.dataTable.ext.buttons.csvFlash.action.call(self, e, dt, button, config);
                 } else if (button[0].className.indexOf('buttons-pdf') >= 0) {
                     $.fn.dataTable.ext.buttons.pdfHtml5.available(dt, config) ?
                         $.fn.dataTable.ext.buttons.pdfHtml5.action.call(self, e, dt, button, config) :
                         $.fn.dataTable.ext.buttons.pdfFlash.action.call(self, e, dt, button, config);
                 } else if (button[0].className.indexOf('buttons-print') >= 0) {
                     $.fn.dataTable.ext.buttons.print.action(e, dt, button, config);
                 }
                 dt.one('preXhr', function (e, s, data) {
                     // DataTables thinks the first item displayed is index 0, but we're not drawing that.
                     // Set the property to what it was before exporting.
                     settings._iDisplayStart = oldStart;
                     data.start = oldStart;
                 });
                 // Reload the grid with the original page. Otherwise, API functions like table.cell(this) don't work properly.
                 setTimeout(dt.ajax.reload, 0);
                 // Prevent rendering of the full data to the DOM
                 return false;
             });
         });
         // Requery the server with the new one-time export settings
         dt.ajax.reload();
     }
  
  window.addEventListener('load', function(){
  $('#seller_table').dataTable({
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
    "ajax": "ajax_table_load.php?action=seller_table",
    dom: 'Bldfrtip',
    "stateSave": true,
        buttons: [{
            "extend": 'excel',
            "text": '<i class="fa fa-file-excel-o" style="color: green;"></i>  Excel',
            "titleAttr": 'Excel',
            "action": newexportaction
        },
        {
            extend: 'colvis',            
            text: "<i class='fa fa-table''></i> Customize Grid",
            postfixButtons: [ 'colvisRestore' ],
            collectionLayout: 'fixed two-column',
            'colVis': {
                'buttonText': 'Toon / verberg kolommen',
                'overlayFade': 0,
                'exclude': [ 0 ]
            },
        }
        ]
  });
});
$(document).on('click', '.btnTableEdit', function( event ) {
    event.preventDefault();
    var value = $(this).attr('data-id');
    $.ajax({
        url: 'ajax_load.php',
        type: 'POST',
        data: 'action=edit_car_make&id='+value,
        dataType: 'html'
    })
    .done(function(data){
       $('#edit_details').empty().append(data); 
    })
    $('#myModal').modal('show');
    return false;
});
</script>
</body>
</html>