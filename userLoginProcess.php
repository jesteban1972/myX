<?php

/* 
 * userLoginProcess.php
 * script to process a login
 * @author Joaquin Javier ESTEBAN MARTINEZ <jesteban1972@me.com>
 * last update: 2017-11-23
 */

require_once 'session.inc';
require_once 'user.inc';
require_once 'exceptions.inc';


// verify the input:
if (!isset($_POST['username'])
        || trim($_POST['username']) === ""
        || !isset($_POST['password'])
        || trim($_POST['username']) === "") {
    
    throw new Exception();
    
}

$username = $_POST['username'];
$password = $_POST['password'];

// have process login:
//if (!isset($_SESSION['userID'])) { // user not logged in
//    
//    $_SESSION['userID'] = -1;
//    
//}


// login the user (Achtung! intval needed):
$_SESSION['userID'] = intval(User::loginProcess($username, $password));

// 99. redirect the user to the start page
// displaying a welcome message:
header ("Location: index.php?welcomeMessage=1");

?>