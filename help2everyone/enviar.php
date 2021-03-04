<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';
/*
$mail = new PHPMailer();
$mail->isSMTP();
$mail->SMTPAuth = true;
$mail->SMTPSecure = 'ssl';
$mail->Host = 'smtp.gmail.com';
$mail->Port = '456';
$mail->isHTML();
$mail->Username = 'H2E.pap@gmail.com';
$mail->Password = 'caracteres123';
$mail->SetFrom("no-reply@howcode.org");
$mail->Subject = 'Hello World';
$mail->Body = 'A test email!';
$mail->AddAddress("goncalo.lslv.silva@gmail.com");

$mail->Send();
*/
$mail = new PHPMailer;

$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'H2E.pap@gmail.com';                 // SMTP username
$mail->Password = 'caracteres123';                           // SMTP password
$mail->SMTPSecure = 'tls';                            // Enable encryption, 'ssl' also accepted

$mail->From = 'H2E.pap@gmail.com';
$mail->FromName = 'Confirmar Conta';
$mail->addAddress('goncalo.lslv.silva@gmail.com', 'Gonçalo');     // Add a recipient
//$mail->addReplyTo('info@example.com', 'Information');
//$mail->addCC('cc@example.com');
//$mail->addBCC('bcc@example.com');

$mail->WordWrap = 50;                                 // Set word wrap to 50 characters
//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = 'Obrigado por ter aderido ao H2E';
$mail->Body    = 'Muito Obrigado por ter criado uma conta no Help2Everyone, para a confirmar clique no link: (Rodapé: Caso este email não seja direcionado para si, simplesmente ignore-o)';
$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message has been sent';
}
?>
