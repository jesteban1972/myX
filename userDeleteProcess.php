<?php

/* 
 * userDeleteProcess.php
 * script to process the deletion of an user
 * (c) Joaquin Javier ESTEBAN MARTINEZ
 * last update: 2018-03-25
 */

require_once 'DB.inc';
require_once 'user.inc';


if ($_SERVER['REQUEST_METHOD'] !== "POST") { // script called from outside the normal flush

    header("HTTP/1.0 403 Forbidden", TRUE, 403);
    
//    header($_SERVER["SERVER_PROTOCOL"]." 403 Forbidden", true, 403);
//    echo "KO";
//    die();
    //include 'forbidden.php';
        
} else {
    
    /*
     * ideally, before processing the deletion, user data and all associated
     * information (experiences, lovers, places, countries, kinds)
     * should be saved in XML format
     */
    
    // get a DB connection to work with:
    $pdo = DB::getDBHandle();
    
    // userID is stored in a variable
    // before processing log out and cleaning up the session:
    $userID = $_SESSION['userID'];
    
    // the user is logged out of the system:
    
    User::logoutProcess();
    
    // $_SESSION variables are cleaned up:
    $_SESSION['userID'] = -1;
    unset($_SESSION['practicaList']);
    unset($_SESSION['amoresList']);
    unset($_SESSION['locaList']);
    
    // deletion query is executed:
    
    $queryString = <<<QUERY
DELETE
FROM `myX`.`users`
WHERE `userID` = :userID
QUERY;
    
    $statement = $pdo->prepare($queryString);
    $statement->bindParam(":userID", $userID, PDO::PARAM_INT);
    $statement->execute();
        
    // user is redirected to 'index.php':
    header ("Location: index.php");

}

?>