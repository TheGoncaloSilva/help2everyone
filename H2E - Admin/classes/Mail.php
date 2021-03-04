<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';
class Mail{
            public static function sendMail($subject, $body, $address){
              $mail = new PHPMailer;
              $mail->isSMTP();                                      // Set mailer to use SMTP
              $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
              $mail->SMTPAuth = true;                               // Enable SMTP authentication
              $mail->Username = 'H2E.pap@gmail.com';                 // SMTP username
              $mail->Password = 'caracteres123';                           // SMTP password
              $mail->SMTPSecure = 'tls';                            // Enable encryption, 'ssl' also accepted
              $mail->From = 'H2E.pap@gmail.com';
              //$mail->FromName = 'Confirmar Conta';
              $mail->addAddress($address);     // Add a recipient
              $mail->SetFrom("no-reply@Help2Everyone.org");
              $mail->WordWrap = 50;                                 // Set word wrap to 50 characters
              $mail->isHTML(true);                                  // Set email format to HTML
              $mail->Subject = $subject;
              $mail->Body    = $body;
              $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

              $mail->Send();
            }
}
?>
