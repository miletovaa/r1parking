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

if(!$_COOKIE['client_tel']) header('Location: ../PL/R-1.php');

$query = "SELECT * from orders WHERE order_id = :order_id";
$result = $db->prepare($query);
$result->bindParam(":order_id", $_COOKIE['order_id'], PDO::PARAM_STR);
$result->execute();
$order = $result->fetch(PDO::FETCH_ASSOC);
$tel = $order['tel_client'];

if (isset($_POST['book'])){
	$passengers = ($_POST['adults'] != 0) ? 'A-'.$_POST['adults'].';' : 'A-1;';
	if ($_POST['children'] != 0) $passengers .= 'C-'.$_POST['children'].';';
	if ($_POST['disabled'] != 0) $passengers .= 'D-'.$_POST['disabled'].';';
	$cars = (isset($_POST['cars'])) ? $_POST['cars'] : 0;
	$registration = (isset($_POST['registration'])) ? $_POST['registration'] : '-';
	$back_from = (isset($_POST['back_from'])) ? $_POST['back_from'] : '-';
	$comments = (isset($_POST['comments'])) ? $_POST['comments'] : '-';
	$key_safe = (isset($_POST['keys'])) ? 1 : 0;
	$free_help = (isset($_POST['free_help'])) ? 1 : 0;
	$subscribe = (isset($_POST['subscribe'])) ? 1 : 0;
	$vat = isset($_POST['vat']) ? 1 : 0;
	$vat_name = isset($_POST['vat_name']) ? $_POST['vat_name'] : '';
	$vat_nip = isset($_POST['vat_nip']) ? $_POST['vat_nip'] : '';
	$vat_address = isset($_POST['vat_address']) ? $_POST['vat_address'] : '';
	$vat_postcode = isset($_POST['vat_postcode']) ? $_POST['vat_postcode'] : '';
	$vat_city = isset($_POST['vat_city']) ? $_POST['vat_city'] : '';
	$last_update = date('y-m-d H:i:s');

	/* 
	* Updating `ORDERS` table with new order info
	*/
	$query = "UPDATE orders SET 
	order_status = 2,
	last_update = :last_update,
	passengers = :passengers,
	cars = :cars,
	registration = :registration,
	back_from = :back_from,
	comments = :comments,
	key_safe = :key_safe,
	payment = :payment,
	vat = :vat,
	vat_name = :vat_name,
	vat_nip = :vat_nip,
	vat_address = :vat_address,
	vat_postcode = :vat_postcode,
	vat_city = :vat_city,
	free_help = :free_help,
	subscribe = :subscribe,
	book_finish = :book_finish
	WHERE order_id = :order_id";
	$result = $db->prepare($query);
	$result->bindParam(":last_update",$last_update, PDO::PARAM_STR);
	$result->bindParam(":passengers",$passengers, PDO::PARAM_STR);
	$result->bindParam(":cars",$cars, PDO::PARAM_INT);
	$result->bindParam(":registration",$registration, PDO::PARAM_STR);
	$result->bindParam(":back_from",$back_from, PDO::PARAM_STR);
	$result->bindParam(":comments",$comments, PDO::PARAM_STR);
	$result->bindParam(":key_safe",$key_safe, PDO::PARAM_INT);
	$result->bindParam(":payment",$_POST['payment'], PDO::PARAM_STR);
	$result->bindParam(":vat",$vat, PDO::PARAM_INT);
	$result->bindParam(":vat_name",$vat_name, PDO::PARAM_STR);
	$result->bindParam(":vat_nip",$vat_nip, PDO::PARAM_STR);
	$result->bindParam(":vat_address",$vat_address, PDO::PARAM_STR);
	$result->bindParam(":vat_postcode",$vat_postcode, PDO::PARAM_STR);
	$result->bindParam(":vat_city",$vat_city, PDO::PARAM_STR);
	$result->bindParam(":free_help",$free_help, PDO::PARAM_INT);
	$result->bindParam(":subscribe",$subscribe, PDO::PARAM_INT);
	$result->bindParam(":book_finish",$last_update, PDO::PARAM_STR);
	$result->bindParam(":order_id",$_COOKIE['order_id'], PDO::PARAM_STR);
	$result->execute();

	/*
	* GENERATING bill, reservation file and VAT invoice (if it was requested)
	*/
	include 'paragon.php';
	include 'confirmation.php';
	if ($vat == 1) include 'vat.php';

	$query = "SELECT * from orders WHERE order_id = :order_id";
	$result = $db->prepare($query);
	$result->bindParam(":order_id", $_COOKIE['order_id'], PDO::PARAM_STR);
	$result->execute();
	$order = $result->fetch(PDO::FETCH_ASSOC);

	/*
	* Updating message from Telegram Bot.
	*/
	$mes = "🟢 Potwierdzona\n".$order['name_client']."\n".$order['tel_client']."\nRezerwacja - ".$order['order_id']."\n".$order['bill']." zł - Na ".$order['for_days']." dni";
	$message_id = TelegramBot::updateMessage($mes, $order['message_id']);

	/*
	* If e-mail wasn't verified yet, send message with unique verification link.
	*/
	if($order['mail_confirmed'] != 1 && $order['mail_client'] != '' && $order['mail_code'] == null){
		$mailto = $order['mail_client'];
		include 'mail_verif.php';
	}
    $refresh = 'true';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../css/styles.css">
	<title><?=$translate['book_parking_place'];?> | R1 parking</title>
</head>
<body>
<div id="refresh" style="display: none;"><?=$refresh;?></div>

<header><? include '../blocks/header.php'?></header>

<div id="costParking" style="display: none;"><?=$order['bill'];?></div>
	<form action="" method="post">
	<div class="container cont_step3">
		<div class="traveler_data step3">
			<div class="input_label"><?=$translate['traveler_data'];?></div>
			<div class="note"><?=$translate['this_info_will_help_us'];?></div>
			<div class="persons">
				<div class="input_row"> 
					<div class="input_label_step3 person"><?=$translate['adults'];?></div>
					<input type="number" min="0" name="adults" id="adultsForm">
				</div>
				<div class="input_row"> 
					<div class="input_label_step3 person unselected" onclick="inputChildrenFunc()"><?=$translate['children'];?><button type="button" id="inputChildren" onclick="inputChildrenFunc()">+</button></div>
					
					<input type="number" min="0" name="children" id="childrenForm" style="display:none">
				</div>
				<div class="input_row"> 
					<div class="input_label_step3 person unselected" onclick="inputDisabledFunc()"><?=$translate['disabled'];?><button type="button" id="inputDisabled" onclick="inputDisabledFunc()">+</button></div>

					<input type="number" min="0" name="disabled" id="disabledForm" style="display:none">
				</div>
			</div>
			<div class="car_row">
				<div class="input_row"> 
					<div class="input_label_step3"><?=$translate['cars'];?></div>
					<select name="cars" id="carsForm" onchange="carsInputs()">
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
						<option value="4">4</option>
						<option value="5">5</option>
						<option value="6">6</option>
						<option value="7">7</option>
						<option value="8">8</option>
					</select>
				</div>
				<div class="input_row"> 
					<input type="hidden" name="registration" id="registrationForm">
					<div class="input_label_step3"><?=$translate['registration'];?></div>
					<input class="step3_reg reg" type="text" onchange="registrationsCollect()">
				</div>
			</div>
			<div class="input_row"> 
				<div class="input_label_step3"><?=$translate['comments'];?></div>
				<textarea name="comments" id="commentsForm" cols="30" rows="10"></textarea>
			</div>
		</div>

		<div class="right_col">
			<div class="block_step3">
				<div class="input_row row">
					<input type="checkbox" name="keys" id="keysForm" onchange="addToBill()">
					<div class="input_label_step3 key_storage" onclick="keyChecked()"><?=$translate['key_storage'];?></div>
				<span class="cost_keys">+ <span id="costKeys"><?=$moderator['cost_key'];?></span> zł</span>
				</div>
			</div>

			<div class="block_step3 payment">
				<div class="block_step3_payment">
					<div class="payment_left">
						<div class="input_label"><?=$translate['payment'];?></div>
						<div id="bill_row"><span id="costAll"><?=$order['bill'];?></span> zł</div>
					</div>
					<div class="payment_right">
						<div class="input_row">
							<input type="radio" name="payment" value="cash" id="cashPaymentForm" required> <div class="payment_label"><?=$translate['cash'];?></div>
						</div>
						<div class="input_row">
							<input type="radio" name="payment" value="online" id="onlinePaymentForm" title="Ta metoda płatności będzie dostępna wkrótce" disabled><div title="Ta metoda płatności będzie dostępna wkrótce" class="payment_label"><?=$translate['online'];?></div>
						</div>
					</div>
				</div>
				<div class="input_row row center">
					<input type="checkbox" name="vat" id="vatForm" onchange="vatFunction()"><div onclick="vatChecked()" class="input_label input_label_vat"><?=$translate['i_want_to_receive_vat'];?></div>
				</div>
				<div id="vat" class="container invisible">
					<div class="left">
						<div class="input_row"> 
							<div class="input_label_step3 vat"><?=$translate['company_name'];?></div>
							<input class="vat_inp" type="text" name="vat_name" id="vatNameForm">
						</div>
						<div class="input_row"> 
							<div class="input_label_step3 vat"><?=$translate['company_address'];?></div>
							<input class="vat_inp" type="text" name="vat_address" id="vatAddressForm">
						</div>
						<div class="input_row"> 
							<div class="input_label_step3 vat"><?=$translate['postcode'];?></div>
							<input class="vat_inp" type="text" name="vat_postcode" id="vatPostcodeForm">
						</div>
					</div>
					<div class="right">
						<div class="input_row"> 
							<div class="input_label_step3 vat"><?=$translate['city'];?></div>
							<input class="vat_inp" type="text" name="vat_city" id="vatCityForm">
						</div>
						<div class="input_row"> 
							<div class="input_label_step3 vat"><?=$translate['nip'];?></div>
							<input class="vat_inp" type="text" name="vat_nip" id="vatNipForm">
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
		<div class="container column">
				<div class="input_row row checkbox_row">
					<input id="rulesForm" type="checkbox" required>
					<div class="input_label_step3" onclick="rulesChecked()"><?=$translate['i_have_read_and_accept'];?> <?=$translate['parking_rules'];?>, <?=$translate['booking_rules'];?>*</div>
				</div>
				<hr>
				<div class="input_row row checkbox_row">
					<input id="freeHelp" type="checkbox" name="free_help">
					<div class="input_label_step3 note" onclick="freeHelpChecked()"><?=$translate['i_want_free_assistance'];?></div>
				</div>
				<div class="input_row row checkbox_row">
					<input id="subscribeForm" type="checkbox" name="subscribe">
					<div class="input_label_step3 note" onclick="sbscrbChecked()"><?=$translate['commercial_information'];?></div>
				</div>
				<div class="note checkbox_row">
					<?=$translate['agree'];?>
				</div>
		<input type="submit" name="book" class="book_btn" value="<?=$translate['book'];?>">
		</div>
	</form>
	
<? include '../blocks/footer.php'?>
<script src="../js/booking.js"></script>
</body>
</html>