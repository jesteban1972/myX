<?php

/* 
 * userLoginProcess.php
 * script to process a login
 * (c) Joaquín Javier ESTEBAN MARTÍNEZ
 * last update: 2017-11-23
 */

require_once 'session.inc';
require_once 'user.inc';
require_once 'exceptions.inc';

session_start();

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

// a new object 'User' is instantiated:
// (using static methods instead)
//$myUser = new User(intval($_SESSION['userID']));
//var_dump($myUser);

// login the user:
$_SESSION['userID'] = User::loginProcess($username, $password);

// 99. redirect the user to the start page:
header ("Location: index.php?welcomeMessage=true");

?>