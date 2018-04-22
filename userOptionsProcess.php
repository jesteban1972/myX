<?php
/** 
 * script 'userOptionsProcess.php'.
 * 
 * script to process user's options
 * (c) Joaquin Javier ESTEBAN MARTINEZ
 * last update: 2018-03-24
 */

require_once 'session.inc';
require_once 'DB.inc';
require_once 'user.inc';

// get a DB connection to work with:
$pdo = DB::getDBHandle();

$user = new User($_SESSION['userID']); // TODO: non necessary!

/*
 * when user options and/or navigation options are set/modified
 * using the form in 'userOptions.php',
 * their values are store in both $_SESSION, $_COOKIE,
 * as well in the DB.
 * when loading the next page the page's header will retrieve the values
 * directly from $_SESSION.
 */

// user options:

// default genre for lovers:

$defaultGenre = filter_input(INPUT_POST, "defaultGenre", FILTER_VALIDATE_INT);
$_SESSION['userOptions']['defaultGenre'] = $defaultGenre;
//setcookie("userOptions[defaultGenre]", $defaultGenre, time() + 3600);

// description fields:

$descr1 =
    filter_input(INPUT_POST, "descr1", FILTER_SANITIZE_STRING);
$_SESSION['userOptions']['descr1'] = $descr1;
//setcookie("userOptions[descr1]", $descr1, time() + 3600);

$descr2 =
    filter_input(INPUT_POST, "descr2", FILTER_SANITIZE_STRING);
$_SESSION['userOptions']['descr2'] = $descr2;
//setcookie("userOptions[descr2]", $descr2, time() + 3600);

$descr3 =
    filter_input(INPUT_POST, "descr3", FILTER_SANITIZE_STRING);
$_SESSION['userOptions']['descr3'] = $descr3;
//setcookie("userOptions[descr3]", $descr3, time() + 3600);

$descr4 =
    filter_input(INPUT_POST, "descr4", FILTER_SANITIZE_STRING);
$_SESSION['userOptions']['descr4'] = $descr4;
//setcookie("userOptions[descr4]", $descr4, time() + 3600);

// user options are stored in the DB:
$user->setUserOptions($defaultGenre,
    $descr1, $descr2, $descr3, $descr4);

// navigation options:

// GUI language:
$GUILang = filter_input(INPUT_POST, "GUILang", FILTER_VALIDATE_INT);
$_SESSION['navigationOptions']['GUILang'] = $GUILang;
//setcookie("userOptions[GUILang]", $GUILang, time() + 3600);

// results per page:
$resultsPerPage = filter_input(INPUT_POST, "resultsPerPage", FILTER_VALIDATE_INT);
$_SESSION['navigationOptions']['resultsPerPage'] = $resultsPerPage;
//setcookie("userOptions[resultsPerPage]", $resultsPerPage, time() + 3600);

// lists order:
$listsOrder = filter_input(INPUT_POST, "listsOrder", FILTER_VALIDATE_INT);
$_SESSION['navigationOptions']['listsOrder'] = $listsOrder;
//setcookie("userOptions[listsOrder]", $listsOrder, time() + 3600);

// navigation options are stored in the DB:
$user->setNavigationOptions($GUILang, $resultsPerPage, $listsOrder);

header("Location: index.php");

?>