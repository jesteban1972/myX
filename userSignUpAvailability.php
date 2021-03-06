<?php
/**
 * script 'userSignUpAvailability.php'.
 * 
 * this microscript is used to interactuate asynchronously with the page
 * 'userSignUp.js'. a query to the DB is performed to determinate
 * whether a given username already exists or not.
 * @author Joaquin Javier ESTEBAN MARTINEZ <jesteban1972@me.com>
 * last updated 2018-04-10
*/

require_once 'core.inc';
require_once 'DB.inc';

// retrieve the username from GET parameters:
$username = $_GET['username'];

// get a DB connection to work with:
$pdo = DB::getDBHandle();
        
// query the table 'users' against the received username:
$queryString = <<<QUERY
SELECT COUNT(`username`)
FROM `myX`.`users`
WHERE `username` = :username
QUERY;

$statement = $pdo->prepare($queryString);
$statement->bindParam(":username", $username, PDO::PARAM_STR);
$statement->execute();

// the number of rows is echoed (intval needed):
echo intval($statement->fetchColumn());