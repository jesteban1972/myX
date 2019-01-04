<?php
/**
 * script 'amorDeleteProcess.php'.
 * 
 * script to process the deletion of a lover.
 * 
 * @author Joaquin Javier ESTEBAN MARTINEZ <jesteban1972@me.com>
 * last update: 2018-06-08
 */

require_once 'core.inc';
require_once 'DB.inc';

// get a DB connection to work with:
$pdo = DB::getDBHandle();


if ($_SERVER['REQUEST_METHOD'] !== "POST") {
    
    // script called from outside the normal flush, redirect to 'index.php':
    $_SESSION['notification'] = _("Unable to load the required page");
    header ("Location: index.php");
    
}
    
try {

    $pdo->beginTransaction();

    // the lover is deleted:
    $queryString = <<<QUERY
DELETE
FROM `amores`
WHERE `amorID` = :amorID
QUERY;
    $statement = $pdo->prepare($queryString);
    $statement->bindParam(":amorID", $_POST['amorID'], PDO::PARAM_INT);
    $statement->execute();
        
    // the assignations are deleted:
    $queryString = <<<QUERY
DELETE
FROM `assignations`
WHERE `amor` = :amorID
QUERY;
    $statement = $pdo->prepare($queryString);
    $statement->bindParam(":amorID", $_POST['amorID'], PDO::PARAM_INT);
    $statement->execute();
        
    // possible orphan experiences are deleted:
    $queryString = <<<QUERY
DELETE
FROM `practica`
WHERE `praxisID` NOT IN (
    SELECT `praxis`
    FROM `assignations`
)
QUERY;
    $statement = $pdo->prepare($queryString);
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

    $pdo->commit();
        
    // set success notification:
    $_SESSION['notification'] = _("Lover deleted successfully");

} catch (Exception $e) {

    $pdo->rollback();

    // set failure notification:
    $_SESSION['notification'] = _("There was a problem deleting the lover");

}
    
// redirect the user to the page 'practica.php':
header ("Location: amores.php");

?>