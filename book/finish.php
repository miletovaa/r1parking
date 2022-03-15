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
* Parse provided data before pasting it to the Database.
*/
$passengers = '';
if ($_POST['adults'] != 0) $passengers .= 'A-'.$_POST['adults'].';';
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

/* 
* Updating `ORDERS` table with new order info
*/
$query = "UPDATE orders SET 
order_status = 1,
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
bill = :bill
WHERE order_id = :order_id";
$result = $db->prepare($query);
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
$result->bindParam(":bill",$_POST['bill'], PDO::PARAM_INT);
$result->bindParam(":order_id",$_COOKIE['order_id'], PDO::PARAM_STR);
$result->execute();
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
    <div class="container">
        <div class="finish"><?=$translate['check_your_email'];?></div>
    </div>
</body>
</html>