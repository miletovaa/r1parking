<?
session_start();
require '../db.php';

/*
* Getting data of user with entered phone number.
*/
$query = "SELECT * from clients WHERE tel = :tel ";
$result = $db->prepare($query);
$result->bindParam(":tel",$_POST['tel'], PDO::PARAM_STR);
$result->execute();
$client = $result->fetch(PDO::FETCH_ASSOC);

if ($client['id']){
    if ((stripos($client['firebase'], $_POST['token'])!==false) OR ($client['firebase'] == $_POST['token'])) echo $client['name'].';'.$client['mail'];
    else echo 'token not found';
}else echo 'no such user.';