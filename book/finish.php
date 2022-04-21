<?
session_start();

// * LOG OUT
if (isset($_GET['logout'])) {
    setcookie("client_tel", '', time() + 0, "/");
    header('Location: ?');
}

if(!$_COOKIE['client_tel']) header('Location: ../PL/R-1.php');

require '../db.php';
require '../functions/translator.php';

/* 
* Fetch required data
*/
$query = "SELECT * from orders WHERE order_id = :order_id";
$result = $db->prepare($query);
$result->bindParam(":order_id", $_COOKIE['order_id'], PDO::PARAM_STR);
$result->execute();
$order = $result->fetch(PDO::FETCH_ASSOC);

/*
* Sending pdf-file to e-mail if requested.
*/
if (isset($_POST['mail'])){
	$mail = $_POST['mail'];
	if($order['mail_confirmed'] != 1 && $order['mail_client'] != '' && $order['mail_code'] == null){
		$mailto = $order['mail_client'];
		include 'mail_verif.php';
	}
	$query = "UPDATE orders SET mail_client = :mail_client  WHERE order_id = :order_id";
	$result = $db->prepare($query);
	$result->bindParam(":mail_client",$mail, PDO::PARAM_STR);
	$result->bindParam(":order_id",$_COOKIE['order_id'], PDO::PARAM_STR);
	$result->execute();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../css/styles.css">
    <title><?=$translate['parking_warsaw'];?> | R1 PARKING</title>

</head>
<body>
<header><? include '../blocks/header.php'?></header>

<?
if($order['mail_confirmed'] == 1 && $order['mail_client'] != ''){
    $mail_btn = 'sent_to_your_email'; $mail_btn_class = 'disabled'; $disabled = 'disabled'; $mail_client = $order['mail_client'];
}else if($order['mail_client'] != ''){
    $mail_func = 'noConfirm()'; $mail_btn = 'send_to_email';?>
<div id="mail_container" style="display: <? echo (isset($_POST['mail'])) ? 'block;': 'none;' ?> ;">
	<div id="mail_confirm">
		<div>
			<span id="cross" onclick="document.getElementById('mail_container').style = 'display: none;'">x</span>
			<?=$translate['confirm_your_email_to_get_bill'];?>
		</div>
	</div>
</div>
<?
}else{
    $mail_func = 'noMailnoConfirm()'; $mail_btn = 'send_to_email';?>
<div id="mail_container" style="display: none;">
	<div id="mail_confirm">
		<div id="mail_enter">
			<span id="cross" onclick="document.getElementById('mail_container').style = 'display: none;'">x</span>
            <form action="" method="post" style="display: flex; flex-direction:column; align-items: center;">
                <input type="text" placeholder="<?=$translate['enter_your_email'];?>" name="mail" style="font-size: 18px; padding: 2px; width: 204px;margin:10px 0 0 0;">
                <input class="finish_btn" style="margin: 16px auto 0;" type="submit" value="<?=$translate['send_code'];?>">
            </form>
		</div>
	</div>
</div>
<?
}
?>
    <div class="container column" style="align-items: center; min-height: 75vh;">
    <div class="" style="text-align: center; width: 100%;"><?=$translate['your_reservation'];?></div>
        <div class="finish_btns_container">
            <span class="finish_btn" onclick="window.location.href = '../PL/R1.php';"><?=$translate['to_the_main_page'];?></span>
            <span class="finish_btn <?=$mail_btn_class;?>" <?=$disabled;?> onclick="<?=$mail_func;?>"><?=$translate[$mail_btn];?><br><?=$mail_client;?></span>
        </div>
        <object width="400" height="500" type="application/pdf" data="https://<?=$_SERVER['HTTP_HOST'];?>/book/confirms/<?=$_COOKIE['order_id'];?>.pdf">
            <iframe src="https://docs.google.com/viewer?url=https://<?=$_SERVER['HTTP_HOST'];?>/book/confirms/<?=$_COOKIE['order_id'];?>.pdf&embedded=true" frameborder="0"></iframe>
        </object>
    </div>
<? include '../blocks/footer.php'?>
<script src="../js/booking.js"></script>
<script>
    function noConfirm(){
console.log('no confirm');
document.getElementById('mail_container').style = 'display: block';
    }
    function noMailnoConfirm(){
console.log('no mail no confirm');
document.getElementById('mail_container').style = 'display: block';
    }
</script>
</body>
</html>