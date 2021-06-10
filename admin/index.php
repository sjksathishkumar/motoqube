<?php include 'inc-meta.php'; 

                                ?>
</head>
<body >
<!--------------------->
<div id="wrapper">
    <?php include 'inc_leftmenubar.php'; ?>
<?php 
    $customers_count = $db->getVal("select count(buyer_id) from sp_buyer");
    $employees_count = $db->getVal("select count(seller_id) from sp_seller");
    $total_orders = $db->getVal("select count(booking_id) from sp_bookings");

?>
<div id="page-wrapper">
    <div class="sp_view">
    <div class="row">
        <div class="col-lg-12">
            <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-info card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">
                    supervisor_account
                    </i>
                  </div>
                  <p class="card-category">Customers</p>
                  <h3 class="card-title"><?= $customers_count; ?></h3>
                </div>
                <div class="card-footer">
                  <div class="stats">
                    <i class="material-icons text-info">visibility</i> 
                    <a href="buyers.php">View Entire Details</a>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-warning card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">
                    supervisor_account
                    </i>
                  </div>
                  <p class="card-category">Sellers</p>
                  <h3 class="card-title"><?= $employees_count; ?></h3>
                </div>
                <div class="card-footer">
                  <div class="stats">
                    <i class="material-icons text-info">visibility</i> 
                    <a href="sellers.php">View Entire Details</a>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-success card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">
                    list_alt
                    </i>
                  </div>
                  <p class="card-category">Services</p>
                  <h3 class="card-title"><?= $total_orders; ?></h3>
                </div>
                <div class="card-footer">
                  <div class="stats">
                    <i class="material-icons text-info">visibility</i> 
                    <a href="bookings.php">View Entire Details</a>
                  </div>
                </div>
              </div>
            </div>
        </div>
    </div>
<br/>
<div class="row">
    <div class="col-lg-12">
        <div class="col-md-6 ">
            <div class="col-md-12">
                <div class=" row panel panel-default" id="dashboard-table" style="margin-top:3em">
                    <div class="gradient-card-header-info">
                        <h2 class="white-text mx-3">Recent Buyer</h2>
                    </div>

                    <div class="panel-body table-responsive">
                        <table width="100%" class="table table-striped table-bordered table-hover" >
                            <thead >
                                <tr>
                                    <th>Buyer ID</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                    $recent_customers = $db->getRows("select buyer_id,name,mobile,email from sp_buyer order by buyer_id desc limit 10");
                                    
                                    if( count($recent_customers) > 0 )
                                    {
                                        foreach($recent_customers as $recent_customers_list)
                                        {
                                            $buyer_id = buyerid($recent_customers_list["buyer_id"]);
                                            $customer_name = $recent_customers_list["name"];
                                            $customer_mobile = $recent_customers_list["mobile"];
                                            $customer_email = $recent_customers_list["email"];
                                ?>
                                            <tr class="odd gradeX">
                                                <td><?php  echo $buyer_id; ?></td>
                                                <td><?php  echo $customer_name; ?></td>
                                                <td><?php  echo $customer_mobile; ?></td>
                                                <td><?php  echo $customer_email; ?></td>
                                               
                                            </tr>
                                <?php
                                        }
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 ">
            <div class="col-md-12">
                <div class=" row panel panel-default" id="dashboard-table" style="margin-top:3em">
                    <div class="gradient-card-header-info">
                        <h2 class="white-text mx-3">Recent Sellers</h2>
                    </div>

                    <div class="panel-body table-responsive">
                        <table width="100%" class="table table-striped table-bordered table-hover" >
                            <thead >
                                <tr>
                                    <th>Seller ID</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                </tr>
                            </thead>
                            <tbody>
                              <?php
                                    $recent_customers = $db->getRows("select seller_id,name,mobile,email from sp_seller order by seller_id desc limit 10");
                                    
                                    if( count($recent_customers) > 0 )
                                    {
                                        foreach($recent_customers as $recent_customers_list)
                                        {
                                            $seller_id = sellerid($recent_customers_list["seller_id"]);
                                            $customer_name = $recent_customers_list["name"];
                                            $customer_mobile = $recent_customers_list["mobile"];
                                            $customer_email = $recent_customers_list["email"];
                                ?>
                                            <tr class="odd gradeX">
                                                <td><?php  echo $seller_id; ?></td>
                                                <td><?php  echo $customer_name; ?></td>
                                                <td><?php  echo $customer_mobile; ?></td>
                                                <td><?php  echo $customer_email; ?></td>
                                               
                                            </tr>
                                <?php
                                        }
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="col-md-6 ">
            <div class="col-md-12">
                <div class=" row panel panel-default" id="dashboard-table" style="margin-top:3em">
                    <div class="gradient-card-header-info">
                        <h2 class="white-text mx-3">Recent Services</h2>
                    </div>

                    <div class="panel-body table-responsive">
                        <table width="100%" class="table table-striped table-bordered table-hover" >
                            <thead >
                                <tr>
                                    <th>Booking ID</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                </tr>
                            </thead>
                            <tbody>
                             <?php
                                    $recent_customers = $db->getRows("select booking_id,name,mobile,email from sp_bookings a left join sp_buyer b on a.buyer_id=b.buyer_id  order by booking_id desc limit 10");
                                    
                                    if( count($recent_customers) > 0 )
                                    {
                                        foreach($recent_customers as $recent_customers_list)
                                        {
                                            $booking_id = bookingid($recent_customers_list["booking_id"]);
                                            $customer_name = $recent_customers_list["name"];
                                            $customer_mobile = $recent_customers_list["mobile"];
                                            $customer_email = $recent_customers_list["email"];
                                ?>
                                            <tr class="odd gradeX">
                                                <td><?php  echo $booking_id; ?></td>
                                                <td><?php  echo $customer_name; ?></td>
                                                <td><?php  echo $customer_mobile; ?></td>
                                                <td><?php  echo $customer_email; ?></td>
                                               
                                            </tr>
                                <?php
                                        }
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</div>
        </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->
<?php include 'inc-script.php'; ?>
</body>
</html>
