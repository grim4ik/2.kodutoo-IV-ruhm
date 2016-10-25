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
		// kas epost on tuhi
		if (empty ($_POST["signupEmail"])) {
			
			// on tuhi
			$signupEmailError = "* Vali on kohustuslik!";
			
		} else {
			// email on olemas ja oige
			$signupEmail = $_POST["signupEmail"];
			
		}
		
	} 
	
		//MUUTUJAD
	$signupNameError = "*";
	$signupName = "";
	
	//kas keegi vajutas nuppu ja see on olemas
	
	if (isset ($_POST["signupName"])) {
		
		//on olemas
		// kas epost on tuhi
		if (empty ($_POST["signupName"])) {
			
			// on tuhi
			$signupNameError = "* Vali on kohustuslik!";
			
		} else {
			// email on olemas ja oige
			$signupName = $_POST["signupName"];
			
		}
		
	} 
	
			//MUUTUJAD
	$signupNimiError = "*";
	$signupNimi = "";
	
	//kas keegi vajutas nuppu ja see on olemas
	
	if (isset ($_POST["signupNimi"])) {
		
		//on olemas
		// kas epost on tuhi
		if (empty ($_POST["signupNimi"])) {
			
			// on tuhi
			$signupNimiError = "* Vali on kohustuslik!";
			
		} else {
			// email on olemas ja oige
			$signupNimi = $_POST["signupNimi"];
			
		}
		
	} 
	
	
	$signupPasswordError = "*";
	
	if (isset ($_POST["signupPassword"])) {
		
		if (empty ($_POST["signupPassword"])) {
			
			$signupPasswordError = "* Vali on kohustuslik!";
			
		} else {
			
			// parool ei olnud tuhi
			
			if ( strlen($_POST["signupPassword"]) < 8 ) {
				
				$signupPasswordError = "* Parool peab olema vahemalt 8 tahemarkki pikk!";
				
			}
			
		}
		
		/* GENDER */
		
		if (!isset ($_POST["gender"])) {
			
			//error
		}else {
			// annad vaartuse
		}
		
	}
	
	//vaikimisi vaartus
	$gender = "";
	
	if (isset ($_POST["gender"])) {
		if (empty ($_POST["gender"])) {
			$genderError = "* Vali on kohustuslik!";
		} else {
			$gender = $_POST["gender"];
		}
		
	} 
	
	
	
	
	if ( $signupEmailError == "*" AND
		 $signupPasswordError == "*" &&
		 $signupNameError == "*" &&
		 $signupNimiError == "*" &&
		 isset($_POST["signupEmail"]) && 
		 isset($_POST["signupName"]) &&
		 isset($_POST["signupNimi"]) &&
		 isset($_POST["signupPassword"]) 
	  ) {
		
		//vigu ei olnud, koik on olemas	
		echo "Salvestan...<br>";
		echo "email ".$signupEmail."<br>";
		echo "login ".$signupName."<br>";
		echo "nimi ".$signupNimi."<br>";
		echo "parool ".$_POST["signupPassword"]."<br>";
		
		$password = hash("sha512", $_POST["signupPassword"]);
		
		echo $password."<br>";
		
		signup($signupEmail, $password, $signupName, $signupNimi);
		
		
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
			<title>Kasutajaloomine leht</title>
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
		<h1>Loo kasutaja</h1>
		
		<form method="POST" >
			
			<label>E-post</label><br>
			<input name="signupEmail" type="email" value="<?=$signupEmail;?>"> <?php echo $signupEmailError; ?>
			
			<br><br>
			
			<label>Login</label><br>
			<input name="signupName" type="login" value="<?=$signupName;?>"> <?php echo $signupNameError; ?>
			
			<br><br>
			
			<label>Nimi</label><br>
			<input name="signupNimi" type="name" value="<?=$signupNimi;?>"> <?php echo $signupNimiError; ?>
			
			<br><br>
			<label>Parool</label><br>
			<input name="signupPassword" type="password"> <?php echo $signupPasswordError; ?>
			
			<br><br>
			
			<input type="submit" value="Loo kasutaja">
			<p><a href="login.php"><-Tagasi</a></p>
		
		</form>

	</body>
</html>