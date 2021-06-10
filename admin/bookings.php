<?php include 'inc-meta.php';
$ext_qry="1!=2";
  if (isset($_POST['search'])){ 

                        if(empty($_REQUEST['date_from']) && !empty($_REQUEST['date_to']))
                        {   
                          echo " <script>alert('Both From and To Date is to be selected.');</script>";  
                           redirect('bookings.php');    
                        } 
                        if(!empty($_REQUEST['date_from']) && empty($_REQUEST['date_to']))
                        {   
                          echo " <script>alert('Both From and To Date is to be selected.');</script>"; 
                          redirect('bookings.php');        
                        } 
                       
                        if(!empty($_REQUEST['src_name']) )
                        { 
                         $ext_qry.= " and a.buyer_id = '" .$_REQUEST['src_name']."' ";
                        }

                        if(!empty($_REQUEST['date_from']) )
                        { 
                         $ext_qry.= " and substring(a.dateandtime,1,10) between '".$_REQUEST['date_from']."' ";  
                        }

                        if(!empty($_REQUEST['date_to']))
                        { 
                         $ext_qry.= " and  '".$_REQUEST['date_to']."' ";    
                        }

                        if(!empty($_REQUEST['src_status']) )
                        { 
                         $ext_qry.= " and a.status = '" .$_REQUEST['src_status']."' ";
                        }
                         if(!empty($_REQUEST['src_seller']) )
                        { 
                         $ext_qry.= " and a.seller_id = '" .$_REQUEST['src_seller']."' ";
                        }
                    } ?>
</head>
<body>
<!--------------------->
<div id="wrapper">
    <?php include 'inc_leftmenubar.php'; ?>
	<div id="page-wrapper">
		<div class="container-fluid">
	        <div class="row panel panel-default page-wrapper-panel">
		        <div class="gradient-card-header">
		            <h2 class="white-text mx-3">Bookings</h2>
		        </div>


                         <div id="accordion2" class="panel-group accordion accordion-color">
            <div class="panel panel-info md-editor-no-dashed">
            <div class="panel-heading panel-full-primary" data-toggle="collapse" data-parent="#accordion2" href="#collapse-1" style="cursor: pointer">
            <h4 class="panel-title"><i class=" fa fa-chevron-down"></i> Advanced Search &nbsp;&nbsp;&nbsp;<i class="mdi mdi-search"></i></h4>
            </div>
            <div id="collapse-1" class="panel-collapse collapse" aria-expanded="true" style="">
            <div class="panel-body">

            <form method="post">
            <div class="col-md-3 mgt-20">
            <label>Buyer Name</label><br/>
            <select name="src_name" class="select2">
            <option value="">Select Name</option>
            <?php 
             $users = $db->getRows("SELECT buyer_id,name from sp_buyer order by name");
                if( count($users) > 0){
                  foreach($users as $data){ 
                    $name = $data["name"];
                    echo '<option value="'.$data["buyer_id"].'">'.$name.' ('.buyerid($data["buyer_id"]).')</option>';
                }
              }
            ?>
            </select>
            </div>
           
           <div class="col-md-3 mgt-20">
            <label>Seller Name</label><br/>
            <select name="src_seller" class="select2">
            <option value="">Select Name</option>
            <?php 
             $users = $db->getRows("SELECT seller_id,name from sp_seller order by name");
                if( count($users) > 0){
                  foreach($users as $data){ 
                    $name = $data["name"];
                    echo '<option value="'.$data["seller_id"].'">'.$name.' ('.sellerid($data["seller_id"]).')</option>';
                }
              }
            ?>
            </select>
            </div>
            
            <div class="col-md-3 mgt-20">
            <label>Date From</label>
            <input type="date" class="form-control" name="date_from" data-provide="datepicker">
            </div>
            <div class="col-md-3 mgt-20">
            <label>Date To</label>
            <input type="date" class="form-control" name="date_to" data-provide="datepicker">
            <br>
            </div>

             
             <div class="col-md-3 mgt-20">
            <label>Status</label><br/>
            <select name="src_status" class="select2">
            <option value="">Choose Status</option>                
            <?php
                $bk_status = $db->getRows("select status_name from sp_booking_status order by priority");
                if(count($bk_status)>0){
                foreach ($bk_status as $key => $value) { ?>
                    <option value="<?=$value['status_name']?>"><?=$value['status_name']?></option>
                <?php } } ?>  
            </select>
            <br>
            </div> 
            <div class="pull-right">
            <button class="btn btn-primary" type="submit" name="search" id="btn-search-filter"><i class="fa fa-search"></i> Search</button>
            <button class="btn btn-warning" type="reset" name="cancel" id="btn-search-reset"><i class="fa fa-times"></i> Cancel</button>
            <br>
            </div>
            </form>


            </div>
            </div>
            </div>
          </div>

			
		        <div class="row">
	                <div class="panel-default">
	                  <div class="panel-body">
	                    <table id="booking_table" class="table table-striped table-hover" width="100%">
	                      <thead>
	                        <tr>
	                          <th>Id</th>  
	                          <th>Booking_Id</th>
                              <th>Buyer_Id</th>  
                              <th>Buyer_Name</th>  
	                          <th>Mobile</th>
                              <th>Catgeory</th>
                              <th>Image</th>
                              <th>Locations</th>                                
                              <th>Status</th>   
                              <th>Booking Date</th>                              
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
  $('#booking_table').dataTable({
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
    "ajax": "ajax_table_load.php?action=booking_table&ext_qry=<?=$ext_qry?>",
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