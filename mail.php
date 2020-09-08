<?php
$to      = "projekteuromind@gmail.com";
$subject = $_POST['title'];
$message = $_POST['message'];


mail($to, $subject, $message);
//header('Location: gra.php');
?>