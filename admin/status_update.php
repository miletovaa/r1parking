<?
require '../db.php';
$db = Database::getConnection();
$order_id = $_POST['order_id'];

$query = "SELECT * from orders WHERE order_id = :order_id";
$result = $db->prepare($query);
$result->bindParam(":order_id", $order_id, PDO::PARAM_STR);
$result->execute();
$order = $result->fetch(PDO::FETCH_ASSOC);
$order_status = $order['order_status'];
$order_status += 1;

$query = "UPDATE orders SET order_status = :order_status WHERE order_id = :order_id";
$result = $db->prepare($query);
$result->bindParam(":order_status",$order_status, PDO::PARAM_STR);
$result->bindParam(":order_id", $order_id, PDO::PARAM_STR);
if($result->execute()) return true;
?>