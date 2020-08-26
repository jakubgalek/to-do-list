<?php

	session_start();
	
	if (!isset($_SESSION['zalogowany']))
	{
		header('Location: index.php');
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
  <script src="script.js" async></script>
</head>

<body>
	

	<nav class="navigation">
  <span class="logo">To Do List</span>
  <ul class="menu">
    <li class="menu__item"><?php echo "Hello ".$_SESSION['user'].' !'; ?></li>
    <li class="menu__item">Settings</li>
	<li class="menu__item"><?php echo '<a href="logout.php">Log Out!</a>'; ?></li>
  </ul>
</nav>
<div id="myDIV" class="header">
  <h2 style="margin:5px">My To Do List</h2>
  <input type="text" id="myInput" placeholder="Title...">
  <span onclick="newElement()" class="addBtn">Add</span>
</div>

<div class="container">
	<div class="item">
	<div class="item__header">
	<h2 class="item__title">Intro to css layouts</h2>
	</div>
		<div class="item__content">
		<p class="item__paragraph">
		This course is dedicated for
		beginners, who want to start
		their journey with CSS
		layouts.
		</p>
</div>
</div>
</body>
</html>