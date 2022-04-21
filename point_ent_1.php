<?
/*
* File is used when phone number was typed to the header
* or on the step2.php page
*/
if(isset($_POST['header_input']) OR isset($_POST['tel'])){
    // * Detect what is the current page
    if (strpos($_SERVER['REQUEST_URI'], 'step2') !== false) $from = 'step2';
    else {
        $tel = $_POST['header_input']; $from = 'lp';
    }

    // * Searching for admin or client with the phone number.
    $query = "SELECT * from admins WHERE admin_tel = :admin_tel";
    $result = $db->prepare($query);
    $result->bindParam(":admin_tel", $tel, PDO::PARAM_STR);
    $result->execute();
    $admin = $result->fetch(PDO::FETCH_ASSOC);

    $query = "SELECT * from clients WHERE tel = :tel";
    $result = $db->prepare($query);
    $result->bindParam(":tel", $tel, PDO::PARAM_STR);
    $result->execute();
    $client = $result->fetch(PDO::FETCH_ASSOC);

    // * IF it's admin's phone number
    // * then go to the Admin Panel
    if (isset($admin)) header('Location: ../admin/log_in_code.php?tel='.$tel);
    // * IF it's client's phone number
    // * then check if it is the same device as was used before
    else if (isset($client)){
        if ((stripos($client['firebase'], $_GET['token']) !== false) or ($client['firebase'] == $_GET['token'])) {
            // * IF the user uses the same device
            // * then log in and go to the next step
            setcookie("client_tel", $tel, time() + 7200*60*60, "/");
            $refresh = 'true';
            $autoinput = $_COOKIE['client_tel'];
            $tel_confirmed = true;
        }else{
            // * IF the user uses NEW device
            // * then send SMS to verify user
            if ($from == 'lp') $tel_confirmed = false;
            else {
                $autoinput = '';
                $tel_confirmed = false;
                $_SESSION['tel_confirmed'] = false;
            }
        } 
    // * IF it's a new user's phone
    // * then send SMS to verify
    }else { 
        if ($from == 'lp'){
            setcookie("new_tel", $tel, time() + 3*60*60, "/");
            $refresh = 'true';
            $tel_confirmed = true;
        }else {
            $_SESSION['new_name'] = $_POST['name'];
            $_SESSION['new_mail'] = $_POST['mail'];
            $tel_confirmed = false;
        }
    }
}
?>