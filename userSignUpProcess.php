<?php
/** 
 * script 'userSignUpProcess.php'.
 * 
 * script to process the sign up of a new user of the application.
 * 
 * @author Joaquin Javier ESTEBAN MARTINEZ <jesteban1972@me.com>
 * last update: 2018-05-11
 */

require_once 'core.inc';
require_once 'user.inc';
require_once 'exceptions.inc';

if ($_SERVER['REQUEST_METHOD'] !== "POST") {
    
    // script called from outside the normal flush, redirect to 'index.php':
    $_SESSION['notification'] = _("Unable to load the required page");
    header ("Location: index.php");
    
}

// validate the input:

/*
 * although already validated in 'userSignUp.js', user input is re-validated,
 * because the user might have desactivated scripting in client side.
 * in failure case exceptions are thrown.
 */

if (!isset($_POST['username']) || trim($_POST['username']) === "" ||
    !isset($_POST['password1']) || trim($_POST['password1']) === "" ||
    !isset($_POST['password2']) || trim($_POST['password2']) === "" ||
    !isset($_POST['email']) || trim($_POST['email']) === "" ||
    !isset($_POST['birthdate']) || trim($_POST['birthdate']) === "")
    throw new InputException('One or more fields are empty, but all of them are required');

// get user data from $_POST:
$username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_STRING);
$password1 = filter_input(INPUT_POST, "password1", FILTER_SANITIZE_STRING);
$password2 = filter_input(INPUT_POST, "password2", FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_STRING);
$birthdate = filter_input(INPUT_POST,
   "birthdate",
    FILTER_VALIDATE_REGEXP,
    array("options" => array("regexp" => "/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/")));

// get user options from $_POST:
$defaultGenre = filter_input(INPUT_POST, "defaultGenre", FILTER_VALIDATE_INT);
$descr1 = filter_input(INPUT_POST, "descr1", FILTER_SANITIZE_STRING);
$descr2 = filter_input(INPUT_POST, "descr2", FILTER_SANITIZE_STRING);
$descr3 = filter_input(INPUT_POST, "descr3", FILTER_SANITIZE_STRING);
$descr4 = filter_input(INPUT_POST, "descr4", FILTER_SANITIZE_STRING);

// get navigation options from $_POST:

$GUILang = (isset($_POST['GUILang'])) ?
    filter_input(INPUT_POST, "GUILang", FILTER_VALIDATE_INT) :
    1;

$resultsPerPage = (isset($_POST['resultsPerPage'])) ?
    filter_input(INPUT_POST, "resultsPerPage", FILTER_VALIDATE_INT) :
    25;

$listsOrder = (isset($_POST['listsOrder'])) ?
    filter_input(INPUT_POST, "listsOrder", FILTER_VALIDATE_INT) :
    1;

// check that the password match:
if (strcmp($password1, $password2) !== 0) {
    
    throw new InputException("The input passwords do not match");
    
}

// check that the given username is available:
if (User::doesUsernameExist($username)) {
    
    throw new usernameExistsException();
    
}

// check that the given username is valid:
if (!User::isValidUsername($username)) {
    
    throw new InputException("The given username contains invalid character(s) used (only latin letters, whitespace, underscore and hyphen allowed).");
    
} 

// create the user account using user data:
$userID = User::createUserAccount($username, $password1, $email, $birthdate);

/*
 * desideratum: an email to be sent with a link to confirmate the account.
 */


// log in the newly created user:
$_SESSION['userID'] = User::loginProcess($username, $password1);

// once the user logged in, set user options and navigation options:
User::setUserOptions($defaultGenre, $descr1, $descr2, $descr3, $descr4);
User::setNavOptions($GUILang, $resultsPerPage, $listsOrder);

// redirect the user to the start page:
header('Location: index.php');

?>