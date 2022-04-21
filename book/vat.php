<?
/*
*
* GENERATING VAT Invoice
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
$reg = str_replace("<br>", ";", $order['registration']);
switch($order['cars']){
    case 1:
        $places = 'miejsca parkingowego';
        break;
    default:
        $places = 'miejsc parkingowych';
        break;
}
switch($order['for_days']){
    case 1:
        $days = 'dzień';
        break;
    default:
        $days = 'dni';
        break;
}
$cena_netto = round($order['bill']/1.23, 2);
$wartosc_vat = $order['bill'] - $cena_netto;
$bill = $order['bill'].'.00';

require_once( "../tfpdf/tfpdf.php" );
$pdf = new tFPDF( 'P', 'mm', 'A4');
$pdf->AddPage();
$pdf->AddFont('DejaVu','','DejaVuSansCondensed.ttf',true);
$pdf->AddFont('DejaVu','B','DejaVuSansCondensed-Bold.ttf',true);

$pdf->SetFont('DejaVu','B',10);
$pdf->Cell(30,5,'Faktura numer:',0,0);
$pdf->SetFont('DejaVu','',10);
$pdf->Cell(38,5,date('d/m/Y'),0,1);
$pdf->SetDrawColor(100,100,100);

$pdf->Cell(1,5,'',0,1);

$pdf->SetFont('DejaVu','B',10);
$pdf->Cell(35,5,'Data wystawienia:',0,0);
$pdf->SetFont('DejaVu','',10);
$pdf->Cell(38,5,'Warszawa, '.$order['date_enter'],0,1);

$pdf->SetFont('DejaVu','B',10);
$pdf->Cell(31,5,'Data sprzedaży:',0,0);
$pdf->SetFont('DejaVu','',10);
$pdf->Cell(38,5,$order['date_enter'],0,1);

$pdf->SetFont('DejaVu','B',10);
$pdf->Cell(33,5,'Termin płatności:',0,0);
$pdf->SetFont('DejaVu','',10);
$pdf->Cell(38,5,$order['date_enter'],0,1);

$pdf->SetFont('DejaVu','B',10);
$pdf->Cell(18,5,'Płatność:',0,0);
$pdf->SetFont('DejaVu','',10);
$pdf->Cell(38,5,'Gotówka',0,1);

$pdf->Line(10,43,200,43);

$pdf->Cell(1,7,'',0,1);

$pdf->SetFont('DejaVu','B',10);
$pdf->Cell(90,7,'Sprzedawca',0,0);
$pdf->Cell(100,7,'Nabywca',0,1);

$pdf->SetFont('DejaVu','',10);
$pdf->Cell(90,7,'Flota Investment Sp. z o.o.',0,0);
$pdf->Cell(100,7,$order['vat_name'],0,1);

$pdf->Cell(90,5,'Równoległa 1',0,0);
$pdf->Cell(100,5,$order['vat_address'],0,1);

$pdf->Cell(90,5,'02-235 Warszawa',0,0);
$pdf->Cell(100,5,$order['vat_postcode'].' '.$order['vat_city'],0,1);

$pdf->Cell(90,7,'NIP 5272894617',0,0);
$pdf->Cell(100,7,'NIP '.$order['vat_nip'],0,1);

$pdf->Cell(90,5,'PKO BP',0,1);
$pdf->Cell(100,5,'70102055580000840234326116',0,1);

$pdf->Cell(1,5,'',0,1);

$pdf->SetFont('DejaVu','B',8);
$pdf->SetFillColor(240,240,240);
$pdf->SetDrawColor(200,200,200);
$pdf->Cell(8,14,'LP',1,0, 'C', true);
$pdf->Cell(60,14,'Nazwa towaru / uslugi',1,0, 'C', true);
$pdf->Cell(13,14,'Ilość',1,0, 'C', true);
$pdf->Cell(20,14,'Cena netto',1,0, 'C', true);
$pdf->Cell(25,14,'Wartość netto',1,0, 'C', true);
$pdf->Cell(15,14,'VAT %',1,0, 'C', true);
$pdf->Cell(25,14,'Wartość VAT',1,0, 'C', true);
$pdf->Cell(25,14,'Wartość brutto',1,1, 'C', true);

$pdf->SetFont('DejaVu','',8);
$pdf->Cell(8,14,'1',1,0, 'C');
$pdf->Cell(60,14,'',1);
$pdf->Text(19,112,"Wynajem ".$order['cars']." ".$places);
$pdf->Text(19,117,"od ".$order['date_enter']." do ".$order['date_exit'].$reg);
$pdf->Cell(13,14,$order['for_days'].' '.$days,1,0, 'C');
$pdf->Cell(20,14,$cena_netto,1,0, 'R');
$pdf->Cell(25,14,$cena_netto,1,0, 'R');
$pdf->Cell(15,14,'23',1,0, 'R');
$pdf->Cell(25,14,$wartosc_vat,1,0, 'R');
$pdf->Cell(25,14,$bill,1,1, 'R');

$pdf->Cell(81,8,'',0,0);
$pdf->Cell(20,8,'W tym',1,0, 'R');
$pdf->Cell(25,8,$cena_netto,1,0, 'R');
$pdf->Cell(15,8,'23',1,0, 'R');
$pdf->Cell(25,8,$wartosc_vat,1,0, 'R');
$pdf->Cell(25,8,$bill,1,1, 'R');

$pdf->SetFont('DejaVu','B',8);
$pdf->Cell(81,8,'',0,0);
$pdf->Cell(20,8,'Razem',1,0, 'R');
$pdf->Cell(25,8,$cena_netto,1,0, 'R');
$pdf->Cell(15,8,'',1,0, 'R');
$pdf->Cell(25,8,$wartosc_vat,1,0, 'R');
$pdf->Cell(25,8,$bill,1,1, 'R');

$pdf->Cell(1,7,'',0,1);

$pdf->Cell(130,7,'',0,0);
$pdf->SetFont('DejaVu','B',10);
$pdf->Cell(40,7,'Wartość netto',0,0,'C');
$pdf->SetFont('DejaVu','',10);
$pdf->Cell(20,7,$cena_netto.' PLN',0,1,'R');

$pdf->Cell(130,7,'',0,0);
$pdf->SetFont('DejaVu','B',10);
$pdf->Cell(40,7,'Wartość VAT',0,0,'C');
$pdf->SetFont('DejaVu','',10);
$pdf->Cell(20,7,$wartosc_vat.' PLN',0,1,'R');

$pdf->Cell(130,7,'',0,0);
$pdf->SetFont('DejaVu','B',10);
$pdf->Cell(40,7,'Wartość brutto',0,0,'C');
$pdf->SetFont('DejaVu','',10);
$pdf->Cell(20,7,$bill.' PLN',0,1,'R');

$pdf->Line(10,180,200,180);

$pdf->Cell(1,20,'',0,1);
$pdf->SetFont('DejaVu','B',10);
$pdf->Cell(40,7,'Kwota opłacona',0,0);
$pdf->SetFont('DejaVu','',10);
$pdf->Cell(20,7,$bill.' PLN',0,1);

$pdf->Line(10,195,200,195);

$pdf->Cell(1,6,'',0,1);
$pdf->SetFont('DejaVu','B',10);
$pdf->Cell(40,7,'Do zapłaty',0,0);
$pdf->SetFont('DejaVu','',10);
$pdf->Cell(20,7,'0 PLN',0,1);
$pdf->Cell(40,3);
$pdf->Cell(20,3,'Słownie: zero PLN zero gr',0,1);

$pdf->Line(10,212,200,212);

$pdf->Output('F', 'vat/'.$_COOKIE['order_id'].'.pdf');
?>