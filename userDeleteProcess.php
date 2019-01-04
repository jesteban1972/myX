<?php
/**
 * script 'userDeleteProcess.php'.
 * 
 * script to process the deletion of an user.
 * 
 * @author Joaquin Javier ESTEBAN MARTINEZ <jesteban1972@me.com>
 * last update: 2018-06-08
 */

require_once 'DB.inc';
require_once 'user.inc';


if ($_SERVER['REQUEST_METHOD'] !== "POST") {
    /*
     * script called from outside the normal flush, redirect to 'index.php'
     */
    $_SESSION['notification'] = _("Unable to load the required page");
    header ("Location: index.php");
    
}
    
/*
 * desideratum: before processing the deletion, user data and all
 * associated information (experiences, lovers, places, countries, kinds)
 * could be saved in XML format.
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

try {

    // deletion query is executed:
    $queryString = <<<QUERY
DELETE
FROM `myX`.`users`
WHERE `userID` = :userID
QUERY;
    $statement = $pdo->prepare($queryString);
    $statement->bindParam(":userID", $userID, PDO::PARAM_INT);
    $statement->execute();

    // set success notification:
    $_SESSION['notification'] = _("User account deleted successfully");

} catch (Exception $e) {

    // set failure notification:
    $_SESSION['notification'] =
        _("There was a problem deleting the user account");

}

// user is redirected to 'index.php':
header ("Location: index.php");

?>