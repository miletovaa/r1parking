<?
session_start();

/* 
* Connection with Database
*/
require '../db.php';
$db = Database::getConnection();

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
* UNSET cookie in case that user have been on the current page before
*/
setcookie("order_id", '', time() + 72*60*60, "/");
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
    <div id="main_photo">
        <img src="../img/parking.webp" alt="">
        <!-- <img src="../img/parking1.webp" alt=""> -->
        <!-- <img src="../img/parking.jpg" alt=""> -->
        <!-- <img src="../img/parking2.jpg" alt=""> -->
        <!-- <img src="../img/parking3.jpg" alt=""> -->
    </div>
    <div class="container dates">
		<form action="step2.php" method="post">
        <div class="block_on_photo_dates">
			<div class="dates_title1"><?=$translate['book_warsaw_chopin'];?></div>
			<div class="dates_title"><?=$translate['your_place'];?></div>
			<hr>
			<div class="date_time">
				<div class="date_time_block">
					<div class="input_label"><?=$translate['arrival_date'];?></div>
					<input min="<? echo date('Y-m-d');?>" type="date" name="date_enter" id="dateEnterForm" required>
				</div>
				<div class="date_time_block">
					<div class="input_label"><?=$translate['departure_date'];?></div>
					<input min="<? echo date('Y-m-d');?>" type="date" name="date_exit" id="dateExitForm" required>
				</div>
				<input type="hidden" id="forDays" name="for_days" value="0">
			<input type="submit" class="btn_days" value="<?=$translate['continue'];?>">
			</div>
        </div>
		</form>
    </div>
<script src="../js/booking.js"></script>
</body>
</html>