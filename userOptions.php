<?php

/* 
 * userOptions.php
 * script to process user options
 * (c) Joaquin Javier ESTEBAN MARTINEZ
 * last update: 2018-01-05
 */

require_once 'core.inc';
//require_once 'session.inc';
//require_once 'user.inc';
//require_once 'exceptions.inc';

$title = _("User options");
$description = _("User customizable options of myX");


require_once 'header.inc';
echo "\t\t\t<section> <!-- section {{ -->\n";


echo <<<HTML
                <form action="userOptionsProcess.php" method="POST">
                    <fieldset>

HTML;

echo "\t\t\t\t\t\t<legend>"._("Navigation options")."</legend>\n";

// GUI language:

echo "\t\t\t\t\t\t<label for=\"GUILang\">"._("GUI language:")."</label>\n";
echo "\t\t\t\t\t\t<select name=\"GUILang\">\n";

// English:
echo "\t\t\t\t\t\t\t<option value=\"1\"";
if ($_SESSION['options']['GUILang'] === GUI_ENGLISH)
    echo " selected=\"selected\"";
echo ">English</option>\n";

// Spanish:
echo "\t\t\t\t\t\t\t<option value=\"2\"";
if ($_SESSION['options']['GUILang'] === GUI_SPANISH)
    echo " selected=\"selected\"";
echo ">Español</option>\n";

// Greek:
echo "\t\t\t\t\t\t\t<option value=\"3\"";
if ($_SESSION['options']['GUILang'] === GUI_GREEK)
    echo " selected=\"selected\"";
echo ">Ελληνικά</option>\n";

echo "\t\t\t\t\t\t</select><br />\n";

echo "\t\t\t\t\t\t<label for=\"resultsPerPage\">".
    _("Results per page:").
    "</label>\n";
echo "\t\t\t\t\t\t<input type=\"number\" name=\"resultsPerPage\" value=\"".
    $_SESSION['options']['resultsPerPage'].
    "\" />\n";
echo "\t\t\t\t\t</fieldset>\n";

// form footer:
echo "\t\t\t\t\t<input type=\"submit\" value=\""._("Save options")."\" />\n";
echo "\t\t\t\t\t<input type=\"button\" value=\"".
    _("Discard changes").
    "\" onclick=\"javascript: history.back();\" />\n";
echo "\t\t\t\t</form>\n";

echo "\t\t\t</section> <!-- }} section -->\n\n";
require_once 'footer.inc';

?>