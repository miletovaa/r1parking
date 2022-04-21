<?
include 'session.php';
require '../db.php';

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
    <form action="log_in_code.php" method="post">
    <input type="text" name="admin_tel" id="adminTel" placeholder="Telefon">
    <input type="submit" id="logIn" value="LOG IN">
    </form>
    <script src="../js/login.js"></script>
</body>
</html>