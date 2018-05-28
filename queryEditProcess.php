<?php
/** 
 * script 'queryEditProcess.php'.
 * 
 * script to process the insertion of a new query against the DB.
 * 
 * @author Joaquin Javier ESTEBAN MARTINEZ <jesteban1972@me.com>
 * last update: 2018-05-27
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

// the input is verified:
if (
    !isset($_POST['name']) || (trim($_POST['name']) === "") ||
    !isset($_POST['descr']) || 
    !isset($_POST['queryString']) || (trim($_POST['queryString']) === "")
    )
        throw new Exception();
    

// queryID is calculated:
$maxQueryID =
    $pdo->query("SELECT MAX(`queryID`) FROM `queries`")->fetchColumn();
$queryID = ($maxQueryID === null) ? 1 : intval($maxQueryID) + 1;

    
// the values are retrieved from $_POST:
$name = $_POST['name'];
$descr = $_POST['descr'];
$queryString = urldecode($_POST['queryString']);
    

// insertion query:
$insertionQueryString = <<<QUERY
INSERT
INTO `queries`
VALUES (:queryID,
    :name,
    :descr,
    :queryString,
    :user)
QUERY;

$statement = $pdo->prepare($insertionQueryString);
$statement->bindParam(":queryID", $queryID, PDO::PARAM_INT);
$statement->bindParam(":name", $name, PDO::PARAM_STR);
$statement->bindParam(":descr", $descr, PDO::PARAM_STR);
$statement->bindParam(":queryString", $queryString, PDO::PARAM_STR);
$statement->bindParam(":user", $_SESSION['userID'], PDO::PARAM_INT);
$statement->execute();

// redirect the user to the page 'amor.php' or 'amores.php':
//if ($amorEdit) {
//
//    header ("Location: amor.php?amorID=".$amorID);
//
//} else {
//
//    header ("Location: amores.php");
//}
header ("Location: queries.php");

?>