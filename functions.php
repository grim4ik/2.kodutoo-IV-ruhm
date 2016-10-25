<?php 
	require("../../config.php");
	
	// see fail peab olema siis seotud kõigiga kus
	// tahame sessiooni kasutada
	// saab kasutada nüüd $_SESSION muutujat
	session_start();
	
	$database = "if16_kirikotk_4";
	// functions.php
	
	function signup($email, $password, $name, $nimi) {
		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("INSERT INTO users (email, password, name, nimi) VALUE (?, ?, ?, ?)");
		echo $mysqli->error;
		
		$stmt->bind_param("ssss", $email, $password, $name, $nimi);
		
		if ( $stmt->execute() ) {
			echo "õnnestus";
		} else {
			echo "ERROR ".$stmt->error;
		}
		
	}
	
	
	function login($email, $password) {
		
		$notice = "";
		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("
			SELECT id, email, password, created
			FROM users
			WHERE email = ?
		");
		
		echo $mysqli->error;
		
		//asendan küsimärgi
		$stmt->bind_param("s", $email);
		
		//rea kohta tulba väärtus
		$stmt->bind_result($id, $emailFromDb, $passwordFromDb, $created);
		
		$stmt->execute();
		
		//ainult SELECT'i puhul
		if($stmt->fetch()) {
			// oli olemas, rida käes
			//kasutaja sisestas sisselogimiseks
			$hash = hash("sha512", $password);
			
			if ($hash == $passwordFromDb) {
				echo "Kasutaja $id logis sisse";
				
				$_SESSION["userId"] = $id;
				$_SESSION["userEmail"] = $emailFromDb;
				//echo "ERROR";
				
				header("Location: data.php");
				
			} else {
				$notice = "parool vale";
			}
			
			
		} else {
			
			//ei olnud ühtegi rida
			$notice = "Sellise emailiga ".$email." kasutajat ei ole olemas";
		}
		
		
		$stmt->close();
		$mysqli->close();
		
		return $notice;
		
		
		
		
		
	}
	
	
	
	function saveEvent($vanus, $text, $nimi, $pnimi) {
		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("INSERT INTO omaidee (vanus, text, nimi, pnimi) VALUE (?, ?, ?, ?)");
		echo $mysqli->error;
		
		$stmt->bind_param("isss", $vanus, $text, $nimi, $pnimi);
		
		if ( $stmt->execute() ) {
			echo "õnnestus";
		} else {
			echo "ERROR ".$stmt->error;
		}
		
	}
	
	
	function getAllPeople() {
		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("
		SELECT id, vanus, text, nimi, pnimi
		FROM omaidee
		");
		$stmt->bind_result($id, $vanus, $text, $nimi, $pnimi);
		$stmt->execute();
		
		$results = array();
		
		// tsükli sisu tehakse nii mitu korda, mitu rida'
		// SQL laysega tuleb
		while($stmt->fetch()) {
			
			$human = new StdClass();
			$human->id = $id;
			$human->vanus = $vanus;
			$human->text = $text;
			$human->nimi = $nimi;
			$human->pnimi = $pnimi;
			
			
			//echo $text."<br>";
			array_push($results, $human);
			
		}
		return $results;
		
	}
	
	function cleanInput($input) {
		
		// input = " kirill ";
		$input = trim($input);
		// input = "kirill";
		
		// võtab välja
		$input = stripslashes($input);
		
		// html asendab, nt "<" saab "$lt;"
		$input = htmlspecialchars($input);
		
		return $input;
		
	}
	
	
	
	
	
	
	
	
	/*function sum($x, $y) {
		
		return $x + $y;
		
	}
	
	echo sum(12312312,12312355553);
	echo "<br>";
	
	
	function hello($firstname, $lastname) {
		return 
		"Tere tulemast "
		.$firstname
		." "
		.$lastname
		."!";
	}
	
	echo hello("romil", "robtsenkov");
	*/
?>