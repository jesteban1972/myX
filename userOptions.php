<?php

/* 
 * userOptions.php
 * script to process user options
 * (c) Joaquin Javier ESTEBAN MARTINEZ
 * last update: 2018-03-24
 */

require_once 'core.inc';
//require_once 'session.inc';
require_once 'user.inc';
//require_once 'exceptions.inc';

$title = _("User options");
$description = _("User customizable options of myX");


require_once 'header.inc';
echo "\t\t\t<section> <!-- section {{ -->\n";


echo "\t\t\t\t<form action=\"userOptionsProcess.php\" method=\"POST\">\n";

// user options:

// get userOptions from the DB:
$userOptions = User::getUserOptions();

echo "\t\t\t\t\t<fieldset>\n";
echo "\t\t\t\t\t\t<legend>"._("User options")."</legend>\n";

// default genre for lovers:

echo "\t\t\t\t\t\t<label for=\"defaultGenre\">"._("Default genre for lovers:").
    "</label>\n";
echo "\t\t\t\t\t\t<select name=\"defaultGenre\">\n";

echo "\t\t\t\t\t\t\t<option value=\"".GENRE_MASCULINE."\"";
if (($userOptions['defaultGenre'] !== null) &&
    $userOptions['defaultGenre'] === GENRE_MASCULINE)
        echo " selected=\"selected\"";
echo ">"._("Man")."</option>\n";

echo "\t\t\t\t\t\t\t<option value=\"".GENRE_FEMININE."\"";
if (($userOptions['defaultGenre'] !== null) &&
    $userOptions['defaultGenre'] === GENRE_FEMININE)
        echo " selected=\"selected\"";
echo ">"._("Woman")."</option>\n";

echo "\t\t\t\t\t\t</select><br />\n";

// description fields:

echo "\t\t\t\t\t\t<fieldset>\n";
echo "\t\t\t\t\t\t\t<legend>"._("Custom meaning of description fields").
    "</legend>\n";

echo "\t\t\t\t\t\t\t<label for=\"descr1\">"._("Description 1:").
    "</label><br />\n";
echo "\t\t\t\t\t\t\t<input type=\"text\" name=\"descr1\" size=\"100\" value=\"";
if ($userOptions['descr1'] !== "")
    echo $userOptions['descr1'];
echo "\" />\n";
    
echo "\t\t\t\t\t\t\t<label for=\"descr2\">"._("Description 2:").
    "</label><br />\n";
echo "\t\t\t\t\t\t\t<input type=\"text\" name=\"descr2\" size=\"100\" value=\"";
if ($userOptions['descr2'] !== "")
    echo $userOptions['descr2'];
echo "\" />\n";

echo "\t\t\t\t\t\t\t<label for=\"descr3\">"._("Description 3:").
    "</label><br />\n";
echo "\t\t\t\t\t\t\t<input type=\"text\" name=\"descr3\" size=\"100\" value=\"";
if ($userOptions['descr3'] !== "")
    echo $userOptions['descr3'];
echo "\" />\n";

echo "\t\t\t\t\t\t\t<label for=\"descr4\">"._("Description 4:").
    "</label><br />\n";
echo "\t\t\t\t\t\t\t<input type=\"text\" name=\"descr4\" size=\"100\" value=\"";
if ($userOptions['descr4'] !== "")
    echo $userOptions['descr4'];
echo "\" />\n";

echo "\t\t\t\t\t</fieldset>\n";

echo "\t\t\t\t\t</fieldset>\n";

// navigation options:

$navigationOptions = User::getNavigationOptions();

echo "\t\t\t\t\t<fieldset>\n";
echo "\t\t\t\t\t\t<legend>"._("Navigation options")."</legend>\n";

// GUI language:

echo "\t\t\t\t\t\t<label for=\"GUILang\">"._("GUI language:")."</label>\n";
echo "\t\t\t\t\t\t<select name=\"GUILang\">\n";

// English:
echo "\t\t\t\t\t\t\t<option value=\"1\"";
if ($_SESSION['navigationOptions']['GUILang'] === GUI_ENGLISH)
    echo " selected=\"selected\"";
echo ">English</option>\n";

// Spanish:
echo "\t\t\t\t\t\t\t<option value=\"2\"";
if ($_SESSION['navigationOptions']['GUILang'] === GUI_SPANISH)
    echo " selected=\"selected\"";
echo ">Español</option>\n";

// Greek:
echo "\t\t\t\t\t\t\t<option value=\"3\"";
if ($_SESSION['navigationOptions']['GUILang'] === GUI_GREEK)
    echo " selected=\"selected\"";
echo ">Ελληνικά</option>\n";

echo "\t\t\t\t\t\t</select><br />\n";

// results per page:
echo "\t\t\t\t\t\t<label for=\"resultsPerPage\">".
    _("Results per page:").
    "</label>\n";
echo "\t\t\t\t\t\t<input type=\"number\" name=\"resultsPerPage\" value=\"";
if ($navigationOptions['resultsPerPage'] !== null)
    echo $navigationOptions['resultsPerPage'];
echo "\" /><br />\n";

// lists order:
echo "\t\t\t\t\t\t<label for=\"listsOrder\">"._("Lists order:")."</label>\n";
echo "\t\t\t\t\t\t<select name=\"listsOrder\">\n";

echo "\t\t\t\t\t\t\t<option value=\"1\"";

if ($_SESSION['navigationOptions']['listsOrder'] === OLDEST_TO_NEWEST)
    echo " selected=\"selected\"";
echo ">"._("From oldest to newest")."</option>\n";

echo "\t\t\t\t\t\t\t<option value=\"2\"";
if ($_SESSION['navigationOptions']['listsOrder'] === NEWEST_TO_OLDEST)
    echo " selected=\"selected\"";
echo ">"._("From newest to oldest")."</option>\n";

echo "\t\t\t\t\t\t</select><br />\n";

echo "\t\t\t\t\t</fieldset>\n";

// form footer:
echo "\t\t\t\t\t<input type=\"submit\" value=\""._("Save options")."\" />\n";
echo "\t\t\t\t\t<input type=\"button\" value=\"".
    _("Discard changes").
    "\" onclick=\"javascript: history.back();\" />\n";
echo "\t\t\t\t</form>\n";

// delete user form:

/*
 * the delete user form is put separatedly
 * the reason of this is that this independent action
 * should not undertake by the user
 */
echo "\t\t\t\t<form action=\"userDelete.php\" method=\"POST\">\n";
//echo "\t\t\t\t\t\t<input type=\"hidden\" name=\"praxisID\" value=\"".
//    $praxis->getPraxisID().
//    "\" />\n";
echo "\t\t\t\t\t<input type=\"submit\" value=\"".
    _("Delete user").
    "\" />\n";
echo "\t\t\t\t</form>\n";

echo "\t\t\t</section> <!-- }} section -->\n\n";
require_once 'footer.inc';

?>