<?php
/** 
 * script 'userSignUpProcess.php'.
 * 
 * script to process the sign up of a new user of the application.
 * @author Joaquin Javier ESTEBAN MARTINEZ <jesteban1972@me.com>
 * last update: 2018-05-11
 */

require_once 'session.inc';
require_once 'user.inc';
require_once 'exceptions.inc';

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
// TODO: rest of the fields

// get user data from $_POST:
$username = $_POST['username'];
$password1 = $_POST['password1'];
$password2 = $_POST['password2'];
$email = $_POST['email'];
$birthdate = filter_input(INPUT_POST,
   "birthdate",
    FILTER_VALIDATE_REGEXP,
    array("options" => array("regexp" => "/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/")));

// get user options from $_POST:
$defaultGenre = $_POST['defaultGenre'];
$descr1 = $_POST['descr1'];
$descr2 = $_POST['descr2'];
$descr3 = $_POST['descr3'];
$descr4 = $_POST['descr4'];

// get navigation options from $_POST:
$GUILang = isset($_POST['GUILang']) ? $_POST['GUILang'] : 1;
$resultsPerPage =
    isset($_POST['resultsPerPage']) ? $_POST['resultsPerPage'] : 25;
$listsOrder = isset($_POST['listsOrder']) ? $_POST['listsOrder'] : 1;

// 1.2 check that the password match:

/*
 * see above considerations about scripting in client side.
 */
if (strcmp($password1, $password2) !== 0) {
    
    throw new InputException("The input passwords do not match");

    //throw new NonMatchingPasswordsException();
    
}

// check that the given username is available:

/*
 * see above considerations about scripting in client side.
 */
if (User::doesUsernameExist($username)) {
    
    throw new usernameExistsException();
    
}

// check that the given username is valid:
if (!User::isValidUsername($username))    
    throw new InputException("The given username contains invalid character(s) used (only latin letters, whitespace, underscore and hyphen allowed).");

// 4. create the user account using userdata:
$userID = User::createUserAccount($username, $password1, $email, $birthdate);

/*
 * desideratum: an email to be sent with a link to confirmate the account.
 */


// 5. log in the newly created user:
$_SESSION['userID'] = User::loginProcess($username, $password1);

// once the user logged in, set user options and navigation options:
User::setUserOptions($defaultGenre, $descr1, $descr2, $descr3,
    $descr4);
User::setNavOptions($GUILang, $resultsPerPage, $listsOrder);

// 6. redirect the user to the start page:
header('Location: index.php');

?>