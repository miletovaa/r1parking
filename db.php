<?
// * CONNECTION TO DATABASE
class Database {
    // подключение к бд
    public static function getConnection() {
        $host = 'localhost';
        $dbname = 'dbname';
        $user = 'root';
        $pass = '123';
        $db = new PDO("mysql:host=$host;charset=utf8;dbname=$dbname", $user, $pass);
        $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
        return $db;
    }
}
$db = Database::getConnection();
?>