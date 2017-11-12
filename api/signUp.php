<?php 

	require '../core/config.php';
	require '../core/User.php';

	$u = new User;
	
    $ip = $_SERVER["REMOTE_ADDR"];    
    if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP)){
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP)){
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    }
    
	$ipInfo = @unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.$ip));    
	$iCnt = @$ipInfo["geoplugin_countryName"];
    

	exit(json_encode( $u->signUp(
		@$_POST["name"],
		@$_POST["email"],
		@$_POST["userName"],
		@$_POST["pass"],
		@$_POST["passC"],
		@$_POST["organisation"],
		@$_POST["country"],
		$iCnt
	) ));


?>