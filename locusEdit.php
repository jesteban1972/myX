<?php
/**
 * script 'locusEdit.php'.
 * 
 * this is the script used for both adding a new place
 * or to edit an existing one.
 * the value of $_POST['locusID'] is used to differentiate both scenarios:
 * if the variable is set, the flag $locusEdit is set to true
 * and a Locus object is instantiated to work with;
 * otherwise $locusEdit is set to false.
 * this script echoes a form whose fields correspond with those of the table
 * 'loca'.
 * (c) Joaquin Javier ESTEBAN MARTINEZ
 * last updated 2018-04-21
*/

require_once 'session.inc';
//require_once 'core.inc';
require_once 'DB.inc';
//require_once 'praxis.inc';
//require_once 'amor.inc';
require_once 'locus.inc';

if ($_SERVER['REQUEST_METHOD'] !== "POST") {
    /*
     * script called from outside the normal flush, throw exception
     */
    header ("Location: index.php");
    
}

// locusEdit is set and eventually an object of class 'Locus' instantiated:
if (isset($_POST['locusID'])) { // script called from 'locus.php'

    $locusEdit = true;
    $locus = new Locus(intval($_POST['locusID']));

} else { // script called from 'loca.php'

    $locusEdit = false;
    
}
    
// get a DB connection to work with:
$pdo = DB::getDBHandle();
    
$title = $locusEdit ? _("Edit place") : _("New place");
$js = "locusEdit.js";

include 'header.inc'; // header of all the pages of the app
echo "\t\t\t<section> <!-- section {{ -->\n";

// the form is echoed:

echo "\t\t\t\t".
    "<form action=\"locusEditProcess.php\" method=\"POST\"".
    " accept-charset=\"utf-8\">\n";
echo "\t\t\t\t\t<fieldset>\n";
echo "\t\t\t\t\t\t<legend>"._("General data")."</legend>\n";

// name:
echo "\t\t\t\t\t\t\t<label for=\"name\">"._("Name").":</label>\n";
echo "\t\t\t\t\t\t\t<input type=\"text\" name=\"name\" value=\"";
if ($locusEdit)
    echo $locus->getName();
echo "\" style=\"width: 80%\" /><br />\n";

// rating:

echo "\t\t\t\t\t\t\t<label for=\"rating\">"._("Rating").":</label>\n";
echo "\t\t\t\t\t\t\t<select name=\"rating\">\n";

echo "\t\t\t\t\t\t\t\t<option value=\"0\"";
if ($locusEdit && ($locus->getRating() === 0))
    echo " selected=\"selected\"";
echo ">"._("undefined")."</option>\n";

echo "\t\t\t\t\t\t\t\t<option value=\"1\"";
if ($locusEdit && ($locus->getRating() === 1))
    echo " selected=\"selected\"";
echo ">"._("very bad")."</option>\n";

echo "\t\t\t\t\t\t\t\t<option value=\"2\"";
if ($locusEdit && ($locus->getRating() === 2))
    echo " selected=\"selected\"";
echo ">"._("bad")."</option>\n";

echo "\t\t\t\t\t\t\t\t<option value=\"3\"";
if ($locusEdit && ($locus->getRating() === 3))
    echo " selected=\"selected\"";
echo ">"._("good")."</option>\n";

echo "\t\t\t\t\t\t\t\t<option value=\"4\"";
if ($locusEdit && ($locus->getRating() === 4))
    echo " selected=\"selected\"";
echo ">"._("very good")."</option>\n";

echo "\t\t\t\t\t\t\t\t<option value=\"5\"";
if ($locusEdit && ($locus->getRating() === 5))
    echo " selected=\"selected\"";
echo ">"._("excellent")."</option>\n";

echo "\t\t\t\t\t\t\t</select><br />\n";

// address:
echo "\t\t\t\t\t\t\t<label for=\"name\">"._("Address").":</label>\n";
echo "\t\t\t\t\t\t\t<input type=\"text\" name=\"address\" value=\"";
if ($locusEdit)
    echo $locus->getAddress();
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
echo "\t\t\t\t\t\t\t\t<label for=\"countryOrigin\">"._("Existing country").
    ":</label>\n";

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
echo "\t\t\t\t\t\t\t\t<label for=\"countryOrigin\">"._("New country").
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
echo "\t\t\t\t\t\t\t\t<label for=\"kindsOrigin\">"._("Existing kind:").
    "</label>\n";

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
echo "\t\t\t\t\t\t\t\t<label for=\"kindOrigin\">"._("New kind:").
    "</label>\n";
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

echo "\t\t\t\t\t<div id=\"description\">\n";
echo "\t\t\t\t\t\t<fieldset>\n";
echo "\t\t\t\t\t\t\t<legend>"._("Description")."</legend>\n";
echo "\t\t\t\t\t\t\t<textarea name=\"description\" style=\"width: 100%; height: 200px;\">";
if ($locusEdit)
    echo $locus->getDescription ();
echo "</textarea>\n";
echo "\t\t\t\t\t\t</fieldset><!-- description -->\n";
echo "\t\t\t\t\t</div>\n";

echo "\t\t\t\t\t<fieldset>\n";
echo "\t\t\t\t\t\t<legend>"._("Other data")."</legend>\n";

// exact coordinates:
echo "\t\t\t\t\t\t\t<label for=\"name\">"._("Exact coordinates").":</label>\n";
echo "\t\t\t\t\t\t\t<input type=\"text\" name=\"coordinatesExact\" value=\"";
if ($locusEdit)
    echo $locus->getCoordExact();
echo "\" /><br />\n";

// generic coordinates:
echo "\t\t\t\t\t\t\t<label for=\"name\">"._("Generic coordinates").":</label>\n";
echo "\t\t\t\t\t\t\t<input type=\"text\" name=\"coordinatesGeneric\" value=\"";
if ($locusEdit)
    echo $locus->getCoordGeneric();
echo "\" /><br />\n";

// www:
echo "\t\t\t\t\t\t\t<label for=\"name\">"._("Web").":</label>\n";
echo "\t\t\t\t\t\t\t<input type=\"text\" name=\"www\" value=\"";
if ($locusEdit)
    echo $locus->getWeb();
echo "\" style=\"width: 80%\" /><br />\n";

echo "\t\t\t\t\t</fieldset>\n";

// form footer:

if ($locusEdit)
    echo "\t\t\t\t\t<input type=\"hidden\" name=\"locusID\" value=\"".
        $locus->getLocusID()."\" />\n";

echo "\t\t\t\t\t<input type=\"submit\" value=\""._("Submit data")."\" />\n";
echo "\t\t\t\t\t<input type=\"button\" name=\"cancel\" value=\""._("Cancel").
    "\" onclick=\"javascript: history.back();\" />\n";
echo "\t\t\t\t</form>\n";

echo "\t\t\t</section> <!-- }} section -->\n\n";
require_once 'footer.inc'; // footer of all the pages of the app

?>