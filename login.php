<?php 
	
	
	require("functions.php");
	
	// kui on sisseloginud siis suunan data lehele
	if (isset($_SESSION["userId"])) {
		header("Location: data.php");
		exit();
	}
	
	//var_dump($_GET);
	
	//echo "<br>";
	
	//var_dump($_POST);
	
	//MUUTUJAD
	$signupEmailError = "*";
	$signupEmail = "";
	
	//kas keegi vajutas nuppu ja see on olemas
	
	if (isset ($_POST["signupEmail"])) {
		
		//on olemas
		// kas epost on tühi
		if (empty ($_POST["signupEmail"])) {
			
			// on tühi
			$signupEmailError = "* Väli on kohustuslik!";
			
		} else {
			// email on olemas ja õige
			$signupEmail = $_POST["signupEmail"];
			
		}
		
	} 
	
	$signupPasswordError = "*";
	
	if (isset ($_POST["signupPassword"])) {
		
		if (empty ($_POST["signupPassword"])) {
			
			$signupPasswordError = "* Väli on kohustuslik!";
			
		} else {
			
			// parool ei olnud tühi
			
			if ( strlen($_POST["signupPassword"]) < 8 ) {
				
				$signupPasswordError = "* Parool peab olema vähemalt 8 tähemärkki pikk!";
				
			}
			
		}
		
		/* GENDER */
		
		if (!isset ($_POST["gender"])) {
			
			//error
		}else {
			// annad väärtuse
		}
		
	}
	
	//vaikimisi väärtus
	$gender = "";
	
	if (isset ($_POST["gender"])) {
		if (empty ($_POST["gender"])) {
			$genderError = "* Väli on kohustuslik!";
		} else {
			$gender = $_POST["gender"];
		}
		
	} 
	
	
	
	
	if ( $signupEmailError == "*" AND
		 $signupPasswordError == "*" &&
		 isset($_POST["signupEmail"]) && 
		 isset($_POST["signupPassword"]) 
	  ) {
		
		//vigu ei olnud, kõik on olemas	
		echo "Salvestan...<br>";
		echo "email ".$signupEmail."<br>";
		echo "parool ".$_POST["signupPassword"]."<br>";
		
		$password = hash("sha512", $_POST["signupPassword"]);
		
		echo $password."<br>";
		
		signup($signupEmail, $password);
		
		
	}
	
	$notice = "";
	//kas kasutaja tahab sisse logida
	if ( isset($_POST["loginEmail"]) && 
		 isset($_POST["loginPassword"]) && 
		 !empty($_POST["loginEmail"]) &&
		 !empty($_POST["loginPassword"]) 
	) {
		
		$notice = login($_POST["loginEmail"], $_POST["loginPassword"]);
		
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Sisselogimise leht</title>
	</head>
	<body>
		<center>
			<style>	
		body {
			background-image:	url("http://www.astro.spbu.ru/staff/afk/Teaching/Seminars/XimFak/bg/Fon5.gif");
			background-repeat: repeat;
			background-position: center top;
			background-attachment: fixed;
			}
			
		</style>

		<h1>Logi sisse</h1>
		<p style="color:red;"><?=$notice;?></p>
		<form method="POST" >
			
			<label>E-post</label><br>
			<input name="loginEmail" type="email">
			
			<br><br>
			<label>Parool</label><br>
			<input name="loginPassword" type="password">
			
			<br><br>
			
			<input type="submit" value="Logi sisse">
			<p><a href="register.php">Loo kasutaja</a></p>
		
		</form>

	</body>
</html>
