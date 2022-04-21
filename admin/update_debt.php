<?
/*
* Find those orders that should have left parking for today but still on the parking.
*/
$query = "SELECT * from orders WHERE (order_status = 3 AND date_exit < :today)";
$result = $db->prepare($query);
$result->bindParam(":today",$today, PDO::PARAM_STR);
$result->execute();
$debt_orders = $result->fetchAll(PDO::FETCH_ASSOC);

/*
* Count penalty bill for forgotten cars.
*/
foreach($debt_orders as $key => $d_o){
    $today_days = intval(substr($d_o['date_exit'], 8,2)) + intval(substr($d_o['date_exit'], 5,2))*30 + intval(substr($d_o['date_exit'], 0,4))*365;
    $exit_days = date('d') + date('m')*30 + date('Y')*365;
    $debt_days = $exit_days-$today_days;
    $debt = $moderator['cost_parking_day_after14'] * $debt_days;
    if ($d_o['debt'] != $debt){
        $query = "UPDATE orders SET debt = :debt WHERE order_id = :order_id";
        $result = $db->prepare($query);
        $result->bindParam(":debt",$debt, PDO::PARAM_INT);
        $result->bindParam(":order_id", $d_o['order_id'], PDO::PARAM_STR);
        $result->execute();
    }
}

/*
* Updating data of delayed orders that were paid and already left.
*/
$query = "SELECT * from orders WHERE (order_status = 4)";
$result = $db->prepare($query);
$result->execute();
$debt_orders = $result->fetchAll(PDO::FETCH_ASSOC);
foreach($debt_orders as $key => $d_o){
    if ($d_o['debt'] != 0){
        $query = "UPDATE orders SET debt = 0 WHERE order_id = :order_id";
        $result = $db->prepare($query);
        $result->bindParam(":order_id", $d_o['order_id'], PDO::PARAM_STR);
        $result->execute();
    }
}
?>