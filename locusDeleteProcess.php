<?php

/* 
 * locusDeleteProcess.php
 * script to process the deletion of a place
 * @author Joaquin Javier ESTEBAN MARTINEZ <jesteban1972@me.com>
 * last update: 2018-01-23
 */

require_once 'DB.inc';

// get a DB connection to work with:
$pdo = DB::getDBHandle();


if ($_SERVER['REQUEST_METHOD'] === "POST") {
    
    // executes the deletion query:
    
    $queryString = <<<QUERY
DELETE
FROM `loca`
WHERE `locusID`=:locusID
QUERY;
    
    $statement = $pdo->prepare($queryString);
    $statement->bindParam(":locusID", $_POST['locusID'], PDO::PARAM_INT);
    $statement->execute();
    
    // redirect the user to the page 'practica.php':
    header ("Location: loca.php");

} /*else script called from outside the normal flush, throw exception*/


?>