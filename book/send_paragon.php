<?
/*
* FILE SENDS RESERVATION FILE (and VAT, if requested) TO THE CUSTOMER'S E-MAIL
*/
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../phpmailer/src/Exception.php';
require '../phpmailer/src/PHPMailer.php';
require '../phpmailer/src/SMTP.php';

$query = "SELECT * from orders WHERE mail_code = :mail_code";
$result = $db->prepare($query);
$result->bindParam(":mail_code",$_GET['code'], PDO::PARAM_STR);
$result->execute();
$order = $result->fetch(PDO::FETCH_ASSOC);

$order_id = $order['order_id'];
$mail_to = $order['mail_client'];
$vat = $order['vat'];

/* 
* Sending mail.
*/
$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;
    $mail->Host = 'smtp.gmail.com';
    $mail->Username = 'mail@gmail.com';
    $mail->Password = '123';
    $mail->addAttachment('confirms/'.$order_id.'.pdf', 'rezerwacja.pdf');
if ($vat == 1) $mail->addAttachment('vat/'.$order_id.'.pdf', 'invoice.pdf');
    $mail->setFrom('mail@gmail.com', 'R1 Parking');
    $mail->addAddress($mail_to);
    $mail->isHTML(true);
    $mail->Subject = 'R1 Parking';
    $mail->Body    = 'R1 Parking Rezerwacja';
    $mail->AltBody = '';
    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo 'Mailer Error: ' . $mail->ErrorInfo;
}
?>