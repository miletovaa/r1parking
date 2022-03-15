<?
session_start();

/* 
* Connection with Database
*/
require '../db.php';
$db = Database::getConnection();

/* 
* Checking if admin with entered data exists in Database.
*
* If YES, log in and go to the ORDERS PAGE.
*
* If NO, print that there is no such user.
*/
if (isset($_POST['admin_pass'])){
    $query = "SELECT * from admins WHERE admin_name = :admin_name AND admin_pass = :admin_pass";
    $result = $db->prepare($query);
    $result->bindParam(":admin_name", $_POST['admin_name'], PDO::PARAM_STR);
    $result->bindParam(":admin_pass", $_POST['admin_pass'], PDO::PARAM_STR);
    $result->execute();
    $admin = $result->fetchAll(PDO::FETCH_ASSOC)[0];
    if (isset($admin)) {
        $_SESSION['admin'] = 'logged_in';
        $_SESSION['admin_level'] = $admin['admin_level'];
    }
    else echo 'Nie znaleziono użytkownika, sprawdź wprowadzone dane.';
}

if ($_SESSION['admin'] == 'logged_in') header('Location: orders_panel.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOG IN TO R1 ADMIN PANEL</title>
</head>
<body>
    <form action="" method="post">
        <input type="text" name="admin_name" id="adminName" placeholder="Imię">
        <input type="password" name="admin_pass" id="adminPass" placeholder="Husło">
        <input type="submit" value="LOG IN">
    </form>
</body>
</html>