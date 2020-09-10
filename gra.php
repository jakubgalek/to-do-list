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
  	<!--[if lt IE 9]>
	<script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
	<![endif]-->
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
  <div class="container">

   <div class="form-box">
   <h1 class="form-box__title">Add new task</h1>
     <form class="form-box__form form" action="add.php" enctype="multipart/form-data" method="post">
       <input class="form__text-input" type="text" name="title" placeholder="Title">
       <textarea class="form__text-input"  name="text" id="password" placeholder="Write something..." rows="12"></textarea>
  	   <div>
  	         <input type="file" name="fileToUpload" id="fileToUpload">
  	   </div>
       <button class="form__button" type="submit" name="submit">Add</button>
     </form>
   </div>


<?php
    $user_id = $_SESSION['id'];
    require_once "connect.php";

	  $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
    
    $query = "SELECT `id`, `title`, `text`,`image`,`user_id` FROM `notatki` WHERE `user_id`='$user_id' ORDER BY id DESC";
    $result = mysqli_query($polaczenie,$query);
    while ($row = mysqli_fetch_array  ($result))
    {

      
        echo '<div class="item">';
        echo '<form action="mail.php" method="post" >';
        echo '<div class="item__header">';
        echo '<h2 class="item__title" onclick="zmien()" id="dd">'.$row['title'].'</h2> </div>';
        echo '<div class="item__content"> <p class="item__paragraph" onclick="zmien2()" id="ee">'.$row['text']."</p>";
        echo '<input  name="title" type="hidden" value="'.$row['title'].'"id="title">';
        echo '<input  name="message" type="hidden" value="'.$row['text'].'"id="message">';
        echo '<input  name="image" type="hidden" value="'.$row['image'].'"id="image">';
        if(($row['image'])!="uploads/"){
        echo '<div id="img_div">';
      	echo '<img  onclick="zmien3()" id="ff" src="'.$row['image'].'" style="max-width: 211px;" ></div> ';}
        echo '<div class="buttons">';
        echo '<button class="item__button button" type="submit" name="id" value="'.$row['id'].'">Modify</button>';
        echo '<button class="item__button button" type="submit" name="id" value="'.$row['id'].'">Sent to mail</button></form>';
        echo '<form action="delete.php" method="post" ><button class="item__button button" type="submit" name="id" value="'.$row['id'].'">Delete</button></form> </div> </div> </div>';

      }

       if(isset($_SESSION['missTitle']))	echo $_SESSION['missTitle'];
       unset($_SESSION['missTitle']);
?>

<script>
function zmien(){
  let title=document.getElementById("title");
  title.type = "text";
  document.getElementById("dd").replaceWith(title );
}
function zmien2(){
  let title=document.getElementById("message");
  title.type = "textarea";
  document.getElementById("ee").replaceWith(title );
}
function zmien3(){
  let title=document.getElementById("image");
  title.type = "file";
  document.getElementById("ff").replaceWith(title );
}
</script>
</div>
</body>
</html>