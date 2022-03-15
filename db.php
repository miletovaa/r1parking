<?
class Database {
    public static function getConnection() {
        $host = 'localhost';
        $dbname = 'db_name';
        $user = 'user';
        $pass = '';
        $db = new PDO("mysql:host=$host;charset=utf8;dbname=$dbname", $user, $pass);
        $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
        return $db;
    }
    public static function moderatorSettings() {
        $db = Database::getConnection();
        $query = "SELECT * FROM moderator";
        $result = $db->prepare($query);
        $result->bindParam(":rest", $rest, PDO::PARAM_STR);
        $result->execute();
        $moderator = $result->fetch(PDO::FETCH_ASSOC);
        return $moderator;
    }
    public static function setLang() {
        $pref = substr($_SERVER["HTTP_ACCEPT_LANGUAGE"], 0, 2);
        $db = Database::getConnection();
        $query = "SELECT lang FROM `translator`";
        $result = $db->prepare($query);
        $result->execute();
        $langs = $result->fetchAll(PDO::FETCH_ASSOC);
        foreach($langs as $key => $l) $langs_arr[]=$l['lang'];
        if (in_array($pref, $langs_arr)) $lang = $pref;
        else $lang = 'pl';
        if (isset($_GET['lang'])) $lang = $_GET['lang'];
        return $lang;
    }
    public static function translator($lang) {
        $db = Database::getConnection();
        $query = "SELECT * FROM `translator` WHERE lang = :lang";
        $result = $db->prepare($query);
        $result->bindParam(":lang", $lang, PDO::PARAM_STR);
        $result->execute();
        $translate = $result->fetch(PDO::FETCH_ASSOC);
        return $translate;
    }
}

function CreateRandomCodeFullCharacter($quantity_сharacters){
    $full_arr = array('A','B','D','F','H','K','P','Q','S','T','U','X','Y','Z',0,1,2,3,4,5,6,7,8,9);
    $code = null;
    for ($i = 1; $i <= $quantity_сharacters; $i++)
    {
        $count_full_arr = count($full_arr);
        $сhar_pos_in_array = rand(0, $count_full_arr-1);
        $code .= $full_arr[$сhar_pos_in_array];
    }
    return $code;
}

/*
STRUCTURE OF MY DATABASE

TABLE `orders`:
order_id
order_status
book_start
book_finish
for_days - int
bill
date_enter
time_enter
date_exit
time_exit
client_id - int
passengers - varchar
cars - int
registration - varchar
back_from - varchar
comments - varchar
payment - varchar
key_safe - boolean
free_help - boolean
subscribe - boolean
vat - boolean
vat_name - varchar
vat_nip - varchar
vat_address
vat_postcode
vat_city

TABLE `clients`:
name
tel
mail
orders - varchar

TABLE `moderator`:
cost_key
cost_parking_day1
cost_parking_day2
cost_parking_day3
cost_parking_day4
cost_parking_day5
cost_parking_day6
cost_parking_day7
cost_parking_day8
cost_parking_day9
cost_parking_day10
cost_parking_day11
cost_parking_day12
cost_parking_day13
cost_parking_day14
cost_parking_day_after14

TABLE `admins`:
admin_pass
admin_name

TABLE `translator`:
ru
en
pl
*/
?>