<?php
/* 
 * script 'amorEditProcess.php'.
 * 
 * script to process the edition or insertion of a new lover
 * (c) Joaquin Javier ESTEBAN MARTINEZ
 * last update: 2018-04-24
 */

require_once 'session.inc';
require_once 'DB.inc';
//require_once 'user.inc';
//require_once 'exceptions.inc';

if ($_SERVER['REQUEST_METHOD'] !== "POST") {
    /*
     * script called from outside the normal flush, throw exception
     */
    header ("Location: index.php");
    
}

// get a DB connection to work with:
$pdo = DB::getDBHandle();

// TODO: verify the input:
//if (!isset($_POST['username'])
//        || trim($_POST['username']) === ""
//        || !isset($_POST['password'])
//        || trim($_POST['username']) === "") {
//    
//    throw new Exception();
//    
//}

// the input is verified:
if (
    !isset($_POST['amorID']) || (trim($_POST['amorID']) === "") ||
    !isset($_POST['achtung']) /*|| (trim($_POST['achtung']) === "")*/ ||
    !isset($_POST['alias']) || (trim($_POST['alias']) === "") ||
    !isset($_POST['rating']) || (trim($_POST['rating']) === "") ||
    !isset($_POST['genre']) || (trim($_POST['genre']) === "") ||
    !isset($_POST['descr1']) || (trim($_POST['descr1']) === "") ||
    !isset($_POST['descr2']) /*|| (trim($_POST['descr2']) === "")*/ ||
    !isset($_POST['descr3']) /*|| (trim($_POST['descr3']) === "")*/ ||
    !isset($_POST['descr4']) /*|| (trim($_POST['descr4']) === "")*/ ||
    !isset($_POST['web']) /*|| (trim($_POST['web']) === "")*/ ||
    !isset($_POST['name']) /*|| (trim($_POST['name']) === "")*/ ||
    !isset($_POST['photo']) /*|| (trim($_POST['photo']) === "")*/ ||
    !isset($_POST['phone']) /*|| (trim($_POST['phone']) === "")*/ ||
    !isset($_POST['email']) /*|| (trim($_POST['email']) === "")*/ ||
    !isset($_POST['other']) /*|| (trim($_POST['other']) === "")*/
    )
        throw new Exception();
    
if (isset($_GET['amorID'])) { // called form amor.php: edit lover

    $amorEdit = true;
    $amorID = intval($_GET['amorID']);

} else { // called from amor.php: new lover

    $amorEdit = false;

    // amorID is calculated:
    $maxAmorID =
        $pdo->query("SELECT MAX(`amorID`) FROM `amores`")->fetchColumn();
    $amorID = ($maxAmorID === null) ? 1 : intval($maxAmorID) + 1;

}
    
// the values are retrieved from $_POST:
$achtung = $_POST['achtung'];
$alias = $_POST['alias'];
$rating = intval($_POST['rating']);
$genre = intval($_POST['genre']);
$descr1 = $_POST['descr1'];
$descr2 = $_POST['descr2'];
$descr3 = $_POST['descr3'];
$descr4 = $_POST['descr4'];
$web = $_POST['web'];
$name = $_POST['name'];
$photo = intval($_POST['photo']);
$telephone = $_POST['phone'];
$email = $_POST['email'];
$other = $_POST['other'];
    
// build the SQL query depending on $amorEdit:
if ($amorEdit) { // update existing lover

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
    
} else { // insert new lover   

    // insertion query:
    $queryString = <<<QUERY
INSERT
INTO `amores`
VALUES (:amorID,
    :achtung,
    :alias,
    :rating,
    :genre,
    :descr1,
    :descr2,
    :descr3,
    :descr4,
    :web,
    :name,
    :photo,
    :phone,
    :email,
    :other,
    :user)
QUERY;

}

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
if (!$amorEdit)
    $statement->bindParam(":user", $_SESSION['userID'], PDO::PARAM_INT);
$statement->execute();

// redirect the user to the page 'amor.php' or 'amores.php':
if ($amorEdit) {

    header ("Location: amor.php?amorID=".$amorID);

} else {

    header ("Location: amores.php");
}

?>