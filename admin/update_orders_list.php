<?
require '../db.php';
$db = Database::getConnection();

$last_update_q = $db->prepare("SELECT * from orders ORDER BY last_update DESC");
$last_update_q->execute();
$last_update = $last_update_q->fetchAll(PDO::FETCH_ASSOC)[0]['last_update'];

if ($last_update != $_POST['last_update']) echo 'There are some updates!';

return true;
?>