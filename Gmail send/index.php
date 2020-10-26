<?php

require_once ('PHPMailer/PHPMailerAutoload.php');




$mail=new PHPMailer();
$mail->isSMTP();
$mail->SMTPAuth = true;
$mail->SMTPSecure = 'tls';
$mail->Host='smtp.gmail.com';
$mail->Port = '587';
$mail->isHTML();
$mail->Username= 'autosender101@gmail.com';
$mail->Password='12a1345e';
$mail->SetFrom('no-replay@petstore.org');
$mail->Subject= 'Hello World';
$mail->Body='A test email';
$mail->AddAddress('amustafov@etfos.hr');

$mail->Send();
echo 'Message has been sent';


?>