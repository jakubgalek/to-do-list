<?php

	session_start();
	
	if (isset($_POST['email']))
	{
		//Udana walidacja? Załóżmy, że tak!
		$wszystko_OK=true;
		
		//Sprawdź poprawność username'a
		$username = $_POST['username'];
		
		//Sprawdzenie długości username'a
		if ((strlen($username)<3) || (strlen($username)>20))
		{
			$wszystko_OK=false;
			$_SESSION['e_username']="Username must be at least 3 and up to 20 characters long!";
		}
		
		if (ctype_alnum($username)==false)
		{
			$wszystko_OK=false;
			$_SESSION['e_username']="Username can only consist of a liter and numbers (no Polish characters)";
		}
		
		// Sprawdź poprawność adresu email
		$email = $_POST['email'];
		$emailB = filter_var($email, FILTER_SANITIZE_EMAIL);
		
		if ((filter_var($emailB, FILTER_VALIDATE_EMAIL)==false) || ($emailB!=$email))
		{
			$wszystko_OK=false;
			$_SESSION['e_email']="Please enter a valid e-mail address!";
		}
		
		//Sprawdź poprawność hasła
		$haslo1 = $_POST['haslo1'];
		$haslo2 = $_POST['haslo2'];
		
		if ((strlen($haslo1)<8) || (strlen($haslo1)>20))
		{
			$wszystko_OK=false;
			$_SESSION['e_haslo']="Password must be at least 8 and up to 20 characters long!";
		}
		
		if ($haslo1!=$haslo2)
		{
			$wszystko_OK=false;
			$_SESSION['e_haslo']="Given passwords do not match!";
		}	
		
		//Czy zaakceptowano regulamin?
		if (!isset($_POST['regulamin']))
		{
			$wszystko_OK=false;
			$_SESSION['e_regulamin']="Confirm the acceptance of the regulations!";
		}				
		
		//Bot or not? Oto jest pytanie!
		$sekret = "6LeUTIcUAAAAADlKvNuia50oKyzFIwLSo4J9xxPv";
		
		$sprawdz = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$sekret.'&response='.$_POST['g-recaptcha-response']);
		
		$odpowiedz = json_decode($sprawdz);
		
		if ($odpowiedz->success==false)
		{
			$wszystko_OK=false;
			$_SESSION['e_bot']="Please confirm that you are not a bot!";
		}		
		
		//Zapamiętaj wprowadzone dane
		$_SESSION['fr_username'] = $username;
		$_SESSION['fr_email'] = $email;
		$_SESSION['fr_haslo1'] = $haslo1;
		$_SESSION['fr_haslo2'] = $haslo2;
		if (isset($_POST['regulamin'])) $_SESSION['fr_regulamin'] = true;
		
		require_once "connect.php";
		mysqli_report(MYSQLI_REPORT_STRICT);
		
		try 
		{
			$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
			if ($polaczenie->connect_errno!=0)
			{
				throw new Exception(mysqli_connect_errno());
			}
			else
			{
				//Czy email już istnieje?
				$rezultat = $polaczenie->query("SELECT id FROM uzytkownicy WHERE email='$email'");
				
				if (!$rezultat) throw new Exception($polaczenie->error);
				
				$ile_takich_maili = $rezultat->num_rows;
				if($ile_takich_maili>0)
				{
					$wszystko_OK=false;
					$_SESSION['e_email']="There is already an account assigned to this email address!";
				}		

				//Czy username jest już zarezerwowany?
				$rezultat = $polaczenie->query("SELECT id FROM uzytkownicy WHERE user='$username'");
				
				if (!$rezultat) throw new Exception($polaczenie->error);
				
				$ile_takich_usernameow = $rezultat->num_rows;
				if($ile_takich_usernameow>0)
				{
					$wszystko_OK=false;
					$_SESSION['e_username']="There is already a player with this username! Choose another.";
				}
				
				if ($wszystko_OK==true)
				{
					//Hurra, wszystkie testy zaliczone, dodajemy gracza do bazy
					
					if ($polaczenie->query("INSERT INTO uzytkownicy VALUES (NULL,  '$username',  '$haslo1',  '$email' )"))
					{
						$_SESSION['udanarejestracja']=true;
						$_SESSION['zalogowany']=true;
						
						$login = htmlentities($_SESSION['fr_username'], ENT_QUOTES, "UTF-8");
						$haslo = htmlentities($_SESSION['fr_haslo1'], ENT_QUOTES, "UTF-8");
					
						if ($rezultat = @$polaczenie->query(
						sprintf("SELECT * FROM uzytkownicy WHERE BINARY user='%s' AND BINARY pass='%s'",
						mysqli_real_escape_string($polaczenie,$login),
						mysqli_real_escape_string($polaczenie,$haslo))))
						{
							$ilu_userow = $rezultat->num_rows;
							if($ilu_userow>0)
							{
								$_SESSION['zalogowany'] = true;
								
								$wiersz = $rezultat->fetch_assoc();
								$_SESSION['id'] = $wiersz['id'];
								$_SESSION['user'] = $wiersz['user'];
								$_SESSION['email'] = $wiersz['email'];
								
								unset($_SESSION['blad']);
								$rezultat->free_result();
								header('Location: gra.php');
								
							} else {
								
								$_SESSION['blad'] = '<span style="color:red; font-size:13px;">Uncorrect username or password!</span>';
								header('Location: index.php');
								
							}
							
						}
					}
					else
					{
						throw new Exception($polaczenie->error);
					}
					
				}
				
				$polaczenie->close();
			}
			
		}
		catch(Exception $e)
		{
			echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestrację w innym terminie!</span>';
			echo '<br />Informacja developerska: '.$e;
		}
		
	}
?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>To-Do-List</title>
	<link rel="icon" type="image/png" href="favicon.png">
	<link rel="stylesheet" href="style.css">
	<script src='https://www.google.com/recaptcha/api.js'></script>
</head>

<body>
<nav class="navigation">
  <span class="logo">To Do List</span>
  <ul class="menu">
    <li class="menu__item"><a href="https://helloroman.com/" target="_blank">CSS author</a></li>
    <li class="menu__item"><a href="https://wondun.github.io/portfolio/" target="_blank">My portfolio</a></li>
    <li class="menu__item"><a href="" target="_blank">Contact</a></li>
  </ul>
</nav>

<div class="form-box">
  <h1 class="form-box__title">Welcome to online TDL</h1>
    <p class="form-box__info">You can add new tasks and set notifications to your e-mail
	to whenever you want!</p>

<form method="post" class="form-box__form form">
	
	<input type="text" value="<?php
		if (isset($_SESSION['fr_username']))
		{
			echo $_SESSION['fr_username'];
			unset($_SESSION['fr_username']);
		}
	?>" name="username" placeholder="username" class="form__text-input">
	
	<?php
		if (isset($_SESSION['e_username']))
		{
			echo '<div class="error">'.$_SESSION['e_username'].'</div>';
			unset($_SESSION['e_username']);
		}
	?>
	
	<input type="email" value="<?php
		if (isset($_SESSION['fr_email']))
		{
			echo $_SESSION['fr_email'];
			unset($_SESSION['fr_email']);
		}
	?>" name="email" placeholder="e-mail" class="form__text-input">
	
	<?php
		if (isset($_SESSION['e_email']))
		{
			echo '<div class="error">'.$_SESSION['e_email'].'</div>';
			unset($_SESSION['e_email']);
		}
	?>
	
	<input type="password"  value="<?php
		if (isset($_SESSION['fr_haslo1']))
		{
			echo $_SESSION['fr_haslo1'];
			unset($_SESSION['fr_haslo1']);
		}
	?>" name="haslo1" placeholder="password" class="form__text-input">
	
	<?php
		if (isset($_SESSION['e_haslo']))
		{
			echo '<div class="error">'.$_SESSION['e_haslo'].'</div>';
			unset($_SESSION['e_haslo']);
		}
	?>		
	
	<input type="password" value="<?php
		if (isset($_SESSION['fr_haslo2']))
		{
			echo $_SESSION['fr_haslo2'];
			unset($_SESSION['fr_haslo2']);
		}
	?>" name="haslo2" placeholder="retype password" class="form__text-input">
	
	<label class="terms">
		<input type="checkbox" name="regulamin" <?php
		if (isset($_SESSION['fr_regulamin']))
		{
			echo "checked";
			unset($_SESSION['fr_regulamin']);
		}
			?>/> I accept the terms and conditions
	</label>
	
	<?php
		if (isset($_SESSION['e_regulamin']))
		{
			echo '<div class="error">'.$_SESSION['e_regulamin'].'</div>';
			unset($_SESSION['e_regulamin']);
		}
	?>	
	
	<div class="g-recaptcha" data-sitekey="6LeUTIcUAAAAAOWoquG3JjjqjZ4Lq3VVAdk6jlel"></div>
		
	<?php
		if (isset($_SESSION['e_bot']))
		{
			echo '<div class="error">'.$_SESSION['e_bot'].'</div>';
			unset($_SESSION['e_bot']);
		}
	?>	
    
	
	<input type="submit" value="Let's finish registration" class="form__button">
	<p class="form-box__info"><a href="index.php">Log In</a></p>
    </form>
</div>

</body>
</html>