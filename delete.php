<?php
session_start();
$user_id = $_SESSION['id'];
$title = $_POST['title'];
$text = $_POST['text'];

require_once "connect.php";

	$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
    
    $delete = mysqli_query($polaczenie,"DELETE FROM `notatki` WHERE title='$title');
    
    mysqli_close($polaczenie);
    header('Location: gra.php');


?>