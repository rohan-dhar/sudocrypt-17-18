<?php 

	require 'core/config.php';
	require 'core/SudoQuest.php';

	if(@$_GET["pass"] !== "admin_123"){
		header("Location: index.php");
		exit();
	}

	$s = new SudoQuest;

	if(isset($_POST["add-go"])){
		$s->addQuest(@$_POST["add-ques"], @$_POST["add-ans"]);
		header("Location: #");
	}
	
	$styles = ["css/inter.css", "css/sadmin.css"];
	$scripts = ["js/sadmin.js"];
	$title = "Sudocrypt | Admin";
	$loggedIn = false;

	$qry = $db->prepare("SELECT * FROM sudoQuest");
	$qry->execute();
	$all = $qry->fetchAll(PDO::FETCH_ASSOC);


?>
<!DOCTYPE html>
<html>
	<head>
		<?php require("struct/head.php"); ?>
	</head>
	<body>
		<?php require("struct/header.php"); ?>	
		<h2 class="ui-page-head">SudoQuest Admin</h2>
		<h3 class="sub-head">Add a SudoQuest</h3>
		<form action="#" method="post">
			<textarea required name="add-ques" placeholder="Question" class="ui-txt-inp" id="add-ques"></textarea>
			<input required type="text" name="add-ans" placeholder="Answer" class="ui-txt-inp" id="add-ans">			
			<input required type="submit" name="add-go" class="ui-btn" id="add-go">
		</form>
		<h3 class="sub-head">All SudoQuests</h3>
		<table>
			<tr>
				<th>Level</th>
				<th>Question</th>
				<th>Answer</th>				
				<th>Status</th>
			</tr>
			<?php 
				$html = "";
				foreach($all as $l){
					$html .= "<tr> <td>".$l["id"]."</td>";
					$html .= "<td class='ques-col'>".$l["question"]."</td>";					
					$html .= "<td>".$l["answer"]."</td>";										
					if($l["status"] == 0){
						$html .= "<td class='status-red'>Closed</td>";
					}else if($l["status"] == 1){
						$html .= "<td class='status-green'>Open</td>";						
					}else{						
						$html .= "<td class='status-blue'>In line</td>";						
					}
					$html .= "</tr>";
				}
				echo $html;
			?>		
		</table>
		<div id="inv"></div>
	</body>
</html>