<?php

/**
 * script locusEdit.php
 * contains the form to edit a place or to add a new one
 * (c) Joaquin Javier ESTEBAN MARTINEZ
 * last updated 2018-01-15
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
    
if (isset($_POST['locusID'])) { // script called from 'locus.php'

    $locusEdit = true;
    $locus = new Locus(intval($_POST['locusID']));

} else { // script called from 'loca.php'

    $locusEdit = false;
}
    
// get a DB connection to work with:
$pdo = DB::getDBHandle();
    
$title = $locusEdit ? _("Edit place") : _("New place");
include 'header.inc'; // header of all the pages of the app
echo "\t\t\t<section> <!-- section {{ -->\n";

// the form is echoed:

echo "\t\t\t\t".
    "<form action=\"locusEditProcess.php\" method=\"POST\" accept-charset=\"utf-8\">\n".
    "\t\t\t\t\t<fieldset>\n";
echo "\t\t\t\t\t\t<legend>".
    _("General data").
    "</legend>\n";

// name:
echo "\t\t\t\t\t\t<label for=\"name\">".
    _("Name:").
    "</label>\n".
    "\t\t\t\t\t\t<input type=\"text\" name=\"name\" value=\"";
if ($locusEdit)
    echo $locus->getName();
echo "\" /><br />\n";

// country (whether existing or new):

echo "\t\t\t\t\t\t<fieldset>\n";
echo "\t\t\t\t\t\t\t<legend>".
    _("Country").
    "</legend>\n";
echo "\t\t\t\t\t\t\t<label for=\"country\">".
    _("Existing country:").
    " </label>\n";
echo "\t\t\t\t\t\t\t<select name=\"country\">\n";

// the existing countries are retrieved from the DB:
$queryString = <<<QUERY
SELECT `countryID`, `name`
FROM `myX`.`countries`
WHERE `user`=:userID 
QUERY;

$statement = $pdo->prepare($queryString);
$statement->bindParam(":userID", $_SESSION['userID'], PDO::PARAM_INT);
$statement->execute();
foreach ($statement as $row)
    echo "\t\t\t\t\t\t\t\t<option value=\"".
        $row['countryID'].
        "\">".
        $row['name'].
        "</option>\n";

echo "\t\t\t\t\t\t\t</select>\n";

// new country:
echo "\t\t\t\t\t\t\t<label for=\"newCountry\">".
    _("New country:").
    "</label>\n";
echo "\t\t\t\t\t\t\t<input type=\"text\" name=\"newCountry\" />\n";
echo "\t\t\t\t\t\t\t<input type=\"submit\" value=\""._("Add country")."\" />\n";
echo "\t\t\t\t\t\t</fieldset>\n";

// kind (whether existing or new):

echo "\t\t\t\t\t\t<fieldset>\n";
echo "\t\t\t\t\t\t\t<legend>".
    _("Kind").
    "</legend>\n";
echo "\t\t\t\t\t\t\t<label for=\"kind\">".
    _("Existing kind:").
    " </label>\n".
    "\t\t\t\t\t\t\t<select name=\"kind\">\n";

// the existing kinds are retrieved from the DB:
$queryString = <<<QUERY
SELECT `kindID`, `name`
FROM `myX`.`kinds`
WHERE `user`=:userID 
QUERY;

$statement = $pdo->prepare($queryString);
$statement->bindParam(":userID", $_SESSION['userID'], PDO::PARAM_INT);
$statement->execute();
foreach ($statement as $row)
    echo "\t\t\t\t\t\t\t\t<option value=\"".
        $row['kindID'].
        "\">".
        $row['name'].
        "</option>\n";

echo "\t\t\t\t\t\t\t</select>\n";
echo "\t\t\t\t\t\t</fieldset>\n";

// description:
echo "\t\t\t\t\t\t<label for=\"description\">".
    _("Description:").
    "</label><br />\n";
echo "\t\t\t\t\t\t<textarea name=\"description\" rows=\"4\" cols=\"80\" />";
if ($locusEdit)
    echo $locus->getDescription();
echo "</textarea><br />\n";

// rating:
echo "\t\t\t\t\t\t<label for=\"rating\">"._("Rating:")." </label>\n";
echo "\t\t\t\t\t\t<select name=\"rating\">\n";
echo "\t\t\t\t\t\t\t<option value=\"0\"";
if ($locusEdit && intval($locus->getRating()) === 0)
    echo " selected=\"selected\"";
echo ">0 - undefined</option>\n";
echo "\t\t\t\t\t\t\t<option value=\"1\"";
if ($locusEdit && intval($locus->getRating()) === 1)
    echo " selected=\"selected\"";
echo ">1 - very bad</option>\n";
echo "\t\t\t\t\t\t\t<option value=\"2\"";
if ($locusEdit && intval($locus->getRating()) === 2)
    echo " selected=\"selected\"";
echo ">2 - bad</option>\n";
echo "\t\t\t\t\t\t\t<option value=\"3\"";
if ($locusEdit && intval($locus->getRating()) === 3)
    echo " selected=\"selected\"";
echo ">3 - good</option>\n";
echo "\t\t\t\t\t\t\t<option value=\"4\"";
if ($locusEdit && intval($locus->getRating()) === 4)
    echo " selected=\"selected\"";
echo ">4 - very good</option>\n";
echo "\t\t\t\t\t\t\t<option value=\"5\"";
if ($locusEdit && intval($locus->getRating()) === 5)
    echo " selected=\"selected\"";
echo ">5 - excellent</option>\n";
echo "\t\t\t\t\t\t</select>\n";
echo "\t\t\t\t\t</fieldset>\n";

echo "\t\t\t\t\t<fieldset>\n";
echo "\t\t\t\t\t\t<legend>".
    _("Complementary data").
    "</legend>\n";
echo "\t\t\t\t\t\t<p>(address, coordinatesExact, coordinatesGeneric, www)</p>\n"; // tocomplete!!!
echo "\t\t\t\t\t</fieldset>\n";


if ($locusEdit)
    echo "\t\t\t\t\t<input type=\"hidden\" name=\"locusID\" value=\"".
        $locus->getLocusID().
        "\" />\n";

echo "\t\t\t\t\t<input type=\"submit\" value=\"".
    _("Submit data").
    "\" />\n";
echo "\t\t\t\t\t<input type=\"button\" name=\"cancel\" value=\"".
        _("Cancel").
        "\" onclick=\"javascript: history.back();\" />\n";
echo "\t\t\t\t</form>\n";

echo "\t\t\t</section> <!-- }} section -->\n\n";
require_once 'footer.inc'; // footer of all the pages of the app

?>