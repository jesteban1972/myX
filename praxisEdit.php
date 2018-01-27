<?php

/**
 * script praxisEdit.php
 * contains the form to edit an experience or to add a new one
 * (c) Joaquin Javier ESTEBAN MARTINEZ
 * last updated 2018-01-24
*/

require_once 'session.inc';
//require_once 'core.inc';
require_once 'DB.inc';
require_once 'praxis.inc';
//require_once 'amor.inc';
//require_once 'locus.inc';

if ($_SERVER['REQUEST_METHOD'] !== "POST") {
    /*
     * script called from outside the normal flush, throw exception
     */
    header ("Location: index.php");
    
}
    
if (isset($_POST['praxisID'])) { // script called from 'praxis.php'

    $praxisEdit = true;
    $praxis = new Praxis(intval($_POST['praxisID']));

} else { // script called from 'practica.php'

    $praxisEdit = false;
}
    
// get a DB connection to work with:
$pdo = DB::getDBHandle();

$title = $praxisEdit ? _("Edit experience") : _("New experience");
include 'header.inc'; // header of all the pages of the app
echo "\t\t\t<section> <!-- section {{ -->\n";

// the form is echoed:

echo "\t\t\t\t<form action=\"praxisEditProcess.php\" method=\"POST\" accept-charset=\"utf-8\">\n";
echo "\t\t\t\t\t<fieldset>\n";
echo "\t\t\t\t\t\t<legend>"._("General data")."</legend>\n";

// place (whether existing or new):

echo "\t\t\t\t\t\t<fieldset>\n";
echo "\t\t\t\t\t\t\t<legend>".
    _("Place").
    "</legend>\n";
echo "\t\t\t\t\t\t\t<label for=\"placeID\">".
    _("Existing place:").
    " </label>\n";
echo "\t\t\t\t\t\t\t<select name=\"placeID\">\n";

// the existing places are retrieved from the DB:
$queryString = <<<QUERY
SELECT `locusID`, `name`
FROM `myX`.`loca`
WHERE `user`=:userID
ORDER BY `name`
QUERY;

$statement = $pdo->prepare($queryString);
$statement->bindParam(":userID", $_SESSION['userID'], PDO::PARAM_INT);
$statement->execute();
foreach ($statement as $row)
    echo "\t\t\t\t\t\t\t\t<option value=\"".
        $row['locusID'].
        "\">".
        $row['name'].
        "</option>\n";

echo "\t\t\t\t\t\t\t</select>\n";

echo "\t\t\t\t\t\t</fieldset>\n";

// date & ordinal:
echo "\t\t\t\t\t\t\t<label for=\"date\">".
    _("Date:").
    " </label>\n";
echo "\t\t\t\t\t\t\t<input type=\"date\" name=\"date\" />\n";
echo "\t\t\t\t\t\t\t<label for=\"ordinal\">".
    _("Ordinal:").
    " </label>\n";
echo "\t\t\t\t\t\t\t<input type=\"text\" name=\"ordinal\" /><br />\n";

// name:
echo "\t\t\t\t\t\t<label for=\"name\">".
    _("Name:").
    "</label>\n";
echo "\t\t\t\t\t\t<input type=\"text\" name=\"name\" value=\"";
if ($praxisEdit)
    echo $praxis->getName();
echo "\" /><br />\n";

// rating:

echo "\t\t\t\t\t\t<label for=\"rating\">".
    _("Rating:").
    "</label>\n";
echo "\t\t\t\t\t\t<select name=\"rating\">\n";

echo "\t\t\t\t\t\t\t<option value=\"0\"";
if ($praxisEdit && ($praxis->getRating() === 0))
    echo " selected=\"selected\"";
echo ">".
    _("undefined").
    "</option>\n";

echo "\t\t\t\t\t\t\t<option value=\"1\"";
if ($praxisEdit && ($praxis->getRating() === 1))
    echo " selected=\"selected\"";
echo ">".
    _("very bad").
    "</option>\n";

echo "\t\t\t\t\t\t\t<option value=\"2\"";
if ($praxisEdit && ($praxis->getRating() === 2))
    echo " selected=\"selected\"";
echo ">".
    _("bad").
    "</option>\n";

echo "\t\t\t\t\t\t\t<option value=\"3\"";
if ($praxisEdit && ($praxis->getRating() === 3))
    echo " selected=\"selected\"";
echo ">".
    _("good").
    "</option>\n";

echo "\t\t\t\t\t\t\t<option value=\"4\"";
if ($praxisEdit && ($praxis->getRating() === 4))
    echo " selected=\"selected\"";
echo ">".
    _("very good").
    "</option>\n";

echo "\t\t\t\t\t\t\t<option value=\"5\"";
if ($praxisEdit && ($praxis->getRating() === 5))
    echo " selected=\"selected\"";
echo ">".
    _("excellent").
    "</option>\n";

echo "\t\t\t\t\t\t</select>\n";

// lover(s) (whether existing or new):

echo "\t\t\t\t\t\t<fieldset>\n";
echo "\t\t\t\t\t\t\t<legend>".
    _("Lover").
    "</legend>\n";
echo "\t\t\t\t\t\t\t<label for=\"amorID\">".
    _("Existing lover:").
    " </label>\n";
echo "\t\t\t\t\t\t\t<select name=\"amorID\">\n";

// the existing lovers are retrieved from the DB:
$queryString = <<<QUERY
SELECT `amorID`, `alias`
FROM `myX`.`amores`
WHERE `user`=:userID
ORDER BY `alias`
QUERY;

$statement = $pdo->prepare($queryString);
$statement->bindParam(":userID", $_SESSION['userID'], PDO::PARAM_INT);
$statement->execute();
foreach ($statement as $row)
    echo "\t\t\t\t\t\t\t\t<option value=\"".
        $row['amorID'].
        "\">".
        $row['alias'].
        "</option>\n";

echo "\t\t\t\t\t\t\t</select>\n";

echo "\t\t\t\t\t\t</fieldset>\n"; // }} lover

echo "\t\t\t\t\t</fieldset>\n"; // }} general data

// description:
echo "\t\t\t\t\t\t<fieldset>\n";
echo "\t\t\t\t\t\t\t<legend>".
    _("Description").
    "</legend>\n";
echo "\t\t\t\t\t\t\t<textarea name=\"description\">";
if ($praxisEdit)
    echo $praxis->getDescription ();
echo "</textarea>\n";
echo "\t\t\t\t\t\t</fieldset>\n";
   
// form foot:

if ($praxisEdit)
    echo "\t\t\t\t\t\t<input type=\"hidden\" name=\"praxisID\" value=\"".
        $praxis->getPraxisID().
        "\" />\n";

echo "\t\t\t\t\t\t<input type=\"submit\" value=\"".
    _("Submit data").
    "\" />\n";
echo "\t\t\t\t\t\t<input type=\"button\" name=\"cancel\" value=\"".
        _("Cancel").
        "\" onclick=\"javascript: history.back();\" />\n";
echo "\t\t\t\t\t</form>\n";

echo "\t\t\t</section> <!-- }} section -->\n\n";
require_once 'footer.inc'; // footer of all the pages of the app

?>