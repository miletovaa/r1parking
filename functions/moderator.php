<?
// * FETCH INFO FROM `MODERATOR` TABLE
function moderatorSettings() {
    $db = Database::getConnection();
    $query = "SELECT * FROM moderator";
    $result = $db->prepare($query);
    $result->execute();
    $moderator = $result->fetch(PDO::FETCH_ASSOC);
    return $moderator;
}

$moderator = moderatorSettings();
?>