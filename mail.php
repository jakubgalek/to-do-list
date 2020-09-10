<?php

	session_start();
	
	if (!isset($_SESSION['zalogowany']))
	{
		header('Location: index.php');
		exit();
	}
	
?>
<?php
$to      = $_SESSION['email'];
$subject = $_POST['title'];
$message = $_POST['message'];
$from = 'sender@example.com'; 
$fromName = 'To Do List'; 
$user =  $_SESSION['user']; 
$image = '<img src="http://localhost/to-do-list/'.$_POST['image'].'"style="max-width: 211px; max-width: 211px;
display: block;
margin-left: auto;
margin-right: auto;">';
 
$htmlContent = ' 
    <html> 
    <head>
    </head> 

    <body style="
    background-color: #171717;  
    color: white;  
    padding: 0px 50px;  
    min-height: 100vh; 
    padding-top: 1px;"> 

    <h1 style="margin-bottom: 4x;"> Hello ';
    $htmlContent .= $user;
    $htmlContent .=' ! </h1>
    <h3 style="margin-top: 0;">We sent you notification from To Do List app.</h3>
    <div class="item" style=" 
    display: grid; 
    border: 2px solid white; 
    margin-top: 21px; 
    min-height: 400px;  
    grid-template-rows: 100px 1fr;">
    
    <div class="item__header" style="
    background: white;

    -webkit-box-pack: center;
    align-content: center;
    padding: 20px 30px;
    text-align: center;">

    <h2 class="item__title" style=" 
    margin: 0;
    color: #171717;
    font-size: 21px;"> ';
    $htmlContent .=$subject ;   
    $htmlContent .='</h2> </div>
    <div class="item__content" style=" 
    padding: 20px 30px;
   
    flex-direction: column;
    align-items: center;

    overflow: hidden;
    max-width: -webkit-fill-available;"> 

    <p class="item__paragraph" style="
    text-align: center; 
    font-size: 14px; 
    overflow: hidden;
    max-width: -webkit-fill-available;"> ' ; 

    $htmlContent .=$message ; 
    $htmlContent .='</p> 
    <div id="img_div" style="display: flex;    flex-direction: column
    align-items: center;" >' ; 

    $htmlContent .=$image;
    $htmlContent .='</div></div>
    </body>
    

    </html>'; 
 
// Set content-type header for sending HTML email 
$headers = "MIME-Version: 1.0" . "\r\n"; 
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n"; 
 
// Additional headers 
$headers .= 'From: '.$fromName.'<'.$from.'>' . "\r\n"; 
 
// Send email 
if(mail($to, $subject, $htmlContent, $headers)){ 
    echo 'Email has sent successfully.'.$htmlContent; 
}else{ 
   echo 'Email sending failed.'.$htmlContent; 
}
header('Location: gra.php');
?>