<?php

use PHPMailer\PHPMailer\PHPMailer;

//Load Composer's autoloader
require 'vendor/autoload.php';
$mail = new PHPMailer(true);

//Server settings
$mail->SMTPDebug = 2;                      //Enable verbose debug output
$mail->isSMTP();                                            //Send using SMTP
$mail->Host       = 'smtp.email.com';                     //Set the SMTP server to send through
$mail->SMTPAuth   = true;                                   //Enable SMTP authentication
$mail->Username   = 'arginanta30@gmail.com';                     //SMTP username
$mail->Password   = 'qiwrwbwafqowpaop';                               //SMTP password
$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
$mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

$mail->setFrom('arginanta30@gmail.com', 'Arginanta');
$mail->addAddress($_POST['email_penerima']);     //Penerima
$mail->addReplyTo('arginanta30@gmail.com', 'Arginanta');

$mail->Subject = $_POST['subject'];
$mail->Body    = $_POST['pesan'];

if ($mail->send()) {
  echo "<script> 
                    alert('Email Berhasil Ditambahkan');
                    document.location.href = 'email.php';
                  </script>";
} else {
  echo "<script> 
                    alert('Email Gagal Ditambahkan');
                    document.location.href = 'email.php';
                  </script>";
}
