<?php 
	
	require 'core/config.php';
	require 'core/User.php';

	$u = new User;
	$u->startSess();
	$loggedIn = $u->authSess()[0];

	$styles = ["css/index.css"];
	$scripts = ["js/index.js"];
	$title = "Sudocrypt | Home";

?>
<!DOCTYPE html>
<html>
	<head>
		<?php require("struct/head.php"); ?>
	</head>
	<body>
		<?php require("struct/header.php"); ?>	

		<div id="cont">			
			<h2 class="sub">It's here.</h2> 
			<h1>
			Sudocrypt <span>7</span></h1>		
			<h4 class="time">From <span>00:00:00</span> on <span>20 November 2017</span> <br>to <span>11:59:59</span> on <span>21 November 2017</span></h4>
		</div>

		<footer> &copy; <a target="_blank" href="http://exunclan.com">Exun Clan</a> 2017-18 | <a target="_blank" href="http://dpsrkp.net">DPS RK Puram</a> </footer>

	</body>
</html>