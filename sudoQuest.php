<?php 
	
	require 'core/config.php';
	require 'core/User.php';
	require 'core/SudoQuest.php';

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

	$sq = new SudoQuest($user[1]);

	$loggedIn = true;
	$styles = ["css/game.css", "css/sudoQuest.css"];
	$scripts = ["js/sudoQuest.js"];
	$title = "Sudocrypt | SudoQuest";
	$det = $user[1];

	$l = $sq->getQuestLevel();

	if(!$l[0]){
		$l[1]["id"] = null;
	}

?>

<!DOCTYPE html>
<html>
	<head>
		<?php require("struct/head.php"); ?>
		<script type="text/javascript"> window.questLevel = <?php echo json_encode(@$l[1]["id"]); ?>; </script>
	</head>
	<body>
		<?php require("struct/header.php"); ?>	
		<h2 class="ui-page-head">
			SudoQuest
		</h2>
		<?php 
			if($l[0]){
				$l = $l[1];
				echo '<div class="level-name"> Level <span>'.$l["id"].'</span> </div>';
				echo '<div class="level-ques">' . $l["question"] . '</div>';
				echo '<input type="text" class="ui-txt-inp" placeholder="Your answer" id="level-answer">';
				echo '<button class="ui-btn" id="level-go">Go</button>';
				echo '<div class="ui-load" id="level-load">';
					echo '<div class="ui-load-box ui-load-box-1"></div>';
					echo '<div class="ui-load-box ui-load-box-2"></div>';
					echo '<div class="ui-load-box ui-load-box-3"></div>';
					echo '<div class="ui-load-box ui-load-box-4"></div>';
				echo '</div>';
				echo '<br>';
				echo '<div id="status"></div>';
				echo '<div id="fake-padding-element"></div>';
			}else{
				echo '<div class="no-level"> <h3>Whoops</h3> No SudoQuests are available for you right now. Keep checking this page for any new SudoQuests to earn extra points.</div>';
			}

		?>
		


	</body>
</html>