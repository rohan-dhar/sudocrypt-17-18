<?php 

class User{
	
	private $id;
	public function signUp($name, $email, $userName, $pass, $passC, $ins, $cnt, $iCnt){		
		$cntList = $GLOBALS["countries"];
		$db = $GLOBALS["db"];

		$userName = trim($userName);
		$name = trim($name);
		$email = trim($email);
		$ins = trim($ins);		

		//Emptyness Check
		if(strlen($name) < 1 || strlen($userName) < 1 || strlen($email) < 1 || strlen($pass) < 1 || strlen($passC) < 1 || strlen($ins) < 1 || strlen($cnt) < 1){
			return [false, "MISSING_PARAM"];
		}

		//Email check
		if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
			return [false, "INC_EMAIL"];			
		}

		$qry = $db->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
		$qry->execute([":email" => $email]);
		$u = $qry->fetch(PDO::FETCH_ASSOC);

		if(isset($u["id"])){
			return [false, "ALREADY"];
		}

		//UserName Check
		$qry = $db->prepare("SELECT * FROM users WHERE userName = :userName LIMIT 1");
		$qry->execute([":userName" => $userName]);
		$u = $qry->fetch(PDO::FETCH_ASSOC);

		if(isset($u["id"])){
			return [false, "ALREADY_USER"];
		}

		//Password Checks
		if(strlen($pass) < 5){
			return [false, "INC_PASS"];	
		}
		if($pass !== $passC){
			return [false, "INC_PASS_MATCH"];				
		}

		//Country Check
		if(!array_search($cnt, $cntList)){
			return [false, "INC_COUNTRY"];							
		}

		$pass = password_hash($pass, PASSWORD_DEFAULT);

		$qry = $db->prepare("INSERT INTO users (name, email, userName, password, organisation, country, ipCountry, level, dq) VALUES(:name, :email, :userName, :pass, :ins, :cnt, :iCnt, 0, 0)");
		$qry->execute([
			":name" => $name,
			":email" => $email,
			":userName" => $userName,
			":pass" => $pass,
			":ins" => $ins,
			":cnt" => $cnt,
			":iCnt" => $iCnt,
		]);
	
		return [true];
	}		

		public function startSess($login = false){
			session_start();
			if($login){
				session_regenerate_id();
			}
		}

		private function setSess($id){			
			$_SESSION["loggedIn"] = true;
			$_SESSION["uid"] = $id;
			$this->id = $id;
		}

		public function authSess(){
			
			$db = $GLOBALS["db"];
			
			if(@!$_SESSION["loggedIn"] || !@$_SESSION["uid"]){
				return [false, "NO_SESS"];
			}

			$id = $_SESSION["uid"];

			$qry = $db->prepare("SELECT * FROM users WHERE id = :id LIMIT 1");
			$qry->execute([":id" => $id]);
			$res = $qry->fetch(PDO::FETCH_ASSOC);

			if(!@$res["id"]){
				return [false, "MISSING_DB"];
			}

			$this->id = $res["id"];

			return [true, $res];
		}



	public function signIn($email, $pass){			
		$email = trim($email);		
		$db = $GLOBALS["db"];

		if(strlen($email) < 1 || strlen($pass) < 1){
			return [false, "MISSING_PARAM"];
		}

		$qry = $db->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
		$qry->execute([":email" => $email]);
		$res = $qry->fetch(PDO::FETCH_ASSOC);
		if(@!$res[id]){
			return [false, "INC_EMAIL"];
		}

		if(password_verify($pass, $res["password"])){
			$this->setSess($res["id"]);
			return [true];	
		}else{
			return [false, "INC_PASS"];	
		}
	
	}

	public function changePassword($pass, $passC){
		$db = $GLOBALS["db"];
		if(strlen($pass) < 1 || strlen($passC) < 1){
			return [false, "MISSING_PARAM"];
		}
		if(strlen($pass) < 5){
			return [false, "INC_PASS"];
		}
		if($pass !== $passC){
			return [false, "INC_PASS_MATCH"];			
		}

		$pass = password_hash($pass, PASSWORD_DEFAULT);
		$id = $this->id;

		$qry = $db->prepare("UPDATE users SET password = :pass WHERE id = :id");
		$qry->execute([
			":pass" => $pass,
			":id" => $id,
		]);

		return [true];
	}

	public function changeUserName($userName){
		
		$db = $GLOBALS["db"];
		$id = $this->id;
		
		if(strlen($userName) < 1){
			return [false, "MISSING_PARAM"];
		}
		
		//UserName Check
		$qry = $db->prepare("SELECT * FROM users WHERE userName = :userName LIMIT 1");
		$qry->execute([":userName" => $userName]);
		$u = $qry->fetch(PDO::FETCH_ASSOC);

		if(isset($u["id"])){
			return [false, "ALREADY_USER"];
		}
		
		$qry = $db->prepare("UPDATE users SET userName = :userName WHERE id = :id");
		$qry->execute([
			":userName" => $userName,
			":id" => $id,
		]);

		return [true];
	}

	public function getDetails($uid = false){
		$db = $GLOBALS["db"];

		if($uid === false){
			$uid = $this->id;
		}
		$qry = $db->prepare("SELECT id, name, email, userName, organisation, country, level, dq FROM users WHERE id = :uid");
		$qry->execute([":uid" => $uid]);
		$res = $qry->fetch(PDO::FETCH_ASSOC);
		return $res;
	}

};

?>