<?
session_start();
require '../db.php';
require '../functions/moderator.php';

switch ($_POST['for_days']) {
    case '0':
        $cost = 0;
        break;
    case '1':
        $cost = $moderator['cost_parking_day1'];
        break;
    case '2':
        $cost = $moderator['cost_parking_day2'];
        break;
    case '3':
        $cost = $moderator['cost_parking_day3'];
        break;
    case '4':
        $cost = $moderator['cost_parking_day4'];
        break;
    case '5':
        $cost = $moderator['cost_parking_day5'];
        break;
    case '6':
        $cost = $moderator['cost_parking_day6'];
        break;
    case '7':
        $cost = $moderator['cost_parking_day7'];
        break;
    case '8':
        $cost = $moderator['cost_parking_day8'];
        break;
    case '9':
        $cost = $moderator['cost_parking_day9'];
        break;
    case '10':
        $cost = $moderator['cost_parking_day10'];
        break;
    case '11':
        $cost = $moderator['cost_parking_day11'];
        break;
    case '12':
        $cost = $moderator['cost_parking_day12'];
        break;
    case '13':
        $cost = $moderator['cost_parking_day13'];
        break;
    case '14':
        $cost = $moderator['cost_parking_day14'];
        break;
    default:
        $cost = (($_POST['for_days'] - 14) * $moderator['cost_parking_day_after14']) + $moderator['cost_parking_day14'];
        break;
}
$_SESSION['bill'] = $cost;
$_SESSION['for_days'] = $_POST['for_days'];

$query = "UPDATE orders SET for_days = :for_days, bill = :bill WHERE order_id = :order_id";
$result = $db->prepare($query);
$result->bindParam(":for_days",$_SESSION['for_days'], PDO::PARAM_INT);
$result->bindParam(":bill",$_SESSION['bill'] , PDO::PARAM_INT);
$result->bindParam(":order_id",$_COOKIE['order_id'], PDO::PARAM_STR);
$result->execute();

echo $cost;
?>