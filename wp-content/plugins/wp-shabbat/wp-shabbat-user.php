<?php



   //Include dependencies

    include(plugin_dir_path( __FILE__ ). "geoipcity.inc");

    include(plugin_dir_path( __FILE__ ). "geoipregionvars.php");

    include(plugin_dir_path( __FILE__ ). "timezone/timezone.php");

	

	

 // Function to get the client ip address



function get_client_ip() {
	
    $ipaddress = '';

    if (array_key_exists('HTTP_CLIENT_IP', $_SERVER)){
		$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
		
	}
    else if(array_key_exists('HTTP_X_FORWARDED_FOR',$_SERVER)){
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
	}
    else if(array_key_exists('HTTP_X_FORWARDED',$_SERVER)){
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
	}
    else if(array_key_exists('HTTP_FORWARDED_FOR',$_SERVER)){
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
	}
    else if(array_key_exists('HTTP_FORWARDED',$_SERVER)){
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
	}
    else if(array_key_exists('REMOTE_ADDR',$_SERVER)){
        $ipaddress = $_SERVER['REMOTE_ADDR'];
	}
    else{
        $ipaddress = 'UNKNOWN';
	}

    return $ipaddress;

}



    //Get remote IP

   
	$ip = get_client_ip();
	//$ip = '213.151.44.95'; // set israel ip for local use
	//var_dump($ip);
	
    //Open GeoIP database and query our IP

    $gi = geoip_open(plugin_dir_path( __FILE__ ). "GeoLiteCity.dat", GEOIP_STANDARD);
    
    $record = geoip_record_by_addr($gi, $ip);

	//Calculate the timezone and local time

    try

    {

       
		$timezone = new DateTimeZone(get_time_zone($record->country_code, $record->region!='')); 
        $user_localtime = new DateTime("now",$timezone);

        $user_timezone_offset = $user_localtime->getOffset();

		

    }

    //Timezone and/or local time detection failed

    catch(Exception $e)

    {

        $user_timezone_offset = 7200;

        $user_localtime = new DateTime("now");

    }
	


$user_time =  $user_localtime->format('U')+ ($user_timezone_offset); // set user_time to users timestamp
$user_localday = $user_localtime->format('D');
function wp_shabbat_user_time(){
	global $user_time;
	return $user_time;
}
function wp_shabbat_user_localday(){
	global $user_localday;
	return $user_localday;
}
function wp_shabbat_user_timezone_offset(){
	global $user_timezone_offset;
	return $user_timezone_offset;
}
function wp_shabbat_user_record(){
	global $record;
	return $record;
}
?>