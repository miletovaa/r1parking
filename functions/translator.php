<?
// * LANGUAGE DETECTION FUNCTIONS
function setLang() {
    $pref = substr($_SERVER["HTTP_ACCEPT_LANGUAGE"], 0, 2);
    $query = "SELECT lang FROM `translator`";
    $result = $db->prepare($query);
    $result->execute();
    $langs = $result->fetchAll(PDO::FETCH_ASSOC);
    foreach($langs as $key => $l) $langs_arr[]=$l['lang'];
    if (in_array($pref, $langs_arr)) $lang = $pref;
    else $lang = 'pl';
    if (!$_COOKIE['lang']) setcookie("lang", $lang, time() + 72*60*60, "/");
    else $lang = $_COOKIE['lang'];
    if (isset($_GET['lang'])) {
        $lang = $_GET['lang']; 
        setcookie("lang", $lang, time() + 72*60*60, "/");
    }
    return $lang;
}
function translator($lang) {
    $db = Database::getConnection();
    $result = $db->prepare("DESCRIBE translator2");
    $result->execute();
    $langs = $result->fetchAll(PDO::FETCH_COLUMN);
    $translate_temp = null;
        $query = "SELECT variable, " . $lang . " FROM translator2";
        $result = $db->prepare($query);
        $result->execute();
        $translate_temp = $result->fetchAll(PDO::FETCH_ASSOC);
    $translate = null;

    foreach ($translate_temp as $key => $value) {
       $translate[$value["variable"]] = $value[$lang];
    }
    return $translate;
}

$lang = setLang();
$translate = translator($lang);
?>