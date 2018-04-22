<?php
/**
 * script 'praxisEdit.php'.
 * 
 * this is the script used for both adding a new experience
 * or to edit an existing one.
 * the value of $_POST['praxisID'] is used to differentiate both scenarios:
 * if the variable is set, the flag $praxisEdit is set to true
 * and a Praxis object is instantiated to work with;
 * otherwise $praxisEdit is set to false.
 * this script echoes a form whose fields correspond with those of the table
 * 'practica'.
 * (c) Joaquin Javier ESTEBAN MARTINEZ
 * last updated 2018-04-21
*/

//require_once 'session.inc';
require_once 'core.inc';
//require_once 'DB.inc';
require_once 'praxis.inc';
//require_once 'amor.inc';
//require_once 'locus.inc';

if ($_SERVER['REQUEST_METHOD'] !== "POST") {
    /*
     * script called from outside the normal flush, throw exception
     */
    header ("Location: index.php");
    
}

// praxisEdit is set and eventually an object of class 'Praxis' instantiated:
if (isset($_POST['praxisID'])) { // script called from 'praxis.php'

    $praxisEdit = true;
    $praxis = new Praxis(intval($_POST['praxisID']));

} else { // script called from 'practica.php'

    $praxisEdit = false;
}
    
// get a DB connection to work with:
$pdo = DB::getDBHandle();

$title = $praxisEdit ? _("Edit experience") : _("New experience");
$js = "praxisEdit.js";

include 'header.inc'; // header of all the pages of the app
echo "\t\t\t<section> <!-- section {{ -->\n";


// the form is echoed:

/*
 * the form used to input the data is divided in three (four?) sections,
 * (TODO: which should be presented as tabs),
 * following the same order in which they will be shown:
 * 
 * section i) general Data: In this sections the fields:
 * - field 'name'
 * - field 'rating'
 * - field 'favorite'
 * - field 'locus' (place)
 * time (including 'date' and 'ordinal'), . These fields
 * are specified directly and with call to the script 'locusEdit.php'
 * (in case the place is not yet registered).
 * and the favorite flag.
 * - participants: Unlimited participants can be added. In case of a lover
 * not yet present in the DB script 'amorEdit.php' is called.
 * 
 * section ii) description:
 * this section is used exclusively to describe the experience
 * using the field 'description'.
 * this field, although not compulsory, is the most important in order to
 * get our goal of remembering the experience and feel glad with it.
 * 
 * section iii) other data: in this tab are located the following fields:
 * - 'achtung'
 * - 'tq'
 * - 'tl'
 */

echo "\t\t\t\t<form action=\"praxisEditProcess.php\" method=\"POST\"".
    " accept-charset=\"utf-8\">\n";

/*
 * section i) general data.
 */

echo "\t\t\t\t\t<div id=\"generalData\">\n";
echo "\t\t\t\t\t\t<fieldset>\n";
echo "\t\t\t\t\t\t\t<legend>"._("General data")."</legend>\n";

// name:
echo "\t\t\t\t\t\t\t<label for=\"name\">"._("Name")."</label>\n";
echo "\t\t\t\t\t\t\t<input id=\"name\" type=\"text\" name=\"name\" value=\"";
if ($praxisEdit)
    echo $praxis->getName();
echo "\" style=\"width: 80%\" /><br />\n";

// rating:

echo "\t\t\t\t\t\t\t<label for=\"rating\">"._("Rating")."</label>\n";
echo "\t\t\t\t\t\t\t<select id=\"rating\" name=\"rating\">\n";

echo "\t\t\t\t\t\t\t\t<option value=\"0\"";
if ($praxisEdit && ($praxis->getRating() === 0))
    echo " selected=\"selected\"";
echo ">"._("undefined")."</option>\n";

echo "\t\t\t\t\t\t\t\t<option value=\"1\"";
if ($praxisEdit && ($praxis->getRating() === 1))
    echo " selected=\"selected\"";
echo ">"._("very bad")."</option>\n";

echo "\t\t\t\t\t\t\t\t<option value=\"2\"";
if ($praxisEdit && ($praxis->getRating() === 2))
    echo " selected=\"selected\"";
echo ">"._("bad")."</option>\n";

echo "\t\t\t\t\t\t\t\t<option value=\"3\"";
if ($praxisEdit && ($praxis->getRating() === 3))
    echo " selected=\"selected\"";
echo ">"._("good")."</option>\n";

echo "\t\t\t\t\t\t\t\t<option value=\"4\"";
if ($praxisEdit && ($praxis->getRating() === 4))
    echo " selected=\"selected\"";
echo ">"._("very good")."</option>\n";

echo "\t\t\t\t\t\t\t\t<option value=\"5\"";
if ($praxisEdit && ($praxis->getRating() === 5))
    echo " selected=\"selected\"";
echo ">"._("excellent")."</option>\n";

echo "\t\t\t\t\t\t\t</select><br />\n";

// favorite:
echo "\t\t\t\t\t\t\t<input id=\"favorite\" type=\"checkbox\" name=\"favorite\"";
if ($praxisEdit && $praxis->isFavorite())
    echo " checked=\"checked\"";
echo " />\n";
echo "\t\t\t\t\t\t\t<label for=\"favorite\">"._("Favorite")."</label><br />\n";

// place (whether existing or new):

echo "\t\t\t\t\t\t\t<fieldset>\n";
echo "\t\t\t\t\t\t\t\t<legend>"._("Place")."</legend>\n";

echo "\t\t\t\t\t\t\t\t<input type=\"radio\" name=\"locusOrigin\" id=\"locusOriginExisting\"";

/*
 * locusOriginExisting is checked by default in two cases:
 * i) if editing an experience, or
 * ii) when new experience (with doPracticaExist true):
 */

if ($praxisEdit ||
    (!$praxisEdit && $_SESSION['DBStatus']['doPracticaExist']))
        echo " checked=\"checked\"";
echo " />\n";
echo "\t\t\t\t\t\t\t\t<label for=\"locusOriginExisting\">"._("Existing place").
    "</label>\n";

echo "\t\t\t\t\t\t\t\t<select name=\"locusID\" id=\"locusID\">\n";

// the existing places are retrieved from the DB:
$queryString = <<<QUERY
SELECT `locusID`, `name`
FROM `myX`.`loca`
WHERE `user` = :userID
ORDER BY `name`
QUERY;

$statement = $pdo->prepare($queryString);
$statement->bindParam(":userID", $_SESSION['userID'], PDO::PARAM_INT);
$statement->execute();
foreach ($statement as $row) {
    
    echo "\t\t\t\t\t\t\t\t\t<option value=\"".$row['locusID']."\"";
    if ($praxisEdit && ($praxis->getLocus() === intval($row['locusID'])))
        echo " selected=\"selected\"";
    echo ">".$row['name']."</option>\n";
    
}

echo "\t\t\t\t\t\t\t\t</select><br />\n";

echo "\t\t\t\t\t\t\t\t<input type=\"radio\" name=\"locusOrigin\" id=\"locusOriginNew\"";

/*
 * locusOriginNew checked by default only when
 * new experience and doPracticaExist is false:
 */

if (!$praxisEdit && !$_SESSION['DBStatus']['doPracticaExist'])
    echo " checked=\"checked\"";
echo " />\n";
echo "\t\t\t\t\t\t\t\t<label for=\"locusOriginNew\">"._("New place").
    "</label>\n";
echo "\t\t\t\t\t\t\t\t<button type=\"button\" id=\"locusNew\">".
    _("Add place...")."</button>\n";

echo "\t\t\t\t\t\t\t</fieldset>\n";

// time (date & ordinal):

echo "\t\t\t\t\t\t\t<fieldset>\n";
echo "\t\t\t\t\t\t\t\t<legend>"._("Time")."</legend>\n";
echo "\t\t\t\t\t\t\t\t<label for=\"date\">"._("Date")."</label>\n";
echo "\t\t\t\t\t\t\t\t<input id=\"date\" type=\"date\" name=\"date\" value=\"";
if ($praxisEdit)
    echo $praxis->getDate();
echo "\"/>\n";
echo "\t\t\t\t\t\t\t\t<label for=\"ordinal\">"._("Ordinal")."</label>\n";
echo "\t\t\t\t\t\t\t\t<input id=\"ordinal\" type=\"text\" name=\"ordinal\" value=\"";
if ($praxisEdit)
    echo $praxis->getOrdinal();
echo "\" /><br />\n";
echo "\t\t\t\t\t\t\t</fieldset>\n";

// participant(s) (whether existing or new):

echo "\t\t\t\t\t\t\t<fieldset>\n";
echo "\t\t\t\t\t\t\t\t<legend>"._("Participant(s)")."</legend>\n";
echo "\t\t\t\t\t\t\t\t<input type=\"radio\" name=\"amorOrigin\"";
if (!$doPracticaExist)
    echo " checked=\"checked\"";
echo " />\n";
echo "\t\t\t\t\t\t\t\t<label for=\"amorID\">"._("Existing lover(s)").
    " </label><br />\n";

// TODO: loop Praxis::getAmoresAmount, if there are more than one
echo "\t\t\t\t\t\t\t\t<select id=\"amorID\" style=\"size: 80%;\">\n"; // TODO: size does not work

// the existing lovers are retrieved from the DB:
$queryString = <<<QUERY
SELECT `amorID`, `alias`
FROM `myX`.`amores`
WHERE `user` = :userID
ORDER BY `alias`
QUERY;

$statement = $pdo->prepare($queryString);
$statement->bindParam(":userID", $_SESSION['userID'], PDO::PARAM_INT);
$statement->execute();

foreach ($statement as $row) {
    
    echo "\t\t\t\t\t\t\t\t\t<option value=\"".$row['amorID']."\"";
    if ($praxisEdit && ($praxis->getAmores()[0] === intval($row['amorID'])))
        echo " selected=\"selected\"";
    echo ">".$row['alias']."</option>\n";
    
}

echo "\t\t\t\t\t\t\t\t</select><br />\n";

echo "\t\t\t\t\t\t\t\t<input type=\"radio\" name=\"amorOrigin\"";
if (!$doPracticaExist)
    echo " checked=\"checked\"";
echo " />\n";
echo "\t\t\t\t\t\t\t\t<label for=\"amorOrigin\">"._("New lover")."</label>\n";
echo "\t\t\t\t\t\t\t\t<button type=\"button\" id=\"amorNew\">".
    _("Add lover...")."</button>\n";

echo "\t\t\t\t\t\t\t</fieldset>\n"; // }} lover

echo "\t\t\t\t\t\t</fieldset><!-- general data -->\n"; // }} general data
echo "\t\t\t\t\t</div>\n";

/*
 * section ii) description.
 */

echo "\t\t\t\t\t<div id=\"description\">\n";
echo "\t\t\t\t\t\t<fieldset>\n";
echo "\t\t\t\t\t\t\t<legend>".
    _("Description").
    "</legend>\n";
echo "\t\t\t\t\t\t\t<textarea name=\"description\" style=\"width: 100%; height: 200px;\">";
if ($praxisEdit)
    echo $praxis->getDescription ();
echo "</textarea>\n";
echo "\t\t\t\t\t\t</fieldset><!-- description -->\n";
echo "\t\t\t\t\t</div>\n";

/*
 * section iii) other data.
 */

echo "\t\t\t\t\t<div id=\"otherData\">\n";
echo "\t\t\t\t\t\t<fieldset>\n";
echo "\t\t\t\t\t\t\t\t<legend>"._("Other data")."</legend>\n";

// field 'tq':

echo "\t\t\t\t\t\t\t<label for=\"tq\">"._("TQ:")."</label>\n";
echo "\t\t\t\t\t\t\t<select id=\"tq\" name=\"tq\">\n";

echo "\t\t\t\t\t\t\t\t<option value=\"0\"";
if ($praxisEdit && ($praxis->getTQ() === 0))
    echo " selected=\"selected\"";
echo ">"._("undefined")."</option>\n";

echo "\t\t\t\t\t\t\t\t<option value=\"1\"";
if ($praxisEdit && ($praxis->getTQ() === 1))
    echo " selected=\"selected\"";
echo ">"._("E_PRIVATE")."</option>\n";

echo "\t\t\t\t\t\t\t\t<option value=\"2\"";
if ($praxisEdit && ($praxis->getTQ() === 2))
    echo " selected=\"selected\"";
echo ">"._("E_EDIT_TO_SHARE")."</option>\n";

echo "\t\t\t\t\t\t\t\t<option value=\"3\"";
if ($praxisEdit && ($praxis->getTQ() === 3))
    echo " selected=\"selected\"";
echo ">"._("E_SHARE")."</option>\n";

echo "\t\t\t\t\t\t\t\t<option value=\"4\"";
if ($praxisEdit && ($praxis->getTQ() === 4))
    echo " selected=\"selected\"";
echo ">"._("E_SHARE_TO_BROADCAST")."</option>\n";

echo "\t\t\t\t\t\t\t\t<option value=\"5\"";
if ($praxisEdit && ($praxis->getTQ() === 5))
    echo " selected=\"selected\"";
echo ">"._("E_BROADCAST")."</option>\n";

echo "\t\t\t\t\t\t\t</select><br />\n";

// field 'tl':

echo "\t\t\t\t\t\t\t<label for=\"tl\">"._("TL:")."</label>\n";
echo "\t\t\t\t\t\t\t<select id=\"tl\" name=\"tl\">\n";

echo "\t\t\t\t\t\t\t\t<option value=\"0\"";
if ($praxisEdit && ($praxis->getTL() === 0))
    echo " selected=\"selected\"";
echo ">"._("undefined")."</option>\n";

echo "\t\t\t\t\t\t\t\t<option value=\"1\"";
if ($praxisEdit && ($praxis->getTL() === 1))
    echo " selected=\"selected\"";
echo ">"._("E_LANG1")."</option>\n";

echo "\t\t\t\t\t\t\t\t<option value=\"2\"";
if ($praxisEdit && ($praxis->getTL() === 2))
    echo " selected=\"selected\"";
echo ">"._("E_LANG2")."</option>\n";

echo "\t\t\t\t\t\t\t\t<option value=\"3\"";
if ($praxisEdit && ($praxis->getTL() === 3))
    echo " selected=\"selected\"";
echo ">"._("E_LANG3")."</option>\n";

echo "\t\t\t\t\t\t\t\t<option value=\"4\"";
if ($praxisEdit && ($praxis->getTL() === 4))
    echo " selected=\"selected\"";
echo ">"._("E_LANG4")."</option>\n";

echo "\t\t\t\t\t\t\t\t<option value=\"5\"";
if ($praxisEdit && ($praxis->getTL() === 5))
    echo " selected=\"selected\"";
echo ">"._("E_LANG5")."</option>\n";

echo "\t\t\t\t\t\t\t</select><br />\n";

echo "\t\t\t\t\t\t</fieldset><!-- other data -->\n";
echo "\t\t\t\t\t</div>\n";
   
// form footer:

if ($praxisEdit)
    echo "\t\t\t\t\t\t<input type=\"hidden\" name=\"praxisID\" value=\"".
        $praxis->getPraxisID()."\" />\n";

echo "\t\t\t\t\t\t<input type=\"submit\" value=\""._("Submit data")."\" />\n";
echo "\t\t\t\t\t\t<input type=\"button\" name=\"cancel\" value=\"".
        _("Cancel")."\" onclick=\"javascript: history.back();\" />\n";
echo "\t\t\t\t\t</form>\n";

echo "\t\t\t</section> <!-- }} section -->\n\n";
require_once 'footer.inc'; // footer of all the pages of the app

?>