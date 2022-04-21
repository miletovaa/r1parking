<?
include 'session.php';
require '../db.php';
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
    $enter = true;
}else{
    $next_step = '';
    $exit = true;
}
$admin = $_SESSION['admin_name'];

$last_update = date('y-m-d H:i:s');

$query = "UPDATE orders SET last_update = :last_update, order_status = :order_status, ";
if ($enter) $query .= "admin_enter = :admin_enter, ";
else if ($exit) $query .= "admin_exit = :admin_exit, ";
$query .= "next_step = :next_step WHERE order_id = :order_id";
$result = $db->prepare($query);
$result->bindParam(":last_update",$last_update, PDO::PARAM_STR);
$result->bindParam(":order_status",$order_status, PDO::PARAM_STR);
if ($enter) $result->bindParam(":admin_enter",$admin, PDO::PARAM_STR);
else if ($exit) $result->bindParam(":admin_exit",$admin, PDO::PARAM_STR);
$result->bindParam(":next_step",$next_step, PDO::PARAM_STR);
$result->bindParam(":order_id", $order_id, PDO::PARAM_STR);
if($result->execute()) return true;
?>