<?php

/* 
 * userSignUpProcess.php
 * script to process a sign up in myX
 * (c) Joaquin Javier ESTEBAN MARTINEZ
 * last update: 2018-01-26
 */

require_once 'session.inc';
require_once 'user.inc';
require_once 'exceptions.inc';

// validate the input:
if (!isset($_POST['username']) || trim($_POST['username']) === "" ||
    !isset($_POST['password1']) || trim($_POST['password1']) === "" ||
    !isset($_POST['password2']) || trim($_POST['password2']) === "" ||
    !isset($_POST['email']) || trim($_POST['email']) === "")
    throw new InputException('One or more fields are empty, but all of them are required');

$username = $_POST['username'];
$password1 = $_POST['password1'];
$password2 = $_POST['password2'];
$email = $_POST['email'];

// 1.2 check that the passwords match:
// (ACHTUNG! In Safari neither INPUT's required attribute nor type="email" are supported!)
// make it from inside class 'User' ??? probably not
if (strcmp($password1, $password2) !== 0) {
    
    throw new InputException("The input passwords do not match");

    //throw new NonMatchingPasswordsException();
    
}

// check that the given username does not exist yet:
// (do it using AJAX in userSignUp.php!!!)
if (User::doesUsernameExist($username)) { // make it from inside class 'User' ???
    
    throw new usernameExistsException();
    
}

// check that the given username is valid:
if (!User::isValidUsername($username)) {
    
    throw new InputException("The given username contains not allowed characters. Allowed characters are only: Letters (A-Z, a-z), numbers (0-9), space ( ), underscore (_) and dash (-)");
    
}

// 4. create the user account:
$userID = User::createUserAccount($username, $password1, $email);

// TODO: send an email with a link to confirmate the account
// ...

// 5. log in the newly created user:
$_SESSION['userID'] = User::loginProcess($username, $password1);

// 6. redirect the user to the start page:
header('Location: index.php');

?>