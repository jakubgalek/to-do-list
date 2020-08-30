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
	<link rel="stylesheet" href="client.css">
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

  <div class="form-box">
  <h1 class="form-box__title">Add new task</h1>
    <form class="form-box__form form" action="add.php" method="post">
      <input class="form__text-input" type="text" name="title" id="e-mail" placeholder="Title">
      <textarea class="form__text-input"  name="text" id="password" placeholder="Write something..." rows="12"></textarea>
      <button class="form__button" type="submit">Add</button>
    </form>
</div>
<div class="container">

<?php
$user_id = $_SESSION['id'];

  require_once "connect.php";

	$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
    
    $query = "SELECT `id`, `title`, `text`, `user_id` FROM `notatki` WHERE `user_id`='$user_id'";
    $result = mysqli_query($polaczenie,$query);
    while ($row = mysqli_fetch_array  ($result))
    {
        echo '<div class="item" name="'.$row['id'].'">';
        echo '<div class="item__header">';
        echo '<h2 class="item__title">'.$row['title'].'</h2> </div>';
        echo '<div class="item__content"> <p class="item__paragraph">'.$row['text']."</p>";
        echo '<form action="delete.php" method="post" name="'.$row['id'].'"><button class="item__button button" type="submit" >Delete</button></form> </div> </div>';

    }
?>
</body>
</html>