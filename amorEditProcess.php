<?php
/* 
 * script 'amorEditProcess.php'.
 * 
 * script to process the edition or insertion of a new lover
 * 
 * @author Joaquin Javier ESTEBAN MARTINEZ <jesteban1972@me.com>
 * last update: 2018-04-24
 */

require_once 'core.inc';
require_once 'DB.inc';

if ($_SERVER['REQUEST_METHOD'] !== "POST") {
    
    // script called from outside the normal flush, redirect to 'index.php':
    $_SESSION['notification'] = _("Unable to load the required page");
    header ("Location: index.php");
    
}

// get a DB connection to work with:
$pdo = DB::getDBHandle();

if (isset($_POST['amorID'])) { // called form 'amor.php': edit lover

    $amorEdit = true;
    $amorID = intval($_POST['amorID']);

}

/*
 * the input is verified (compulsory fields 'amorID' and 'alias')
 */
if (
    !isset($_POST['amorID']) || (trim($_POST['amorID']) === "") ||
    !isset($_POST['alias']) || (trim($_POST['alias']) === "")
    )
        throw new Exception();
     
// the values are retrieved from $_POST:
$achtung = filter_input(INPUT_POST, "achtung", FILTER_SANITIZE_STRING);
$alias = filter_input(INPUT_POST, "alias", FILTER_SANITIZE_STRING);
$rating = filter_input(INPUT_POST, "rating", FILTER_VALIDATE_INT);
$genre = filter_input(INPUT_POST, "genre", FILTER_VALIDATE_INT);
$descr1 = filter_input(INPUT_POST, "descr1", FILTER_SANITIZE_STRING);
$descr2 = filter_input(INPUT_POST, "descr2", FILTER_SANITIZE_STRING);
$descr3 = filter_input(INPUT_POST, "descr3", FILTER_SANITIZE_STRING);
$descr4 = filter_input(INPUT_POST, "descr4", FILTER_SANITIZE_STRING);
$web = filter_input(INPUT_POST, "web", FILTER_SANITIZE_STRING);
$name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_STRING);
$photo = filter_input(INPUT_POST, "photo", FILTER_VALIDATE_INT);
$telephone = filter_input(INPUT_POST, "phone", FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_STRING);
$other = filter_input(INPUT_POST, "other", FILTER_SANITIZE_STRING);
    
// build the SQL query depending on $amorEdit:
if ($amorEdit) { // update existing lover
    
    try {

        // update query:
        $queryString = <<<QUERY
UPDATE `amores`
SET `achtung` = :achtung,
    `alias` = :alias,
    `rating`=:rating,
    `genre` = :genre,
    `descr1` = :descr1,
    `descr2` = :descr2,
    `descr3` = :descr3,
    `descr4` = :descr4,
    `web` = :web,
    `name` = :name,
    `photo` = :photo,
    `phone` = :phone,
    `email` = :email,
    `other` = :other
WHERE `amorID` = :amorID
QUERY;
        $statement = $pdo->prepare($queryString);
        $statement->bindParam(":amorID", $amorID, PDO::PARAM_INT);
        $statement->bindParam(":achtung", $achtung, PDO::PARAM_STR);
        $statement->bindParam(":alias", $alias, PDO::PARAM_STR);
        $statement->bindParam(":rating", $rating, PDO::PARAM_INT);
        $statement->bindParam(":genre", $genre, PDO::PARAM_INT);
        $statement->bindParam(":descr1", $descr1, PDO::PARAM_STR);
        $statement->bindParam(":descr2", $descr2, PDO::PARAM_STR);
        $statement->bindParam(":descr3", $descr3, PDO::PARAM_STR);
        $statement->bindParam(":descr4", $descr4, PDO::PARAM_STR);
        $statement->bindParam(":web", $web, PDO::PARAM_STR);
        $statement->bindParam(":name", $name, PDO::PARAM_STR);
        $statement->bindParam(":photo", $photo, PDO::PARAM_INT);
        $statement->bindParam(":phone", $phone, PDO::PARAM_STR);
        $statement->bindParam(":email", $email, PDO::PARAM_STR);
        $statement->bindParam(":other", $other, PDO::PARAM_STR);
        $statement->execute();

        // set success notification:
        $_SESSION['notification'] = _("Lover edited successfully");
    
    } catch (Exception $e) {
        
        // set failure notification:
        $_SESSION['notification'] = _("There was a problem editing the lover");
    
    }

}

// redirect the user to the page 'amor.php' or 'amores.php':
if ($amorEdit) {

    header ("Location: amor.php?amorID=".$amorID);

} else {

    header ("Location: amores.php");
}

?>