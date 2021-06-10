<?php include '../../config.php'; 
include 'header.php';
header('Content-type: application/json');
				$arrResult1['status'] = 'success'; 
				$arrResult1['code'] = 200; 	
				$time = $db->getRow("select value,value2 from settings where se_id='5'");
				$period = $db->getVal("select value from settings where se_id='1'");

				$from= date('YmdHi',strtotime($time["value"]));
				$to= date('YmdHi',strtotime($time["value2"]));
				$current_date = date('YmdHi');

				if($current_date>=$from && $current_date<=$to){
					$hold=1;
				}
				else{
					$hold=0;
				}
				$arrResult1['hold'] =$hold;
				$arrResult1['cooling_time'] =$period;

		echo json_encode($arrResult1);
		exit;

?>