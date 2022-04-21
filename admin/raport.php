<?

/* 
*
* THIS PAGE GENERATES RAPORT FOR PRINTING.
*
*/

include 'session.php';
require '../db.php';
require '../functions/moderator.php';

/* 
* Checking if admin logged in.
* If NO, go to LOG IN page.
*/
if ($_SESSION['admin'] != 'logged_in') header('Location: log_in.php');

$zmiana_start = $moderator['zmiana_start'];

/* 
* Fetch required rows.
*/
if (isset($_GET['date_from'])){
    $date_from = $_GET['date_from'];
    $date_to =  $_GET['date_to'];

    $query = "SELECT * from orders WHERE 
    (order_status = 3 AND date_enter >= :date_from AND date_enter <= :date_to) OR 
    (order_status = 4 AND date_enter >= :date_from AND date_enter <= :date_to) OR 
    (order_status = 3 AND date_exit >= :date_from AND date_exit <= :date_to) OR
    (order_status = 4 AND date_exit >= :date_from AND date_exit <= :date_to)";
    $result = $db->prepare($query);
    $result->bindParam(":date_from",$date_from, PDO::PARAM_STR);
    $result->bindParam(":date_to",$date_to, PDO::PARAM_STR);
    $result->bindParam(":zmiana_start",$zmiana_start, PDO::PARAM_STR);
    $result->execute();
    $orders = $result->fetchAll(PDO::FETCH_ASSOC);

    $title = 'Wszystko od '.$date_from.' do '.$date_to;
}else{
    date_default_timezone_set('Europe/Warsaw');
    $today = date('Y-m-d');
    if ($zmiana_start > $curr_time) $day = date('Y-m-').(intval(date('d'))-1); // 2022-02-24
    if (isset($_GET['wczoraj'])) $day = substr($day, 0, 8).(intval(substr($day, 8, 2))-1);
    else if (isset($_GET['jutro'])) $day = substr($day, 0, 8).(intval(substr($day, 8, 2))+1);
    $tomorrow = substr($day, 0, 8).(intval(substr($day, 8, 2))+1);
    
    $query = "SELECT * from orders WHERE 
    (order_status = 3 AND date_enter = :today AND time_enter >= :zmiana_start) OR 
    (order_status = 3 AND date_enter = :tomorrow AND time_enter < :zmiana_start) OR 
    (order_status = 4 AND date_exit = :today AND time_exit >= :zmiana_start) OR 
    (order_status = 4 AND date_exit = :tomorrow AND time_exit < :zmiana_start)";
    $result = $db->prepare($query);
    $result->bindParam(":today",$day, PDO::PARAM_STR);
    $result->bindParam(":tomorrow",$tomorrow, PDO::PARAM_STR);
    $result->bindParam(":zmiana_start",$zmiana_start, PDO::PARAM_STR);
    $result->execute();
    $orders = $result->fetchAll(PDO::FETCH_ASSOC);
    $title = 'Zmiena od '.$day.' '.$zmiana_start.' do '.$tomorrow.' '.$zmiana_start;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../css/admin.css">
	<title>Rezerwacje | R1 Parking</title>
    <style>
        @media print{    
            .btn_link{
                display: none !important;
            }
        }
        .btn_link{
            border: none;
            right: 0;
            position: absolute;
        }
    </style>
</head>
<body>
<button class="btn_link btn_link_active" onclick="window.print();">PRINT</button>
<div style="text-align: center;"><?=$title;?></div>
    <div id="orders_container">
		<div class="order_row head">
            <div class="order_col">ID REZERWACJI</div>
            <div class="order_col">PRACOWNIK</div>
            <div class="order_col">AKCJA</div>
            <div class="order_col">DATA</div>
            <div class="order_col">CZAS</div>
            <div class="order_col">CENA</div>
            <div class="order_col">METODA PŁATNOŚCI</div>
        </div>
	<? foreach($orders as $key => $order){?>
		<?
			switch ($order['order_status']){
				case 3:
					$order_status = 'ZAPARKOWAŁ SAMOCHÓD';
                    $admin_col = 'admin_enter';
                    $date_col = 'date_enter';
                    $time_col = 'time_enter';
				break;
				case 4:
					$order_status = 'ODDAŁ SAMOCHÓD';
                    $admin_col = 'admin_exit';
                    $date_col = 'date_exit';
                    $time_col = 'time_exit';
				break;
			}
			if ($debt) $class = 'status5'; 
			switch ($order['payment']){
				case 'cash':
					$title_payment = 'Gotówka';
				break;
				case 'online':
					$title_payment = 'Online';
				break;
				case 'invoice':
					$title_payment = 'Faktura';
				break;
			}
		?>
		<div class="order_row">
            <div class="order_col"><?=$order['order_id'];?></div>
            <div class="order_col"><?=$order[$admin_col];?></div>
            <div class="order_col"><?=$order_status;?></div>
            <div class="order_col"><?=$order[$date_col];?></div>
            <div class="order_col">o <?=$order[$time_col];?></div>
            <div class="order_col"><?=$order['bill'];?> zł</div>
            <div class="order_col"><?=$title_payment;?></div>
		</div>
	<?}?>
	</div>
</body>
</html>