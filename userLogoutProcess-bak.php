<?php

/* 
 * userLogoutProcess.php
 * script to process a logout
 * (c) Joaquin Javier ESTEBAN MARTINEZ
 * last update: 2018-01-26
 */

require_once 'session.inc';
require_once 'user.inc';

//include("session.inc");

// retrieve userID from $_SESSION:
if (!isset($_SESSION['userID'])) {
    
    $_SESSION['userID'] = -1; // not logged in
    
} else {
    
    $userID = intval($_SESSION['userID']);

    if ($userID !== -1)
        User::logoutProcess();

    // clean up all the $_SESSION variables:
    unset($_SESSION);
    $_SESSION['userID'] = -1;

}


header("Location: index.php");

?>