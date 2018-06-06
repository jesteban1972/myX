<?php
/**
 * script 'locusDeleteProcess.php'.
 * 
 * this script to process the deletion of a place.
 * 
 * the deletion of a place can also involve the deletion of the country and/or
 * the kind of place, if them remain orphan.
 * 
 * @author Joaquin Javier ESTEBAN MARTINEZ <jesteban1972@me.com>
 * last update: 2018-01-23
 */

require_once 'DB.inc';

// get a DB connection to work with:
$pdo = DB::getDBHandle();


if ($_SERVER['REQUEST_METHOD'] === "POST") {
    
    try {
        
        /*
         * the deletion query is accomplished within a transaction that involves
         * the deletion of orphan countries and kinds.
         */
        
        $pdo->beginTransaction();
    
        $queryString = <<<QUERY
DELETE
FROM `loca`
WHERE `locusID` = :locusID
QUERY;
    
        $statement = $pdo->prepare($queryString);
        $statement->bindParam(":locusID", $_POST['locusID'], PDO::PARAM_INT);
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
        
        // commit transaction:
        $pdo->commit();
    
    } catch (Exception $e) {
        
        $pdo->rollback();
        
    }
    
    // redirect the user to the page 'practica.php':
    header ("Location: loca.php");

} /*else script called from outside the normal flush, throw exception*/


?>