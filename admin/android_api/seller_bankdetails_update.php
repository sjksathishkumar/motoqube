<?php include '../../config.php'; 
include 'header.php';
header('Content-type: application/json');
if (isset($_POST['seller_id']) && !empty($_POST['seller_id']) ){
	$seller_id=$_POST['seller_id'];     		
		$fields_data = array(
          'account_name'  => isset($_POST['account_name'])?$_POST['account_name']:'',
          'account_number'  => isset($_POST['account_number'])?$_POST['account_number']:'',
          'bank'  => isset($_POST['bank'])?$_POST['bank']:'',
          'ifsc'  => isset($_POST['ifsc'])?$_POST['ifsc']:'',
          'gpay'  => isset($_POST['g-pay'])?$_POST['g-pay']:'',
          'phonepay'  => isset($_POST['phonepe'])?$_POST['phonepe']:'',
        );
          $result = $db->updateAry('sp_seller_account', $fields_data,"where seller_id='$seller_id'");
			if($db->getAffectedRows()>0){ 
				$arrResult2['status'] = 'success'; 
				$arrResult2['code'] = 200; 				
				$arrResult2['message'] = "Updated Successfully !";	
			}
			else{
				$arrResult2['status'] = 'error'; 
				$arrResult2['code'] = 201; 				
				$arrResult2['message'] = "Updation Failed! Already Updated";
			}
			echo json_encode($arrResult2);
	exit;
}
else{
	error203();
}
