<?php
session_start();
$user_id = $_SESSION['id'];
$title = $_POST['title'];
$text = $_POST['text'];

require_once "connect.php";

	$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
    
    $add = mysqli_query($polaczenie,"INSERT INTO `notatki` (`id`, `title`, `text`, `user_id`) VALUES ('', '$title', '$text', '$user_id');");
    
    mysqli_close($polaczenie);
    header('Location: gra.php');


?>