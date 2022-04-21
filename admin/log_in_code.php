<?
include 'session.php';
require '../db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?
$tel = (isset($_POST['admin_tel'])) ? $_POST['admin_tel'] : '+'.trim($_GET['tel']);
/* 
* Checking if there any admin having such phone number in our `ADMINS` table
*
* If YES:
* send SMS to verify
*/
$query = "SELECT * from admins WHERE admin_tel = :admin_tel";
$result = $db->prepare($query);
$result->bindParam(":admin_tel", $tel, PDO::PARAM_STR);
$result->execute();
$admin = $result->fetchAll(PDO::FETCH_ASSOC)[0];
if (isset($admin)) {
    $_SESSION['admin_level'] = $admin['admin_level'];
    $_SESSION['admin_name'] = $admin['admin_name'];

    $gen_code = rand(1000,9999);
    $_SESSION['gen_code_admin'] = $gen_code;

    include_once 'API/sms';
    /*
    ! Here we already use API of sending SMS
    */
?>
    <input type="hidden" name="tel" id="userTel" value="<?=$tel;?>">
    <input name="user_code" id="userCode">
    <input type="submit" id="sendUserCode" value="send code" onclick="confirmTel()">
    <div id="loginerror"></div>
<?
    } else echo 'Nie znaleziono użytkownika, sprawdź wprowadzone dane.';
?>

<script src="../js/login.js"></script>
</body>
</html>