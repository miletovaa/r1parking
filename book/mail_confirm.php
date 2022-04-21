<?
/*
*
* THIS FILE UPDATES STATUS OF E-MAIL FROM `unconfirmed` TO `confirmed`
* AND SENDS GENERATED FILES TO THE E-MAIL
*
*/

session_start();
require '../db.php';

$result = $db->prepare($query);
$result->bindParam(":mail_code",$_GET['code'], PDO::PARAM_STR);
$result->execute();

$query2 = "SELECT * from orders WHERE mail_code = :mail_code";
$result2 = $db->prepare($query);
$result2->bindParam(":mail_code",$_GET['code'], PDO::PARAM_STR);
$result2->execute();
$order = $result2->fetch(PDO::FETCH_ASSOC);
setcookie("order_id", $order['order_id'], time() + 3*60*60, "/");

include 'send_paragon.php';
?>