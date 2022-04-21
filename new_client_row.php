<?
$query = "INSERT INTO clients (`name`, `tel`,`mail`,`orders`, `firebase`) VALUES (:name, :tel, :mail, :orders, :firebase)";
$result = $db->prepare($query);
$result->bindParam(":name", $_SESSION['new_name'], PDO::PARAM_STR);
$result->bindParam(":tel", $tel, PDO::PARAM_STR);
$result->bindParam(":mail", $_SESSION['new_mail'], PDO::PARAM_STR);
$result->bindParam(":orders", $_COOKIE['order_id'], PDO::PARAM_STR);
$result->bindParam(":firebase", $_POST['token'], PDO::PARAM_STR);
$result->execute();
setcookie("client_tel", $tel, time() + 7200*60*60, "/");
?>