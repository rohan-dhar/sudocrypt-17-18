<?php 
	
	require '../core/config.php';
	require '../core/User.php';
	require '../core/SudoQuest.php';

	$u = new User;
	$u->startSess();
	$user = $u->authSess();

	if(!$user[0]){		
		exit(json_encode([false, "LOGOUT"]));
	}

	$sq = new SudoQuest( $user[1] );
	exit(json_encode( $sq->checkQuestAnswer(@$_POST["answer"], @$_POST["level"]) ));

?>