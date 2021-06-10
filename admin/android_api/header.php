<?php
$name = base64_decode("U3BhcmVzRE9BUEk=");
$sess= base64_decode("U3BhcmVzRE9BUElBZG1pbkAxMjM=");
$valid = array ($name => $sess);
$valid_users = array_keys($valid);

$user = $_SERVER['PHP_AUTH_USER'];
$pass = $_SERVER['PHP_AUTH_PW'];

$validated = (in_array($user, $valid_users)) && ($pass == $valid[$user]);

if (!$validated) {
  header('WWW-Authenticate: Basic realm="My Realm"');
  header('HTTP/1.0 401 Unauthorized');
  die ("Not authorized");
}

function error203(){	
	$arrResult1['status'] = 'error'; 
	$arrResult1['code'] = 203; 				
	$arrResult1['message'] = 'Mandatory Fields Missing!';
	echo json_encode($arrResult1);
	exit;
}

function invalid_auth(){	
	$arrResult1['status'] = 'error'; 
	$arrResult1['code'] = 203; 				
	$arrResult1['message'] = 'Invalid Authentication!';
	echo json_encode($arrResult1);
	exit;
}
function verifyseller(){
global $db;
	if(isset($_POST["seller_id"]) && isset($_POST["token"])){
		$seller_id = $_POST["seller_id"];
		$token = $_POST["token"];

		$seller = $db->getRow("select * from sp_seller where seller_id='$seller_id' and api_token='$token'");
		if(count($seller)>0){}else{
			// invalid_auth();
		}
	}
	else{
		// invalid_auth();
	}
}

function verifybuyer(){
global $db;
	if(isset($_POST["buyer_id"]) && isset($_POST["token"])){
		$buyer_id = $_POST["buyer_id"];
		$token = $_POST["token"];
		$buyer = $db->getRow("select * from sp_buyer where buyer_id='$buyer_id' and api_token='$token'");
		if(count($buyer)>0){return $buyer;}else{invalid_auth();}
	}
	else{
		invalid_auth();
	}
}

function notification_insert($section,$section_id,$name){
global $db;
	$details = array(
		'section'=>$section,
	    'section_id' => $section_id,
	    'name' => $name,
	);
	$result_data = $db->insertAry('sp_notifications', $details);
	// echo $db->getLastQuery();
}
?>