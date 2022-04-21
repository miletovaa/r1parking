<? include 'general_land.php';?>
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
<header><? include '../blocks/header.php'?></header>
    <div id="main_photo">
        <img src="../img/parking.webp" alt="">
    </div>
    <div class="container dates">
		<form action="" method="post">
        <div class="block_on_photo_dates index2">
			<div class="dates_title1 index2"><?=$translate['check_availability'];?></div>
			<hr>
			<div class="date_time">
				<div class="date_time_block">
					<div class="input_label date_form"><?=$translate['arrival_date'];?></div>
					<input min="<? echo date('Y-m-d');?>" onchange="document.getElementById('dateExitForm').setAttribute('min', document.getElementById('dateEnterForm').value); countBill();" type="date" name="date_enter" id="dateEnterForm" required>
				</div>
				<div class="date_time_block">
					<div class="input_label date_form"><?=$translate['departure_date'];?></div>
					<input onchange="document.getElementById('dateEnterForm').setAttribute('max', document.getElementById('dateExitForm').value); countBill()" type="date" name="date_exit" id="dateExitForm" required>
				</div>
				<input type="hidden" id="forDays" name="for_days" value="0">
				<input type="hidden" id="costParking" value="0">
			<input name="continue" type="submit" class="btn_days" value="<?=$translate['book'];?>">
			</div>
			<div class="cost_index2"><?=$translate['cost'];?>: <span class="index2_bill" id="billJS">0</span> zł</div>
        </div>
		</form>
    </div>
	<div class="container column">
        <div class="title">
            <h2><?=$translate['safe_parking'];?></h2>

        </div>
        <div class="airport">
            <div class="text">
                <div class="text1"><?=$translate['free_transfer'];?></div>
                <div class="text2"><?=$translate['care_about_your_trip'];?></div>
                <div class="text3"><?=$translate['parking_description'];?></div>
            
            </div>
            <div class="img">
                <img src="../img/lotnisko.png" alt="">
            </div>
        </div>

        <div class="text4">
            <?=$translate['choose_the_best'];?>
        </div>

        <iframe height="450" style="border:0; width: 100%;" loading="lazy" allowfullscreen  src="https://www.google.com/maps/embed/v1/place?key=AIzaSyD_YKgeutPWWFaJZ2c5EaSjLfY376i_J_0&q=R1+Parking+Okęcie">
</iframe>
    </div>
<? include '../blocks/footer.php'?>
<script src="../js/booking.js"></script>
<script src="../phone_confirm/phone_confirm.js"></script>
<script type="module" src="../js/get_token.js"></script>
</body>
</html>