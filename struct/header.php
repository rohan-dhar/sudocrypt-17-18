
<header class="ui-header">
	<div class="ui-header-mobile-menu"></div>
	
	<div class="ui-header-menu-open">
		<div class="ui-header-menu-open-stick" id="ui-header-menu-open-stick-1"></div>	
		<div class="ui-header-menu-open-stick" id="ui-header-menu-open-stick-2"></div>	
		<div class="ui-header-menu-open-stick" id="ui-header-menu-open-stick-3"></div>		
	</div>
	
	<a class="ui-menu-item" href="index.php">Home</a><a class="ui-menu-item" href="rules.php">Rules</a>
	<?php 
		if(@$loggedIn){
			echo '<a class="ui-menu-item" href="dashboard.php">Dashboard</a>';
		}
	?>
	<img class="ui-header-logo" src="img/logo.png" />
	

<?php 
	if(@$loggedIn){
		echo '<a class="ui-menu-item" href="play.php">Play</a>';
		echo '<a class="ui-menu-item" href="sudoQuest.php">SudoQuest</a>';		
		echo '<a class="ui-menu-item" href="signout.php">Signout</a>';
	}else{
		echo '<a class="ui-menu-item" href="signup.php">Sign Up</a>';
		echo '<a class="ui-menu-item" href="signin.php">Sign In</a>';
	}

?>

</header>