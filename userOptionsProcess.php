<?php
/** 
 * script 'userOptionsProcess.php'.
 * 
 * script to process user's options
 * @author Joaquin Javier ESTEBAN MARTINEZ <jesteban1972@me.com>
 * last update: 2018-06-09
 */

require_once 'core.inc';
//require_once 'session.inc';
require_once 'DB.inc';
require_once 'user.inc';

// get a DB connection to work with:
$pdo = DB::getDBHandle();

$user = new User($_SESSION['userID']);

/*
 * when user options and/or navigation options are set/modified
 * using the form in 'userOptions.php',
 * their values are store in both $_SESSION, $_COOKIE,
 * as well in the DB.
 * when loading the next page the page's header will retrieve the values
 * directly from $_SESSION.
 */

if ($_SERVER['REQUEST_METHOD'] !== "POST") {
    /*
     * script called from outside the normal flush, redirect to 'index.php'
     */
    $_SESSION['notification'] = _("Unable to load the required page");
    header ("Location: index.php");
    
}

/*
 * user options are read from POST and stored in $_SESSION.
 */

// default genre for lovers:
$defaultGenre = filter_input(INPUT_POST, "defaultGenre", FILTER_VALIDATE_INT);
$_SESSION['userOptions']['defaultGenre'] = $defaultGenre;

// description fields:

$descr1 =
    filter_input(INPUT_POST, "descr1", FILTER_SANITIZE_STRING);
$_SESSION['userOptions']['descr1'] = $descr1;

$descr2 =
    filter_input(INPUT_POST, "descr2", FILTER_SANITIZE_STRING);
$_SESSION['userOptions']['descr2'] = $descr2;

$descr3 =
    filter_input(INPUT_POST, "descr3", FILTER_SANITIZE_STRING);
$_SESSION['userOptions']['descr3'] = $descr3;

$descr4 =
    filter_input(INPUT_POST, "descr4", FILTER_SANITIZE_STRING);
$_SESSION['userOptions']['descr4'] = $descr4;

/*
 * navigation options are read from POST and stored in $_SESSION.
 */


// GUI language:
$GUILang = filter_input(INPUT_POST, "GUILang", FILTER_VALIDATE_INT);
$_SESSION['navOptions']['GUILang'] = $GUILang;

// results per page:
$resultsPerPage = filter_input(INPUT_POST, "resultsPerPage", FILTER_VALIDATE_INT);
$_SESSION['navOptions']['resultsPerPage'] = $resultsPerPage;

// lists order:
$listsOrder = filter_input(INPUT_POST, "listsOrder", FILTER_VALIDATE_INT);
$_SESSION['navOptions']['listsOrder'] = $listsOrder;

// user and navigation options are stored in the DB:
$user->setUserOptions($defaultGenre,
    $descr1, $descr2, $descr3, $descr4);
$user->setNavOptions($GUILang, $resultsPerPage, $listsOrder);

header("Location: index.php");

?>