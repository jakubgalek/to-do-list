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
      <li class="menu__item"><?php echo '<a href="pulpit.php">Tasks</a>'; ?></li>
      <li class="menu__item"><?php echo '<a href="logout.php">Log Out!</a>'; ?></li>
    </ul>
  </nav>
  <div class="container">


<?php


    $user_id = $_SESSION['id'];
    require_once "connect.php";

	  $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
    
    $query = "SELECT `user`, `pass`, `email` FROM `uzytkownicy` WHERE `id`='$user_id'";
    $result = mysqli_query($polaczenie,$query);
    while ($row = mysqli_fetch_array  ($result))
    {

        echo "Your account details";
        echo "<br />";
        echo "<br />";
        echo "<br />";
        echo "Username ->  ".$row['user'];
        echo "<br />";
        echo "<br />";
        echo "E-mail ->  ".$row['email'];
        echo "<br />";
        echo "<br />";
        echo "Password ->  ".$row['pass'];
        echo "<br />";
        echo "<br />";

      }


?>

</body>
</html>