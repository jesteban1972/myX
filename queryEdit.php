<?php
/**
 * script 'queryEdit.php'.
 * 
 * this is the script used to insert in the DB a query against the DB
 * giving a name and a description to it.
 * 
 * @author Joaquin Javier ESTEBAN MARTINEZ <jesteban1972@me.com>
 * last updated 2018-05-30
*/

require_once 'session.inc';
//require_once 'core.inc';
//require_once 'DB.inc';
//require_once 'praxis.inc';
//require_once 'amor.inc';
//require_once 'locus.inc';

if ($_SERVER['REQUEST_METHOD'] !== "POST") {
    /*
     * script called from outside the normal flush, throw exception
     */
    header ("Location: index.php");
    
}
    
$title = _("Edit query");
//$js = "queryEdit.js"; // needed to validate the form

include 'header.inc'; // header of all the pages of the app
echo "\t\t\t<section> <!-- section {{ -->\n";

// the form is echoed:

echo "\t\t\t\t<form id=\"queryEditForm\"".
    " action=\"queryEditProcess.php\"".
    " method=\"POST\" accept-charset=\"utf-8\">\n";

echo "\t\t\t\t\t<fieldset>\n";
echo "\t\t\t\t\t\t<legend>"._("General data")."</legend>\n";

/*
 * the queryString is presented to the user as received from $_GET.
 * 
 * TODO it should be rewritten to hide the user part.
 */
echo "\t\t\t\t\t\t\t<p class=\"medium\">".$_POST['queryString']."</p>\n";
echo "\t\t\t\t\t\t\t<input type=\"text\" name=\"queryString\" value=\"".
    $_POST['queryString']."\" style=\"display: none;\" />\n";

// name:
echo "\t\t\t\t\t\t\t<label for=\"name\">"._("Name").":</label>\n";
echo "\t\t\t\t\t\t\t<input id=\"name\" type=\"text\" name=\"name\"".
    " style=\"width: 80%\" /><br />\n";
echo "\t\t\t\t\t\t</fieldset><!-- general data -->\n";


// description:
echo "\t\t\t\t\t<div id=\"descr\">\n";
echo "\t\t\t\t\t\t<fieldset>\n";
echo "\t\t\t\t\t\t\t<legend>"._("Description")."</legend>\n";
echo "\t\t\t\t\t\t\t<textarea id=\"descrTxt\" name=\"descr\"".
    " style=\"width: 100%; height: 200px;\">";
echo "</textarea>\n";
echo "\t\t\t\t\t\t</fieldset><!-- description -->\n";
echo "\t\t\t\t\t</div>\n";

// form footer:
echo "\t\t\t\t\t<input type=\"submit\" value=\""._("Submit data")."\" />\n";
echo "\t\t\t\t\t<input type=\"button\" name=\"cancel\" value=\""._("Cancel").
    "\" onclick=\"javascript: history.back();\" />\n";
echo "\t\t\t\t</form>\n";

echo "\t\t\t</section> <!-- }} section -->\n\n";
require_once 'footer.inc'; // footer of all the pages of the app

?>