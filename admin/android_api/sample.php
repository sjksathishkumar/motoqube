<?php include '../../config.php'; 
include 'header.php';
header('Content-type: application/json');

		$res = array();
        $res['notification']['sound'] = "beep_sound.mp3";
        $res['notification']['channel_id'] ="SparesDoBuyer";
        $res['data']['title'] = "Hi";
        $res['data']['message'] = "Welcome Message";
        $res['data']['image'] = null;
        $res['data']['type'] = "default";
        $res['data']['id'] = 0;
        $res['data']['screen']="main";
        $res['data']['bookingid']="SBD0001";

       // print_r(json_encode($res));

        $value = sendfcm(array("fY78JCFISICSLuuEi_QiW2:APA91bGEUHdSmNSPf4HUJx4MmkPoSa4_g754tWeVkVKLepfVMr0Ay6Kz2_UTAnnQoPL9Jh3bX5S6vEVbP55GKZftfzBSV6Ra1NOTrRJZrHOwphvJ-fp7qy66JTAgAuxwAdRhrHNsWA0O"), $res);

        print_r($value);
        // return $res;

?>