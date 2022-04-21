<?
function CreateRandomCodeFullCharacter($quantity_сharacters){
    $full_arr = array('A','B','D','F','H','K','P','Q','S','T','U','X','Y','Z',0,1,2,3,4,5,6,7,8,9);
    $code = null;
    for ($i = 1; $i <= $quantity_сharacters; $i++)
    {
        $count_full_arr = count($full_arr);
        $сhar_pos_in_array = rand(0, $count_full_arr-1);
        $code .= $full_arr[$сhar_pos_in_array];
    }
    return $code;
}

    $last_update = date('y-m-d H:i:s');
    $order_id = CreateRandomCodeFullCharacter(6);
    $query = "INSERT INTO `orders` 
    (`last_update`,
    `order_id`,
    `book_start`,
    `date_enter`,
    `date_exit`) VALUES 
    (:last_update,
    :order_id,
    :book_start,
    :date_enter,
    :date_exit)";
    $result = $db->prepare($query);
    $result->bindParam(":last_update",$last_update, PDO::PARAM_STR);
    $result->bindParam(":order_id", $order_id, PDO::PARAM_STR);
    $result->bindParam(":book_start", $last_update, PDO::PARAM_STR);
    $result->bindParam(":date_enter", $_POST['date_enter'], PDO::PARAM_STR);
    $result->bindParam(":date_exit", $_POST['date_exit'], PDO::PARAM_STR);
    $result->execute();
    // установка куки ордер_айди
    setcookie("order_id", $order_id, time() + 3*60*60, "/");
?>