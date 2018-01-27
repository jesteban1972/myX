<?php

/* 
 * userSignUp.php
 * sign up PHP file of myX
 * (c) Joaquin Javier ESTEBAN MARTINEZ
 * last update: 2017-11-05
 */

//session_start(); // the session is initiated NOT NEEDED

require_once 'user.inc'; // script used to manage user access

$title = "myX sign up";
$description = "Sign up form in myX";

require_once 'header.inc'; // header of all the pages of the app
echo "\t\t\t<section><!-- section {{ -->\n";

echo <<<HTML
                <article id="start">

HTML;

// the form is echoed:

echo "\t\t\t\t\t<form action=\"userSignUpProcess.php\" method=\"POST\" accept-charset=\"utf-8\">\n";

// general data:
echo "\t\t\t\t\t\t<fieldset>\n";
echo "\t\t\t\t\t\t\t<legend>"._("User data")."</legend>\n";
echo "\t\t\t\t\t\t\t<label for=\"username\">"._("Username:")."</label><br />\n";
echo "\t\t\t\t\t\t\t<input type=\"text\" name=\"username\" value=\"".
    $_POST['username'].
    "\" required=\"required\" /><br />\n";
echo "\t\t\t\t\t\t\t<label for=\"password1\">"._("Password:")."</label><br />\n";
echo "\t\t\t\t\t\t\t<input type=\"password\" name=\"password1\" value=\"".
    $_POST['password1'].
    "\" required=\"required\" /><br />\n";
echo "\t\t\t\t\t\t\t<label for=\"password2\">".
    _("Confirm password:")."</label><br />\n";
echo "\t\t\t\t\t\t\t<input type=\"text\" name=\"password2\" value=\"".
    $_POST['password2'].
    "\" required=\"required\" /><br />\n";
echo "\t\t\t\t\t\t\t<label for=\"email\">"._("Email:")."</label><br />\n";
echo "\t\t\t\t\t\t\t<input type=\"email\" name=\"email\" value=\"".
    $_POST['email'].
    "\" required=\"required\" /><br />\n";
echo "\t\t\t\t\t\t</fieldset>\n";

// user data:
echo "\t\t\t\t\t\t<fieldset>\n";
echo "\t\t\t\t\t\t\t<legend>"._("User data")."</legend>\n";
echo "\t\t\t\t\t\t\t<label for=\"birthDate\">"._("Birthdate")."</label>\n";
echo "\t\t\t\t\t\t\t<input type=\"date\" name=\"birthDate\" />\n";
echo "\t\t\t\t\t\t\t<label for=\"defaultGenre\">".
    _("Default lover's genre:").
    "</label>\n";
echo "\t\t\t\t\t\t\t<select name=\"defaultGenre\">\n";
echo "\t\t\t\t\t\t\t\t<option value=\"".
    GENRE_MASCULINE."\">"._("Man")."</option>\n";
echo "\t\t\t\t\t\t\t\t<option value=\"".
    GENRE_FEMININE."\">"._("Woman")."</option>\n";
echo "\t\t\t\t\t\t\t</select>\n";
echo "\t\t\t\t\t\t</fieldset>\n";

echo "\t\t\t\t\t\t<input type=\"submit\" value=\""._("Submit data")."\" />\n";
echo "\t\t\t\t\t\t<input type=\"button\" name=\"cancel\" value=\"".
        _("Cancel").
        "\" onclick=\"javascript: history.back();\" />\n";
echo "\t\t\t\t\t</form>\n";

echo <<<HTML
                </article>

HTML;

echo "\t\t\t</section><!-- }} section -->\n\n";
require_once 'footer.inc'; // footer of all the pages of the app

?>