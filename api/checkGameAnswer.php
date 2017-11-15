<?php 
	
	require '../core/config.php';
	require '../core/User.php';
	require '../core/Game.php';

	$u = new User;
	$u->startSess();
	$user = $u->authSess();

	if(!$user[0]){		
		exit(json_encode([false, "LOGOUT"]));
	}

	$g = new Game( $user[1] );
	exit(json_encode( $g->checkGameAnswer(@$_POST["answer"]) ));

?>