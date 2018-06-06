<?php
/** 
 * script 'locusEditProcess.php'.
 * 
 * script to process the edition or insertion of a new place.
 * 
 * @author Joaquin Javier ESTEBAN MARTINEZ <jesteban1972@me.com>
 * last update: 2018-06-06
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
    
// the input is verified (name is the only compulsory field):
if (
    !isset($_POST['locusID']) || (trim($_POST['locusID']) === "") ||
    !isset($_POST['achtung']) ||
    !isset($_POST['name']) || (trim($_POST['name']) === "") ||
    !isset($_POST['rating']) ||
    !isset($_POST['address']) ||
    !isset($_POST['country']) ||
    !isset($_POST['kind']) ||
    !isset($_POST['descr']) ||
    !isset($_POST['coordExact']) ||
    !isset($_POST['coordGeneric']) ||
    !isset($_POST['web'])
    )
        throw new Exception();

if (isset($_POST['locusID'])) { // called form locus.php: edit place

    $locusEdit = true;
    $locusID = intval($_POST['locusID']);

} else { // called from loca.php: new place

    $locusEdit = false;

    // locusID is calculated:
    $maxLocusID =
        $pdo->query("SELECT MAX(`locusID`) FROM `loca`")->fetchColumn();
    $locusID = ($maxLocusID === null) ? 1 : intval($maxLocusID) + 1;

}

// the values are retrieved from $_POST:
$achtung = $_POST['achtung'];
$name = $_POST['name'];
$rating = intval($_POST['rating']);
$address = $_POST['address'];
$country = intval($_POST['country']);
$kind = intval($_POST['kind']);
$description = $_POST['descr'];
$coordExact = $_POST['coordExact'];
$coordGeneric = $_POST['coordGeneric'];
$web = $_POST['web'];


// build the SQL query depending on $locusEdit:
if ($locusEdit) { // update existing place

    // update query:
    $queryString = <<<QUERY
UPDATE `loca`
SET `name` = :name,
    `rating` = :rating,
    `address` = :address,
    `country` = :country,
    `kind` = :kind,
    `descr` = :descr,
    `coordExact` = :coordExact,
    `coordGeneric` = :coordGeneric,
    `web` = :web    
WHERE `locusID` = :locusID
QUERY;
    
} else { // insert new place   

    // insertion query:
    $queryString = <<<QUERY
INSERT
INTO `loca`
VALUES (:locusID,
    :achtung,
    :name,
    :rating,
    :address,
    :country,
    :kind,
    :descr,
    :coordExact,
    :coordGeneric,
    :web,
    :user)
QUERY;

}

$statement = $pdo->prepare($queryString);
$statement->bindParam(":locusID", $locusID, PDO::PARAM_INT);
$statement->bindParam(":name", $name, PDO::PARAM_STR);
$statement->bindParam(":rating", $rating, PDO::PARAM_INT);
$statement->bindParam(":address", $address, PDO::PARAM_STR);
$statement->bindParam(":country", $country, PDO::PARAM_INT);
$statement->bindParam(":kind", $kind, PDO::PARAM_INT);
$statement->bindParam(":description", $description, PDO::PARAM_STR);
$statement->bindParam(":coordExact", $coordExact, PDO::PARAM_STR);
$statement->bindParam(":coordGeneric", $coordGeneric, PDO::PARAM_STR);
$statement->bindParam(":web", $web, PDO::PARAM_STR);
if (!$locusEdit)
    $statement->bindParam(":user",$_SESSION['userID'], PDO::PARAM_INT);
$statement->execute();
/*
 * TODO: if temporaryLocus we are redirected to page 'praxisEdit.php'
 */

// redirect the user to the page 'amores.php' or 'amor.php:
if ($locusEdit)
    header ("Location: locus.php?locusID=".$locusID);
else
    header ("Location: loca.php");



?>