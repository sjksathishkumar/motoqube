<?php include '../../config.php'; 
include 'header.php';
header('Content-type: application/json');

$arrResult['status'] = 'success'; 
$arrResult['code'] = 200; 				
$arrResult['payment_methods']=array();

$result["methods"] =array(array("name"=>"Online Payment","active"=>1),
	array("name"=>"Bank Transfer","active"=>1),
	array("name"=>"UPI","active"=>1));
$result["razorpay"]=array("key_id"=>"rzp_test_hJXD7F3kp3qLBF","key_secret"=>"cSALvCOn9PvzCnBgb7WmAnBm","payment_fee"=>"2");
$result["UPI"]=array("UPI_ID"=>"sparesdo@okaxis");
$result["Bank_Transfer"]=array("Account_Name"=>"sparesdo","Account_Number"=>"1734155000044772","IFSC"=>"KVBL0001734","Branch"=>"GUDIYATHAM, TAMIL NADU");



array_push($arrResult['payment_methods'], $result);
echo json_encode($arrResult);
?>