<?
session_start();
require '../db.php';
require '../functions/translator.php';
require '../functions/moderator.php';

$bill = $_POST['cars'] * $_SESSION['bill'];

if ($_POST['keys'] == 'true') $bill = $bill + $moderator['cost_key'];

$query = "UPDATE orders SET bill = :bill WHERE order_id = :order_id";
$result = $db->prepare($query);
$result->bindParam(":bill",$bill ,PDO::PARAM_INT);
$result->bindParam(":order_id",$_COOKIE['order_id'], PDO::PARAM_STR);
$result->execute();

echo $bill;
?>