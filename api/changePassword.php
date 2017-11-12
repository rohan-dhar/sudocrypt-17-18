<?php 

	require '../core/config.php';
	require '../core/User.php';

	$u = new User;
	$u->startSess(true);	    
	$l = $u->authSess();

	if(!$l[0]){
		exit(json_encode([false, "LOGOUT"]));
	}

	exit(json_encode( $u->changePassword(
		@$_POST["pass"],
		@$_POST["passC"]
	) ));

?>