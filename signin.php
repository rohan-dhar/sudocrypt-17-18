<?php 
	
	require 'core/config.php';
	require 'core/User.php';

	$u = new User;
	$u->startSess();


	if($u->authSess()[0]){
		header("Location: dashboard.php");
		exit();
	}

	$loggedIn = false;
	$styles = ["css/signin.css"];
	$scripts = ["js/signin.js"];
	$title = "Sudocrypt | Sign In";

?>
<!DOCTYPE html>
<html>
	<head>
		<?php require("struct/head.php"); ?>
	</head>
	<body>
		<?php require("struct/header.php"); ?>	
		<h2 class="ui-page-head">Sign In</h2>
		
		<div id="cont">		
			<input type="email" class="ui-txt-inp log-inp" placeholder="Email" id="log-email">	
			<input type="password" class="ui-txt-inp log-inp" placeholder="Password" id="log-pass">
			<button class="ui-btn" id="log-go">Sign In</button>
		</div>
			

	</body>
</html>