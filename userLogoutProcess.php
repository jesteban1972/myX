<?php
/* 
 * userLogoutProcess.php
 * script to process a logout
 * (c) Joaquín Javier ESTEBAN MARTÍNEZ
 * last update: 2017-11-07
 */
require_once 'session.inc';
require_once 'user.inc';
//include("session.inc");
// retrieve userID from $_SESSION:
if (!isset($_SESSION['userID'])) {
    
    $_SESSION['userID'] = -1; // not logged in
    
}
    
$userID = intval($_SESSION['userID']);
//if ($userID === -1) { // script not called from index.php
//
//// TODO: make it better throwing an exception:
//    echo <<<HTML
//<p align="center><b>Sorry, you can't be logged out if you're not logged in</b></p>"
//HTML;
//    exit;
//    
//}
// an instance of class 'User' is created to handle logout:
// (using static method instead)
//$myUser = new User($userID);
// log the user out of the system if he is currently logged in:
if ($userID !== -1) {
    User::logoutProcess();
    // clean up all the $_SESSION variables:
    $_SESSION['userID'] = -1;
    unset($_SESSION['practicaList']);
    unset($_SESSION['amoresList']);
    unset($_SESSION['locaList']);
}
header("Location: index.php");
?>