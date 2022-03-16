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
if ($order_status == 2){
    $next_step = $order['time_enter'];
}else if ($order_status == 3){
    $next_step = $order['time_exit'];
}else $next_step = '';

$last_update = date('y-m-d H:i:s');

$query = "UPDATE orders SET last_update = :last_update, order_status = :order_status, next_step = :next_step WHERE order_id = :order_id";
$result = $db->prepare($query);
$result->bindParam(":last_update",$last_update, PDO::PARAM_STR);
$result->bindParam(":order_status",$order_status, PDO::PARAM_STR);
$result->bindParam(":next_step",$next_step, PDO::PARAM_STR);
$result->bindParam(":order_id", $order_id, PDO::PARAM_STR);
if($result->execute()) return true;
?>