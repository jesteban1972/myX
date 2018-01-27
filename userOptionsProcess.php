<?php

/* 
 * userOptionsProcess.php
 * script to process user's options
 * (c) Joaquin Javier ESTEBAN MARTINEZ
 * last update: 2018-01-13
 */

require_once 'session.inc';
require_once 'user.inc';

// GUI language:
$GUILang = filter_input(INPUT_POST, "GUILang", FILTER_VALIDATE_INT);
$_SESSION['options']['GUILang'] = $GUILang;
setcookie("userOptions[GUILang]", $GUILang, time() + 3600);

// results per page:
$resultsPerPage = filter_input(INPUT_POST, "resultsPerPage", FILTER_VALIDATE_INT);
$_SESSION['options']['resultsPerPage'] = $resultsPerPage;
setcookie("userOptions[resultsPerPage]", $resultsPerPage, time() + 3600);

header("Location: index.php");

?>