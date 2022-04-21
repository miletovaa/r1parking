<?
/*
*
* GENERATING BILL
* using `tfpdf` library
*
*/

/* 
* Fetch required data and process it.
*/
$query = "SELECT * from orders WHERE order_id = :order_id";
$result = $db->prepare($query);
$result->bindParam(":order_id", $_COOKIE['order_id'], PDO::PARAM_STR);
$result->execute();
$order = $result->fetch(PDO::FETCH_ASSOC);
date_default_timezone_set('Europe/Warsaw');
$a = (stripos($order['passengers'], 'A') === false) ? 0 : substr($order['passengers'], strripos($order['passengers'], 'A')+2,1);
$c = (stripos($order['passengers'], 'C') === false) ? 0 : substr($order['passengers'], strripos($order['passengers'], 'C')+2,1);
$d = (stripos($order['passengers'], 'D') === false) ? 0 : substr($order['passengers'], strripos($order['passengers'], 'D')+2,1);
$reg = str_replace("<br>", ";", $order['registration']);

require_once( "../tfpdf/tfpdf.php" );
$pdf = new tFPDF( 'P', 'mm', array(105, 148));
$pdf->AddPage();
$pdf->AddFont('DejaVu','','DejaVuSansCondensed.ttf',true);
$pdf->AddFont('DejaVu','B','DejaVuSansCondensed-Bold.ttf',true);
$pdf->SetMargins(3,5);
$pdf->SetLineWidth(0.4);
$pdf->Image('../img/logo-parking.png',3,3,20);
$pdf->Cell(70,5);
$pdf->Image('../img/b00king.jpg',80,3,20);
$pdf->Ln();
$pdf->Cell(63,5,'',0,0);
	$pdf->SetFont('DejaVu','B',10);
	$pdf->Cell(38,8,'Parking R1',0,1,'C');
	$pdf->Line(69,22,103,22);
$pdf->SetFont('DejaVu','B',12);
$pdf->Cell(63,4,'Rezerwacja nr: '.$order['order_id'],0,0);
$pdf->Line(3,28,60,28);
	$pdf->SetFont('DejaVu','',10);
	$pdf->Cell(38,5,'Równoległa 1, 02-235',0,1,'C');
$pdf->Cell(63,6,'Przyjazd: '.mb_strimwidth($order['time_enter'], 0, 5).' '.$order['date_enter'],0,0);
	$pdf->Cell(38,5,'Warszawa',0,1,'C');
$pdf->Cell(62,5,'Wyjazd: '.mb_strimwidth($order['time_exit'], 0, 5).' '.$order['date_exit'],0,0);
	$pdf->Cell(38,5,'Telefon:',0,1,'C');
$pdf->Cell(63,5,'',0,0);
	$pdf->SetFont('DejaVu','B',10);
	$pdf->Cell(38,5,'+48797650599',0,1,'C');
$pdf->Cell(63,5,'',0,0);
	$pdf->Line(69,43,103,43);
	$pdf->SetFont('DejaVu','',10);
	$pdf->Cell(38,5,'Pax: '.$a.' + '.$c.' + '.$d,0,1,'C');

$pdf->Cell(20,5,'Pojazd',0,0);$pdf->Cell(20,5,$order['bill'].',00 zł',0,1);

$pdf->SetFont('DejaVu','',12);$pdf->Cell(40,5,$reg,0,0);$pdf->SetFont('DejaVu','',10); $pdf->Cell(40,5,'Saldo:',0,0);
$pdf->SetFont('DejaVu','B',10);/* $pdf->Cell(20,5,'0,00 zł',0,1); */

$pdf->SetFont('DejaVu','',8);
$pdf->Cell(100,10,'',0,1);
$pdf->Cell(100,4,'Zachowaj dokument, jest podstawą wydania pojazdu!',0,1);
$pdf->Cell(100,4,'Data druku: '.date('H:i:s Y-m-d'),0,0);
$pdf->Output('F', 'paragony/'.$_COOKIE['order_id'].'.pdf');
?>