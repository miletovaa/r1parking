<?
include 'session.php';
require '../db.php';
require '../functions/moderator.php';

/* 
* Checking if admin logged in.
* If NO, go to LOG IN page.
*/
if ($_SESSION['admin'] != 'logged_in') header('Location: log_in.php');
/* 
* Checking if admin's level allows to edit settings.
* If NO, go to TODAY page.
*/
if ($_SESSION['admin_level'] != 1) header('Location: today.php');

/* 
* Updating data in the Database.
*/
if (isset($_POST['update'])){
	$query = "UPDATE moderator SET
	cost_key = :cost_key
	WHERE id = 1";
	$result = $db->prepare($query);
	$result->bindParam(":cost_key",$_POST['cost_key'], PDO::PARAM_STR);
	$result->execute();
	header("Refresh: 0; url=edit_mod_sett.php");
}
if (isset($_POST['zmiana'])){
	$query = "UPDATE moderator SET
	zmiana_start = :zmiana_start
	WHERE id = 1";
	$result = $db->prepare($query);
	$result->bindParam(":zmiana_start",$_POST['zmiana_start'], PDO::PARAM_STR);
	$result->execute();
	header("Refresh: 0; url=edit_mod_sett.php");
}
if (isset($_POST['cennik'])){
	$query = "UPDATE moderator SET
	cost_parking_day1 = :cost_parking_day1,
	cost_parking_day2 = :cost_parking_day2,
	cost_parking_day3 = :cost_parking_day3,
	cost_parking_day4 = :cost_parking_day4,
	cost_parking_day5 = :cost_parking_day5,
	cost_parking_day6 = :cost_parking_day6,
	cost_parking_day7 = :cost_parking_day7,
	cost_parking_day8 = :cost_parking_day8,
	cost_parking_day9 = :cost_parking_day9,
	cost_parking_day10 = :cost_parking_day10,
	cost_parking_day11 = :cost_parking_day11,
	cost_parking_day12 = :cost_parking_day12,
	cost_parking_day13 = :cost_parking_day13,
	cost_parking_day14 = :cost_parking_day14,
	cost_parking_day_after14 = :cost_parking_day_after14
	WHERE id = 1";
	$result = $db->prepare($query);
	$result->bindParam(":cost_parking_day1",$_POST['cost_parking_day1'], PDO::PARAM_INT);
	$result->bindParam(":cost_parking_day2",$_POST['cost_parking_day2'], PDO::PARAM_INT);
	$result->bindParam(":cost_parking_day3",$_POST['cost_parking_day3'], PDO::PARAM_INT);
	$result->bindParam(":cost_parking_day4",$_POST['cost_parking_day4'], PDO::PARAM_INT);
	$result->bindParam(":cost_parking_day5",$_POST['cost_parking_day5'], PDO::PARAM_INT);
	$result->bindParam(":cost_parking_day6",$_POST['cost_parking_day6'], PDO::PARAM_INT);
	$result->bindParam(":cost_parking_day7",$_POST['cost_parking_day7'], PDO::PARAM_INT);
	$result->bindParam(":cost_parking_day8",$_POST['cost_parking_day8'], PDO::PARAM_INT);
	$result->bindParam(":cost_parking_day9",$_POST['cost_parking_day9'], PDO::PARAM_INT);
	$result->bindParam(":cost_parking_day10",$_POST['cost_parking_day10'], PDO::PARAM_INT);
	$result->bindParam(":cost_parking_day11",$_POST['cost_parking_day11'], PDO::PARAM_INT);
	$result->bindParam(":cost_parking_day12",$_POST['cost_parking_day12'], PDO::PARAM_INT);
	$result->bindParam(":cost_parking_day13",$_POST['cost_parking_day13'], PDO::PARAM_INT);
	$result->bindParam(":cost_parking_day14",$_POST['cost_parking_day14'], PDO::PARAM_INT);
	$result->bindParam(":cost_parking_day_after14",$_POST['cost_parking_day_after14'], PDO::PARAM_INT);
	$result->execute();
	header("Refresh: 0; url=edit_mod_sett.php");
}

/* 
* Create new admin in Database.
*/
if (isset($_POST['new_admin'])){
	$query = "INSERT INTO `admins` 
	(`admin_name`,
	`admin_pass`,
	`admin_level`) VALUES 
	(:new_admin_name,
	:new_admin_password,
	:new_admin_level)";
	$result = $db->prepare($query);
	$result->bindParam(":new_admin_name", $_POST['new_admin_name'], PDO::PARAM_STR);
	$result->bindParam(":new_admin_password", $_POST['new_admin_password'], PDO::PARAM_STR);
	$result->bindParam(":new_admin_level", $_POST['new_admin_level'], PDO::PARAM_INT);
	$result->execute();
	header("Refresh: 0; url=edit_mod_sett.php");
}

$query = "SELECT * from admins WHERE admin_level > 1 ";
$result = $db->prepare($query);
$result->execute();
$admins = $result->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../css/admin.css">
	<title>ZMIEŃ USTAWIENIA | R1 Parking</title>
</head>
<body>
<div id="wrapper">
	<h1>ZMIEŃ USTAWIENIA</h1>
<? include 'buttons.php';?>
	<hr>
	<div class="blocks">
	<div class="container sett">
		<form action="" method="post">
		<div class="admin_title">Cennik</div>
		<div class="cost">
			<div class="cost_col">
				<div class="sett_row">1 dzień <input type="number" name="cost_parking_day1" id="" value="<?=$moderator['cost_parking_day1'];?>"></div>
				<div class="sett_row">2 dni <input type="number" name="cost_parking_day2" id="" value="<?=$moderator['cost_parking_day2'];?>"></div>
				<div class="sett_row">3 dni <input type="number" name="cost_parking_day3" id="" value="<?=$moderator['cost_parking_day3'];?>"></div>
				<div class="sett_row">4 dni <input type="number" name="cost_parking_day4" id="" value="<?=$moderator['cost_parking_day4'];?>"></div>
				<div class="sett_row">5 dni <input type="number" name="cost_parking_day5" id="" value="<?=$moderator['cost_parking_day5'];?>"></div>
				<div class="sett_row">6 dni <input type="number" name="cost_parking_day6" id="" value="<?=$moderator['cost_parking_day6'];?>"></div>
				<div class="sett_row">1 tydznień <input type="number" name="cost_parking_day7" id="" value="<?=$moderator['cost_parking_day7'];?>"></div>
			</div>
			<div class="cost_col">
				<div class="sett_row">8 dni <input type="number" name="cost_parking_day8" id="" value="<?=$moderator['cost_parking_day8'];?>"></div>
				<div class="sett_row">9 dni <input type="number" name="cost_parking_day9" id="" value="<?=$moderator['cost_parking_day9'];?>"></div>
				<div class="sett_row">10 dni <input type="number" name="cost_parking_day10" id="" value="<?=$moderator['cost_parking_day10'];?>"></div>
				<div class="sett_row">11 dzień <input type="number" name="cost_parking_day11" id="" value="<?=$moderator['cost_parking_day11'];?>"></div>
				<div class="sett_row">12 dni <input type="number" name="cost_parking_day12" id="" value="<?=$moderator['cost_parking_day12'];?>"></div>
				<div class="sett_row">13 dni <input type="number" name="cost_parking_day13" id="" value="<?=$moderator['cost_parking_day13'];?>"></div>
				<div class="sett_row">2 tygodnie <input type="number" name="cost_parking_day14" id="" value="<?=$moderator['cost_parking_day14'];?>"></div>
			</div>
		</div>
				<div class="sett_row">Każdy następny dzień <input type="number" name="cost_parking_day_after14" id="" value="<?=$moderator['cost_parking_day_after14'];?>"></div>
		<div class="btn_container">
			<input class="sett_btn" type="submit" name="cennik" value="ZMIEŃ">
		</div>
		</form>
	</div>
	<div class="container block">
		<div class="admin_title">Ustawienia</div>
		<form action="" method="post">
			<div class="sett_row">Przechowanie kluczy <input type="number" name="cost_key" id="" value="<?=$moderator['cost_key'];?>"></div>
			<div class="btn_container">
				<input class="sett_btn" type="submit" name="update" value="ZMIEŃ">
			</div>
		</form>
		<form action="" method="post">
			<div class="sett_row">Początek pracy <div class=""><input type="time" name="zmiana_start" value="<?=$moderator['zmiana_start'];?>"></div></div>
			<div class="btn_container">
				<input class="sett_btn" type="submit" name="zmiana" value="ZMIEŃ">
			</div>
		</form>
	</div>
	</div>
	
	<div class="container admins">
		<div class="admin_title">Admins: <button class="admin_btn" onclick="addNewAdminVisible()">ADD NEW ADMIN</button></div>
		<div id="admins_container">
		<? foreach ($admins as $key => $admin){?>
			<?
				switch ($admin['admin_level']){
					case 2:
						$level = 'Level 2. Edit and view.';
					break;
					case 3:
						$level = 'Level 3. View.';
					break;
				}
			?>
			<div class="admin_block">
				<div class="admin_info">
					<div class="admin_row admin_name"><?=$admin['admin_name'];?></div>
					<div class="admin_row admin_level"><?=$level;?></div>
					<a class="personal_link" href="">Personal summary</a>
				
				<div class="admin_btns">
					<input type="submit" class="delete_admin" id="a<?=$admin['id'];?>" value="DELETE">
				</div>
				</div>
			</div>
		<?}?>
			<div id="add_new_admin" style="display: none;">
			<form action="" method="POST">
				<div class="admin_block new">
					<div class="admin_info">
						<div class="admin_row">New admin name: <input type="text" name="new_admin_name" required></div>
						<div class="admin_row">New admin password: <input type="text" name="new_admin_password" required></div>
						<div class="admin_row">New admin level: <input type="number" name="new_admin_level" min="1" max="3" required></div>
					</div>
					<div class="admin_btns">
						<input type="submit" class="add_admin" name="new_admin" value="ADD NEW ADMIN">
					</div>
				</div>
			</form>
			</div>
		</div>
	</div>
	</div>
</div>
<script src="../js/admin.js"></script>
</body>
</html>