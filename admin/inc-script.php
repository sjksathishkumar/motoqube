<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<!-- Bootstrap Core JavaScript -->
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!-- Metis Menu Plugin JavaScript -->
<script src="vendor/metisMenu/metisMenu.min.js"></script>
<!-- DataTables JavaScript -->
<script src="vendor/datatables-responsive/dataTables.responsive.js"></script>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>

<!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap.min.css"> -->

<script src="vendor/datatables/js/jquery.dataTables.min.js"></script>
<script src="vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
<script src="vendor/datatables-responsive/dataTables.responsive.js"></script>

<script src="dist/js/sb-admin-2.js"></script>
<script src="//cdn.ckeditor.com/4.11.2/full/ckeditor.js"></script>
<!-- <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script> -->

<!-- customize column -->
<script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.colVis.min.js"></script>
<!--excel----->
<script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>

<!----------------jquery alert plugin---------->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>
<!-- select2 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

<!-- Custom Theme JavaScript -->
<script src="dist/js/sb-admin-2.js"></script>
<script src="js/custom_common.js"></script>
<script type="text/javascript">
$('#side-menu li').click(function () {
    $(this).find('ul:first').toggle();
    $(this).siblings('li').find('ul').toggleClass("in");
});
$('#navbar-header .navbar-toggle').trigger('click');


    var current = location.pathname.split("/").slice(-1);
    $('#side-menu li ul li a').each(function(){
        var element = $(this);

        $('#side-menu li').find('ul:first').css({"display": "none"}); 
            $('#side-menu li').find('ul:first').toggleClass("in");
        // if the current path is like this link, make it active
        if(element.attr('href').indexOf(current) !== -1){
            element.parent().parent('ul:first').toggle();      	
            element.parent().parent('ul:first').toggleClass("in");
        }
   //      else{
   //      	$('#side-menu li').find('ul').css({"display": "block"}); 
			// $('#side-menu li').find('ul').toggleClass("in");
   //      }
    });
</script>

