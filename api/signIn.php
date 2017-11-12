<?php 

	require '../core/config.php';
	require '../core/User.php';

	$u = new User;
	$u->startSess(true);	    

	exit(json_encode( $u->signIn(
		@$_POST["email"],
		@$_POST["pass"]
	) ));

?>