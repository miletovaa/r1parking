<?
include 'session.php';
require '../db.php';
require '../functions/moderator.php';

/* 
* Checking if admin logged in.
* If NO, go to LOG IN page.
*/
if ($_SESSION['admin'] != 'logged_in') header('Location: log_in.php');

function CreateRandomCodeFullCharacter($quantity_сharacters){
    $full_arr = array('A','B','D','F','H','K','P','Q','S','T','U','X','Y','Z',0,1,2,3,4,5,6,7,8,9);
    $code = null;
    for ($i = 1; $i <= $quantity_сharacters; $i++)
    {
        $count_full_arr = count($full_arr);
        $сhar_pos_in_array = rand(0, $count_full_arr-1);
        $code .= $full_arr[$сhar_pos_in_array];
    }
    return $code;
}

/* 
* Make sure if we have any overdue parking.
*/
date_default_timezone_set('Europe/Warsaw');
$today = date('Y-m-d');
$tomorrow = date('Y-m-').(intval(date('d'))+1);
$curr_time = date('H:i:s');
$zmiana_start = $moderator['zmiana_start'];
if ($zmiana_start > $curr_time) $today = date('Y-m-').(intval(date('d'))-1);
include 'update_debt.php';

/*
* Creating of new order by admin.
*/
if(isset($_POST['anuluj'])) return true;
else if (isset($_POST['dodaj'])){
	$order_id = CreateRandomCodeFullCharacter(6);
	$last_update = date('y-m-d H:i:s');
	$passengers = '';
	if ($_POST['a'] != 0) $passengers .= 'A-'.$_POST['a'].'; ';
	if ($_POST['c'] != 0) $passengers .= 'C-'.$_POST['c'].'; ';
	if ($_POST['i'] != 0) $passengers .= 'D-'.$_POST['i'].'; ';
	$query = "INSERT INTO `orders` 
	(`order_status`,
	`last_update`,
	`order_id`,
	`date_enter`,
	`date_exit`,
	`time_enter`,
	`time_exit`,
	`next_step`,
	`for_days`,
	`mail_client`,
	`tel_client`,
	`name_client`,
	`payment`,
	`registration`,
	`passengers`,
	`cars`,
	`bill`) VALUES 
	(2,
	:last_update,
	:order_id,
	:date_enter,
	:date_exit,
	:time_enter,
	:time_exit,
	:next_step,
	:for_days,
	:mail_client,
	:tel_client,
	:name_client,
	'cash',
	:registration,
	:passengers,
	:cars,
	:bill)";
	$result = $db->prepare($query);
	$result->bindParam(":last_update",$last_update, PDO::PARAM_STR);
	$result->bindParam(":order_id", $order_id, PDO::PARAM_STR);
	$result->bindParam(":date_enter", $_POST['date_enter'], PDO::PARAM_STR);
	$result->bindParam(":date_exit", $_POST['date_exit'], PDO::PARAM_STR);
	$result->bindParam(":time_enter", $_POST['time_enter'], PDO::PARAM_STR);
	$result->bindParam(":time_exit", $_POST['time_exit'], PDO::PARAM_STR);
	$result->bindParam(":next_step", $_POST['time_enter'], PDO::PARAM_STR);
	$result->bindParam(":for_days", $_POST['for_days'], PDO::PARAM_INT);
	$result->bindParam(":mail_client", $_POST['mail_client'], PDO::PARAM_STR);
	$result->bindParam(":tel_client", $_POST['tel_client'], PDO::PARAM_STR);
	$result->bindParam(":name_client", $_POST['name_client'], PDO::PARAM_STR);
	$result->bindParam(":registration", $_POST['registration'], PDO::PARAM_STR);
	$result->bindParam(":passengers", $passengers, PDO::PARAM_STR);
	$result->bindParam(":cars", $_POST['cars'], PDO::PARAM_INT);
	$result->bindParam(":bill", $_POST['bill'], PDO::PARAM_INT);
	$result->execute();
	header('Refresh: 0');
}

/* 
* Fetch all orders from the Database.
*
* Order rows by selected column.
*/
$query = "SELECT * from orders";
if (isset($_GET['debt'])){
	$query .= " WHERE (order_status > 0) ORDER BY debt DESC";
}else{
	$query .= " WHERE (order_status > 0) ";
}
if (isset($_GET['order_by'])) {
	$res = $db->prepare("SELECT * from orders");
	$res->execute();
	$column = $res->fetchAll(PDO::FETCH_ASSOC)[0];
	if (isset($column[$_GET['order_by']])) $query .= " ORDER BY ".$_GET['order_by'];
	if (isset($_GET['desc'])) {
		$query .= " DESC";
	}
}
$result = $db->prepare($query);
$result->execute();
$orders = $result->fetchAll(PDO::FETCH_ASSOC);

$last_update_q = $db->prepare("SELECT * from orders ORDER BY last_update DESC");
$last_update_q->execute();
$last_update = $last_update_q->fetchAll(PDO::FETCH_ASSOC)[0]['last_update'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../css/admin.css">
	<title>Rezerwacje | R1 Parking</title>
</head>
<body>
<div id="costParkingDay1" style="display: none;"><?=$moderator['cost_parking_day1'];?></div><div id="costParkingDay2" style="display: none;"><?=$moderator['cost_parking_day2'];?></div><div id="costParkingDay3" style="display: none;"><?=$moderator['cost_parking_day3'];?></div><div id="costParkingDay4" style="display: none;"><?=$moderator['cost_parking_day4'];?></div><div id="costParkingDay5" style="display: none;"><?=$moderator['cost_parking_day5'];?></div><div id="costParkingDay6" style="display: none;"><?=$moderator['cost_parking_day6'];?></div><div id="costParkingDay7" style="display: none;"><?=$moderator['cost_parking_day7'];?></div><div id="costParkingDay8" style="display: none;"><?=$moderator['cost_parking_day8'];?></div><div id="costParkingDay9" style="display: none;"><?=$moderator['cost_parking_day9'];?></div><div id="costParkingDay10" style="display: none;"><?=$moderator['cost_parking_day10'];?></div><div id="costParkingDay11" style="display: none;"><?=$moderator['cost_parking_day11'];?></div><div id="costParkingDay12" style="display: none;"><?=$moderator['cost_parking_day12'];?></div><div id="costParkingDay13" style="display: none;"><?=$moderator['cost_parking_day13'];?></div><div id="costParkingDay14" style="display: none;"><?=$moderator['cost_parking_day14'];?></div><div id="costParkingDayAfter14" style="display: none;"><?=$moderator['cost_parking_day_after14'];?></div>
<div id="lastUpdate" style="display:none;"><?=$last_update;?></div>
	<h1><a href="orders_panel.php"> Wszystkie rezerwacje </a></h1>
<? include 'buttons.php';?>
<input type="checkbox" name="debt" id="showDebt" <? if(isset($_GET['debt'])) echo 'checked';?> onclick="showDebt()"> Wyświetlaj opóźnione samochody
	<div id="orders_container">
		<div class="order_row head">
			<div class="order_col id" style="flex-direction: column;">NR</div>
			<div class="order_col" style="flex-direction: column;"><div class=""><img src="../img/icons/search.png" width="15" onclick="searchIndexInput()" id="searchIndex" alt=""> ID REZERWACJI <a href="?order_by=id">&#9650;</a><a href="?order_by=id&desc=">&#9660;</a><br></div><input type="text" id="searchOrderIndex" style="display: none;" class="search"></div>
			<div class="order_col" style="flex-direction: column;"><div class=""><img src="../img/icons/search.png" width="15" onclick="searchStatus()" id="searchStatus" alt=""> STATUS <a href="?order_by=order_status">&#9650;</a><a href="?order_by=order_status&desc=">&#9660;</a><br></div><select id="searchStatusInput" style="display: none;" class="search"><option value="zrealizowana">ZREALIZOWANA</option><option value="potwierdzona">POTWIERDZONA</option><option value="PRZETWARZANA">PRZETWARZANA</option><option value="Nie potwierdzona">Nie potwierdzona</option></select></div>
			<div class="order_col">DO ZAPŁATY <a href="?order_by=bill">&#9650;</a><a href="?order_by=bill&desc=">&#9660;</a></div>
			<div class="order_col" style="flex-direction: column;"><div class=""><img src="../img/icons/search.png" width="15" onclick="searchDateInput()" id="searchDateInput" alt=""> PRZYJAZD / WYJAZD <a href="?order_by=date_enter">&#9650;</a><a href="?order_by=date_enter&desc=">&#9660;</a></div><input type="date" id="searchDate" style="display: none;" class="search"></div>
			<div class="order_col" style="flex-direction: column;"><div class=""><img src="../img/icons/search.png" width="15" onclick="searchRegInput()" id="searchReg" alt=""> REJESTRACJA <br></div><input type="text" id="searchRegInput" style="display: none;" class="search"></div>
			<div class="order_col" style="flex-direction: column;">PASAŻEROWIE</div>
			<div class="order_col" style="flex-direction: column;"><div class=""><img src="../img/icons/search.png" width="15" onclick="searchClient()" id="searchCli" alt=""> KLIENT <br></div><input type="text" id="searchClientInput" style="display: none;" class="search"></div>
		</div>
		<form action="" method="post"><div id="newReservationRow" style="display:none;" class="order_row status_new">
			<div class="order_col id btns"><input class="new_btn dodaj" type="submit" value="DODAJ" name="dodaj"><input class="new_btn anuluj" type="submit" value="ANULUJ" name="anuluj"></div>
			<div class="order_col">NOWA REZERWACJA</div>
			<div class="order_col"><b>POTWIERDZONA</b></div>
			<div class="order_col payment">Gotówka <div class=""><span id="newResCostJS">0</span> zł</div></div>
			<div class="order_col">od <input class="new_date_time" type="date" name="date_enter" id="dateEnterForm" class="input_new" onchange="countBill()"><input class="new_date_time" type="time" name="time_enter" class="input_new"> do <input class="new_date_time" type="date" name="date_exit" id="dateExitForm" class="input_new" onchange="countBill()"><input class="new_date_time" type="time" name="time_exit" class="input_new"></div>
			<div class="order_col"><div style="display: flex;width: 90%;"><input type="text" class="input_new rejestracja" placeholder="Rejestracja" onchange="registrationsCollect()"><button class="rej" onclick="moreRej(event)">+</button></div></div>
			<div class="order_col"><div class="new_pass">Dorośli <input type="number" class="input_new_pass" min="0" max="8" name="a" id=""></div><div class="new_pass">Dzieci <input type="number" class="input_new_pass" min="0" max="8" name="c" id=""></div><div class="new_pass">Os. niepełn. <input type="number" class="input_new_pass" min="0" max="8" name="i" id=""></div></div>
			<div class="order_col"><input type="text" class="input_new" name="name_client" placeholder="Imię"> <input type="text" class="input_new" placeholder="E-mail" name="mail_client"><input type="text" class="input_new" placeholder="Telefon" name="tel_client"></div>
			<input type="hidden" name="for_days" id="forDays">
			<input type="hidden" name="bill" id="newResCost">
			<input type="hidden" name="registration" id="registration">
			<input type="hidden" name="cars" id="cars">
		</div></form>
	<? foreach($orders as $key => $order){?>
		<?
			if ($order['order_status'] == 3 AND $order['date_exit'] < $today) $debt = true;
			else $debt = false;
			switch ($order['order_status']){
				case 1:
					$class = 'status1';
					$order_status = 'Rezerwacja nie potwierdzona.';
				break;
				case 2:
					$class = 'status2';
					$order_status = '<b>POTWIERDZONA</b> <button class="status_btn" id="s'.$order['order_id'].'" onclick="updateStatusBtn(this)">Już na parkingu</button>';
				break;
				case 3:
					$class = 'status3';
					$order_status = '<b>ZAPARKOWANY</b> <button class="status_btn" id="s'.$order['order_id'].'" onclick="updateStatusBtn(this)">Już odjechał</button>';
				break;
				case 4:
					$class = 'status4';
					$order_status = '<b>ZREALIZOWANA!</b>';
				break;
			}
			if ($debt){
				$class = 'status5'; 
				if (!isset($_GET['debt'])) $class .= ' displaynone';
			} 
			switch ($order['payment']){
				case 'cash':
					$img_payment = 'cash.png';
					$title_payment = 'Gotówka';
				break;
				case 'online':
					$img_payment = 'online.png';
					$title_payment = 'Online';
				break;
				case 'invoice':
					$img_payment = 'invoice.png';
					$title_payment = 'Faktura';
				break;
			}
			$passengers = '';
			$passengers .= (stripos($order['passengers'], 'A') !== false) ? 'Dorośli: '.substr($order['passengers'], strripos($order['passengers'], 'A')+2,1).'<br>' : '';
			$passengers .= (stripos($order['passengers'], 'C') !== false) ? 'Dzieci: '.substr($order['passengers'], strripos($order['passengers'], 'C')+2,1).'<br>' : '';
			$passengers .= (stripos($order['passengers'], 'D') !== false) ? 'Niepełn.: '.substr($order['passengers'], strripos($order['passengers'], 'D')+2,1).'<br>' : '';
		?>
		<div class="order_row <?=$class;?>">
			<div class="order_col id"><span class="small"><?=$order['id'];?></span></div>
			<div class="order_col"><b><?=$order['order_id'];?></b><a href="../book/print_paragon.php?order_id=<?=$order['order_id'];?>" target="_blank" class="call">RACHUNEK</a></div>
			<div class="order_col"><?=$order_status;?></div>
			<div class="order_col payment"><img class="icon" src="../img/icons/<?=$img_payment;?>" alt="" title="<?=$title_payment;?>"><div class=""><?=$order['bill'];?> <?if($debt) echo '<span style="color: red; font-weight: bold;">+'.$order['debt'].'</span>';?> zł</div></div>
			<div class="order_col">&#129042;<?=$order['date_enter'];?> <!-- <?=$order['admin_enter'];?> --><br><?=$order['date_exit'];?>&#129042; <!-- <?=$order['admin_exit'];?> --></div>
			<div class="order_col"><?=$order['registration'];?></div>
			<div class="order_col"><?=$passengers;?></div>
			<div class="order_col"><span class="name_client"><?=$order['name_client'];?></span> <span class="mail_client"><?=$order['mail_client'];?></span><a class="call" href="tel:<?=$order['tel_client'];?>"><b><?=$order['tel_client'];?></b><span class="zadzwon">ZADZWOŃ</span></a></div>
		</div>
	<?}?>
	</div>

<script src="../js/admin.js"></script>
<script src="../js/update_orders_list.js"></script>
</body>
</html>