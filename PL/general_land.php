<?
session_start();
require '../db.php';
require '../functions/translator.php';
require '../functions/moderator.php';

// * LOG OUT
if (isset($_GET['logout'])) {
    setcookie("client_tel", '', time() + 0, "/");
    header('Location: ?');
}

// * Unset cookie order_id
setcookie("order_id", '', time() + 0, "/");

include '../point_ent_1.php';

// * Generate new order row.
if (isset($_POST['continue'])){
    include '../book/new_order_row.php';
    $refresh = 'true';
}

$_SESSION['cost_parking_day1'] = $moderator['cost_parking_day1']; $_SESSION['cost_parking_day2'] = $moderator['cost_parking_day2']; $_SESSION['cost_parking_day3'] = $moderator['cost_parking_day3']; $_SESSION['cost_parking_day4'] = $moderator['cost_parking_day4']; $_SESSION['cost_parking_day5'] = $moderator['cost_parking_day5']; $_SESSION['cost_parking_day6'] = $moderator['cost_parking_day6']; $_SESSION['cost_parking_day7'] = $moderator['cost_parking_day7']; $_SESSION['cost_parking_day8'] = $moderator['cost_parking_day8']; $_SESSION['cost_parking_day9'] = $moderator['cost_parking_day9']; $_SESSION['cost_parking_day10'] = $moderator['cost_parking_day10']; $_SESSION['cost_parking_day11'] = $moderator['cost_parking_day11']; $_SESSION['cost_parking_day12'] = $moderator['cost_parking_day12']; $_SESSION['cost_parking_day13'] = $moderator['cost_parking_day13']; $_SESSION['cost_parking_day14'] = $moderator['cost_parking_day14']; $_SESSION['cost_parking_day_after14'] = $moderator['cost_parking_day_after14'];
?>