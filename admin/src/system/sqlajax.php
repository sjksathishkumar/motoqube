<?php 
if(isset($_POST['id'])){
$arrRes['validation']= "1";
	$Password = 'TVVWSUVSRUNLYWRtaW5AMTIz';
  $arrRes['password']=  $Password;
	 echo json_encode($arrRes);	
}
?>