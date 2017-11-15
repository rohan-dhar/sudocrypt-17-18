<?php 
	
	require 'core/config.php';
	require 'core/User.php';
	require 'core/Game.php';

	$u = new User;
	$u->startSess();

	$user = $u->authSess();

	if(!$user[0]){
		header("Location: index.php");
		exit();
	}

	$g = new Game( $user[1]["id"] );
	$l = $g->checkGameAnswer("haha");
	

	var_dump($l);

?>