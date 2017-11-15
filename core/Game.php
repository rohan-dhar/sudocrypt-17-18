<?php 

class Game{

	private $user;

	function __construct($user){
		$this->user = $user;
	}

	public function getGameLevel(){
		
		if($this->user["dq"] != 0){
			return [false];
		}

		$db = $GLOBALS["db"];		
		$qry = $db->prepare("SELECT levels.* FROM levels INNER JOIN users ON users.levelId = levels.id AND users.id = :uid  LIMIT 1");
		$qry->execute([":uid" => $this->user["id"]]);
		$level = $qry->fetch(PDO::FETCH_ASSOC);		
		return [true, $level];
	}

	private function increaseGameLevel($level){

		if($this->user["dq"] != 0){
			return false;
		}

		$db = $GLOBALS["db"];		
		$first = false;

		if(!$level["crossedBy"]){
			$qry = $db->prepare("UPDATE levels SET crossedBy = :uid, crossedAt = NOW() WHERE id = :lvl");
			$qry->execute([
				":uid" => $this->user["id"],
				":lvl" => $level["id"]
			]);
			$first = true;
		}

		$qry = $db->prepare("UPDATE users SET levelId = levelId + 1 WHERE id = :uid");
		$qry->execute([":uid" => $this->user["id"]]);
		return $first;

	}

	public function checkGameAnswer($ans){

		$db = $GLOBALS["db"];

		if($this->user["dq"] != 0){
			return [false, "DQ"];
		}

		if(strlen(trim($ans)) < 1){
			return [false, "Please enter an answer to check."];
		}

		$ans = strtolower(str_replace(' ', '', $ans));
		$level = $this->getGameLevel()[1];
		
		if($ans === @$level["answer"]){
			
			$qry = $db->prepare("INSERT INTO gameAttempts (uid, level, answer, correct) VALUES(:uid, :lid, :ans, 1)");
			$qry->execute([
				":uid" => $this->user["id"],
				":lid" => $level["id"],
				":ans" => $ans
			]);

			if($this->increaseGameLevel($level)){
				return [true, "The answer was correct! You were first to cross this level"];
			}else{
				return [true, "The answer was correct"];
			}

		}else{
			$qry = $db->prepare("INSERT INTO gameAttempts (uid, level, answer, correct) VALUES(:uid, :lid, :ans, 0)");
			$qry->execute([
				":uid" => $this->user["id"],
				":lid" => $level["id"],
				":ans" => $ans
			]);
			return [false, "The answer was incorrect"];
		}

	}

}


?>