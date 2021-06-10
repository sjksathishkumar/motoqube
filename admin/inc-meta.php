<?php 
include("../config.php");
if(!empty($_SESSION["SPARESDO_subadminlogin"]) )
{
    if(!empty($_SESSION["SPARESDO_adminlogin"]))
    {
        $spareslogin=$_SESSION["SPARESDO_adminlogin"];
    }
    else
    { 
        $spareslogin=$_SESSION["SPARESDO_subadminlogin"];
    }
}
else
{
    echo "<script>window.location.href='login.php';</script>";
}

$yesterday_timestamp = strtotime("- 1 day");
$yesterday_date = date("Y-m-d", $yesterday_timestamp);

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<title>SparesDo</title>
<!-- Bootstrap Core CSS -->
<link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<!-- MetisMenu CSS -->
<link href="vendor/metisMenu/metisMenu.min.css" rel="stylesheet">
<!-- Custom CSS -->
<link href="dist/css/sb-admin-2.css" rel="stylesheet">
<!-- datatable -->
<link href="vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">
<!-- DataTables Responsive CSS -->
<link href="vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">
<!-- column button visibility -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">
<!--  -->
<!-- w3 -->
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<!-- Select2 css and js file -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<!----------------jquery alert plugin---------->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css">
<!-- jquery u.i -->
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<!---- Custom Css --->
<link href="dist/css/custom.css" rel="stylesheet">
<link href="dist/css/ck_edidor_styles.css" rel="stylesheet">
<link href="dist/css/mdb-button-styles.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
<!-- Custom CSS -->
<link href="css/custom_common.css" rel="stylesheet">
<?php include("inc_permission.php"); ?>