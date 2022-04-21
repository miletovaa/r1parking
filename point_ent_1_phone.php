<?
if(isset($_POST['header_input']) OR isset($_POST['tel']) OR isset($_GET['send_code'])){
    if(!$tel_confirmed){
        $_SESSION['tel_confirmed'] = false; $_SESSION['code_errors'] = 0;
        if (isset($_GET['send_code'])) $tel = '+'. trim($_GET['send_code']);
        include 'phone_confirm/form_code.php';
    }
}
?>