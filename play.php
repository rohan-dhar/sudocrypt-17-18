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

	if($user[1]["dq"] != 0){
		header("Location: dq.php");
		exit();		
	}

	$g = new Game( $user[1] );
	$level = $g->getGameLevel();

	if(!$level[0]){
		header("Location: dq.php");
		exit();		
	}

	$level = $level[1];

	$loggedIn = true;
	$styles = ["css/game.css"];
	$scripts = ["js/play.js"];
	$title = "Sudocrypt | Play";
	$det = $u->getDetails();

?>

<!DOCTYPE html>
<html>
	<head>
		<?php require("struct/head.php"); ?>
	</head>
	<body>
		<?php require("struct/header.php"); ?>	
		<h2 class="ui-page-head">
			Play
		</h2>
	
		<div class="level-name"> Level <span><?php echo $level["id"]; ?></span> </div>
		<div class="level-ques">
			<?php echo $level["question"] ?>
		</div>
		<input type="text" class="ui-txt-inp" placeholder="Your answer" id="level-answer">
		<button class="ui-btn" id="level-go">Go</button>
		
		<div class="ui-load" id="level-load">
			<div class="ui-load-box ui-load-box-1"></div>
			<div class="ui-load-box ui-load-box-2"></div>
			<div class="ui-load-box ui-load-box-3"></div>
			<div class="ui-load-box ui-load-box-4"></div>
		</div>
		<br>
		<div id="status"></div>
		<div id="fake-padding-element"></div>
		<!--
			<?php echo $level["sourceHint"]; ?>
		-->
	</body>
</html>