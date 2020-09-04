<?php

	session_start();
	
	if ((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany']==true))
	{
		header('Location: gra.php');
		exit();
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
    <form class="form-box__form form" action="zaloguj.php" method="post">
      <input class="form__text-input" type="text" name="login" id="e-mail" placeholder="username">
      <input class="form__text-input" type="password" name="haslo" id="password" placeholder="password">
	  <?php
		if(isset($_SESSION['blad']))	echo $_SESSION['blad'];
		unset($_SESSION['blad']);
	  ?>
      <button class="form__button" type="submit">Log In</button>

	  <p class="form-box__info"><a href="register.php">Create new account</a></p>
    </form>
</div>
		
</body>
</html>