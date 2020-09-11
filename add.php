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



    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
      echo "File is an image - " . $check["mime"] . ".";
      $uploadOk = 1;
    } else {
      echo "File is not an image.";
      $uploadOk = 0;
    }
  }
  
  // Check if file already exists
  if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
  }
  
  // Check file size
  if ($_FILES["fileToUpload"]["size"] > 5000000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
  }
  
  // Allow certain file formats
  if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
  && $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
  }
  
  // Check if $uploadOk is set to 0 by an error
  if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
  // if everything is ok, try to upload file
  } else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
      echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
    } else {
      echo "Sorry, there was an error uploading your file.";
    }
  }
        $image=$target_file;
        if ($image=="uploads/") $image="";
        
        $add = mysqli_query($polaczenie,"INSERT INTO `notatki` (`id`, `title`, `text`, `image`, `user_id`) VALUES ('', '$title', '$text', '$image', '$user_id');");
    

}
    mysqli_close($polaczenie);
    header('Location: pulpit.php');

?>