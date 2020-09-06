<?php
session_start();
$id = $_POST['id'];

require_once "connect.php";

	$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
    
    $delete = mysqli_query($polaczenie,"DELETE FROM `notatki` WHERE id='$id'");
    mysqli_close($polaczenie);
    
    header('Location: gra.php');


?>