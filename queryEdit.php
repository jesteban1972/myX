<?php
/**
 * script 'queryEdit.php'.
 * 
 * this is the script used to insert in the DB a query against the DB
 * giving a name and a description to it.
 * 
 * @author Joaquin Javier ESTEBAN MARTINEZ <jesteban1972@me.com>
 * last updated 2018-06-09
*/

require_once 'session.inc';
//require_once 'core.inc';
//require_once 'DB.inc';
//require_once 'praxis.inc';
//require_once 'amor.inc';
//require_once 'locus.inc';

if ($_SERVER['REQUEST_METHOD'] !== "POST") {
    /*
     * script called from outside the normal flush, redirect to 'index.php'
     */
    $_SESSION['notification'] = _("Unable to load the required page");
    header ("Location: index.php");
    
}
    
$title = _("Edit query");
$js = "queryEdit.js";

include 'header.inc'; // header of all the pages of the app
echo "\t\t\t<section> <!-- section {{ -->\n";

// the form is echoed:

echo "\t\t\t\t<form id=\"queryEditForm\"".
    " action=\"queryEditProcess.php\"".
    " method=\"POST\" accept-charset=\"utf-8\">\n";

echo "\t\t\t\t\t<fieldset>\n";
echo "\t\t\t\t\t\t<legend>"._("General data")."</legend>\n";

echo "\t\t\t\t\t\t\t<input type=\"hidden\" name=\"queryString\" value=\"".
    $_POST['queryString']."\" />\n";

// name:
echo "\t\t\t\t\t\t\t<label for=\"name\">"._("Name").":<sup>*</sup></label>\n";
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
echo "\t\t\t\t\t<p><sup>*</sup>"._("compulsory fields")."</p>\n";
echo "\t\t\t\t\t<input type=\"submit\" value=\""._("Submit data")."\" />\n";
echo "\t\t\t\t\t<input type=\"button\" name=\"cancel\" value=\""._("Cancel").
    "\" onclick=\"javascript: history.back();\" />\n";
echo "\t\t\t\t</form>\n";

echo "\t\t\t</section> <!-- }} section -->\n\n";
require_once 'footer.inc'; // footer of all the pages of the app

?>