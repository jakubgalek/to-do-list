<?php
    session_start();

    $user_id = $_SESSION['id'];
    require_once "connect.php";

    $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);

    $delete_user = mysqli_query($polaczenie,"DELETE FROM `uzytkownicy` WHERE `id`= '$user_id';");
    $delete_tasks = mysqli_query($polaczenie,"DELETE FROM `notatki` WHERE `user_id`='$user_id';");

    mysqli_close($polaczenie);
    session_unset();
    header('Location: index.php');
?>