<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../phpmailer/src/Exception.php';
require '../phpmailer/src/PHPMailer.php';
require '../phpmailer/src/SMTP.php';

/* 
* Generating unique combination for e-mail confirmation.
*/
$permitted_chars = 'abcdefghijklmnopqrstuvwxyz';
$mail_code = substr(str_shuffle($permitted_chars), 0, 16);
$query = "UPDATE orders SET mail_code = :mail_code WHERE order_id = :order_id";
$result = $db->prepare($query);
$result->bindParam(":mail_code",$mail_code, PDO::PARAM_STR);
$result->bindParam(":order_id",$_COOKIE['order_id'], PDO::PARAM_STR);
$result->execute();
$link = 'https://sredarazrabotki.space/book/mail_confirm.php?code='.$mail_code;

/* 
* Sending mail.
*/
$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->CharSet = 'UTF-8';
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;
    $mail->Host = 'smtp.gmail.com';
    $mail->Username = 'mail@gmail.com';
    $mail->Password = '123';
    $mail->setFrom('mail@gmail.com', 'R1 Parking');
    $mail->addAddress($mailto);
    $mail->isHTML(true);
    $mail->Subject = $translate['mail1'];
    $mail->Body    = "<h1>".$translate['mail1']."</h1>".
    "<p style='color: red; font-style: italic;'>".$translate['mail2'].
    "</p> <br><br> <a href='".$link."' style='font-weight: bold;'>".$translate['mail3']."</a> \n";
    $mail->AltBody = '';
    $mail->send();
} catch (Exception $e) {
    echo 'Mailer Error: ' . $mail->ErrorInfo;
}
?>