<?
session_start();
/* 
* Connection with Database
*/
require '../db.php';
$db = Database::getConnection();

/*
* This function fetches some settings from the Database
* such as prices etc.
* This settings can be edited by admins in Admin Panel anytime
* and the changes will be on the site immediately
*/
$moderator = Database::moderatorSettings();

/* 
* Here is a fuction that sets language
* depending on browser settings of user
* OR
* users choice in the header of the cite
*/
$lang = Database::setLang();

/* 
* That function fetches site data from the Database
* depending on set language
*/
$translate = Database::translator($lang);

/* 
* Checking if we already have in Database client with such Phone number.
*
* If YES, we select client's ID from the Database to add new order to the client's row
*
* If NO, we create new row to the `CLIENTS` table in Database with provided users's info
*/
$client_isset = false;
$tel = $_POST['tel'];
$query = "SELECT * from clients WHERE tel = :tel";
$result = $db->prepare($query);
$result->bindParam(":tel", $tel, PDO::PARAM_STR);
$result->execute();
$client = $result->fetchAll(PDO::FETCH_ASSOC)[0];
if (!is_null($client)){
	$client_isset = true;
	$client_id = $client['id'];
	$client_orders = $client['orders'];
} 
$mail = isset($_POST['mail']) ? $_POST['mail'] : '-';
if (!$client_isset){
	$query = "INSERT INTO `clients` (`name`,`tel`,`mail`) VALUES (:client_name,:tel,:mail)";
	$result = $db->prepare($query);
	$result->bindParam(":client_name", $_POST['name'], PDO::PARAM_STR);
	$result->bindParam(":tel", $tel, PDO::PARAM_STR);
	$result->bindParam(":mail", $mail, PDO::PARAM_STR);
	$result->execute();

	$query = "SELECT * from clients WHERE tel = :tel";
	$result = $db->prepare($query);
	$result->bindParam(":tel", $tel, PDO::PARAM_STR);
	$fetch = $result->fetch(PDO::FETCH_ASSOC);
	$client_id = $fetch['id'];
	$client_orders = '';
}

/* 
* Updating `ORDERS` table with new order info
*/
$last_update = date('y-m-d H:i:s');
$query = "UPDATE orders SET 
last_update = :last_update,
date_enter = :date_enter,
time_enter = :time_enter,
date_exit = :date_exit,
time_exit = :time_exit,
for_days = :for_days,
bill = :bill,
client_id = :client_id
WHERE order_id = :order_id";
$result = $db->prepare($query);
$result->bindParam(":last_update",$last_update, PDO::PARAM_STR);
$result->bindParam(":date_enter",$_POST['date_enter'], PDO::PARAM_STR);
$result->bindParam(":time_enter",$_POST['time_enter'], PDO::PARAM_STR);
$result->bindParam(":date_exit",$_POST['date_exit'], PDO::PARAM_STR);
$result->bindParam(":time_exit",$_POST['time_exit'], PDO::PARAM_STR);
$result->bindParam(":for_days",$_POST['for_days'], PDO::PARAM_INT);
$result->bindParam(":bill",$_POST['bill'], PDO::PARAM_INT);
$result->bindParam(":client_id",$client_id, PDO::PARAM_INT);
$result->bindParam(":order_id",$_COOKIE['order_id'], PDO::PARAM_STR);
$result->execute();

$client_orders .= $_COOKIE['order_id'].'; ';
$query2 = "UPDATE clients SET orders = :orders WHERE id = :client_id";
$result2 = $db->prepare($query2);
$result2->bindParam(":orders",$client_orders, PDO::PARAM_STR);
$result2->bindParam(":client_id",$client_id, PDO::PARAM_INT);
$result2->execute();
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
<header><? include '../blocks/header.php'?></header>
<div id="costParking" style="display: none;"><?=$_POST['bill'];?></div>
	<form action="finish.php" method="post">
	<div class="container">
		<div class="traveler_data step3">
			<div class="input_label"><?=$translate['traveler_data'];?></div>
			<div class="note"><?=$translate['this_info_will_help_us'];?></div>
			<div class="persons">
				<div class="input_row"> 
					<div class="input_label_step3 person"><?=$translate['adults'];?></div>
					<input type="number" min="0" name="adults" id="adultsForm">
				</div>
				<div class="input_row"> 
					<div class="input_label_step3 person"><?=$translate['children'];?></div>
					<input type="number" min="0" name="children" id="childrenForm">
				</div>
				<div class="input_row"> 
					<div class="input_label_step3 person"><?=$translate['disabled'];?></div>
					<input type="number" min="0" name="disabled" id="disabledForm">
				</div>
			</div>
			<div class="car_row">
				<div class="input_row"> 
					<div class="input_label_step3"><?=$translate['cars'];?></div>
					<input type="number" min="0" max="8" name="cars" id="carsForm" onchange="carsInputs()">
				</div>
				<div class="input_row"> 
					<div class="input_label_step3"><?=$translate['registration'];?></div>
					<input class="step3_reg" type="text" name="registration" id="registrationForm">
				</div>
			</div>
			<div class="input_row"> 
				<div class="input_label_step3"><?=$translate['return_from'];?></div>
				<input type="text" name="back_from" id="backFromForm">
			</div>
			<div class="input_row"> 
				<div class="input_label_step3"><?=$translate['comments'];?></div>
				<textarea name="comments" id="commentsForm" cols="30" rows="10"></textarea>
			</div>
		</div>

		<div class="right_col">
			<div class="block_step3">
				<div class="input_label"><?=$translate['additional_services'];?></div>
				<div class="input_row row">
					<input type="checkbox" name="keys" id="keysForm" onchange="addToBill()">
					<div class="input_label_step3" onclick="keyChecked()"><?=$translate['key_storage'];?></div>
				<span class="cost_keys">+ <span id="costKeys"><?=$moderator['cost_key'];?></span> zł</span>
				</div>
			</div>

			<div class="block_step3 payment">
				<div class="input_label"><?=$translate['payment'];?></div>
				<div class="input_label_step3"><?=$translate['total_payment'];?></div>
				<div id="bill_row"><span id="costAll"><?=$_POST['bill'];?></span> zł</div>
				<input type="hidden" name="bill" id="bill" value="0">

				<div class="input_row">
					<input type="radio" name="payment" value="cash" id="cashPaymentForm" required> <div class=""><?=$translate['cash'];?></div>
				</div>
				<div class="input_row">
					<input type="radio" name="payment" value="online" id="onlinePaymentForm"><div class=""><?=$translate['online'];?></div>
				</div>
			</div>
		</div>
	</div>
		<div class="container column">
			
				<div class="input_row row center">
					<input type="checkbox" name="vat" id="vatForm" onchange="vatFunction()"><div onclick="vatChecked()" class="input_label"><?=$translate['i_want_to_receive_vat'];?></div>
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

				<div class="input_row row">
					<input id="rulesForm" type="checkbox" required>
					<div class="input_label_step3" onclick="rulesChecked()"><?=$translate['i_have_read_and_accept'];?> <?=$translate['parking_rules'];?>, <?=$translate['booking_rules'];?>*</div>
				</div>
				<hr>
				<div class="input_row row">
					<input id="freeHelp" type="checkbox" name="free_help">
					<div class="input_label_step3" onclick="freeHelpChecked()"><?=$translate['i_want_free_assistance'];?></div>
				</div>
				<div class="input_row row">
					<input id="subscribeForm" type="checkbox" name="subscribe">
					<div class="input_label_step3" onclick="sbscrbChecked()"><?=$translate['commercial_information'];?></div>
				</div>
				<div class="note">
					<?=$translate['agree'];?>
				</div>
		<input type="submit" class="book_btn" value="<?=$translate['book'];?>">
		</div>
	</form>
<script src="../js/booking.js"></script>
</body>
</html>