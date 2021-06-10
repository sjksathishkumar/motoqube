<?php
$curPageName = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1); 
echo "<script>var pgnm = '$curPageName';</script>"; 
if(isset($spareslogin)){
    if($spareslogin == 'yes')
    {
        $LoggedInName = 'Admin';$bookings_edit=1;
        ?><style>.sp_add,.sp_edit,.sp_delete,.subadmin_view{visibility: visible !important;}</style><?php
          // echo "<script>window.addEventListener('load', function(){ $('.sp_add, .sp_edit, .sp_delete').remove();});</script>";

    echo "<script>window.addEventListener('load', function(){ $('body').css('display','block');});</script>";
    }
    else if($spareslogin != 'yes')
    {
     $view=$edit=$delete=$add=0;
     $sb_id=$_SESSION["SPARESDO_subadminlogin"];
      $result_data = $db->getRow("select * from sp_subadmin where sb_id='".$sb_id."' Limit 1");
      if(count($result_data) > 0){ } else{ header('Location: index.php'); }
      $rights = (object) json_decode($result_data['rights']);
      $dashboard_view = (isset($rights->dashboard_view) && !empty($rights->dashboard_view) && $rights->dashboard_view != null)?$rights->dashboard_view:"0";

         //---------- 
          if($curPageName=="index.php"){
            $view = $dashboard_view;      
          }
          // -----------

      $vehicle_view = (isset($rights->vehicle_view) && !empty($rights->vehicle_view) && $rights->vehicle_view != null)?$rights->vehicle_view:"0";
      $vehicle_add = (isset($rights->vehicle_add) && !empty($rights->vehicle_add) && $rights->vehicle_add != null)?$rights->vehicle_add:"0";
      $vehicle_edit = (isset($rights->vehicle_edit) && !empty($rights->vehicle_edit) && $rights->vehicle_edit != null)?$rights->vehicle_edit:"0";
      $vehicle_delete = (isset($rights->vehicle_delete) && !empty($rights->vehicle_delete) && $rights->vehicle_delete != null)?$rights->vehicle_delete:"0";
        //---------- 
          if($curPageName=="car_make.php" || $curPageName=="car_model.php" || $curPageName=="car_year.php" || $curPageName =="car_variant.php" || $curPageName=="bike_make.php" || $curPageName=="bike_model.php" || $curPageName=="bike_year.php" || $curPageName =="bike_variant.php" ){
            $view = $vehicle_view;
            $add = $vehicle_add;        
            $edit = $vehicle_edit;
            $delete = $vehicle_delete;    
            if($view==0){
              echo "<script>window.addEventListener('load', function(){ window.location.href='index.php'});</script>";     
            }
          }
          // -----------


      $sellers_view= (isset($rights->sellers_view) && !empty($rights->sellers_view) && $rights->sellers_view != null)?$rights->sellers_view:"0";
      $sellers_edit= (isset($rights->sellers_edit) && !empty($rights->sellers_edit) && $rights->sellers_edit != null)?$rights->sellers_edit:"0";
      $sellers_delete= (isset($rights->sellers_delete) && !empty($rights->sellers_delete) && $rights->sellers_delete != null)?$rights->sellers_delete:"0";
        //---------- 
          if($curPageName=="sellers.php" || $curPageName=="view_seller.php"){
            $view = $sellers_view;   
            $edit = $sellers_edit;
            $delete = $sellers_delete;  
             if($view==0){
              echo "<script>window.addEventListener('load', function(){ window.location.href='index.php'});</script>";     
            }       
          }
        // -----------

      $buyers_view= (isset($rights->buyers_view) && !empty($rights->buyers_view) && $rights->buyers_view != null)?$rights->buyers_view:"0";
      $buyers_edit= (isset($rights->buyers_edit) && !empty($rights->buyers_edit) && $rights->buyers_edit != null)?$rights->buyers_edit:"0";
      $buyers_delete= (isset($rights->buyers_delete) && !empty($rights->buyers_delete) && $rights->buyers_delete != null)?$rights->buyers_delete:"0";

       //---------- 
          if($curPageName=="buyers.php" || $curPageName=="view_buyer.php"){
            $view = $buyers_view;   
            $edit = $buyers_edit;
            $delete = $buyers_delete;  
             if($view==0){
              echo "<script>window.addEventListener('load', function(){ window.location.href='index.php'});</script>";     
            }       
          }
        // -----------

      $banners_view= (isset($rights->banners_view) && !empty($rights->banners_view) && $rights->banners_view != null)?$rights->banners_view:"0";
      $banners_add= (isset($rights->banners_add) && !empty($rights->banners_add) && $rights->banners_add != null)?$rights->banners_add:"0";
      $banners_delete= (isset($rights->banners_delete) && !empty($rights->banners_delete) && $rights->banners_delete != null)?$rights->banners_delete:"0";

        //---------- 
          if($curPageName=="buyer_banner.php" || $curPageName=="seller_banner.php"){
            $view = $banners_view;   
            $add = $banners_add;
            $delete = $banners_delete;  
             if($view==0){
              echo "<script>window.addEventListener('load', function(){ window.location.href='index.php'});</script>";     
            }       
          }
        // -----------

      $bookings_view= (isset($rights->bookings_view) && !empty($rights->bookings_view) && $rights->bookings_view != null)?$rights->bookings_view:"0";
      $bookings_edit= (isset($rights->bookings_edit) && !empty($rights->bookings_edit) && $rights->bookings_edit != null)?$rights->bookings_edit:"0";
      $bookings_delete= (isset($rights->bookings_delete) && !empty($rights->bookings_delete) && $rights->bookings_delete != null)?$rights->bookings_delete:"0";
        //---------- 
          if($curPageName=="bookings.php" || $curPageName=="view_bookings.php"){
            $view = $bookings_view;   
            $edit = $bookings_edit;
            $delete = $bookings_delete;  
             if($view==0){
              echo "<script>window.addEventListener('load', function(){ window.location.href='index.php'});</script>";     
            }       
          }
        // -----------

      $locations_view= (isset($rights->locations_view) && !empty($rights->locations_view) && $rights->locations_view != null)?$rights->locations_view:"0";
      $locations_add= (isset($rights->locations_add) && !empty($rights->locations_add) && $rights->locations_add != null)?$rights->locations_add:"0";
      $locations_edit= (isset($rights->locations_edit) && !empty($rights->locations_edit) && $rights->locations_edit != null)?$rights->locations_edit:"0";
      $locations_delete= (isset($rights->locations_delete) && !empty($rights->locations_delete) && $rights->locations_delete != null)?$rights->locations_delete:"0";

        //---------- 
          if($curPageName=="buyer_locations.php" || $curPageName=="locations.php"){
            $view = $locations_view;   
            $add = $locations_add;
            $edit= $locations_edit;
            $delete = $locations_delete;  
             if($view==0){
              echo "<script>window.addEventListener('load', function(){ window.location.href='index.php'});</script>";     
            }       
          }
        // -----------

      $popular_view= (isset($rights->popular_view) && !empty($rights->popular_view) && $rights->popular_view != null)?$rights->popular_view:"0";
      $popular_add= (isset($rights->popular_add) && !empty($rights->popular_add) && $rights->popular_add != null)?$rights->popular_add:"0";
      $popular_edit= (isset($rights->popular_edit) && !empty($rights->popular_edit) && $rights->popular_edit != null)?$rights->popular_edit:"0";
      $popular_delete= (isset($rights->popular_delete) && !empty($rights->popular_delete) && $rights->popular_delete != null)?$rights->popular_delete:"0";

         //---------- 
          if($curPageName=="popular_locations.php" || $curPageName=="popular_locations_state.php"){
            $view = $popular_view;   
            $add = $popular_add;
            $edit= $popular_edit;
            $delete = $popular_delete;  
             if($view==0){
              echo "<script>window.addEventListener('load', function(){ window.location.href='index.php'});</script>";     
            }       
          }
        // -----------

      $contents_view= (isset($rights->contents_view) && !empty($rights->contents_view) && $rights->contents_view != null)?$rights->contents_view:"0";
      $contents_edit= (isset($rights->contents_edit) && !empty($rights->contents_edit) && $rights->contents_edit != null)?$rights->contents_edit:"0";
      $contents_delete= (isset($rights->contents_delete) && !empty($rights->contents_delete) && $rights->contents_delete != null)?$rights->contents_delete:"0";

       //---------- 
          if($curPageName=="contents.php"){
            $view = $contents_view;   
            $edit = $contents_edit;
            $delete = $contents_delete;  
             if($view==0){
              echo "<script>window.addEventListener('load', function(){ window.location.href='index.php'});</script>";     
            }       
          }
        // -----------

      $settings_view= (isset($rights->settings_view) && !empty($rights->settings_view) && $rights->settings_view != null)?$rights->settings_view:"0";
      $settings_edit= (isset($rights->settings_edit) && !empty($rights->settings_edit) && $rights->settings_edit != null)?$rights->settings_edit:"0";

       //---------- 
          if($curPageName=="settings.php"){
            $view = $settings_view;   
            $edit = $settings_edit; 
             if($view==0){
              echo "<script>window.addEventListener('load', function(){ window.location.href='index.php'});</script>";     
            }       
          }
        // -----------

        //---------- 
          if($curPageName=="subadmin.php" || $curPageName=="roles_rights.php"){
              echo "<script>window.addEventListener('load', function(){ window.location.href='index.php'});</script>";
          }

          if($vehicle_view=="0"){echo "<script>window.addEventListener('load', function(){ $('.vehicle_view').remove(); });</script>";  }
          if($sellers_view=="0"){echo "<script>window.addEventListener('load', function(){ $('.sellers_view').remove(); });</script>";  }
          if($buyers_view=="0"){echo "<script>window.addEventListener('load', function(){ $('.buyers_view').remove(); });</script>";  }
          if($banners_view=="0"){echo "<script>window.addEventListener('load', function(){ $('.banners_view').remove(); });</script>";  }
          if($bookings_view=="0"){echo "<script>window.addEventListener('load', function(){ $('.bookings_view').remove(); });</script>";  }
          if($locations_view=="0"){echo "<script>window.addEventListener('load', function(){ $('.locations_view').remove(); });</script>";  }
          if($popular_view=="0"){echo "<script>window.addEventListener('load', function(){ $('.popular_view').remove(); });</script>";  }
          if($contents_view=="0"){echo "<script>window.addEventListener('load', function(){ $('.contents_view').remove(); });</script>";  }         
          if($settings_view=="0"){echo "<script>window.addEventListener('load', function(){ $('.settings_view').remove(); });</script>";  }
        // -----------

    if($view==0){
        ?><style>.sp_view{display: none !important;}</style><?php        
           echo "<script>window.addEventListener('load', function(){ $('.sp_view').remove();})</script>";
    }
    else{
    ?><style>.sp_view{visibility: visible !important;} .dt-button.buttons-excel{display:none;}</style><?php
    }
    if($add==0){?><style>.sp_add{display: none !important;}</style><?php   
        echo "<script>window.addEventListener('load', function(){ $('.sp_add').remove();})</script>";
    }
    else{ 
        ?><style>.sp_add{visibility: visible !important;}</style><?php
    }
    if($edit==0){?><style>.sp_edit{display: none !important;}</style><?php   
        echo "<script>window.addEventListener('load', function(){ $('.sp_edit').remove();})</script>";
    }
    else{ 
        ?><style>.sp_edit{visibility: visible !important;}</style><?php
    }
    if($delete==0){?><style>.sp_delete{display: none !important;}</style><?php   
           echo "<script>window.addEventListener('load', function(){ $('.sp_delete').remove();});</script>";
    }
    else{
         ?><style>.sp_delete{visibility: visible !important;}</style><?php
    }

      echo "<script>window.addEventListener('load', function(){ $('.subadmin_view').remove(); $('body').css('display','block');});</script>";     
    }
    else { 
        echo "<script>window.location.href='login.php';</script>";
    }
}
else{
 redirect('login.php');
}
?>