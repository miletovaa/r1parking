<?
include 'session.php';
/* 
* Checking if admin logged in.
* If NO, go to LOG IN page.
* If YES, go to ORDERS page.
*/
if ($_SESSION['admin'] == 'logged_in') header('Location: orders_panel.php');
else header('Location: log_in.php');
?>