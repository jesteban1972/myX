<?php
/**
 * script 'praxisDeleteProcess.php'.
 * 
 * script to process the deletion of an experience.
 * 
 * the deletion of an experience can also involve the deletion of the place
 * associated, if it remains orphan, as well as orphan countries and/or kinds.
 * idem for lovers.
 * 
 * @author Joaquin Javier ESTEBAN MARTINEZ <jesteban1972@me.com>
 * last update: 2018-06-06
 */

require_once 'core.inc';
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
    
/*
 * the deletion query is accomplished within a transaction that involves the
 * deletion assignations as well as possible orphan places, countries, kinds
 * and lovers.
 */
    
try {

    $pdo->beginTransaction();

    // the experience is deleted:
    $queryString = <<<QUERY
DELETE
FROM `practica`
WHERE `praxisID` = :praxisID
QUERY;
    $statement = $pdo->prepare($queryString);
    $statement->bindParam(":praxisID", $_POST['praxisID'], PDO::PARAM_INT);
    $statement->execute();

    // the assignations are deleted:
    $queryString = <<<QUERY
DELETE
FROM `assignations`
WHERE `praxis` = :praxisID
QUERY;
    $statement = $pdo->prepare($queryString);
    $statement->bindParam(":praxisID", $_POST['praxisID'], PDO::PARAM_INT);
    $statement->execute();

    // possible orphan places are deleted:
    $queryString = <<<QUERY
DELETE
FROM `loca`
WHERE `locusID` NOT IN (
    SELECT `locus`
    FROM `practica`
)
QUERY;
    $statement = $pdo->prepare($queryString);
    $statement->execute();

    // possible orphan countries are deleted:
    $queryString = <<<QUERY
DELETE
FROM `countries`
WHERE `countryID` NOT IN (
    SELECT `country`
    FROM `loca`
)
QUERY;
    $statement = $pdo->prepare($queryString);
    $statement->execute();

    // possible orphan kinds are deleted:
    $queryString = <<<QUERY
DELETE
FROM `kinds`
WHERE `kindID` NOT IN (
    SELECT `kind`
    FROM `loca`
)
QUERY;
    $statement = $pdo->prepare($queryString);
    $statement->execute();
        
    // possible orphan lovers are deleted:
    $queryString = <<<QUERY
DELETE
FROM `amores`
WHERE `amorID` NOT IN (
    SELECT `amor`
    FROM `assignations`
)
QUERY;
    $statement = $pdo->prepare($queryString);
    $statement->execute();

    // commit transaction:
    $pdo->commit();

    // set success notification:
    $_SESSION['notification'] = _("Experience deleted successfully");

} catch (Exception $e) {

    $pdo->rollback();

    // set failure notification:
$_SESSION['notification'] = _("There was a problem deleting the experience");

}

// redirect the user to the page 'practica.php':
header ("Location: practica.php");

?>