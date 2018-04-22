<?php

/* 
 * userSignUp.php
 * sign up PHP file of myX
 * (c) Joaquin Javier ESTEBAN MARTINEZ
 * last update: 2018-04-10
 */

//session_start(); // the session is initiated NOT NEEDED

require_once 'user.inc'; // script used to manage user access

$title = "myX sign up";
$description = "Sign up form in myX";
$js = "userSignUp.js";

require_once 'header.inc'; // header of all the pages of the app
echo "\t\t\t<section><!-- section {{ -->\n";

echo <<<HTML
                <article id="start">

HTML;

// the form is echoed:

/*
 * tooltips shoud be used to explain the meaning of the fields.
 */

echo "\t\t\t\t\t<form id=\"userSignUpForm\" action=\"userSignUpProcess.php\"".
    " method=\"POST\" accept-charset=\"utf-8\">\n";

// user data:

echo "\t\t\t\t\t\t<fieldset>\n";
echo "\t\t\t\t\t\t\t<legend>"._("User data (all fields required)").
    "</legend>\n";

// username:

/*
 * username must be unique in the DB.
 * as the potential user types the wished username, the DB is queried
 * to inform him/her about the availability of the user name.
 */

echo "\t\t\t\t\t\t\t<label for=\"username\">"._("Username:")."</label>\n";
echo "\t\t\t\t\t\t\t<input id=\"username\" name=\"username\"".
    " type=\"text\" required=\"required\" />\n";
echo "\t\t\t\t\t\t\t<div id=\"usernameAvailability\"".
    " style=\"display: inline; visibility: hidden;\"></div>";
echo "<br />\n";

// password (and confirmation):
echo "\t\t\t\t\t\t\t<label for=\"password1\">"._("Password:")."</label>\n";
echo "\t\t\t\t\t\t\t<input id=\"password1\" name=\"password1\"".
    " type=\"password\" required=\"required\" /><br />\n";
echo "\t\t\t\t\t\t\t<label for=\"password2\">".
    _("Confirm password:")."</label>\n";
echo "\t\t\t\t\t\t\t<input id=\"password2\" name=\"password2\"".
    " type=\"password\" required=\"required\" />\n";
echo "\t\t\t\t\t\t\t<div id=\"passwordMessage\"".
    " style=\"display: inline; color: red; visibility: hidden;\"></div>";
echo "<br />\n";

// email:
echo "\t\t\t\t\t\t\t<label for=\"email\">"._("Email:")."</label>\n";
echo "\t\t\t\t\t\t\t<input id=\"email\" name=\"email\" type=\"email\"".
    " required=\"required\" /><br />\n";

// birthdate:
echo "\t\t\t\t\t\t\t<label for=\"birthdate\">"._("Birthdate:")."</label>\n";
echo "\t\t\t\t\t\t\t<input type=\"date\" name=\"birthdate\"".
    " pattern=\"[0-9]{4}-[0-9]{2}-[0-9]{2}\" />\n";

echo "\t\t\t\t\t\t</fieldset>\n";

// user options:

echo "\t\t\t\t\t\t<fieldset>\n";
echo "\t\t\t\t\t\t\t<legend>"._("User options")."</legend>\n";

echo "\t\t\t\t\t\t\t<label for=\"defaultGenre\">".
    _("Default lover's genre:").
    "</label>\n";
echo "\t\t\t\t\t\t\t<select name=\"defaultGenre\">\n";
echo "\t\t\t\t\t\t\t\t<option value=\"".
    GENRE_MASCULINE."\">"._("Man")."</option>\n";
echo "\t\t\t\t\t\t\t\t<option value=\"".
    GENRE_FEMININE."\">"._("Woman")."</option>\n";
echo "\t\t\t\t\t\t\t</select><br />\n";

// custom meaning for description fields:
echo "\t\t\t\t\t\t\t<fieldset>\n";
echo "\t\t\t\t\t\t\t\t<legend>"._("Custom meaning of description fields").
    "</legend>\n";
echo "\t\t\t\t\t\t\t\t<label for=\"descr1\">".
    _("Description 1:")."</label>\n";
echo "\t\t\t\t\t\t\t\t<input name=\"descr1\" type=\"text\" size=\"100\" /><br />\n";
echo "\t\t\t\t\t\t\t\t<label for=\"descr2\">".
    _("Description 2:")."</label>\n";
echo "\t\t\t\t\t\t\t\t<input name=\"descr2\" type=\"text\" size=\"100\" /><br />\n";
echo "\t\t\t\t\t\t\t\t<label for=\"descr3\">".
    _("Description 3:")."</label>\n";
echo "\t\t\t\t\t\t\t\t<input name=\"descr3\" type=\"text\" size=\"100\" /><br />\n";
echo "\t\t\t\t\t\t\t\t<label for=\"descr4\">".
    _("Description 4:")."</label>\n";
echo "\t\t\t\t\t\t\t\t<input name=\"descr4\" type=\"text\" size=\"100\" /><br />\n";
echo "\t\t\t\t\t\t\t</fieldset>\n";

echo "\t\t\t\t\t\t</fieldset>\n";

// navigation options (GUI language, results per page, lists order):

echo "\t\t\t\t\t\t<fieldset>\n";
echo "\t\t\t\t\t\t\t<legend>"._("Navigation options")."</legend>\n";

echo "\t\t\t\t\t\t\t<label for=\"GUILang\">".
    _("GUI language:").
    "</label>\n";
echo "\t\t\t\t\t\t\t<select name=\"GUILang\">\n";
echo "\t\t\t\t\t\t\t\t<option value=\"".GUI_ENGLISH."\">English</option>\n";
echo "\t\t\t\t\t\t\t\t<option value=\"".GUI_SPANISH."\">Español</option>\n";
echo "\t\t\t\t\t\t\t\t<option value=\"".GUI_GREEK."\">Ελληνικά</option>\n";
echo "\t\t\t\t\t\t\t</select><br />\n";

echo "\t\t\t\t\t\t\t<label for=\"resultsPerPage\">".
    _("Results per page:")."</label>\n";
echo "\t\t\t\t\t\t\t<input name=\"resultsPerPage\" type=\"number\"".
    " value=\"25\" /><br />\n";
echo "\t\t\t\t\t\t\t<label for=\"listsOrder\">".
    _("Lists order:")."</label>\n";
echo "\t\t\t\t\t\t\t<select name=\"listsOrder\">\n";
echo "\t\t\t\t\t\t\t\t<option value=\"1\">"._("From oldest to newest").
    "</option>\n";
echo "\t\t\t\t\t\t\t\t<option value=\"2\">"._("From newest to oldest").
    "</option>\n";
echo "\t\t\t\t\t\t\t</select>\n";

echo "\t\t\t\t\t\t</fieldset>\n";

echo "\t\t\t\t\t\t<input type=\"submit\" value=\""._("Submit data")."\" />\n";
echo "\t\t\t\t\t\t<input type=\"button\" name=\"cancel\" value=\"".
        _("Cancel")."\" onclick=\"javascript: history.back();\" />\n";
echo "\t\t\t\t\t</form>\n";

echo <<<HTML
                </article>

HTML;

echo "\t\t\t</section><!-- }} section -->\n\n";
require_once 'footer.inc'; // footer of all the pages of the app

?>