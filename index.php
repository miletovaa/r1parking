<?
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
<header><? include 'blocks/header.php'?></header>
    <div id="main_photo">
        <img src="../img/main1.jpg" alt="">
    </div>
    <div class="container on_photo">
        <div class="block_on_photo">
            <div class="title"><?=$translate['check_cost_and_book'];?></div>
            <div class=""><a href="book/index.php?lang=<?=$lang;?>"><div class="link rezerwacja btn_on_photo"><?=$translate['booking'];?></div></a></div>
        </div>
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
                <img src="img/lotnisko.png" alt="">
            </div>
        </div>

        <div class="text4">
            <?=$translate['choose_the_best'];?>
        </div>
    </div>
    
    <div class="empty"></div>
<script src="js/booking.js"></script>
</body>
</html>