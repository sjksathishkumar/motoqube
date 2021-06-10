<?php include 'inc-meta.php';
if(isset($_POST["hold_bid"])){
  $hold_bid=$_POST["hold_bid"];
  $hold_bid2=$_POST["hold_bid2"];
        $datas = array(
          'value'=>date('Y-m-d H:i',strtotime($hold_bid)),  
          'value2'=>date('Y-m-d H:i',strtotime($hold_bid2)),                     
        );
        $value = $db->updateAry('settings',$datas,"where se_id='5'");
        if( $db->getAffectedRows() > 0 )
        {
          $_SESSION["success"]="Updated Successfully";
        }
        else{
          $_SESSION["error"]="Updation Failed";          
        }
    $session_status = unset_session_success_and_session_error();
}
if(isset($_POST["period"]) && isset($_POST["percentage"])){
  $period=$_POST["period"];
  $percentage=$_POST["percentage"];
        $datas = array(
          'value'=>$period,                     
        );
        $value = $db->updateAry('settings',$datas,"where se_id='1'");
       
       $datas = array(
          'value'=>$percentage,                     
        );
        $value = $db->updateAry('settings',$datas,"where se_id='4'");

        $_SESSION["success"]="Updated Successfully";
        
    $session_status = unset_session_success_and_session_error();
}
?>
</head>
<body>
  <div id="wrapper">
    <?php include 'inc_leftmenubar.php'; ?>
    <!-- Page Content -->
    <div id="page-wrapper">
      <div class="container-fluid">
        <div class="row panel panel-default" style=" margin-top: 3em; padding: 0px 25px;">
          <div class="">
            <!-- <?php
              /*Session Alert Message*/
              if( isset($session_status) && !empty($session_status) )
              {
                echo msg($session_status);
              }
            ?> -->

            <div class="gradient-card-header">
              <h2 class="white-text mx-3">Settings</h2>
            </div>

            <!-- <button id="ADD" class="btn btn-info button-addnew pull-right" ><i class="fa fa-plus-circle" aria-hidden="true"></i>Add New &nbsp;&nbsp;<i class="fa fa-angle-down" aria-hidden="true"></i>
            </button> -->
            <br/>


                  <div class="col-md-4 col-md-offset-1 top15 panel">
                    <form method="post" action="" enctype="multipart/form-data">
                      
                        <span class="badge-label info-color p-2 ma-top20">Cooling Period <span class="grey">(in minutes)</span></span>
                        
                        <?php
                          $period = $db->getVal("select value from settings where se_id='1'");                          
                          if(!empty($period) )
                          {
                          ?>
                          <input class="form-control" type="number" name="period" value="<?=$period?>" />   
                          <?php
                          }
                          $percentage = $db->getVal("select value from settings where se_id='4'"); 
                        ?>                      

                        <span class="badge-label info-color p-2 ma-top20">Business Percentage <span class="grey">(%)</span></span>
                        <input class="form-control" type="number" name="percentage" value="<?=$percentage?>" />   

                        <div class="update_and_reset_btns sp_edit" style="padding-top: 15px;padding-bottom: 15px;">
                          <button type="submit" class="btn btn-primary btn-lg" name="update" style="font-size: 14px;margin-bottom: 5px;"><i class="fa fa-check" aria-hidden="true"></i> Update</button>

                          <button type="reset" class="btn btn-warning btn-lg" style="font-size: 14px;margin-bottom: 5px;"><i class="fa fa-times" aria-hidden="true"></i> Cancel</button>
                        </div>
                      
                    </form>
                  </div>

        		      <div class="col-md-4 col-md-offset-1 top15 panel">
                    <form method="post" action="" enctype="multipart/form-data">                      
                     
                        <?php
                          $seller_list = $db->getRow("select value,value2 from settings where se_id='5'");
                          ?>
                          <span class="badge-label info-color p-2 ma-top20">Hold Bid From</span>
                          <input class="form-control"  type="datetime-local" name="hold_bid" value="<?=  date('Y-m-d\TH:i',strtotime($seller_list['value'])) ?>" />


                          <span class="badge-label info-color p-2 ma-top20">Hold Bid To</span>
                          <input class="form-control"  type="datetime-local" name="hold_bid2" value="<?=date('Y-m-d\TH:i',strtotime($seller_list['value2']))?>" /> 
                          <?php                          
                        ?>

                        <div class="update_and_reset_btns sp_edit" style="padding-top: 15px;padding-bottom: 15px;">
                          <button type="submit" class="btn btn-primary btn-lg" name="update" style="font-size: 14px;margin-bottom: 5px;"><i class="fa fa-check" aria-hidden="true"></i> Update</button>

                          <button type="reset" class="btn btn-warning btn-lg" style="font-size: 14px;margin-bottom: 5px;"><i class="fa fa-times" aria-hidden="true"></i> Cancel</button>
                        </div>
                      
                    </form>
                  </div>


          </div>
          <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->

  </div>
  <!-- /#wrapper -->

  <?php include 'inc-script.php'; ?>

</body>

</html>
