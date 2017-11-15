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

	if($user[1]["dq"] != 0){
		header("Location: dq.php");
		exit();		
	}

	$loggedIn = true;
	$styles = ["css/dashboard.css"];
	$scripts = ["js/dashboard.js"];
	$title = "Sudocrypt | Dashboard";
	$det = $user[1];

?>

<!DOCTYPE html>
<html>
	<head>
		<?php require("struct/head.php"); ?>
	</head>
	<body>
		<?php require("struct/header.php"); ?>	
		<h2 class="ui-page-head">
			Dashboard
		</h2>
	
		<h3 class="welcome">Welcome, <span class="welcome-name"><b><?php echo htmlentities($det["name"]); ?></b></span></h3>

		<div class="cont" id="cont-user">
			<input type="text" class="ui-txt-inp" placeholder="New Username" id="user-username"><br>
			<button class="ui-btn" id="user-go">Go</button>			
		</div>
		<div class="cont" id="cont-pass">
			<input type="password" class="ui-txt-inp" placeholder="New Password" id="pass-pass"><br>
			<input type="password" class="ui-txt-inp" placeholder="Confrim new Password" id="pass-pass-conf"><br>
			<button class="ui-btn" id="pass-go">Go</button>			
		</div>
		<div class="cont" id="cont-det">
			<div class="det-box">				
				<div class="det-type">Email</div><div class="det-data"> <?php echo htmlentities($det["email"]); ?> </div>
			</div>	
			<div class="det-box" id="det-box-user">				
				<div class="det-type">Username</div><div class="det-data"> <?php echo htmlentities($det["userName"]); ?> </div>
			</div>	
			<div class="det-box" id="det-box-score">				
				<div class="det-type">Score</div><div class="det-data"> <?php echo htmlentities($u->getScore()); ?> </div>
			</div>	
			<div class="det-box">				
				<div class="det-type">Institute</div><div class="det-data"> <?php echo htmlentities($det["organisation"]); ?> </div>
			</div>	
			<div class="det-box">				
				<div class="det-type">Country</div><div class="det-data"> <?php echo htmlentities($det["country"]); ?> </div>
			</div>	
		</div>


		<button class="ui-btn dash-btn" id="change-user">Change Username</button>			
		<button class="ui-btn dash-btn" id="change-pass">Change Password</button>					
		<button class="ui-btn dash-btn" id="cancel-extra">Cancel</button>				


	</body>
</html>