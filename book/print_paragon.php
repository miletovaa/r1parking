<?
/*
*
* THIS FILE PRINTS BILL OF THE ORDER.
* Used in Admin Panel.
*
*/

require '../db.php';

$order_id = (isset($_GET['order_id'])) ? $_GET['order_id'] : $_COOKIE['order_id'];
$query = "SELECT * from orders WHERE order_id = :order_id";
$result = $db->prepare($query);
$result->bindParam(":order_id", $order_id, PDO::PARAM_STR);
$result->execute();
$order = $result->fetch(PDO::FETCH_ASSOC);

date_default_timezone_set('Europe/Warsaw');
$a = (stripos($order['passengers'], 'A') === false) ? 0 : substr($order['passengers'], strripos($order['passengers'], 'A')+2,1);
$c = (stripos($order['passengers'], 'C') === false) ? 0 : substr($order['passengers'], strripos($order['passengers'], 'C')+2,1);
$d = (stripos($order['passengers'], 'D') === false) ? 0 : substr($order['passengers'], strripos($order['passengers'], 'D')+2,1);
$reg = str_replace("<br>", ";", $order['registration']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Rachunek</title>

<style>
#page {
	display: none;
}
@page {
  size: 105mm 148mm;
}
@media print {
	body{
		font-family: Arial, Helvetica, sans-serif;
	}
	#page {
		display: block;
	}
	.cells_row {
		display: flex;
	}
	#img1{
		width: 20mm;
		top: 3mm;
		left: 3mm;
	}
	#img2{
		width: 20mm;
		top: 3mm;
		right: 3mm;
		position: absolute;
	}
	#cell1{
		display: flex;
		flex-direction: column;
		justify-content: center;
		width: 63mm;
		height: 30mm;
	}
	#cell2{
		display: flex;
		flex-direction: column;
		justify-content: center;
		width: 38mm;
		height: 30mm;
	}
	#cell6{
		margin-top: 10mm;
	}
	#hr1{
		width: 57mm;
		margin: 0;
	}
	#hr2, #hr3{
		width: 34mm;
		margin: 0;
	}
	.font8{
		font-size: 8pt;
	}
	.font10{
		font-size: 10pt;
	}
	.font12{
		font-size: 12pt;
	}
	.tacenter{
		text-align: center;
	}
}
</style>
</head>
<body>
<div id="page">
	<img id="img1" src="../img/logo-parking.png" alt="">
	<img id="img2" src="../img/b00king.jpg" alt="">
	<div id="container">
		<div class="cells_row">
			<div id="cell1" class="font10">
				<span class="font12"><b>Rezerwacja nr: <?=$order['order_id']?></b></span>
				<hr id="hr1">
				Przyjazd: <?=mb_strimwidth($order['time_enter'], 0, 5).' '.$order['date_enter'];?><br>
				Wyjazd: <?=mb_strimwidth($order['time_exit'], 0, 5).' '.$order['date_exit'];?>
			</div>
			<div id="cell2" class="font10 tacenter">
				<span class="font14"><b>Parking R1</b></span>
				<hr id="hr2">
				Równoległa 1, 02-235<br>
				Warszawa<br>
				Telefon:<br>
				<b>+48797650599</b>
				<hr id="hr3">
				<? echo 'Pax: '.$a.' + '.$c.' + '.$d;?>
			</div>
		</div>

			<div id="cell3" class="font10">
				<span>Pojazd</span> <?=$order['bill']?>,00 zł
			</div>

		<div class="cells_row" style="justify-content:space-between;">
			<div id="cell4" class="font10">
				<span class="font12"><?=$reg;?></span>
			</div>
			<div id="cell5">
				<!-- Saldo: 0,00 zł -->
			</div>
		</div>
		<div id="cell6" class="font8">
			Zachowaj dokument, jest podstawą wydania pojazdu!<br>
			Data druku: <?=date('H:i:s Y-m-d');?>
		</div>

	</div>
</div>
<script>
window.onload = function() {
	window.print();
	console.log('print');
};
window.onfocus = function () { window.close(); }

</script>
</body>
</html>