<?
session_start();
require 'db.php';
require 'functions/moderator.php';
require 'functions/translator.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="css/styles.css">
    <title><?=$translate['price'];?> | R1 PARKING</title>
</head>
<body>
<header><? include 'blocks/header.php'?></header>
    <div class="container_cennik">
        <h1 class="cennik"><?=$translate['price'];?></h1>
        <div class="cennik_line"><div class="cennik_days">1 <?=$translate['dzien'];?></div><div id="costParkingDay1"><?=$moderator['cost_parking_day1'];?> PLN</div></div><hr>
        <div class="cennik_line"><div class="cennik_days">2 <?=$translate['dni'];?></div><div id="costParkingDay2" ><?=$moderator['cost_parking_day2'];?> PLN</div></div><hr>
        <div class="cennik_line"><div class="cennik_days">3 <?=$translate['dni'];?></div><div id="costParkingDay3" ><?=$moderator['cost_parking_day3'];?> PLN</div></div><hr>
        <div class="cennik_line"><div class="cennik_days">4 <?=$translate['dni'];?></div><div id="costParkingDay4" ><?=$moderator['cost_parking_day4'];?> PLN</div></div><hr>
        <div class="cennik_line"><div class="cennik_days">5 <?=$translate['dniey'];?></div><div id="costParkingDay5" ><?=$moderator['cost_parking_day5'];?> PLN</div></div><hr>
        <div class="cennik_line"><div class="cennik_days">6 <?=$translate['dniey'];?></div><div id="costParkingDay6" ><?=$moderator['cost_parking_day6'];?> PLN</div></div><hr>
        <div class="cennik_line"><div class="cennik_days">1 <?=$translate['tydzien'];?></div><div id="costParkingDay7" ><?=$moderator['cost_parking_day7'];?> PLN</div></div><hr>
        <div class="cennik_line"><div class="cennik_days">8 <?=$translate['dniey'];?></div><div id="costParkingDay8" ><?=$moderator['cost_parking_day8'];?> PLN</div></div><hr>
        <div class="cennik_line"><div class="cennik_days">9 <?=$translate['dniey'];?></div><div id="costParkingDay9" ><?=$moderator['cost_parking_day9'];?> PLN</div></div><hr>
        <div class="cennik_line"><div class="cennik_days">10 <?=$translate['dniey'];?></div><div id="costParkingDay10" ><?=$moderator['cost_parking_day10'];?> PLN</div></div><hr>
        <div class="cennik_line"><div class="cennik_days">11 <?=$translate['dniey'];?></div><div id="costParkingDay11" ><?=$moderator['cost_parking_day11'];?> PLN</div></div><hr>
        <div class="cennik_line"><div class="cennik_days">12 <?=$translate['dniey'];?></div><div id="costParkingDay12" ><?=$moderator['cost_parking_day12'];?> PLN</div></div><hr>
        <div class="cennik_line"><div class="cennik_days">13 <?=$translate['dniey'];?></div><div id="costParkingDay13" ><?=$moderator['cost_parking_day13'];?> PLN</div></div><hr>
        <div class="cennik_line"><div class="cennik_days">2 <?=$translate['tygodnie'];?></div><div id="costParkingDay14" ><?=$moderator['cost_parking_day14'];?> PLN</div></div><hr><br>
        <div class="cennik_line"><div class="cennik_days"><?=$translate['each_next_day'];?></div><div id="costParkingDayAfter14" >+ <?=$moderator['cost_parking_day_after14'];?> PLN</div></div>
    </div>
    <div class="empty"></div>
<? include 'blocks/footer.php'?>
<script src="js/booking.js"></script>
</body>
</html>