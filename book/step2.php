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
* Checking if user have been on this page before.
*
* If YES, we insert to the <inputs> data provided and added to Database (`ORDERS` table) before.
*
* In case that user HAVEN'T BEEN here before, we
* 1) create new row to the `ORDERS` table in Database,
* 2) add new ORDER_ID to COOKIES to determine client on other pages,
* 3) we insert to the <inputs> data provided to the <inputs> at the previous page
*/
if (isset($_COOKIE['order_id'])){
	$query = "SELECT * from orders WHERE order_id = :order_id";
	$result = $db->prepare($query);
	$result->bindParam(":order_id", $_COOKIE['order_id'], PDO::PARAM_STR);
	$result->execute();
	$order = $result->fetch(PDO::FETCH_ASSOC);
}else{
	$order_id = CreateRandomCodeFullCharacter(6);
	setcookie("order_id", $order_id, time() + 72*60*60, "/");
	$query = "INSERT INTO `orders` 
	(`order_id`,
	`date_enter`,
	`date_exit`) VALUES 
	(:order_id,
	:date_enter,
	:date_exit)";
	$result = $db->prepare($query);
	$result->bindParam(":order_id", $order_id, PDO::PARAM_STR);
	$result->bindParam(":date_enter", $_POST['date_enter'], PDO::PARAM_STR);
	$result->bindParam(":date_exit", $_POST['date_exit'], PDO::PARAM_STR);
	$result->execute();
	$order['date_enter'] = $_POST['date_enter'];
	$order['date_exit'] = $_POST['date_exit'];
}
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
<header><? include '../blocks/header.php'?></header>
	<div id="costParkingDay1" style="display: none;"><?=$moderator['cost_parking_day1'];?></div><div id="costParkingDay2" style="display: none;"><?=$moderator['cost_parking_day2'];?></div><div id="costParkingDay3" style="display: none;"><?=$moderator['cost_parking_day3'];?></div><div id="costParkingDay4" style="display: none;"><?=$moderator['cost_parking_day4'];?></div><div id="costParkingDay5" style="display: none;"><?=$moderator['cost_parking_day5'];?></div><div id="costParkingDay6" style="display: none;"><?=$moderator['cost_parking_day6'];?></div><div id="costParkingDay7" style="display: none;"><?=$moderator['cost_parking_day7'];?></div><div id="costParkingDay8" style="display: none;"><?=$moderator['cost_parking_day8'];?></div><div id="costParkingDay9" style="display: none;"><?=$moderator['cost_parking_day9'];?></div><div id="costParkingDay10" style="display: none;"><?=$moderator['cost_parking_day10'];?></div><div id="costParkingDay11" style="display: none;"><?=$moderator['cost_parking_day11'];?></div><div id="costParkingDay12" style="display: none;"><?=$moderator['cost_parking_day12'];?></div><div id="costParkingDay13" style="display: none;"><?=$moderator['cost_parking_day13'];?></div><div id="costParkingDay14" style="display: none;"><?=$moderator['cost_parking_day14'];?></div><div id="costParkingDayAfter14" style="display: none;"><?=$moderator['cost_parking_day_after14'];?></div>
<form action="step3.php" method="post">
<div class="container column">
	<div class="step2_title1"><?=$translate['book_warsaw_chopin'];?></div>
    <div class="step2_title2"><?=$translate['fill_info'];?></div>

	<div class="container rows">
		<div class="traveler_data">
			<div class="step2_titles"><?=$translate['traveler_data'];?></div>
			<div class="input_row"> 
				<div class="input_label_step2"><?=$translate['full_name'];?>*</div>
				<input type="text" name="name" id="nameForm" autocomplete="on" placeholder="np. Jan Kowalski" required>
			</div>
			<div class="input_row">
				<div class="input_label_step2"><?=$translate['phone_number'];?>*</div>
				<input type="tel" name="tel" id="telForm" autocomplete="on" placeholder="np. +48789419479" required>
			</div>
			<div class="input_row">
				<div class="input_label_step2"><?=$translate['mail'];?></div>
				<input type="email" name="mail" id="mailForm" autocomplete="on" placeholder="np. jan@gmail.com">
			</div>
			<div class="note"><?=$translate['you_will_receive_confirmation'];?></div>
		</div>

		<div class="rigth_col">
		<div class="date_time_step2">
			<div class="arrival">
				<div class="date_time_block_step2">
					<div class="input_label white"><?=$translate['arrival_date'];?></div>
					<input min="<? echo date('Y-m-d');?>" type="date" name="date_enter" class="date_step2" required id="dateEnterForm" onchange="countBill()" value="<?=$order['date_enter'];?>">
				</div>
				<div class="date_time_block_step2">
					<div class="input_label white"><?=$translate['arrival_time'];?></div>
					<input type="time" name="time_enter" class="date_step2" required id="timeEnterForm" value="15:00">
				</div>
			</div>
			<div class="departure">
				<div class="date_time_block_step2">
					<div class="input_label white"><?=$translate['departure_date'];?></div>
					<input min="<? echo date('Y-m-d');?>" type="date" name="date_exit" class="date_step2" required id="dateExitForm" onchange="countBill()" value="<?=$order['date_exit'];?>">
				</div>
				<div class="date_time_block_step2">
					<div class="input_label white"><?=$translate['departure_time'];?></div>
					<input type="time" name="time_exit" class="date_step2" required id="timeExitForm" value="15:00">
				</div>
			</div>
			<input type="hidden" id="forDays" name="for_days" value="0">
		</div>
		<div class="cost">
			<div class="input_label"><?=$translate['cost'];?></div>
			<div class="bill" id="bill"><div id="billJS">0</div> <div class=""> zł</div></div>
			<input type="hidden" name="bill" id="costParking" value="0">
			<div class="note">
				*<?=$translate['this_is_the_total_cost_of'];?>
			</div>
		</div>
		<div class="advantage">
		&#10004; <?=$translate['free_transfer_to_the_airport'];?>
		</div>
		</div>
	</div>
		<input class="continue_btn" type="submit" value="<?=$translate['continue'];?>">
</div>
</form>
<script src="../js/booking.js"></script>
<script>
    countBill();
</script>
</body>
</html>