<?php

/* 
 * amorDeleteProcess.php
 * script to process the deletion of a lover
 * (c) Joaquin Javier ESTEBAN MARTINEZ
 * last update: 2018-01-23
 */

require_once 'DB.inc';

// 1. get a DB connection to work with:
$pdo = DB::getDBHandle();


if ($_SERVER['REQUEST_METHOD'] === "POST") {
    
    // executes the deletion query:
    
    $queryString = <<<QUERY
DELETE
FROM `amores`
WHERE `amorID`=:amorID
QUERY;
    
    $statement = $pdo->prepare($queryString);
    $statement->bindParam(":amorID", $_POST['amorID'], PDO::PARAM_INT);
    $statement->execute();
    
    // redirect the user to the page 'practica.php':
    header ("Location: amores.php");

} /*else script called from outside the normal flush, throw exception*/


?>