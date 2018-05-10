<?php
/**
 * script 'praxisDeleteProcess.php'.
 * 
 * script to process the deletion of an experience.
 * (c) Joaquin Javier ESTEBAN MARTINEZ
 * last update: 2018-01-25
 */

require_once 'DB.inc';

if ($_SERVER['REQUEST_METHOD'] !== "POST") {

    // script called from outside the normal flush
    header($_SERVER["SERVER_PROTOCOL"]." 403 Forbidden", true, 403);
    die();
    //include 'forbidden.php';
        
} else {
    
    // get a DB connection to work with:
    $pdo = DB::getDBHandle();
    
    // executes the deletion query:
    
    $queryString = <<<QUERY
DELETE
FROM `practica`
WHERE `praxisID` = :praxisID
QUERY;
    
    $statement = $pdo->prepare($queryString);
    $statement->bindParam(":praxisID", $_POST['praxisID'], PDO::PARAM_INT);
    $statement->execute();
    
    // redirect the user to the page 'practica.php':
    header ("Location: practica.php");

}

?>