<?php
/** 
 * script 'locusEditProcess.php'.
 * 
 * script to process the edition or insertion of a new place.
 * 
 * @author Joaquin Javier ESTEBAN MARTINEZ <jesteban1972@me.com>
 * last update: 2018-06-08
 */

require_once 'session.inc';
require_once 'DB.inc';


if ($_SERVER['REQUEST_METHOD'] !== "POST") {
    /*
     * script called from outside the normal flush, redirect to 'index.php'
     */
    $_SESSION['notification'] = _("Unable to load the required page");
    header ("Location: index.php");
    
}

// get a DB connection to work with:
$pdo = DB::getDBHandle();
    
// the input is verified ('locusID' and 'name' are compulsory fields):
if (!isset($_POST['locusID']) || (trim($_POST['locusID']) === "") ||
    !isset($_POST['name']) || (trim($_POST['name']) === ""))
    throw new Exception();

// the values are retrieved from $_POST:
$locusID = intval($_POST['locusID']);
$achtung = $_POST['achtung'];
$name = $_POST['name'];
$rating = intval($_POST['rating']);
$address = $_POST['address'];
$country = intval($_POST['country']);
$kind = intval($_POST['kind']);
$descr = $_POST['descr'];
$coordExact = $_POST['coordExact'];
$coordGeneric = $_POST['coordGeneric'];
$web = $_POST['web'];

try {

    // update query:
    $queryString = <<<QUERY
UPDATE `loca`
SET `achtung` = :achtung,
    `name` = :name,
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
    $statement = $pdo->prepare($queryString);
    $statement->bindParam(":locusID", $locusID, PDO::PARAM_INT);
    $statement->bindParam(":achtung", $achtung, PDO::PARAM_STR);
    $statement->bindParam(":name", $name, PDO::PARAM_STR);
    $statement->bindParam(":rating", $rating, PDO::PARAM_INT);
    $statement->bindParam(":address", $address, PDO::PARAM_STR);
    $statement->bindParam(":country", $country, PDO::PARAM_INT);
    $statement->bindParam(":kind", $kind, PDO::PARAM_INT);
    $statement->bindParam(":descr", $descr, PDO::PARAM_STR);
    $statement->bindParam(":coordExact", $coordExact, PDO::PARAM_STR);
    $statement->bindParam(":coordGeneric", $coordGeneric, PDO::PARAM_STR);
    $statement->bindParam(":web", $web, PDO::PARAM_STR);
    $statement->execute();

    // set success notification:
    $_SESSION['notification'] = _("Place edited successfully");

} catch (Exception $e) {

    // set failure notification:
    $_SESSION['notification'] = _("There was a problem editing the place");

}

// redirect to the page 'amor.php':
header ("Location: locus.php?locusID=".$locusID);

?>