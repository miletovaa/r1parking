<?
include 'session.php';

$user_code = $_POST['user_code'];
$gen_code = $_SESSION['gen_code_admin'];
if($user_code == $gen_code){
    $_SESSION['admin'] = 'logged_in';
    echo 'true';
}else {
    $_SESSION['admin_errors'] ++;
    echo $_SESSION['admin_errors'];
}
?>