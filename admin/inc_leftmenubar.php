<nav class="navbar navbar-default navbar-static-top w3-card-2" role="navigation"   style="margin-bottom: 0px">
<?php $user_name = 'Admin';  if(!empty($_SESSION["SPARESDO_subadminlogin"])){ ?> 
    <div class="navbar-header" style="background-color: white">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
    </div>
    <!-- /.navbar-header -->
<?php } 
if(!empty($_SESSION['SPARESDO_subadminlogin'])){
    if($_SESSION['SPARESDO_subadminlogin']==0){ $user_name = "Admin"; }
    else{
    $user_name = $db->getVal("select name from sp_subadmin where sb_id='".$_SESSION["SPARESDO_subadminlogin"]."'");
    }
} ?>
    <div class="nav navbar-top-links navbar-right">
          <li class="dropdown">
            <?php $notification = $db->getRows("Select * from sp_notifications order by id desc");$counts= count($notification); ?>
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-bell fa-fw"></i><?php if($counts>0){?><span class="badge badge-danger badge-counter"><?=$counts?></span><?php } ?>
                    </a>
                    <ul class="dropdown-menu dropdown-alerts" style="max-height: 350px;overflow: auto;">
                        <?php 
                        
                        if($counts>0){
                            foreach ($notification as $key => $value) {
                               $section= $value["section"];$link="";
                               if($section=="seller"){
                                $link = "view_seller.php?seller=".$value["section_id"];
                                $title= "New ".$section;
                               }
                               elseif($section=="buyer"){
                                $link = "view_buyer.php?buyer=".$value["section_id"];
                                $title= "New ".$section;
                               }
                               elseif($section=="booking"){
                                $link = "view_bookings.php?booking=".$value["section_id"];
                                $title= "New ".$section;                                
                               }
                               elseif($section=="choosed seller"){
                                $link = "view_bookings.php?booking=".$value["section_id"];
                                $title= "Seller Choosed for the Booking ID: ".bookingid($value["section_id"]);
                               }
                               elseif($section=="choosed seller"){
                                $link = "view_bookings.php?booking=".$value["section_id"];
                                $title= "Seller Choosed for the Booking ID: ".bookingid($value["section_id"]);
                               }
                               elseif($section=="shipped"){
                                $link = "view_bookings.php?booking=".$value["section_id"];
                                $title= "Product is Shippied Booking ID: ".bookingid($value["section_id"]);
                               }
                                elseif($section=="payment pending"){
                                $link = "view_bookings.php?booking=".$value["section_id"];
                                $title= "Need payment confirmation for the Booking ID: ".bookingid($value["section_id"]);
                               }
                               elseif($section=="paid"){
                                $link = "view_bookings.php?booking=".$value["section_id"];
                                $title= "New payment for the Booking ID: ".bookingid($value["section_id"]);
                               }
                               elseif($section=="cancel requested"){
                                $link = "view_bookings.php?booking=".$value["section_id"];
                                $title= "Cancel Requested for the Booking ID: ".bookingid($value["section_id"]);
                               }
                               elseif($section=="return requested"){
                                $link = "view_bookings.php?booking=".$value["section_id"];
                                $title= "Return Requested for the Booking ID: ".bookingid($value["section_id"]);
                               }
                        ?>
                        <li>
                            <a href="javascript:void(10)" onclick='delete_tablerow_withoutconfirm(this,"sp_notifications","delete_row","id","<?=$value["id"]?>","<?=$link?>")'>                                
                                <div class="small"><i class="fa fa-handshake fa-fw "></i> <?=$title?> <span class="pull-right text-muted small"><?= difference($value["dateandtime"]) ?></span> 
                                    <div class="medium">User Name: <?=$value["name"]?></div>                                   
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <?php } } else{ echo "<p class='text-center'>No New Notifications</p>"; }?>
                        
                    </ul>
                    <!-- /.dropdown-alerts -->
                </li>
        <!-- /.dropdown -->
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#" style="color: #fff;">
                Welcome, <?= $user_name ?>
                <i class="material-icons user-login">
                    how_to_reg
                    </i> <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-user">
              <!--   <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                </li>
                <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                </li> -->
               <!--  <li class="divider"></li> -->
                <li><a href="login.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
            <!-- /.dropdown-user -->
        </li>
        <!-- /.dropdown -->
    </div>
    <!-- /.navbar-top-links -->
<?php   if(!empty($_SESSION["SPARESDO_subadminlogin"])){ ?> 
    <div class="navbar-default sidebar" role="navigation"  style="background-color: white;">
        <div class="sidebar-nav navbar-collapse collapse" style="padding: 12px;">
            <ul class="nav" id="side-menu">
                <li>
                    <a href="index.php"><i class="material-icons">
                    dashboard
                    </i> Dashboard</a>
                </li>
               
                <li class="vehicle_view">
                    <a href="javascript:void(0)"><i class="material-icons">
                    library_books
                    </i> Vehicle Details <span class="fa fa-angle-down" style="float: right;"></span></a>
                    <ul class="nav nav-second-level" style="display: none">
                        <li>
                            <a href="car_make.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Car</a>
                        </li>
                        <li>
                            <a href="bike_make.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Bike</a>
                        </li>
                    </ul>
                </li>
                <li class="sellers_view">
                    <a href="sellers.php"><i class="material-icons">
                    account_circle
                    </i> Sellers</a>
                </li>
                <li class="buyers_view">
                    <a href="buyers.php"><i class="material-icons">people</i> Buyers</a>
                </li>
                <li class="banners_view">
                    <a href="#"><i class="material-icons">image</i>Banner <span class="fa fa-angle-down" style="float: right;"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="buyer_banner.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i>&nbsp;&nbsp;Buyer App</a>
                        </li>
                        <li>
                            <a href="seller_banner.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i>&nbsp;&nbsp;Seller App</a>
                        </li>
                    </ul>
                </li>
                <li class="bookings_view">
                    <a href="bookings.php"><i class="material-icons">book</i> Bookings</a>
                </li>

                <li class="locations_view">
                    <a href="javascript:void(0)"><i class="material-icons">
                    map
                    </i> Locations <span class="fa fa-angle-down" style="float: right;"></span></a>
                    <ul class="nav nav-second-level" style="display: none">
                        <li>
                            <a href="buyer_locations.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Buyer</a>
                        </li>
                        <li>
                            <a href="locations.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Seller</a>
                        </li>
                    </ul>
                </li>
              

                 <li class="popular_view">
                    <a href="javascript:void(0)"><i class="material-icons">
                    trending_up
                    </i> Popular Locations <span class="fa fa-angle-down" style="float: right;"></span></a>
                    <ul class="nav nav-second-level" style="display: none">
                        <li>
                           <a href="popular_locations.php"><i class="fa fa-angle-double-right"></i> India</a>
                        </li>
                        <li>
                            <a href="popular_locations_state.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> State</a>
                        </li>
                    </ul>
                </li>
                  <li class="contents_view">
                    <a href="contents.php"><i class="material-icons">
                    source
                    </i> Contents</a>
                </li>
                 <li class="settings_view">
                    <a href="settings.php"><i class="material-icons">
                    settings
                    </i> Settings</a>
                </li>

                 <li class="subadmin_view">
                    <a href="subadmin.php"><i class="material-icons">
                    supervised_user_circle
                    </i> Subadmin</a>
                </li>

            </ul>
        </div>
    </div>
<?php } ?>
</nav>