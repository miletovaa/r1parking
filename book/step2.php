<?
session_start();
require '../db.php';
require '../functions/translator.php';
require '../functions/moderator.php';
require '../functions/telegram.php';

// * LOG OUT
if (isset($_GET['logout'])) {
    setcookie("client_tel", '', time() + 0, "/");
    header('Location: ?');
}

if (!isset($_COOKIE['order_id']) OR $_COOKIE['order_id'] == '') include 'new_order_row.php';

$query = "SELECT * from orders WHERE order_id = :order_id";
$result = $db->prepare($query);
$result->bindParam(":order_id", $_COOKIE['order_id'], PDO::PARAM_STR);
$result->execute();
$order = $result->fetch(PDO::FETCH_ASSOC);

if(isset($_COOKIE['client_tel'])){
	$query = "SELECT * from clients WHERE tel = :tel";
	$result = $db->prepare($query);
	$result->bindParam(":tel", $_COOKIE['client_tel'], PDO::PARAM_STR);
	$result->execute();
	$client = $result->fetch(PDO::FETCH_ASSOC);
}
$autoinput = $_COOKIE['client_tel'];

if (isset($_POST['continue'])){
	// * Processing phone number string.
	$tel = trim($_POST['tel']); $tel = str_replace(" ", "", $tel); $tel = str_replace("-", "", $tel); 
	if(stripos($tel, '+') !== false) $tel = $tel;
	else if(substr($tel, 0, 2) == '48' && strlen($tel) == 11) $tel = '+'.$tel;
	else if(stripos($tel, '+48') === false && strlen($tel) == 9) $tel = '+48'.$tel;

	/* 
	* Updating `ORDERS` table with new order info
	*/
	$last_update = date('y-m-d H:i:s');
	$query = "UPDATE orders SET 
	order_status = 1,
	last_update = :last_update,
	date_enter = :date_enter,
	time_enter = :time_enter,
	date_exit = :date_exit,
	time_exit = :time_exit,
	name_client = :name_client,
	tel_client = :tel_client,
	mail_client = :mail_client WHERE order_id = :order_id";
	$result = $db->prepare($query);
	$result->bindParam(":last_update",$last_update, PDO::PARAM_STR);
	$result->bindParam(":date_enter",$_POST['date_enter'], PDO::PARAM_STR);
	$result->bindParam(":time_enter",$_POST['time_enter'], PDO::PARAM_STR);
	$result->bindParam(":date_exit",$_POST['date_exit'], PDO::PARAM_STR);
	$result->bindParam(":time_exit",$_POST['time_exit'], PDO::PARAM_STR);
	$result->bindParam(":name_client",$_POST['name'], PDO::PARAM_STR);
	$result->bindParam(":tel_client",$tel, PDO::PARAM_STR);
	$result->bindParam(":mail_client",$_POST['mail'], PDO::PARAM_STR);
	$result->bindParam(":order_id",$_COOKIE['order_id'], PDO::PARAM_STR);
	$result->execute();

	$order_str = 'R1-'.$_COOKIE['order_id'].';';

	// * CHECKING IF USER IS LOGGED IN
	// * If YES, updating data in `clients` table
	if (isset($_COOKIE['client_tel'])){
		$query = "SELECT * from clients WHERE tel = :tel";
		$result = $db->prepare($query);
		$result->bindParam(":tel", $_COOKIE['client_tel'], PDO::PARAM_STR);
		$result->execute();
		$client = $result->fetch(PDO::FETCH_ASSOC);

		// * checking if phone numer is the same and if we should verify it using SMS again.
		if ($_COOKIE['client_tel'] == $tel) { $tel_confirmed = true; $_SESSION['tel_confirmed'] = true; $refresh = 'true'; }
		else { $tel_confirmed = false; $_SESSION['tel_confirmed'] = false; $_COOKIE['client_tel'] = $tel; }
		$order_str = $client['orders'].$order_str;

		// * checking if any other data updated and form a string of updates.
		$histor_chang = '';
		if ($_POST['name'] != $client['name']) $histor_chang .= 'было изменено имя';
		if ($_POST['mail'] != $client['mail']) $histor_chang .= ($histor_chang == '') ? 'был изменен e-mail':', был изменен e-mail';
		if ($tel != $client['tel']) $histor_chang .= ($histor_chang == '') ? 'был изменен номер телефона':', был изменен номер телефона';
		$histor = ($histor_chang == '') ? $client['histor_chang'] : $client['histor_chang'].'/'.date('y-m-d H:i:s').' '.$histor_chang;

		// * updating client's row.
		$result2 = $db->prepare("UPDATE clients SET orders = :orders, name = :name, mail = :mail, tel = :new_tel, histor_chang = :histor_chang WHERE tel = :tel ");
		$result2->bindParam(":orders", $order_str, PDO::PARAM_STR);
		$result2->bindParam(":name", $_POST['name'], PDO::PARAM_STR);
		$result2->bindParam(":mail", $_POST['mail'], PDO::PARAM_STR);
		$result2->bindParam(":new_tel", $tel, PDO::PARAM_STR);
		$result2->bindParam(":histor_chang", $histor, PDO::PARAM_STR);
		$result2->bindParam(":tel", $_COOKIE['client_tel'], PDO::PARAM_STR);
		$result2->execute();
	}else{
	// * if user is NOT logged in
		include '../point_ent_1.php';
	}

	// * if phone number is confirmed we log client in
	// * and send message about the new order to Telegram Bot
		if ($tel_confirmed === true){	 
			setcookie("client_tel", $tel, time() + 7200*60*60, "/");
			$mes = "🟡 Niepotwierdzona\n".$_POST['name']."\n".$tel."\nRezerwacja - ".$_COOKIE['order_id']."\n".$order['bill']." zł - Na ".$_POST['for_days']." dni";
			$message_id = TelegramBot::sendMessageTo($mes);
			$query = "UPDATE orders SET message_id = :message_id WHERE order_id = :order_id";
			$result = $db->prepare($query);
			$result->bindParam(":message_id",$message_id, PDO::PARAM_INT);
			$result->bindParam(":order_id", $_COOKIE['order_id'], PDO::PARAM_STR);
			$result->execute();
		}
}

$_SESSION['cost_parking_day1'] = $moderator['cost_parking_day1']; $_SESSION['cost_parking_day2'] = $moderator['cost_parking_day2']; $_SESSION['cost_parking_day3'] = $moderator['cost_parking_day3']; $_SESSION['cost_parking_day4'] = $moderator['cost_parking_day4']; $_SESSION['cost_parking_day5'] = $moderator['cost_parking_day5']; $_SESSION['cost_parking_day6'] = $moderator['cost_parking_day6']; $_SESSION['cost_parking_day7'] = $moderator['cost_parking_day7']; $_SESSION['cost_parking_day8'] = $moderator['cost_parking_day8']; $_SESSION['cost_parking_day9'] = $moderator['cost_parking_day9']; $_SESSION['cost_parking_day10'] = $moderator['cost_parking_day10']; $_SESSION['cost_parking_day11'] = $moderator['cost_parking_day11']; $_SESSION['cost_parking_day12'] = $moderator['cost_parking_day12']; $_SESSION['cost_parking_day13'] = $moderator['cost_parking_day13']; $_SESSION['cost_parking_day14'] = $moderator['cost_parking_day14']; $_SESSION['cost_parking_day_after14'] = $moderator['cost_parking_day_after14'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../css/styles.css">
	<title><?=$translate['book_parking_place'];?> | R1 PARKING</title>
</head>
<body>
<div id="refresh" style="display: none;"><?=$refresh;?></div>
<? include '../point_ent_1_phone.php';?>
<header><? include '../blocks/header.php'?></header>
<form action="" method="post">
<div class="container column">
	<div class="step2_title1"><?=$translate['book_warsaw_chopin'];?></div>

	<div class="container rows">
		<div class="traveler_data">
			<div class="step2_titles"><?=$translate['traveler_data'];?></div>
			<div class="input_row input_row_step2"> 
				<div class="input_label_step2"><?=$translate['full_name'];?>*</div>
				<input type="text" name="name" id="nameForm" autocomplete="on" placeholder="np. Jan Kowalski" required value="<?=$client['name'];?>">
			</div>
			<div class="input_row input_row_step2">
				<div class="input_label_step2"><?=$translate['phone_number'];?>*</div>
				<input type="tel" name="tel" id="telForm" autocomplete="on" placeholder="np. +48789419479" required value="<?=(isset($_COOKIE['client_tel'])) ? $autoinput : $_COOKIE['new_tel'];?>" onchange="autoinput();">
			</div>
			<div class="input_row input_row_step2">
				<div class="input_label_step2"><?=$translate['mail'];?></div>
				<input type="email" name="mail" id="mailForm" autocomplete="on" placeholder="np. jan@gmail.com" value="<?=$client['mail'];?>">
			</div>
			<div class="note"><?=$translate['you_will_receive_confirmation'];?></div>
		</div>

		<div class="right_col">
		<div class="date_time_step2">
			<div class="arrival">
				<div class="date_time_block_step2 left">
					<div class="input_label white"><?=$translate['arrival_date'];?></div>
					<input style="color: #b7b7b7;" min="<? echo date('Y-m-d');?>" onchange="document.getElementById('dateExitForm').setAttribute('min', document.getElementById('dateEnterForm').value); countBill();" type="date" name="date_enter" class="date_step2" required id="dateEnterForm" value="<?=$order['date_enter'];?>">
				</div>
				<div class="date_time_block_step2 right">
					<div class="input_label white"><?=$translate['arrival_time'];?></div>
					<input type="time" name="time_enter" class="date_step2 bright_time" required id="timeEnterForm" value="15:00" onchange="document.getElementById('timeEnterForm').classList.remove('bright_time')">
				</div>
			</div>
			<div class="departure">
				<div class="date_time_block_step2 left">
					<div class="input_label white"><?=$translate['departure_date'];?></div>
					<input style="color: #b7b7b7;" onchange="document.getElementById('dateEnterForm').setAttribute('max', document.getElementById('dateExitForm').value); countBill();" type="date" name="date_exit" class="date_step2" required id="dateExitForm" value="<?=$order['date_exit'];?>">
				</div>
				<div class="date_time_block_step2 right">
					<div class="input_label white"><?=$translate['departure_time'];?></div>
					<input type="time" name="time_exit" class="date_step2 bright_time" required id="timeExitForm" value="15:00" onchange="document.getElementById('timeExitForm').classList.remove('bright_time')">
				</div>
			</div>
			<input type="hidden" id="forDays" name="for_days" value="0">
		</div>
		<div class="cost">
			<div class="input_label"><?=$translate['cost'];?></div>
			<div class="bill" id="bill"><div id="billJS">0</div> <div class=""> zł</div></div>
			<div class="note">
				*<?=$translate['this_is_the_total_cost_of'];?>
			</div>
		</div>
		<div class="advantage">
		&#10004; <?=$translate['free_transfer_to_the_airport'];?>
		</div>
		</div>
	</div>
	<div class="cont_continue_btn">
	<input class="continue_btn" name="continue" type="submit" value="<?=$translate['continue'];?>">
	</div>
</div>
</form>
<? include '../blocks/footer.php'?>
<script src="../js/booking.js"></script>
<script src="../phone_confirm/phone_confirm.js"></script>
<script type="module" src="../js/get_token.js"></script>
<script>
    countBill();
	autoinput();
</script>
</body>
</html>