<?
session_start();
/* 
* Checking if admin logged in.
* If NO, go to LOG IN page.
*/
if ($_SESSION['admin'] != 'logged_in') header('Location: log_in.php');

/* 
* Connection with Database
*/
require '../db.php';
$db = Database::getConnection();

/* 
* Fetch all orders from the Database.
*
* Order rows by selected column.
*/
$query = "SELECT * from orders WHERE order_status > 0 ";
if (isset($_GET['status'])){
    $query .= "AND order_status = ".$_GET['status'];
}
if (isset($_GET['order_by'])) {
    $res = $db->prepare("SELECT * from orders");
    $res->execute();
    $column = $res->fetchAll(PDO::FETCH_ASSOC)[0];
    if (isset($column[$_GET['order_by']])) $query .= " ORDER BY ".$_GET['order_by'];
    if (isset($_GET['desc'])) {
        $query .= " DESC";
    }
}
$result = $db->prepare($query);
$result->execute();
$orders = $result->fetchAll(PDO::FETCH_ASSOC);

$last_update_q = $db->prepare("SELECT * from orders ORDER BY last_update DESC");
$last_update_q->execute();
$last_update = $last_update_q->fetchAll(PDO::FETCH_ASSOC)[0]['last_update'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../css/admin.css">
    <title>Rezerwacje | R1 Parking</title>
</head>
<body>
<div id="lastUpdate" style="display:none;"><?=$last_update;?></div>
    <h1><a href="orders_panel.php"> Wszystkie rezerwacje </a></h1>
    <a href="today.php">DZIŚ &#9654;</a> 
<!-- 
if admin's level allows edit settings,
print link to the Settings panel on page
 -->
<? if ($_SESSION['admin_level'] == 1){?>
    <a href="edit_mod_sett.php">ZMIEŃ USTAWIENIA &#9654;</a>
<? } ?>
    <div id="orders_container">
        <div class="order_row head">
            <div class="order_col" style="flex-direction: column;"><div class=""><img src="../img/icons/search.png" width="15" onclick="searchIndexInput()" id="searchIndex" alt=""> NR REZERWACJI <a href="?order_by=order_id">&#9650;</a><a href="?order_by=order_id&desc=">&#9660;</a><br></div><input type="text" id="searchOrderIndex" style="display: none;" class="search"></div>
            <div class="order_col" style="flex-direction: column;"><div class=""><img src="../img/icons/search.png" width="15" onclick="searchStatus()" id="searchStatus" alt=""> STATUS <a href="?order_by=order_status">&#9650;</a><a href="?order_by=order_status&desc=">&#9660;</a><br></div><select id="searchStatusInput" style="display: none;" class="search"><option value="zrealizowana">ZREALIZOWANA</option><option value="potwierdzona">POTWIERDZONA</option><option value="PRZETWARZANA">PRZETWARZANA</option><option value="Nie potwierdzona">Nie potwierdzona</option></select></div>
            <div class="order_col">DO ZAPŁATY <a href="?order_by=bill">&#9650;</a><a href="?order_by=bill&desc=">&#9660;</a></div>
            <div class="order_col" style="flex-direction: column;"><div class=""><img src="../img/icons/search.png" width="15" onclick="searchDateInput()" id="searchDateInput" alt=""> PRZYJAZD / WYJAZD <a href="?order_by=date_enter">&#9650;</a><a href="?order_by=date_enter&desc=">&#9660;</a></div><input type="date" id="searchDate" style="display: none;" class="search"></div>
            <div class="order_col" style="flex-direction: column;"><div class=""><img src="../img/icons/search.png" width="15" onclick="searchRegInput()" id="searchReg" alt=""> REJESTRACJA <br></div><input type="text" id="searchRegInput" style="display: none;" class="search"></div>
            <div class="order_col" style="flex-direction: column;"><div class=""><img src="../img/icons/search.png" width="15" onclick="searchClient()" id="searchCli" alt=""> KLIENT <br></div><input type="text" id="searchClientInput" style="display: none;" class="search"></div>
            <!-- <div class="order_col">KLIENT</div> -->
        </div>
    <? foreach($orders as $key => $order){?>
        <?
            switch ($order['order_status']){
                case 1:
                    $class = 'status1';
                    $order_status = 'Rezerwacja nie potwierdzona.<button class="status_btn" id="s'.$order['order_id'].'" onclick="updateStatusBtn()">Potwierdzona</button>';
                break;
                case 2:
                    $class = 'status2';
                    $order_status = '<b>POTWIERDZONA</b> <button class="status_btn" id="s'.$order['order_id'].'" onclick="updateStatusBtn()">Samochód na parkingu</button>';
                break;
                case 3:
                    $class = 'status3';
                    $order_status = '<b>PRZETWARZANA</b> <button class="status_btn" id="s'.$order['order_id'].'" onclick="updateStatusBtn()">Samochód odjechał</button>';
                break;
                case 4:
                    $class = 'status4';
                    $order_status = '<b>ZREALIZOWANA!</b>';
                break;
            }
            switch ($order['payment']){
                case 'cash':
                    $img_payment = 'cash.png';
                    $title_payment = 'Gotówka';
                break;
                case 'online':
                    $img_payment = 'online.png';
                    $title_payment = 'Online';
                break;
                case 'invoice':
                    $img_payment = 'invoice.png';
                    $title_payment = 'Faktura';
                break;
            }
            /* $result = $db->prepare("SELECT * from clients WHERE id = :client_id");
            $result->bindParam(":client_id", $order['client_id'], PDO::PARAM_INT);
            $result->execute();
            $client = $result->fetchAll(PDO::FETCH_ASSOC)[0]; */
        ?>
        <div class="order_row <?=$class;?>">
            <div class="order_col"><?=$order['id'];?><br><span class="small"><?=$order['order_id'];?></span></div>
            <div class="order_col"><?=$order_status;?></div>
            <div class="order_col payment"><?=$order['bill'];?> zł <img class="icon" src="../img/icons/<?=$img_payment;?>" alt="" title="<?=$title_payment;?>"></div>
            <div class="order_col">&#129042;<?=$order['date_enter'];?><br><?=$order['date_exit'];?>&#129042;</div>
            <div class="order_col"><?=$order['registration'];?></div>
            <div class="order_col"><?=$order['name_client'];?> <br> <b><?=$order['tel_client'];?></b><a class="call" href="tel:<?=$order['tel_client'];?>">ZADZWOŃ</a></div>
        </div>
    <?}?>
    </div>

<script src="../js/admin.js"></script>
<script src="../js/update_orders_list.js"></script>
</body>
</html>