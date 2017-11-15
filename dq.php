<?php 
	
	require 'core/config.php';
	require 'core/User.php';

	$u = new User;
	$u->startSess();
	$user = $u->authSess();

	if(!$user[0]){
		header("Location: index.php");
		exit();
	}

	if($user[1]["dq"] == 0){
		header("Location: dashboard.php");
		exit();		
	}

	$loggedIn = true;
	$styles = ["css/dq.css"];
	$scripts = [];
	$title = "Sudocrypt | Disqualified";

	$r = $dqReasons[$user[1]["dq"]];

?>

<!DOCTYPE html>
<html>
	<head>
		<?php require("struct/head.php"); ?>
	</head>
	<body>
		<?php require("struct/header.php"); ?>	
		<h2 class="ui-page-head">
			Disqualified
		</h2>
	
		<div id="cont">
			<h3>You have been disqualified</h3>
			<?php echo $r; ?>	
			If you feel this is not correct, you can contact us on our Facebook page. Please do not contact us asking for one more chance to play.
		</div>

	</body>
</html>