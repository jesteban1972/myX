<?php
/**
 * script 'locusEdit.php'.
 * 
 * this is the script used for both adding a new place
 * or to edit an existing one.
 * the value of $_GET['locusID'] is used to differentiate both scenarios:
 * if the variable is set, the flag $locusEdit is set to true
 * and a Locus object is instantiated to work with;
 * otherwise $locusEdit is set to false.
 * this script echoes a form whose fields correspond with those of the table
 * 'loca'.
 * 
 * @author Joaquin Javier ESTEBAN MARTINEZ <jesteban1972@me.com>
 * last updated 2018-04-24
*/

require_once 'session.inc';
//require_once 'core.inc';
require_once 'DB.inc';
//require_once 'praxis.inc';
//require_once 'amor.inc';
require_once 'locus.inc';

if ($_SERVER['REQUEST_METHOD'] !== "GET") {
    /*
     * script called from outside the normal flush, throw exception
     */
    header ("Location: index.php");
    
}

// locusEdit is set and eventually an object of class 'Locus' instantiated:
if (isset($_GET['locusID'])) { // script called from 'locus.php'

    $locusEdit = true;
    $locus = new Locus(intval($_GET['locusID']));
    $tempPraxis = false;

} else { // script called from 'loca.php' or from 'praxisEdit.php'

    $locusEdit = false;
    if (isset($_GET['tempPraxis'])) {
        
        $tempPraxis = true;
        $tempLocus = true;
        
    }
        
}
    
// get a DB connection to work with:
$pdo = DB::getDBHandle();
    
$title = $locusEdit ? _("Edit place") : _("New place");
$js = "locusEdit.js";

include 'header.inc'; // header of all the pages of the app
echo "\t\t\t<section> <!-- section {{ -->\n";

// the form is echoed:

echo "\t\t\t\t<form id=\"locusEditForm\" action=\"";
echo $tempPraxis ?
    "praxisEdit.php?praxisID=".$_SESSION['tempPraxis']['praxisID'] :
    "locusEditProcess.php";
echo "\" method=\"POST\" accept-charset=\"utf-8\">\n";

echo "\t\t\t\t\t<fieldset>\n";
echo "\t\t\t\t\t\t<legend>"._("General data")."</legend>\n";

// achtung:
echo "\t\t\t\t\t\t\t<label for=\"achtung\" style=\"visibility: hidden;\">"._("Achtung").":</label>\n";
echo "\t\t\t\t\t\t\t<input id=\"achtung\" type=\"text\" name=\"achtung\" value=\"";
if ($locusEdit)
    echo $locus->getAchtung();
else if ($tempLocus && $_SESSION['tempLocusData']['achtung'] !== "")
    echo $_SESSION['tempLocusData']['achtung'];
echo "\" style=\"visibility: hidden; width: 80%\" /><br />\n";

// name:
echo "\t\t\t\t\t\t\t<label for=\"name\">"._("Name").":</label>\n";
echo "\t\t\t\t\t\t\t<input id=\"name\" type=\"text\" name=\"name\" value=\"";
if ($locusEdit)
    echo $locus->getName();
else if ($tempLocus && $_SESSION['tempLocusData']['name'] !== "")
    echo $_SESSION['tempLocusData']['name'];
echo "\" style=\"width: 80%\" /><br />\n";

// rating:

echo "\t\t\t\t\t\t\t<label for=\"rating\">"._("Rating").":</label>\n";
echo "\t\t\t\t\t\t\t<select id=\"rating\" name=\"rating\">\n";

echo "\t\t\t\t\t\t\t\t<option value=\"0\"";
if (($locusEdit && ($locus->getRating() === 0)) ||
    ($tempLocus && ($_SESSION['tempLocusData']['rating'] === 0)))
    echo " selected=\"selected\"";
echo ">"._("undefined")."</option>\n";

echo "\t\t\t\t\t\t\t\t<option value=\"1\"";
if (($locusEdit && ($locus->getRating() === 1)) ||
    ($tempLocus && ($_SESSION['tempLocusData']['rating'] === 1)))
    echo " selected=\"selected\"";
echo ">"._("very bad")."</option>\n";

echo "\t\t\t\t\t\t\t\t<option value=\"2\"";
if (($locusEdit && ($locus->getRating() === 2)) ||
    ($tempLocus && ($_SESSION['tempLocusData']['rating'] === 2)))
    echo " selected=\"selected\"";
echo ">"._("bad")."</option>\n";

echo "\t\t\t\t\t\t\t\t<option value=\"3\"";
if (($locusEdit && ($locus->getRating() === 3)) ||
    ($tempLocus && ($_SESSION['tempLocusData']['rating'] === 3)))
    echo " selected=\"selected\"";
echo ">"._("good")."</option>\n";

echo "\t\t\t\t\t\t\t\t<option value=\"4\"";
if (($locusEdit && ($locus->getRating() === 4)) ||
    ($tempLocus && ($_SESSION['tempLocusData']['rating'] === 4)))
    echo " selected=\"selected\"";
echo ">"._("very good")."</option>\n";

echo "\t\t\t\t\t\t\t\t<option value=\"5\"";
if (($locusEdit && ($locus->getRating() === 5)) ||
    ($tempLocus && ($_SESSION['tempLocusData']['rating'] === 5)))
    echo " selected=\"selected\"";
echo ">"._("excellent")."</option>\n";

echo "\t\t\t\t\t\t\t</select><br />\n";

// address:
echo "\t\t\t\t\t\t\t<label for=\"name\">"._("Address").":</label>\n";
echo "\t\t\t\t\t\t\t<input id=\"address\" type=\"text\" name=\"address\"".
    " value=\"";
if ($locusEdit)
    echo $locus->getAddress();
else if ($tempPraxis)
    echo $_SESSION['tempLocusData']['address'];
echo "\" style=\"width: 80%\" /><br />\n";

// country (whether existing or new):

echo "\t\t\t\t\t\t\t<fieldset>\n";
echo "\t\t\t\t\t\t\t\t<legend>". _("Country")."</legend>\n";

echo "\t\t\t\t\t\t\t\t<input id=\"countryOriginExisting\" type=\"radio\"".
    " name=\"countryOrigin\"";

/*
 * countryOriginExisting is checked by default in two cases:
 * i) if editing an place, or
 * ii) when new place (with doPracticaExist true):
 */

if ($locusEdit ||
    (!$locusEdit && $_SESSION['DBStatus']['doPracticaExist']))
        echo " checked=\"checked\"";

echo " />\n";
echo "\t\t\t\t\t\t\t\t<label for=\"countryOriginExisting\">".
    _("Existing country").":</label>\n";

echo "\t\t\t\t\t\t\t\t<select name=\"countryID\" id=\"countryID\">\n";

// the existing countries are retrieved from the DB:
$queryString = <<<QUERY
SELECT `countryID`, `name`
FROM `myX`.`countries`
WHERE `user` = :userID
ORDER BY `name`
QUERY;

$statement = $pdo->prepare($queryString);
$statement->bindParam(":userID", $_SESSION['userID'], PDO::PARAM_INT);
$statement->execute();
foreach ($statement as $row) {
    
    echo "\t\t\t\t\t\t\t\t\t<option value=\"".$row['countryID']."\"";
    if ($locusEdit && ($locus->getCountry() === intval($row['countryID'])))
        echo " selected=\"selected\"";
    echo ">".$row['name']."</option>\n";
    
}

echo "\t\t\t\t\t\t\t\t</select><br />\n";

echo "\t\t\t\t\t\t\t\t<input id=\"countryOriginNew\" type=\"radio\"".
    " name=\"countryOrigin\"";

/*
 * countryOriginNew checked by default only when
 * new place and doPracticaExist is false:
 */

if (!$locusEdit && !$_SESSION['DBStatus']['doPracticaExist'])
    echo " checked=\"checked\"";

echo " />\n";
echo "\t\t\t\t\t\t\t\t<label for=\"countryOriginNew\">"._("New country").
    ":</label>\n";
echo "\t\t\t\t\t\t\t\t<input id=\"countryNewTxt\" type=\"text\"".
    " name=\"countryNew\" />\n";
echo "\t\t\t\t\t\t\t\t<button type=\"button\" id=\"countryNew\">".
    _("Add country")."</button>\n";

echo "\t\t\t\t\t\t\t</fieldset>\n";

// kind (whether existing or new):

echo "\t\t\t\t\t\t\t<fieldset>\n";
echo "\t\t\t\t\t\t\t\t<legend>". _("Kind")."</legend>\n";

echo "\t\t\t\t\t\t\t\t<input id=\"kindOriginExisting\" type=\"radio\"".
    " name=\"kindOrigin\"";

/*
 * kindOriginExisting is checked by default in two cases:
 * i) if editing an place, or
 * ii) when new place (with doPracticaExist true):
 */

if ($locusEdit ||
    (!$locusEdit && $_SESSION['DBStatus']['doPracticaExist']))
        echo " checked=\"checked\"";

echo " />\n";
echo "\t\t\t\t\t\t\t\t<label for=\"kindOriginExisting\">"._("Existing kind").
    ":</label>\n";

echo "\t\t\t\t\t\t\t\t<select name=\"kindID\" id=\"kindID\">\n";

// the existing kinds are retrieved from the DB:
$queryString = <<<QUERY
SELECT `kindID`, `name`
FROM `myX`.`kinds`
WHERE `user` = :userID
ORDER BY `name`
QUERY;

$statement = $pdo->prepare($queryString);
$statement->bindParam(":userID", $_SESSION['userID'], PDO::PARAM_INT);
$statement->execute();
foreach ($statement as $row) {
    
    echo "\t\t\t\t\t\t\t\t\t<option value=\"".$row['kindID']."\"";
    if ($locusEdit && ($locus->getKind() === intval($row['kindID'])))
        echo " selected=\"selected\"";
    echo ">".$row['name']."</option>\n";
    
}

echo "\t\t\t\t\t\t\t\t</select><br />\n";

echo "\t\t\t\t\t\t\t\t<input id=\"kindOriginNew\" type=\"radio\"".
    " name=\"kindOrigin\"";

/*
 * countryOriginNew checked by default only when
 * new place and doPracticaExist is false:
 */

if (!$locusEdit && !$_SESSION['DBStatus']['doPracticaExist'])
    echo " checked=\"checked\"";

echo " />\n";
echo "\t\t\t\t\t\t\t\t<label for=\"kindOriginNew\">"._("New kind").
    ":</label>\n";
echo "\t\t\t\t\t\t\t\t<input id=\"kindNewTxt\" type=\"text\"".
    " name=\"kindNew\" />\n";
//echo "\t\t\t\t\t\t\t\t<input type=\"text\" name=\"kindNew\" />\n";
echo "\t\t\t\t\t\t\t\t<button type=\"button\" id=\"kindNew\">".
    _("Add kind")."</button>\n";

echo "\t\t\t\t\t\t\t</fieldset>\n";

echo "\t\t\t\t\t</fieldset>\n";

/*
 * section ii) description.
 */

echo "\t\t\t\t\t<div id=\"descr\">\n";
echo "\t\t\t\t\t\t<fieldset>\n";
echo "\t\t\t\t\t\t\t<legend>"._("Description")."</legend>\n";
echo "\t\t\t\t\t\t\t<textarea id=\"descrTxt\" name=\"descr\"".
    " style=\"width: 100%; height: 200px;\">";
if ($locusEdit)
    echo $locus->getDescr();
else if ($tempLocus && $_SESSION['tempLocusData']['descr'] !== "")
    echo $_SESSION['tempLocusData']['descr'];
echo "</textarea>\n";
echo "\t\t\t\t\t\t</fieldset><!-- description -->\n";
echo "\t\t\t\t\t</div>\n";

echo "\t\t\t\t\t<fieldset>\n";
echo "\t\t\t\t\t\t<legend>"._("Other data")."</legend>\n";

// exact coordinates:
echo "\t\t\t\t\t\t\t<label for=\"coordExact\">"._("Exact coordinates").
    ":</label>\n";
echo "\t\t\t\t\t\t\t<input id=\"coordExact\" type=\"text\" name=\"coordExact\"".
    " value=\"";
if ($locusEdit)
    echo $locus->getCoordExact();
else if ($tempLocus && $_SESSION['tempLocusData']['coordExact'] !== "")
    echo $_SESSION['tempLocusData']['coordExact'];
echo "\" /><br />\n";

// generic coordinates:
echo "\t\t\t\t\t\t\t<label for=\"coordGeneric\">"._("Generic coordinates").
    ":</label>\n";
echo "\t\t\t\t\t\t\t<input id=\"coordGeneric\" type=\"text\"".
    " name=\"coordGeneric\" value=\"";
if ($locusEdit)
    echo $locus->getCoordGeneric();
else if ($tempLocus && $_SESSION['tempLocusData']['coordGeneric'] !== "")
    echo $_SESSION['tempLocusData']['coordGeneric'];
echo "\" /><br />\n";

// web:
echo "\t\t\t\t\t\t\t<label for=\"web\">"._("Web").":</label>\n";
echo "\t\t\t\t\t\t\t<input id=\"web\" type=\"text\" name=\"web\" value=\"";
if ($locusEdit)
    echo $locus->getWeb();
else if ($tempLocus && $_SESSION['tempLocusData']['web'] !== "")
    echo $_SESSION['tempLocusData']['web'];
echo "\" style=\"width: 80%\" /><br />\n";

echo "\t\t\t\t\t</fieldset>\n";

// form footer:

if ($locusEdit) {
    
    echo "\t\t\t\t\t<input type=\"hidden\" name=\"locusID\" value=\"".
        $locus->getLocusID()."\" />\n";
    echo "\t\t\t\t\t<input type=\"hidden\" name=\"country\" value=\"".
        $locus->getCountry()."\" />\n";
    echo "\t\t\t\t\t<input type=\"hidden\" name=\"kind\" value=\"".
        $locus->getKind()."\" />\n";
    
}
    
if ($tempPraxis)
    echo "\t\t\t\t\t<input id=\"tempPraxis\" type=\"hidden\" />\n";

echo "\t\t\t\t\t<input type=\"submit\" value=\"";

if ($tempPraxis) {
    
    echo _("Submit data and continue...");
    
} else {
    
    echo _("Submit data");
    
}

echo "\" />\n";
echo "\t\t\t\t\t<input type=\"button\" name=\"cancel\" value=\""._("Cancel").
    "\" onclick=\"javascript: history.back();\" />\n";
echo "\t\t\t\t</form>\n";

echo "\t\t\t</section> <!-- }} section -->\n\n";
require_once 'footer.inc'; // footer of all the pages of the app

?>