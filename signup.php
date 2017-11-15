<?php 
	
	require 'core/config.php';

	$styles = ["css/signup.css"];
	$scripts = ["js/signup.js"];
	$title = "
Sudocrypt | Sign Up";

?>
<!DOCTYPE html>
<html>
	<head>
		<?php require("struct/head.php"); ?>
	</head>
	<body>
		<?php require("struct/header.php"); ?>	
		<h2 class="ui-page-head">Sign Up For 
Sudocrypt 2017</h2>
		<input type="text" class="ui-txt-inp reg-inp" placeholder="Name" id="reg-name">
		<input type="email" class="ui-txt-inp reg-inp" placeholder="Email" id="reg-email">
		<br>
		<input type="text" class="ui-txt-inp reg-inp" placeholder="Username" id="reg-user">
		<br>
		<input type="password" class="ui-txt-inp reg-inp" placeholder="Password" id="reg-pass">
		<input type="password" class="ui-txt-inp reg-inp" placeholder="Confirm Password" id="reg-pass-conf">
		<br>
		<input type="text" class="ui-txt-inp reg-inp" placeholder="Institution / Organisation" id="reg-ins">		
		<select class="ui-text-inp reg-inp" id="reg-cnt">			
			<option disabled selected>Country</option>
			<?php 
				$html = "";
				foreach($countries as $c){
					$html .= "<option value='".$c."'>".$c."</option>";
				}
				echo $html;
			?>			
		</select>
	
		<button class="ui-btn" id="reg-go">Sign up</button>
	
		<footer> &copy; <a target="_blank" href="http://exunclan.com">Exun Clan</a> 2017-18 | <a target="_blank" href="http://dpsrkp.net">DPS RK Puram</a> </footer>

	</body>
</html>