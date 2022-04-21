<?
/*
*
* GENERATING RESERVATION FILE
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
$pdf = new tFPDF( 'P', 'mm', 'A4');

$pdf->AddPage();
$pdf->AddFont('DejaVu','','DejaVuSansCondensed.ttf',true);
$pdf->AddFont('DejaVu','B','DejaVuSansCondensed-Bold.ttf',true);
$pdf->SetLineWidth(0.4);
$pdf->Image('../img/logo.jpg',3,30,70);
$pdf->Cell(180,50);
$pdf->Image('../img/b00king.jpg',80,3,20);
$pdf->Ln();

$pdf->SetFont('DejaVu','',14);
$pdf->SetTextColor(81, 189, 254);
$pdf->Cell(80,14,'REZERWACJA NR',0,0);
$pdf->Cell(80,14,'KLIENT',0,1);

$pdf->SetFont('DejaVu','',24);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(80,8,$order['order_id'],0,0);
$pdf->Cell(80,8,$order['name_client'],0,1);

$pdf->Cell(1,10,'',0,1);

$pdf->SetFont('DejaVu','',14);
$pdf->SetTextColor(81, 189, 254);
$pdf->Cell(80,10,'PRZYJAZD',0,0);
$pdf->Cell(80,10,'TELEFON',0,1);

$pdf->SetFont('DejaVu','',18);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(80,6,mb_strimwidth($order['time_enter'], 0, 5).' '.$order['date_enter'],0,0);
$pdf->Cell(80,6,$order['tel_client'],0,1);

$pdf->SetFont('DejaVu','',14);
$pdf->SetTextColor(81, 189, 254);
$pdf->Cell(80,10,'WYJAZD',0,0);
$pdf->Cell(80,10,'EMAIL',0,1);

$pdf->SetFont('DejaVu','',18);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(80,6,mb_strimwidth($order['time_exit'], 0, 5).' '.$order['date_exit'],0,0);
$pdf->Cell(80,6,$order['mail_client'],0,1);

$pdf->Cell(1,5,'',0,1);

$pdf->SetFont('DejaVu','',10);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(18,7,'POJAZDY:',0,0);
$pdf->SetTextColor(81, 189, 254);
$pdf->Cell(80,7,$order['cars'],0,1);

$pdf->SetTextColor(0,0,0);
$pdf->Cell(22,7,'DOROSŁYCH:',0,0);
$pdf->SetTextColor(81, 189, 254);
$pdf->Cell(80,7,$a,0,1);

$pdf->SetTextColor(0,0,0);
$pdf->Cell(15,7,'DZIECI:',0,0);
$pdf->SetTextColor(81, 189, 254);
$pdf->Cell(80,7,$c,0,1);

$pdf->Cell(1,10,'',0,1);
$pdf->SetDrawColor(81,189,254);
$pdf->Line(10,153,200,153);

$pdf->SetTextColor(81, 189, 254);
$pdf->SetFont('DejaVu','B',20);
$pdf->Cell(38,8,'Parking R1',0,1);

$pdf->Cell(1,5,'',0,1);
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('DejaVu','',14);
$pdf->Cell(30,5,'Adres:',0,0);
$pdf->SetFont('DejaVu','B',14);
$pdf->Cell(38,5,'Równoległa 1, 02-235',0,1);

$pdf->Cell(1,5,'',0,1);
$pdf->SetFont('DejaVu','',14);
$pdf->Cell(30,5,'Telefon:',0,0);
$pdf->SetFont('DejaVu','B',14);
$pdf->Cell(38,5,'+48 797 650 599',0,1);

$pdf->Cell(1,5,'',0,1);
$pdf->SetFont('DejaVu','',14);
$pdf->Cell(30,5,'Email:',0,0);
$pdf->SetFont('DejaVu','B',14);
$pdf->Cell(38,5,'parkingrownolegla@gmail.com',0,1);

$pdf->Cell(1,5,'',0,1);
$pdf->SetFont('DejaVu','',14);
$pdf->Cell(30,5,'GPS:',0,0);
$pdf->SetFont('DejaVu','B',14);
$pdf->Cell(38,5,'52.200553, 20.944280',0,1);

$pdf->Cell(1,7,'',0,1);
$pdf->SetFont('DejaVu','B',14);
$pdf->Cell(30,7,'Edycja rezerwacji:',0,1);
$pdf->SetFont('DejaVu','',14);
$pdf->Cell(38,6,'W celu dokonania zmian w rezerwacji',0,1);
$pdf->Cell(38,6,'wyślij e-mail na adres',0,1);
$pdf->SetTextColor(81, 189, 254);
$pdf->Cell(38,6,'parkingrownolegla@gmail.com',0,1);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(38,6,'Prosimy o zawarcie numeru rezerwacji',0,1);
$pdf->Cell(38,6,'w tytule wiadomości',0,1);

$pdf->Output('F', 'confirms/'.$_COOKIE['order_id'].'.pdf');
?>