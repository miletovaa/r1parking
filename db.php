<?
class Database {
    public static function getConnection() {
        $host = 'localhost';
        $dbname = 'dbname';
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
?>