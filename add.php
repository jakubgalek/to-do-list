<?php
session_start();
$user_id = $_SESSION['id'];
$title = $_POST['title'];
$text = $_POST['text'];
$missTitleMessage="This field cannot be empty";

require_once "connect.php";

	$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
    if ($title=="") $_SESSION['missTitle']="<script type='text/javascript'>alert('$missTitleMessage');</script>";
    else{
    unset($_SESSION['missTitle']);

    $image = $_FILES['image']['name'];
    $target = "images/".basename($image);
    $add = mysqli_query($polaczenie,"INSERT INTO `notatki` (`id`, `title`, `text`, `image`, `user_id`) VALUES ('', '$title', '$text', '$image', '$user_id');");
        
}
    mysqli_close($polaczenie);
    header('Location: gra.php');









?>