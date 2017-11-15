<?php 

class SudoQuest{
	
	private $user;

	function __construct($user = false){
		$this->user = $user;
	}

	public function getQuestLevel(){
		
		if($this->user["dq"] != 0){
			return [false];
		}

		$db = $GLOBALS["db"];		

		$qry = $db->prepare("SELECT * FROM sudoQuest WHERE status = 1 LIMIT 1");
		$qry->execute();		
		$l = $qry->fetch(PDO::FETCH_ASSOC);


		if(empty(@$l["id"])){
			return [false];
		}

		$qry = $db->prepare("SELECT * FROM sudoQuestAttempts WHERE questId = :qid AND uid = :uid AND correct = 1 LIMIT 1");
		$qry->execute([
			":qid" => $l["id"],
			":uid" => $this->user["id"]
		]);		
		$res = $qry->fetch(PDO::FETCH_ASSOC);

		if(isset($res["id"])){
			return [false];
		}else{
			return [true, $l];
		}

	}

	private function passQuest($l, $ans){

		$db = $GLOBALS["db"];				

		$qry = $db->prepare("INSERT INTO sudoQuestAttempts (uid, questId, answer, correct) VALUES (:uid, :qid, :ans, 1)");
		$qry->execute([
			":uid" => $this->user["id"],
			":qid" => $l["id"],
			":ans" => $ans			
		]);

		$qry = $db->prepare("SELECT COUNT(*) FROM sudoQuestAttempts WHERE questId = :qid AND correct = 1");
		$qry->execute([
			":qid" => $l["id"],
		]);
		$res = $qry->fetch(PDO::FETCH_ASSOC);

		if($res["COUNT(*)"] >= 3){
			$qry = $db->prepare("SELECT id FROM sudoQuest WHERE status = 2 ORDER BY time ASC LIMIT 1");
			$qry->execute();
			$lid = $qry->fetch(PDO::FETCH_ASSOC);

			$qry = $db->prepare("UPDATE sudoQuest SET status = 0 WHERE id = :id LIMIT 1");
			$qry->execute([":id" => $l["id"]]);

			if(isset($lid["id"])){
				$qry = $db->prepare("UPDATE sudoQuest SET status = 1 WHERE id = :id LIMIT 1");
				$qry->execute([":id" => $lid["id"]]);				
			}
		}
	}
	public function checkQuestAnswer($ans, $levelId){

		if($this->user["dq"] != 0){
			return [false, "DQ"];
		}

		$levelId = (int)$levelId;

		if(strlen(trim($ans)) < 1 || $levelId === false){
			return [false, "Please enter an answer to check"];
		}

		$ans = strtolower(str_replace(' ', '', $ans));
		$level = $this->getQuestLevel();
		
		if(!$level[0] || @$level[1]["id"] != $levelId){
			return [false, "NO_LEVEL"];
		}

		$level = $level[1];

		if($level["answer"] === $ans){
			$this->passQuest($level, $ans);
			return [true];
		}else{
			return [false, "The answer was incorrect"];
		}
	}


	public function addQuest($ques, $ans){

		$db = $GLOBALS["db"];			

		if(strlen(trim($ans)) < 1 || strlen(trim($ques)) < 1){
			return [false, "Enter both the question and the answer"];
		}

		$qry = $db->prepare("SELECT COUNT(*) FROM sudoQuest WHERE status = 1");
		$qry->execute();
		$res = $qry->fetch(PDO::FETCH_ASSOC);

		if(@$res["COUNT(*)"] < 1){
			$qry = $db->prepare("INSERT INTO sudoQuest (question, answer, status) VALUES (:ques, :ans, 1)");
			$qry->execute([
				":ques" => $ques,
				":ans" => $ans,				
			]);
		}else{
			$qry = $db->prepare("INSERT INTO sudoQuest (question, answer, status) VALUES (:ques, :ans, 2)");
			$qry->execute([
				":ques" => $ques,
				":ans" => $ans,				
			]);					
		}
		return [true, "The SudoQuest was added."];	
	}

}
?>