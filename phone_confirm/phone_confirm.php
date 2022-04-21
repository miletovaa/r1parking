<?
session_start();
require '../db.php';
require '../functions/telegram.php';

$user_code = $_POST['user_code'];
$gen_code = $_SESSION['gen_code'];
if($user_code == $gen_code){
    $_SESSION['tel_confirmed'] = true;
    if (isset($_POST['tel'])) $tel = $_POST['tel'];
    setcookie("client_tel", $tel, time() + 7200*60*60, "/");

    $query = "SELECT * from clients WHERE tel = :tel";
    $result = $db->prepare($query);
    $result->bindParam(":tel", $tel, PDO::PARAM_STR);
    $result->execute();
    $client = $result->fetch(PDO::FETCH_ASSOC);

    if (!$client['id']){
        $query = "INSERT INTO clients (`name`, `tel`,`mail`,`orders`, `firebase`) VALUES (:name, :tel, :mail, :orders, :firebase)";
        $result = $db->prepare($query);
        $result->bindParam(":name", $_SESSION['new_name'], PDO::PARAM_STR);
        $result->bindParam(":tel", $tel, PDO::PARAM_STR);
        $result->bindParam(":mail", $_SESSION['new_mail'], PDO::PARAM_STR);
        $result->bindParam(":orders", $_COOKIE['order_id'], PDO::PARAM_STR);
        $result->bindParam(":firebase", $_POST['token'], PDO::PARAM_STR);
        $result->execute();
    }else{
        $token = $client['firebase']. ' / '.$_POST['token'];
        $query = "UPDATE clients SET firebase = :token WHERE tel = :tel";
        $result = $db->prepare($query);
        $result->bindParam(":token", $token, PDO::PARAM_STR);
        $result->bindParam(":tel", $tel, PDO::PARAM_STR);
        $result->execute();
    }

    if (isset($_COOKIE['order_id'])){
        $query = "SELECT * from orders WHERE order_id = :order_id";
        $result = $db->prepare($query);
        $result->bindParam(":order_id", $_COOKIE['order_id'], PDO::PARAM_STR);
        $result->execute();
        $order = $result->fetch(PDO::FETCH_ASSOC);
        $next_step = $order['time_enter'];
        $last_update = date('y-m-d H:i:s');
        $tel = $order['tel_client'];
    
        $mes = "🟡 Niepotwierdzona\n".$order['name_client']."\n".$tel."\nRezerwacja - ".$order['order_id']."\n".$order['bill']." zł - Na ".$order['for_days']." dni";
        $message_id = TelegramBot::sendMessageTo($mes);
    
        $query = "UPDATE orders SET order_status = 1, message_id = :message_id, last_update = :last_update, next_step = :next_step WHERE order_id = :order_id";
        $result = $db->prepare($query);
        $result->bindParam(":message_id",$message_id, PDO::PARAM_INT);
        $result->bindParam(":last_update",$last_update, PDO::PARAM_STR);
        $result->bindParam(":next_step",$next_step, PDO::PARAM_STR);
        $result->bindParam(":order_id", $_COOKIE['order_id'], PDO::PARAM_STR);
        $result->execute();
    }
    echo 'true';
}else {
    $_SESSION['code_errors'] ++;
    echo $_SESSION['code_errors'];
}
?>