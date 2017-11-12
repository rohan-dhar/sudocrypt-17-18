<header class="ui-header">
	<a class="ui-menu-item" href="index.php">Home</a><a class="ui-menu-item" href="rules.php">Rules</a><img class="ui-header-logo" src="img/logo.png" />

<?php 
	if(@$loggedIn){
		echo '<a class="ui-menu-item" href="dashboard.php">Dashboard</a>';
		echo '<a class="ui-menu-item" href="signout.php">Sign Out</a>';
	}else{
		echo '<a class="ui-menu-item" href="signup.php">Sign Up</a>';
		echo '<a class="ui-menu-item" href="signin.php">Sign In</a>';
	}

?>

</header>