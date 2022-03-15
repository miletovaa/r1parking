<?
require '../db.php';
$db = Database::getConnection();
$id = $_POST['id'];

$query = "DELETE from admins WHERE id = :admin_id";
$result = $db->prepare($query);
$result->bindParam(":admin_id", $id, PDO::PARAM_STR);
if($result->execute()) return true;
?>