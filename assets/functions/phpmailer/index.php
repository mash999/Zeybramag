<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';
$message = "
<div>
    <h2 style='font-size:22px;font-family:helvetica;'>Hey, Ruhul </h2>
    <p style='font-family:helvetica;'>We hear ya! We've got your name on the list. Now keep your eyes open for the Zeybras near you. More details to follow soon.....</p>
    <img src='http://www.zeybramag.com/three-zeybra.jpg' style='width:200px; height: auto;'> 
</div>";
$mail = new PHPMailer(true);                             
try {
    $mail->isSMTP();
    $mail->Host = 'mail.zeybramag.com'; 
    $mail->SMTPAuth = true;                              
    $mail->Username = 'noreply@zeybramag.com';                
    $mail->Password = 'noreply_zeybramag123';                          
    $mail->SMTPSecure = 'ssl';                           
    $mail->Port = 465;                                   

    $mail->setFrom('noreply@zeybramag.com', 'Zeybramag');
    $mail->addAddress('mashbu111@gmail.com');    
    $mail->isHTML(true);                                 
    $mail->Subject = "Greetings from Zeybramag";
    $mail->Body    = $message;
    $mail->AltBody = "We hear ya! We've got your name on the list. Now keep your eyes open for the Zeybras near you. More details to follow soon.....";
    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
}