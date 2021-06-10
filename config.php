<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    date_default_timezone_set("Asia/Calcutta");
    $varAdminFolder = "manage";
    //$_SESSION['lang'] = 'french';

    define("DS", DIRECTORY_SEPARATOR);

    define("PATH_ROOT", dirname(__FILE__));

    define("PATH_LIB", PATH_ROOT . DS . "library" . DS);

    define("PATH_MAIL", PATH_ROOT . DS . "phpmail" . DS);

    define("PATH_ADMIN", PATH_ROOT . DS . $varAdminFolder . DS);

    define("PATH_ADMIN_MODULE", PATH_ADMIN . "modules" . DS);

    define("PATH_CLASS", PATH_ROOT . DS . "classes" . DS);

    //define("URL_ROOT", "http://localhost/sparesdo");
   // define("URL_ROOT1", "http://localhost/sparesdo/admin");   

     define("URL_ROOT", "https://www.sparesdo.in");
     define("URL_ROOT1", "https://www.sparesdo.in/admin");

    define("URL_ADMIN", URL_ROOT . $varAdminFolder . "/");

    define("URL_ADMIN_HOME", URL_ADMIN . "user-login.php");

    define("URL_ADMIN_CSS", URL_ADMIN . "css/");

    define("URL_ADMIN_JS", URL_ADMIN . "js/");

    define("URL_ADMIN_IMG", URL_ADMIN . "img/");

    define("SELF", basename($_SERVER['PHP_SELF']));

    define("DATE_FORMAT", "d/m/Y H:i:s");


    define("ADMIN_TITLE", "Muviereck Technology");
    define("COPY_RIGHT", "Copyright  2018 . Powered By Muviereck Technology | All rights reserved .");

    //define RegX expressions
    define("REGX_MAIL", "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/");
    define("REGX_URL", "/^(http(s)?\:\/\/(?:www\.)?[a-zA-Z0-9]+(?:(?:\-|_)[a-zA-Z0-9]+)*(?:\.[a-zA-Z0-9]+(?:(?:\-|_)[a-zA-Z0-9]+)*)*\.[a-zA-Z]{2,4}(?:\/)?)$/i");
    define("REGX_PHONE", "/^[0-9\+][0-9\-\(\)\s]+[0-9]$/");
    define("REGX_PRICE", "/^[0-9\.]+$/");

    require_once(PATH_LIB."validations.php");
    require_once(PATH_LIB."class.database.php");

    /* Local Connection */

    //$db_host = "localhost";
    //$db_user = "root";
    //$db_password = "";
    //$db_tablename = "sparesdo";

    // sparesd.in
    $db_host ="localhost";
    $db_user ="farmssm_sparesd";
    $db_password ="QjJWZbF1";
    $db_tablename ="farmssm_sparesd";

    $db=new MySqlDb($db_host,$db_user,$db_password,$db_tablename);
    $dbcon=mysqli_connect($db_host,$db_user,$db_password,$db_tablename);

    require_once(PATH_LIB."functions.php");
    require_once(PATH_MAIL."class.phpmailer.php");
    
    /*Custom Functions*/
    require_once(PATH_LIB."custom-functions.php");

    $pagename=basename($_SERVER['PHP_SELF']);
    $base_url = constant('URL_ROOT');
    $base_url_slash = constant('URL_ROOT')."/";
    $base_url1 = constant('URL_ROOT1');

	//Display Product Name with limited character
	//10-jan-2019
	function custom_character($x, $length)
	{
	    if(strlen($x)<=$length)
	    {
	      return $x;
	    }
	    else
	    {
	      $y=substr($x,0,$length) . '...';
	      return $y;
	    }
	}

	//fucntion : time_elapsed_string()
	//Desc : Get Last time ago calculation.
    function time_elapsed_string($datetime, $full = false) {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }

    $SMSapiKey = urlencode('IdTGmAJYM14-7Q2Iv6U09swdQtxUWTgtXL9XnoXrzC  ');
    $senderID = urlencode('spardo');
    $AdminMobileNumber = '9655959576';

    function bookingid($id){return "BSD".str_pad($id, 3, '0', STR_PAD_LEFT);}
    function sellerid($id){return "SDS".str_pad($id, 3, '0', STR_PAD_LEFT);}
    function buyerid($id){return "SDB".str_pad($id, 3, '0', STR_PAD_LEFT);}

 function sendfirebasenotification($registration_id,$body,$title,$image=NULL,$screen=main,$id=NULL,$scheduled=false,$date=NULL,$app="buyer"){
    if($app =="seller"){
        $server_key = 'AAAAO341nbo:APA91bH8pgWEb8-tltlhvpkwD0VSXCrdIULCGgta3pCnsA5ApvDJfLOcHmLaSNXSOdIZhAa5w2orGYP_f3kTCInn7f2181_yP2MDBXJNlOFaPh9rqV23ylM6pg2ItQYINjE0L1oruxjg';
    }
    else{
        $server_key = 'AAAA9SoVYJU:APA91bEfyYlS-31QsCPebi5-tLwuWAhqnZrgkEWzaFcRMaaD-Vb0dyXJZqipCvGUCH2C52PT3E-f_-RAmuWTGWykp21lKFTkMQzU8zCOwJ8xetmXxT8ux5jEPwK3oTfG-RgpdU0ZU-wN';
    }
        if($app=="seller"){$android_channel_id="channelseller3";}

        else{$android_channel_id="channelseller3";}

        // $registration_id = json_encode($registration_id);
		 $json_data =[
            "registration_ids"=>$registration_id, "priority"=> "high",
             "data" => [
                 "message" => $body,
                 "title"=> $title,
                 "icon" => "sparesdo_logo_blk",
                 "sound" => "notifysound.wav",
                 "color" => "#ffa400",
                 "bookingid" => $id,
                 "image"=>"",
                 "screen" =>$screen,
                 "click_action"=> $screen,
                 "android_channel_id"=> $android_channel_id,
                 "isScheduled" => $scheduled,
                 "scheduledTime" => $date
             ],
             "notification" => [
                "body" => $body,
                 "title"=> $title,
                 "icon" => "sparesdo_logo_blk",
                 "sound" => "notifysound.wav",
                 "color" => "#ffa400",
                 "bookingid" => $id,
                 "image"=>"",
                 "screen" =>$screen,
                 "click_action"=> $screen,
                 "android_channel_id"=> $android_channel_id,
                 "isScheduled" => $scheduled,
                 "scheduledTime" => $date
             ]
        ];

        $data = json_encode($json_data);
        //FCM API end-point
        $url = 'https://fcm.googleapis.com/fcm/send';
        //api_key in Firebase Console -> Project Settings -> CLOUD MESSAGING -> Server key
       
        //header with content_type api key
        $headers = array(
            'Content-Type:application/json',
            'Authorization:key='.$server_key
        );
        //CURL request to route notification to FCM connection server (provided by Google)
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $result = curl_exec($ch);
       if ($result === FALSE) {
        die('Oops! FCM Send Error: ' . curl_error($ch));
    }
    return $result;
    curl_close($ch);
    }
?>

