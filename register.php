<?php
// odbieramy dane z formularza
$login = $_POST['login'];
$haslo = $_POST['haslo'];
$email = $_POST['e-mail'];


if($login and $haslo) {
	
require_once "connect.php";
$mysqli = @new mysqli($host, $db_user, $db_password, $db_name);

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
    // dodajemy rekord do bazy
    $ins = mysqli_query($mysqli,"INSERT INTO uzytkownicy (user, pass, email) VALUES ('$login', '$haslo','$email')");
	
    if($ins) echo "Rekord został dodany poprawnie";
    else echo "Błąd nie udało się dodać nowego rekordu";
    
    mysqli_close($mysqli);
}
require_once "zaloguj.php";
?>