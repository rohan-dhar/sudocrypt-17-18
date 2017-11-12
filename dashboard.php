<?php 
	
	require 'core/config.php';
	require 'core/User.php';

	$u = new User;
	$u->startSess();

	if(!$u->authSess()[0]){
		header("Location: index.php");
		exit();
	}


	$loggedIn = true;
	$styles = ["css/dashboard.css"];
	$scripts = ["js/dashboard.js"];
	$title = "SudoCrypt | Dashboard";
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
			Dashboard
			<div class="extra-info">
				Sudocrypt 7.0 will start at 00:00:00 on 20st November 2017 and end at 23:59:59 on 21nd November 2017 (IST)
			</div>
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