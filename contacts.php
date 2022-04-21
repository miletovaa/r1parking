<?
session_start();
require 'db.php';
require 'functions/translator.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

if (isset($_POST['contacts_send'])){
    $body = $_POST['tel']." ".$_POST['mail']." \n\n".$_POST['message'];
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
        $mail->addAddress('parking@gmail.com');
        $mail->isHTML(true);
        $mail->Subject = 'PARKING R1';
        $mail->Body    = $body;
        $mail->AltBody = '';
        $mail->send();
    } catch (Exception $e) {
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="css/styles.css">
    <title><?=$translate['contacts'];?> | R1 PARKING</title>
</head>
<body>
<header><? include 'blocks/header.php'?></header>
    <div class="container column">
        <h1><?=$translate['contacts'];?></h1>
        <div class="container">
        <div class="contacts">
            <div class=""><b>Parking R1</b></div>
            <div class="">ul. Równoległa 1</div>
            <div class="">02-235 Warszawa</div>
            <br>
            <hr>
            <br>
            <div class=""><b>KRS</b> 00007882205</div>
            <div class=""><b>REGON</b> 383451384</div>
            <div class=""><b>NIP</b> 5272894617</div>
        </div>
        <form class="form_contacts" action="" method="post">
			<input type="tel" name="tel" id="telForm" autocomplete="on" placeholder="<?=$translate['phone_number'];?>">
			<input type="email" name="mail" id="mailForm" autocomplete="on" placeholder="<?=$translate['mail'];?>">
			
            <textarea name="message" id="commentsForm" cols="30" rows="4" placeholder="<?=$translate['how_can_we_help'];?>"></textarea>

            <input type="submit" name="contacts_send" class="book_btn" value="<?=$translate['send_code'];?>">
        </form>
        </div>
    </div>
    <div class="empty"></div>
    <div class="empty"></div>
<? include 'blocks/footer.php'?>
<script src="js/booking.js"></script>
</body>
</html>