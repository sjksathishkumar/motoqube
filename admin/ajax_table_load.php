<?php 
include('../config.php');
$sql_details = array(
    'user' => $db_user,
    'pass' => $db_password,
    'db'   => $db_tablename,
    'host' => $db_host
);
$action = $_REQUEST['action'];
switch ($action) {  

  case "car_make_table":{
	// DB table to use
	$table = "(SELECT make,make_image,make_id,(@row_number:=@row_number + 1) AS row_num,priority FROM `sp_car_make`,(SELECT @row_number := 0) x order by make_id) as temp";
	// Table's primary key
	$primaryKey = 'make_id';

	$columns = array(
		array('db'=>'priority','dt'=>0),
	    array( 'db' => 'make','dt' => 1),	    		
	    array( 'db' => 'make_image','dt' => 2,'formatter' => function( $d, $row ) {return '<img src="../'.$d.'" style="max-width:70px"/>'; }),
	    array( 'db' => 'make','dt' => 3,'formatter'=> function($d, $row){
	        return '<a class="btn btn-default btn-circle btnTableView sp_view" href="car_model.php?make='.$row[6].'"  name="view"  title="View" ><i class="fa fa-angle-double-right"></i></a>'; }),
	    array('db' => 'make','dt' => 4,'formatter'=> function($d, $row){
            return '<button class="btn btn-primary btn-circle btnTableEdit sp_edit" name="edit" value="'.$row[6].'" title="Edit" data-toggle="modal" data-target="#edit_custom_model" data-id="'.$row[6].'" data-myvalue="'.$row[6].'" ><i class="fa fa-pencil-alt"></i></button>'; }),
	    array('db' => 'make','dt' => 5,'formatter'=> function($d, $row){
            return '<button type="button" class=" btn btn-danger btn-circle btnTableDelete sp_delete" onclick=delete_tablerow(this,"sp_car_make","delete_row","make_id","'.$row[6].'") name="delete" value="'.$row[6].'" title="Delete"><i class="fa fa-times"></i></button>'; } ),	 
	    array( 'db' => 'make_id','dt' => 6),	    		
	);

	require( '../ssp.class.php' );
	 
	echo json_encode(
	    SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns,$joinQuery = NULL, $extraWhere = '', $groupBy = '', $having = '','')
	);

	break;
  }

   case "car_model_table":{
   	if(isset($_GET["make"])){
   	$make = $_GET["make"];
	// DB table to use
	$table = "(SELECT model,model_image,model_id,make_id,(@row_number:=@row_number + 1) AS row_num FROM `sp_car_model`,(SELECT @row_number := 0) x where make_id='".$make."' order by model_id) as temp";
	// Table's primary key
	$primaryKey = 'model_id';

	$columns = array(
		array('db'=>'row_num','dt'=>0),
	    array( 'db' => 'model','dt' => 1),	    		
	    array( 'db' => 'model_image','dt' => 2,'formatter' => function( $d, $row ) {return '<img src="../'.$d.'" style="max-width:70px"/>'; }),
	    array( 'db' => 'model','dt' => 3,'formatter'=> function($d, $row){
	        return '<a class="btn btn-default btn-circle btnTableView sp_view" href="car_year.php?model='.$row[6].'"  name="view"  title="View" ><i class="fa fa-angle-double-right"></i></a>'; }),
	    array('db' => 'model','dt' => 4,'formatter'=> function($d, $row){
            return '<button class="btn btn-primary btn-circle btnTableEdit sp_edit" name="edit" value="'.$row[6].'" title="Edit" data-toggle="modal" data-target="#edit_custom_model" data-id="'.$row[6].'" data-myvalue="'.$row[6].'" ><i class="fa fa-pencil-alt"></i></button>'; }),
	    array('db' => 'model','dt' => 5,'formatter'=> function($d, $row){
            return '<button type="button" class=" btn btn-danger btn-circle btnTableDelete sp_delete" onclick=delete_tablerow(this,"sp_car_model","delete_row","model_id","'.$row[6].'") name="delete" value="'.$row[6].'" title="Delete"><i class="fa fa-times"></i></button>'; } ),	 
	    array( 'db' => 'model_id','dt' => 6),
	    array( 'db' => 'make_id','dt' => 7),	    		

	);

	require( '../ssp.class.php' );
	 
	echo json_encode(
	    SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns,$joinQuery = NULL, $extraWhere = '', $groupBy = '', $having = '','')
	);
	}
	break;
  }

   case "car_year_table":{
   	if(isset($_GET["model"])){
   	$model_id = $_GET["model"];
	// DB table to use
	$table = "(SELECT year,model_id,make_id,year_id,(@row_number:=@row_number + 1) AS row_num FROM `sp_car_year`,(SELECT @row_number := 0) x where model_id='".$model_id."' order by year_id) as temp";
	// Table's primary key
	$primaryKey = 'year_id';

	$columns = array(
		array('db'=>'row_num','dt'=>0),
	    array( 'db' => 'year','dt' => 1),	

	    array( 'db' => 'year','dt' => 2,'formatter'=> function($d, $row){
	        return '<a class="btn btn-default btn-circle btnTableView sp_view" href="car_variant.php?year='.$row[6].'"  name="view"  title="View" ><i class="fa fa-angle-double-right"></i></a>'; }),
	    array('db' => 'year','dt' => 3,'formatter'=> function($d, $row){
            return '<button class="btn btn-primary btn-circle btnTableEdit sp_edit" name="edit" value="'.$row[6].'" title="Edit" data-toggle="modal" data-target="#edit_custom_model" data-id="'.$row[6].'" data-myvalue="'.$row[6].'" ><i class="fa fa-pencil-alt"></i></button>'; }),
	    array('db' => 'year','dt' => 4,'formatter'=> function($d, $row){
            return '<button type="button" class=" btn btn-danger btn-circle btnTableDelete sp_delete" onclick=delete_tablerow(this,"sp_car_year","delete_row","year_id","'.$row[6].'") name="delete" value="'.$row[6].'" title="Delete"><i class="fa fa-times"></i></button>'; } ), 
	    array( 'db' => 'model_id','dt' => 5),
	    array( 'db' => 'year_id','dt' => 6),	    
	    array( 'db' => 'make_id','dt' => 7),	    		

	);

	require( '../ssp.class.php' );
	 
	echo json_encode(
	    SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns,$joinQuery = NULL, $extraWhere = '', $groupBy = '', $having = '','')
	);
	}
	break;
  }

  case "car_variant_table":{
   	if(isset($_GET["year"])){
   	$year_id = $_GET["year"];
	// DB table to use
	$table = "(SELECT variant,variant_id,(@row_number:=@row_number + 1) AS row_num FROM `sp_car_variant`,(SELECT @row_number := 0) x where year_id='".$year_id."' order by variant_id) as temp";
	// Table's primary key
	$primaryKey = 'variant_id';

	$columns = array(
		array('db'=>'row_num','dt'=>0),
	    array( 'db' => 'variant','dt' => 1),	

	    array('db' => 'variant','dt' => 2,'formatter'=> function($d, $row){
            return '<button class="btn btn-primary btn-circle btnTableEdit sp_edit" name="edit" value="'.$row[4].'" title="Edit" data-toggle="modal" data-target="#edit_custom_model" data-id="'.$row[4].'" data-myvalue="'.$row[4].'" ><i class="fa fa-pencil-alt"></i></button>'; }),
	    array('db' => 'variant','dt' => 3,'formatter'=> function($d, $row){
            return '<button type="button" class=" btn btn-danger btn-circle btnTableDelete sp_delete" onclick=delete_tablerow(this,"sp_car_variant","delete_row","variant_id","'.$row[4].'") name="delete" value="'.$row[4].'" title="Delete"><i class="fa fa-times"></i></button>'; } ), 
	    array( 'db' => 'variant_id','dt' => 4),	    		

	);

	require( '../ssp.class.php' );
	 
	echo json_encode(
	    SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns,$joinQuery = NULL, $extraWhere = '', $groupBy = '', $having = '','')
	);
	}
	break;
  }

    case "bike_make_table":{
	// DB table to use
	$table = "(SELECT make,make_image,make_id,(@row_number:=@row_number + 1) AS row_num,priority FROM `sp_bike_make`,(SELECT @row_number := 0) x order by make_id) as temp";
	// Table's primary key
	$primaryKey = 'make_id';

	$columns = array(
		array('db'=>'priority','dt'=>0),
	    array( 'db' => 'make','dt' => 1),	    		
	    array( 'db' => 'make_image','dt' => 2,'formatter' => function( $d, $row ) {return '<img src="../'.$d.'" style="max-width:70px"/>'; }),
	    array( 'db' => 'make','dt' => 3,'formatter'=> function($d, $row){
	        return '<a class="btn btn-default btn-circle btnTableView sp_view" href="bike_model.php?make='.$row[6].'"  name="view"  title="View" ><i class="fa fa-angle-double-right"></i></a>'; }),
	    array('db' => 'make','dt' => 4,'formatter'=> function($d, $row){
            return '<button class="btn btn-primary btn-circle btnTableEdit sp_edit" name="edit" value="'.$row[6].'" title="Edit" data-toggle="modal" data-target="#edit_custom_model" data-id="'.$row[6].'" data-myvalue="'.$row[6].'" ><i class="fa fa-pencil-alt"></i></button>'; }),
	    array('db' => 'make','dt' => 5,'formatter'=> function($d, $row){
            return '<button type="button" class=" btn btn-danger btn-circle btnTableDelete sp_delete" onclick=delete_tablerow(this,"sp_bike_make","delete_row","make_id","'.$row[6].'") name="delete" value="'.$row[6].'" title="Delete"><i class="fa fa-times"></i></button>'; } ),	 
	    array( 'db' => 'make_id','dt' => 6),	    		
	);

	require( '../ssp.class.php' );
	 
	echo json_encode(
	    SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns,$joinQuery = NULL, $extraWhere = '', $groupBy = '', $having = '','')
	);

	break;
  }

   case "bike_model_table":{
   	if(isset($_GET["make"])){
   	$make = $_GET["make"];
	// DB table to use
	$table = "(SELECT model,model_image,model_id,make_id,(@row_number:=@row_number + 1) AS row_num FROM `sp_bike_model`,(SELECT @row_number := 0) x where make_id='".$make."' order by model_id) as temp";
	// Table's primary key
	$primaryKey = 'model_id';

	$columns = array(
		array('db'=>'row_num','dt'=>0),
	    array( 'db' => 'model','dt' => 1),	    		
	    array( 'db' => 'model_image','dt' => 2,'formatter' => function( $d, $row ) {return '<img src="../'.$d.'" style="max-width:70px"/>'; }),
	    array( 'db' => 'model','dt' => 3,'formatter'=> function($d, $row){
	        return '<a class="btn btn-default btn-circle btnTableView sp_view" href="bike_year.php?model='.$row[6].'"  name="view"  title="View" ><i class="fa fa-angle-double-right"></i></a>'; }),
	    array('db' => 'model','dt' => 4,'formatter'=> function($d, $row){
            return '<button class="btn btn-primary btn-circle btnTableEdit sp_edit" name="edit" value="'.$row[6].'" title="Edit" data-toggle="modal" data-target="#edit_custom_model" data-id="'.$row[6].'" data-myvalue="'.$row[6].'" ><i class="fa fa-pencil-alt"></i></button>'; }),
	    array('db' => 'model','dt' => 5,'formatter'=> function($d, $row){
            return '<button type="button" class=" btn btn-danger btn-circle btnTableDelete sp_delete" onclick=delete_tablerow(this,"sp_bike_model","delete_row","model_id","'.$row[6].'") name="delete" value="'.$row[6].'" title="Delete"><i class="fa fa-times"></i></button>'; } ),	 
	    array( 'db' => 'model_id','dt' => 6),
	    array( 'db' => 'make_id','dt' => 7),	    		

	);

	require( '../ssp.class.php' );
	 
	echo json_encode(
	    SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns,$joinQuery = NULL, $extraWhere = '', $groupBy = '', $having = '','')
	);
	}
	break;
  }

   case "bike_year_table":{
   	if(isset($_GET["model"])){
   	$model_id = $_GET["model"];
	// DB table to use
	$table = "(SELECT year,model_id,make_id,year_id,(@row_number:=@row_number + 1) AS row_num FROM `sp_bike_year`,(SELECT @row_number := 0) x where model_id='".$model_id."' order by year_id) as temp";
	// Table's primary key
	$primaryKey = 'year_id';

	$columns = array(
		array('db'=>'row_num','dt'=>0),
	    array( 'db' => 'year','dt' => 1),	

	    array( 'db' => 'year','dt' => 2,'formatter'=> function($d, $row){
	        return '<a class="btn btn-default btn-circle btnTableView sp_view" href="bike_variant.php?year='.$row[6].'"  name="view"  title="View" ><i class="fa fa-angle-double-right"></i></a>'; }),
	    array('db' => 'year','dt' => 3,'formatter'=> function($d, $row){
            return '<button class="btn btn-primary btn-circle btnTableEdit sp_edit" name="edit" value="'.$row[6].'" title="Edit" data-toggle="modal" data-target="#edit_custom_model" data-id="'.$row[6].'" data-myvalue="'.$row[6].'" ><i class="fa fa-pencil-alt"></i></button>'; }),
	    array('db' => 'year','dt' => 4,'formatter'=> function($d, $row){
            return '<button type="button" class=" btn btn-danger btn-circle btnTableDelete sp_delete" onclick=delete_tablerow(this,"sp_bike_year","delete_row","year_id","'.$row[6].'") name="delete" value="'.$row[6].'" title="Delete"><i class="fa fa-times"></i></button>'; } ), 
	    array( 'db' => 'model_id','dt' => 5),
	    array( 'db' => 'year_id','dt' => 6),	    
	    array( 'db' => 'make_id','dt' => 7),	    		

	);

	require( '../ssp.class.php' );
	 
	echo json_encode(
	    SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns,$joinQuery = NULL, $extraWhere = '', $groupBy = '', $having = '','')
	);
	}
	break;
  }

  case "bike_variant_table":{
   	if(isset($_GET["year"])){
   	$year_id = $_GET["year"];
	// DB table to use
	$table = "(SELECT variant,variant_id,(@row_number:=@row_number + 1) AS row_num FROM `sp_bike_variant`,(SELECT @row_number := 0) x where year_id='".$year_id."' order by variant_id) as temp";
	// Table's primary key
	$primaryKey = 'variant_id';

	$columns = array(
		array('db'=>'row_num','dt'=>0),
	    array( 'db' => 'variant','dt' => 1),	

	    array('db' => 'variant','dt' => 2,'formatter'=> function($d, $row){
            return '<button class="btn btn-primary btn-circle btnTableEdit sp_edit" name="edit" value="'.$row[4].'" title="Edit" data-toggle="modal" data-target="#edit_custom_model" data-id="'.$row[4].'" data-myvalue="'.$row[4].'" ><i class="fa fa-pencil-alt"></i></button>'; }),
	    array('db' => 'variant','dt' => 3,'formatter'=> function($d, $row){
            return '<button type="button" class=" btn btn-danger btn-circle btnTableDelete sp_delete" onclick=delete_tablerow(this,"sp_bike_variant","delete_row","variant_id","'.$row[4].'") name="delete" value="'.$row[4].'" title="Delete"><i class="fa fa-times"></i></button>'; } ), 
	    array( 'db' => 'variant_id','dt' => 4),	    		

	);

	require( '../ssp.class.php' );
	 
	echo json_encode(
	    SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns,$joinQuery = NULL, $extraWhere = '', $groupBy = '', $having = '','')
	);
	}
	break;
  }

  case "seller_table":{
	// DB table to use
	$table = "(SELECT concat('SDS',LPAD(seller_id, case when length(seller_id)>3 THEN length(seller_id) ELSE 3 END, 0)) as sellerid,seller_id,name,mobile,alternate_mobile,email,shop,address,landmark,location,city,state,pincode,business_percentage,CASE WHEN status = 0 THEN 'Inactive' ELSE 'Active' END AS status,(@row_number:=@row_number + 1) AS row_num,car_deal, bike_deal FROM `sp_seller`,(SELECT @row_number := 0) x order by seller_id desc) as temp";
	// Table's primary key
	$primaryKey = 'seller_id';

	$columns = array(
		array('db'=>'row_num','dt'=>0),
		array('db'=>'sellerid','dt'=>1),
	    array( 'db' => 'name','dt' => 2),	
	    array( 'db' => 'mobile','dt' => 3),	
	    array( 'db' => 'email','dt' => 4),	
	    array( 'db' => 'shop','dt' => 5),	
	    array( 'db' => 'address','dt' => 6),		    	    
	    array( 'db' => 'landmark','dt' => 7),
	    array( 'db' => 'location','dt' => 8),	
	    array( 'db' => 'city','dt' => 9),	
	    array( 'db' => 'state','dt' => 10),		    	    
	    array( 'db' => 'pincode','dt' => 11),		 
	    array( 'db' => 'alternate_mobile','dt' => 12),	
	    array( 'db' => 'business_percentage','dt' => 13),	
	  array( 'db' => 'business_percentage','dt' => 14,'formatter'=> function($d, $row){ $val='';if($row[19]!='' && !empty($row[19])){ $val='car';  if($row[20]!='' && !empty($row[20])){ $val.=', bike'; } }  if($row[20]!='' && !empty($row[20])){ $val='bike'; } return $val; }),
	    array( 'db' => 'status','dt' => 15,'formatter'=> function($d, $row){ return ($d=="Active")?'<b class="cl-green">Active</b>':'<b class="cl-red">Inactive</b>';}),		    	    
	    array( 'db' => 'shop','dt' => 16,'formatter'=> function($d, $row){
	        return '<a class="btn btn-default btn-circle btnTableView sp_view" href="view_seller.php?seller='.$row[18].'"  name="view"  title="View" ><i class="fa fa-angle-double-right"></i></a>'; }),
	    array('db' => 'name','dt' => 17,'formatter'=> function($d, $row){
            return '<button type="button" class=" btn btn-danger btn-circle btnTableDelete sp_delete" onclick=delete_tablerow(this,"sp_seller","delete_row","seller_id","'.$row[18].'") name="delete" value="'.$row[18].'" title="Delete"><i class="fa fa-times"></i></button>'; } ), 
		array('db'=>'seller_id','dt'=>18),
		array('db'=>'car_deal','dt'=>19),
		array('db'=>'bike_deal','dt'=>20),


	);

	require( '../ssp.class.php' );
	 
	echo json_encode(
	    SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns,$joinQuery = NULL, $extraWhere = '', $groupBy = '', $having = '','')
	);
	
	break;
  }
    case "buyer_table":{
	// DB table to use
	$table = "(SELECT concat('SDB',LPAD(buyer_id, case when length(buyer_id)>3 THEN length(buyer_id) ELSE 3 END, 0)) as buyerid,buyer_id,name,mobile,email,address,landmark,city,state,pincode,CASE WHEN status = 0 THEN 'Inactive' ELSE 'Active' END AS status,(@row_number:=@row_number + 1) AS row_num FROM `sp_buyer`,(SELECT @row_number := 0) x order by buyer_id desc) as temp";
	// Table's primary key
	$primaryKey = 'buyer_id';

	$columns = array(
		array('db'=>'row_num','dt'=>0),
		array('db'=>'buyerid','dt'=>1),
	    array( 'db' => 'name','dt' => 2),	
	    array( 'db' => 'mobile','dt' => 3),	
	    array( 'db' => 'email','dt' => 4),	
	    array( 'db' => 'address','dt' => 5),		    	    
	    array( 'db' => 'landmark','dt' => 6),		    	    
	    array( 'db' => 'city','dt' => 7),	
	    array( 'db' => 'state','dt' => 8),		    	    
	    array( 'db' => 'pincode','dt' => 9),		 
	    array( 'db' => 'status','dt' => 10,'formatter'=> function($d, $row){ return ($d=="Active")?'<b class="cl-green">Active</b>':'<b class="cl-red">Inactive</b>';}),		    	    
	   array( 'db' => 'buyer_id','dt' => 11,'formatter'=> function($d, $row){
	        return '<a class="btn btn-default btn-circle btnTableView sp_view" href="view_buyer.php?buyer='.$d.'"  name="view"  title="View" ><i class="fa fa-angle-double-right"></i></a>'; }),
	    array('db' => 'name','dt' => 12,'formatter'=> function($d, $row){
            return '<button type="button" class=" btn btn-danger btn-circle btnTableDelete sp_delete" onclick=delete_tablerow(this,"sp_buyer","delete_row","buyer_id","'.$row[13].'") name="delete" value="'.$row[13].'" title="Delete"><i class="fa fa-times"></i></button>'; } ), 
		array('db'=>'buyer_id','dt'=>13),

	);

	require( '../ssp.class.php' );
	 
	echo json_encode(
	    SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns,$joinQuery = NULL, $extraWhere = '', $groupBy = '', $having = '','')
	);
	
	break;
  }
  case "booking_table":{
  	$ext_qry = $_GET["ext_qry"];
	// DB table to use
	$table = "(SELECT concat('SDB',LPAD(a.buyer_id, case when length(a.buyer_id)>3 THEN length(a.buyer_id) ELSE 3 END, 0)) as buyer_id, concat('BSD',LPAD(a.booking_id, case when length(a.booking_id)>3 THEN length(a.booking_id) ELSE 3 END, 0)) as bookingid, a.booking_id ,a.images,a.category,b.name,b.mobile,locations,a.dateandtime,a.status,(@row_number:=@row_number + 1) AS row_num FROM `sp_bookings` a left join sp_buyer b on a.buyer_id = b.buyer_id,(SELECT @row_number := 0) x  where $ext_qry order by booking_id desc) as temp";
	// echo $table;
	// Table's primary key
	$primaryKey = 'buyer_id';
	$columns = array(
		array('db'=>'row_num','dt'=>0),
		array('db'=>'bookingid','dt'=>1),
		array('db'=>'buyer_id','dt'=>2),
	    array('db' => 'name','dt' => 3),	
	    array('db' => 'mobile','dt' => 4),
	    array('db' => 'category','dt' => 5),		    	    
	    array('db' => 'images','dt' => 6,'formatter'=> function($d, $row){ $image1 = json_decode($d); return (!empty($image1))?'<img src="../'.array_values($image1)[0].'" style="max-width:70px"/>':'';}),
	    array('db' => 'Locations','dt' => 7),	
	    array('db' => 'Status','dt' => 8),		 
		array('db'=>'dateandtime','dt'=>9,'formatter'=> function($d, $row){ return date('d-m-Y h:i a',strtotime($d));}),

	   	array( 'db' => 'booking_id','dt' => 10,'formatter'=> function($d, $row){
	        return '<a class="btn btn-default btn-circle btnTableView sp_view" href="view_bookings.php?booking='.$d.'"  name="view"  title="View" ><i class="fa fa-angle-double-right"></i></a>'; }),
	    array('db' => 'name','dt' => 11,'formatter'=> function($d, $row){
            return '<button type="button" class=" btn btn-danger btn-circle btnTableDelete sp_delete" onclick=delete_tablerow(this,"sp_bookings","delete_row","booking_id","'.$row[12].'") name="delete" value="'.$row[12].'" title="Delete"><i class="fa fa-times"></i></button>'; } ), 
		array('db'=>'booking_id','dt'=>12),

	);

	require( '../ssp.class.php' );
	 
	echo json_encode(
	    SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns,$joinQuery = NULL, $extraWhere = '', $groupBy = '', $having = '','')
	);
	
	break;
  }


    case "popularlocation_table":{
	$table = "(SELECT location,popular_location_id,(@row_number:=@row_number + 1) AS row_num FROM `sp_popular_locations`,(SELECT @row_number := 0) x order by popular_location_id) as temp";
	// Table's primary key
	$primaryKey = 'popular_location_id';

	$columns = array(
		array('db'=>'row_num','dt'=>0),
	    array( 'db' => 'location','dt' => 1),	
	    array('db' => 'popular_location_id','dt' => 2,'formatter'=> function($d, $row){
            return '<button class="btn btn-primary btn-circle btnTableEdit sp_edit" name="edit" value="'.$row[4].'" title="Edit" data-toggle="modal" data-target="#edit_custom_model" data-id="'.$row[4].'" data-myvalue="'.$row[4].'" ><i class="fa fa-pencil-alt"></i></button>'; }),
	    array('db' => 'popular_location_id','dt' => 3,'formatter'=> function($d, $row){
            return '<button type="button" class=" btn btn-danger btn-circle btnTableDelete sp_delete" onclick=delete_tablerow(this,"sp_popular_locations","delete_row","popular_location_id","'.$row[4].'") name="delete" value="'.$row[4].'" title="Delete"><i class="fa fa-times"></i></button>'; } ),	 
	    array( 'db' => 'popular_location_id','dt' => 4),	    		
	);

	require( '../ssp.class.php' );
	 
	echo json_encode(
	    SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns,$joinQuery = NULL, $extraWhere = '', $groupBy = '', $having = '','')
	);
	break;
  }

    case "location_table":{
	$table = "(SELECT state,district,location,location_id,pincode,(@row_number:=@row_number + 1) AS row_num FROM `sp_locations`,(SELECT @row_number := 0) x order by location_id) as temp";
	// Table's primary key
	$primaryKey = 'location_id';

	$columns = array(
		array('db'=>'row_num','dt'=>0),
	    array( 'db' => 'state','dt' => 1),
	    array( 'db' => 'district','dt' => 2),	
	    array( 'db' => 'location','dt' => 3),	
	    array( 'db' => 'pincode','dt' => 4),	
	    array('db' => 'location_id','dt' => 5,'formatter'=> function($d, $row){
            return '<button class="btn btn-primary btn-circle btnTableEdit sp_edit" name="edit" value="'.$row[7].'" title="Edit" data-toggle="modal" data-target="#edit_custom_model" data-id="'.$row[7].'" data-myvalue="'.$row[7].'" ><i class="fa fa-pencil-alt"></i></button>'; }),
	    array('db' => 'location_id','dt' => 6,'formatter'=> function($d, $row){
            return '<button type="button" class=" btn btn-danger btn-circle btnTableDelete sp_delete" onclick=delete_tablerow(this,"sp_locations","delete_row","location_id","'.$row[7].'") name="delete" value="'.$row[7].'" title="Delete"><i class="fa fa-times"></i></button>'; } ),	 
	    array( 'db' => 'location_id','dt' => 7),	    		
	);

	require( '../ssp.class.php' );
	 
	echo json_encode(
	    SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns,$joinQuery = NULL, $extraWhere = '', $groupBy = '', $having = '','')
	);
	break;
  }


    case "buyer_location_table":{
	$table = "(SELECT state,district,location,location_id,pincode,(@row_number:=@row_number + 1) AS row_num FROM `sp_buyer_locations`,(SELECT @row_number := 0) x order by location_id) as temp";
	// Table's primary key
	$primaryKey = 'location_id';

	$columns = array(
		array('db'=>'row_num','dt'=>0),
	    array( 'db' => 'state','dt' => 1),
	    array( 'db' => 'district','dt' => 2),	
	    array( 'db' => 'location','dt' => 3),	
	    array( 'db' => 'pincode','dt' => 4),	
	    array('db' => 'location_id','dt' => 5,'formatter'=> function($d, $row){
            return '<button class="btn btn-primary btn-circle btnTableEdit sp_edit" name="edit" value="'.$row[7].'" title="Edit" data-toggle="modal" data-target="#edit_custom_model" data-id="'.$row[7].'" data-myvalue="'.$row[7].'" ><i class="fa fa-pencil-alt"></i></button>'; }),
	    array('db' => 'location_id','dt' => 6,'formatter'=> function($d, $row){
            return '<button type="button" class=" btn btn-danger btn-circle btnTableDelete sp_delete" onclick=delete_tablerow(this,"sp_buyer_locations","delete_row","location_id","'.$row[7].'") name="delete" value="'.$row[7].'" title="Delete"><i class="fa fa-times"></i></button>'; } ),	 
	    array( 'db' => 'location_id','dt' => 7),	    		
	);

	require( '../ssp.class.php' );
	 
	echo json_encode(
	    SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns,$joinQuery = NULL, $extraWhere = '', $groupBy = '', $having = '','')
	);
	break;
  }

   case "popularlocation_state_table":{
	$table = "(SELECT state,district,state_location_id,(@row_number:=@row_number + 1) AS row_num FROM `sp_popular_locations_state`,(SELECT @row_number := 0) x order by state_location_id) as temp";
	// Table's primary key
	$primaryKey = 'state_location_id';

	$columns = array(
		array('db'=>'row_num','dt'=>0),
	    array( 'db' => 'state','dt' => 1),	
	    array( 'db' => 'district','dt' => 2),	
	    array('db' => 'state_location_id','dt' => 3,'formatter'=> function($d, $row){
            return '<button class="btn btn-primary btn-circle btnTableEdit sp_edit" name="edit" value="'.$row[5].'" title="Edit" data-toggle="modal" data-target="#edit_custom_model" data-id="'.$row[5].'" data-myvalue="'.$row[5].'" ><i class="fa fa-pencil-alt"></i></button>'; }),
	    array('db' => 'state_location_id','dt' => 4,'formatter'=> function($d, $row){
            return '<button type="button" class=" btn btn-danger btn-circle btnTableDelete sp_delete" onclick=delete_tablerow(this,"sp_popular_locations_state","delete_row","state_location_id","'.$row[5].'") name="delete" value="'.$row[5].'" title="Delete"><i class="fa fa-times"></i></button>'; } ),	 
	    array( 'db' => 'state_location_id','dt' => 5),	    		
	);

	require( '../ssp.class.php' );
	 
	echo json_encode(
	    SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns,$joinQuery = NULL, $extraWhere = '', $groupBy = '', $having = '','')
	);
	break;
  }
  case 'content_table':{
  	$table = "(SELECT *,(@row_number:=@row_number + 1) AS row_num FROM sp_content,(SELECT @row_number := 0) x  order by content_id) as temp";
	// Table's primary key
	$primaryKey = 'content_id';

	$columns = array(
		array('db'=>'row_num','dt'=>0),
	    array( 'db' => 'section','dt' => 1),	
	    array( 'db' => 'content','dt' => 2),	
	    array('db' => 'content_id','dt' => 3,'formatter'=> function($d, $row){
            return '<button class="btn btn-primary btn-circle btnTableEdit sp_edit" name="edit" value="'.$row[5].'" title="Edit" data-toggle="modal" data-target="#edit_custom_model" data-id="'.$row[5].'" data-myvalue="'.$row[5].'"><i class="fa fa-pencil-alt"></i></button>'; }),
	    array('db' => 'content_id','dt' => 4,'formatter'=> function($d, $row){
            return '<button type="button" class=" btn btn-danger btn-circle btnTableDelete sp_delete" onclick=delete_tablerow(this,"sp_content","delete_row","content_id","'.$row[5].'") name="delete" value="'.$row[5].'" title="Delete"><i class="fa fa-times"></i></button>'; } ),	 
	    array( 'db' => 'content_id','dt' => 5),	    		
	);

	require( '../ssp.class.php' );
	 
	echo json_encode(
	    SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns,$joinQuery = NULL, $extraWhere = '', $groupBy = '', $having = '','')
	);
	break;
  	break;
  }

    case 'subadmin_table':{
  	$table = "(SELECT *,(@row_number:=@row_number + 1) AS row_num FROM sp_subadmin,(SELECT @row_number := 0) x  order by sb_id) as temp";
	// Table's primary key
	$primaryKey = 'sb_id';

	$columns = array(
		array('db'=>'row_num','dt'=>0),
	    array('db' => 'name','dt' => 1),	
	    array('db' => 'mobile','dt' => 2),	
	    array('db' => 'email','dt' => 3),	
	    array('db' => 'sb_id','dt' => 4,'formatter'=> function($d, $row){
            return '<a class="btn btn-success btn-circle sp_view" name="view" value="'.$row[6].'" title="View" href="roles_rights.php?id='.$row[6].'"><i class="fa fa-eye"></i></a>'; }),
        array('db' => 'sb_id','dt' => 5,'formatter'=> function($d, $row){
            return '<button class="btn btn-primary btn-circle btnTableEdit sp_edit" name="edit" value="'.$row[6].'" title="Edit" data-toggle="modal" data-target="#edit_custom_model" data-id="'.$row[6].'" data-myvalue="'.$row[6].'"><i class="fa fa-pencil-alt"></i></button>'; }),
	    array('db' => 'sb_id','dt' => 6,'formatter'=> function($d, $row){
            return '<button type="button" class=" btn btn-danger btn-circle btnTableDelete sp_delete" onclick=delete_tablerow(this,"sp_subadmin","delete_row","sb_id","'.$row[6].'") name="delete" value="'.$row[6].'" title="Delete"><i class="fa fa-times"></i></button>'; } ),	 
	    array( 'db' => 'sb_id','dt' => 7),	    		
	);

	require( '../ssp.class.php' );
	 
	echo json_encode(
	    SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns,$joinQuery = NULL, $extraWhere = '', $groupBy = '', $having = '','')
	);
	break;
  }
    case "buyer_banner_table":{
	// DB table to use
	$table = "(SELECT image,(@row_number:=@row_number + 1) AS row_num,id FROM `sp_buyer_banner`,(SELECT @row_number := 0) x order by id) as temp";
	// Table's primary key
	$primaryKey = 'id';

	$columns = array(
		array('db'=>'row_num','dt'=>0), 		
	    array( 'db' => 'image','dt' => 1,'formatter' => function( $d, $row ) {return '<img src="../'.$d.'" style="max-width:70px"/>'; }),
	    array('db' => 'image','dt' => 2,'formatter'=> function($d, $row){
            return '<button type="button" class=" btn btn-danger btn-circle btnTableDelete sp_delete" onclick=delete_tablerow(this,"sp_buyer_banner","delete_row","id","'.$row[3].'") name="delete" value="'.$row[3].'" title="Delete"><i class="fa fa-times"></i></button>'; } ),	 
	    array( 'db' => 'id','dt' => 3),	    		
	);

	require( '../ssp.class.php' );
	 
	echo json_encode(
	    SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns,$joinQuery = NULL, $extraWhere = '', $groupBy = '', $having = '','')
	);

	break;
  }
  case "seller_banner_table":{
	// DB table to use
	$table = "(SELECT image,(@row_number:=@row_number + 1) AS row_num,id FROM `sp_seller_banner`,(SELECT @row_number := 0) x order by id) as temp";
	// Table's primary key
	$primaryKey = 'id';

	$columns = array(
		array('db'=>'row_num','dt'=>0), 		
	    array( 'db' => 'image','dt' => 1,'formatter' => function( $d, $row ) {return '<img src="../'.$d.'" style="max-width:70px"/>'; }),
	    array('db' => 'image','dt' => 2,'formatter'=> function($d, $row){
            return '<button type="button" class=" btn btn-danger btn-circle btnTableDelete sp_delete" onclick=delete_tablerow(this,"sp_seller_banner","delete_row","id","'.$row[3].'") name="delete" value="'.$row[3].'" title="Delete"><i class="fa fa-times"></i></button>'; } ),	 
	    array( 'db' => 'id','dt' => 3),	    		
	);

	require( '../ssp.class.php' );
	 
	echo json_encode(
	    SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns,$joinQuery = NULL, $extraWhere = '', $groupBy = '', $having = '','')
	);

	break;
  }



}