<?php
/**
 * script 'queryEdit.php'.
 * 
 * this is the script used to insert in the DB a query against the DB
 * giving a name and a description to it.
 * 
 * @author Joaquin Javier ESTEBAN MARTINEZ <jesteban1972@me.com>
 * last updated 2018-05-27
*/

require_once 'session.inc';
//require_once 'core.inc';
//require_once 'DB.inc';
//require_once 'praxis.inc';
//require_once 'amor.inc';
//require_once 'locus.inc';

if ($_SERVER['REQUEST_METHOD'] !== "GET") {
    /*
     * script called from outside the normal flush, throw exception
     */
    header ("Location: index.php");
    
}

// locusEdit is set and eventually an object of class 'Locus' instantiated:
//if (isset($_GET['locusID'])) { // script called from 'locus.php'
//
//    $locusEdit = true;
//    $locus = new Locus(intval($_GET['locusID']));
//    $tempPraxis = false;
//
//} else { // script called from 'loca.php' or from 'praxisEdit.php'
//
//    $locusEdit = false;
//    if (isset($_GET['tempPraxis'])) {
//        
//        $tempPraxis = true;
//        $tempLocus = true;
//        
//    }
//        
//}
    
// get a DB connection to work with:
//$pdo = DB::getDBHandle();
    
//$title = $locusEdit ? _("Edit place") : _("New place");
$title = _("Edit query");
//$js = "locusEdit.js";

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
echo "\t\t\t\t\t\t\t<p class=\"medium\">".$_GET['queryString']."</p>\n";
echo "\t\t\t\t\t\t\t<input type=\"text\" name=\"queryString\" value=\"".
    /*urldecode*/($_GET['queryString'])."\" style=\"display: visible;\" />\n";// hidden

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
//if ($locusEdit)
//    echo $locus->getDescr();
//else if ($tempLocus && $_SESSION['tempLocusData']['descr'] !== "")
//    echo $_SESSION['tempLocusData']['descr'];
echo "</textarea>\n";
echo "\t\t\t\t\t\t</fieldset><!-- description -->\n";
echo "\t\t\t\t\t</div>\n";

// form footer:

if ($locusEdit)
    echo "\t\t\t\t\t<input type=\"hidden\" name=\"locusID\" value=\"".
        $locus->getLocusID()."\" />\n";
if ($tempPraxis)
    echo "\t\t\t\t\t<input id=\"tempPraxis\" type=\"hidden\" />\n";

echo "\t\t\t\t\t<input type=\"submit\" value=\""._("Submit data")."\" />\n";
echo "\t\t\t\t\t<input type=\"button\" name=\"cancel\" value=\""._("Cancel").
    "\" onclick=\"javascript: history.back();\" />\n";
echo "\t\t\t\t</form>\n";

echo "\t\t\t</section> <!-- }} section -->\n\n";
require_once 'footer.inc'; // footer of all the pages of the app

?>