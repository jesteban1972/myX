<?php
/**
 * script 'praxisEdit.php'.
 * 
 * this is the script used for both adding a new experience
 * or to edit an existing one.
 * 
 * the value of $_GET['praxisID'] is used to differentiate both scenarios:
 * if the variable is set, the flag $praxisEdit is set to true
 * and a Praxis object is instantiated to work with;
 * otherwise $praxisEdit is set to false.
 * this script echoes a form whose fields correspond with those of the table
 * 'practica'.
 * 
 * @author Joaquin Javier ESTEBAN MARTINEZ <jesteban1972@me.com>
 * last updated 2018-06-08
*/

//require_once 'session.inc';
require_once 'core.inc';
//require_once 'DB.inc';
require_once 'praxis.inc';
//require_once 'amor.inc';
//require_once 'locus.inc';

if ($_SERVER['REQUEST_METHOD'] !== "GET") {
    /*
     * script called from outside the normal flush, redirect to 'index.php'
     */
    $_SESSION['notification'] = _("Unable to load the required page");
    header ("Location: index.php");
    
}

/*
 * we first check if any parameter 'tempLocus' or 'tempAmor'
 * have been received from $_GET.
 * if yes, the data are taken from $_SESSION to populate the fields.
 */

// praxisEdit is set and eventually an object of class 'Praxis' instantiated:
if (isset($_GET['praxisID'])) { // script called from 'praxis.php'

    $praxisEdit = true;
    $praxis = new Praxis(intval($_GET['praxisID']));

} else { // script called from 'practica.php' (TODO: or from 'index.php') or back from 'locusEdit.php' or 'amorEdit.php'

    $praxisEdit = false;
    if (isset($_SESSION['tempPraxisData'])) {
        
        $tempPraxis = true;
        //$tempPraxisData = $_SESSION['tempPraxisData'];
                
    }
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
 * section i) general Data: in this sections the fields:
 * - 'achtung' (hidden)
 * - field 'name'
 * - field 'rating'
 * - flag 'favorite'
 * - field 'locus' (place). in case of a lover
 * not yet present in the DB, the script 'locusEdit.php' is called.
 * - time (including 'date' and 'ordinal').
 * - participants: unlimited participants can be added. in case of a lover
 * not yet present in the DB, the script 'amorEdit.php' is called.
 * 
 * section ii) description:
 * this section is used exclusively to describe the experience
 * using the field 'description'.
 * this field, although not compulsory, is the most important in order to
 * get our goal of remembering the experience feeling pleasure with it.
 * 
 * section iii) other data: in this tab are located the following fields:
 * - 'tq' (not used in the current context)
 * - 'tl' (not used in the current context)
 */

echo "\t\t\t\t<form id=\"praxisEditForm\" action=\"praxisEditProcess.php\"".
    " method=\"POST\" accept-charset=\"utf-8\">\n";

/*
 * section i) general data.
 */

echo "\t\t\t\t\t<div id=\"generalData\">\n";
echo "\t\t\t\t\t\t<fieldset>\n";
echo "\t\t\t\t\t\t\t<legend>"._("General data")."</legend>\n";

// achtung:
echo "\t\t\t\t\t\t\t<label for=\"achtung\" style=\"visibility: hidden;\">".
    _("Achtung").":</label>\n";
echo "\t\t\t\t\t\t\t<input id=\"achtung\" type=\"text\" name=\"achtung\" value=\"";
if ($praxisEdit)
    echo $praxis->getAchtung();
else if ($tempPraxis)
    echo $_SESSION['tempPraxisData']['achtung'];
echo "\" style=\"visibility: hidden; width: 80%\" /><br />\n";

// name:
echo "\t\t\t\t\t\t\t<label for=\"name\">"._("Name")."<sup>*</sup></label>\n";
echo "\t\t\t\t\t\t\t<input id=\"name\" type=\"text\" name=\"name\" value=\"";
if ($praxisEdit)
    echo $praxis->getName();
else if ($tempPraxis && isset($_SESSION['tempPraxisData']['name']))
    echo $_SESSION['tempPraxisData']['name'];
echo "\" style=\"width: 80%\" /><br />\n";

// rating:

echo "\t\t\t\t\t\t\t<label for=\"rating\">"._("Rating")."</label>\n";
echo "\t\t\t\t\t\t\t<select id=\"rating\" name=\"rating\">\n";

echo "\t\t\t\t\t\t\t\t<option value=\"0\"";
if (($praxisEdit && ($praxis->getRating() === 0)) ||
    ($tempPraxis && ($_SESSION['tempPraxisData']['rating'] === 0)))
    echo " selected=\"selected\"";
echo ">"._("undefined")."</option>\n";

echo "\t\t\t\t\t\t\t\t<option value=\"1\"";
if (($praxisEdit && ($praxis->getRating() === 1)) ||
    ($tempPraxis && ($_SESSION['tempPraxisData']['rating'] === 1)))
    echo " selected=\"selected\"";
echo ">"._("very bad")."</option>\n";

echo "\t\t\t\t\t\t\t\t<option value=\"2\"";
if (($praxisEdit && ($praxis->getRating() === 2)) ||
    ($tempPraxis && ($_SESSION['tempPraxisData']['rating'] === 2)))
    echo " selected=\"selected\"";
echo ">"._("bad")."</option>\n";

echo "\t\t\t\t\t\t\t\t<option value=\"3\"";
if (($praxisEdit && ($praxis->getRating() === 3)) ||
    ($tempPraxis && ($_SESSION['tempPraxisData']['rating'] === 3)))
    echo " selected=\"selected\"";
echo ">"._("good")."</option>\n";

echo "\t\t\t\t\t\t\t\t<option value=\"4\"";
if (($praxisEdit && ($praxis->getRating() === 4)) ||
    ($tempPraxis && ($_SESSION['tempPraxisData']['rating'] === 4)))
    echo " selected=\"selected\"";
echo ">"._("very good")."</option>\n";

echo "\t\t\t\t\t\t\t\t<option value=\"5\"";
if (($praxisEdit && ($praxis->getRating() === 5)) ||
    ($tempPraxis && ($_SESSION['tempPraxisData']['rating'] === 5)))
    echo " selected=\"selected\"";
echo ">"._("excellent")."</option>\n";

echo "\t\t\t\t\t\t\t</select><br />\n";

// favorite:
echo "\t\t\t\t\t\t\t<input id=\"favorite\" type=\"checkbox\" name=\"favorite\"";
if (($praxisEdit && $praxis->isFavorite()) ||
    ($tempPraxis && ($_SESSION['tempPraxisData']['favorite'] === 1)))
    echo " checked=\"checked\"";
echo " />\n";
echo "\t\t\t\t\t\t\t<label for=\"favorite\">"._("Favorite")."</label><br />\n";

// place (whether existing or new):

echo "\t\t\t\t\t\t\t<fieldset>\n";
echo "\t\t\t\t\t\t\t\t<legend id=\locusLegend\">"._("Place").
    "<sup>*</sup></legend>\n";

echo "\t\t\t\t\t\t\t\t<input id=\"locusOriginExisting\" type=\"radio\"".
    " name=\"locusOrigin\""; // 'locusOrigin' common name

/*
 * locusOriginExisting is checked by default in two cases:
 * i) if editing an experience, or
 * ii) when new experience (with doPracticaExist true and
 * $_SESSION['tempLocusData'] not set):
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

echo "\t\t\t\t\t\t\t\t<input id=\"locusOriginNew\" type=\"radio\"".
    " name=\"locusOrigin\""; // 'locusOrigin' common name

/*
 * locusOriginNew checked by default when:
 * i) new experience and doPracticaExist are false
 * ii) new experience and $_SESSION['tempLocusData']:
 */

if ((!$praxisEdit && !$_SESSION['DBStatus']['doPracticaExist']) ||
    ($tempPraxis && isset($_SESSION['tempLocusData'])))
    echo " checked=\"checked\"";

echo " />\n";
echo "\t\t\t\t\t\t\t\t<label for=\"locusOriginNew\">"._("New place");
if (isset($_SESSION['tempLocusData']))
    echo " (".$_SESSION['tempLocusData']['name'].")";
echo "</label>\n";
echo "\t\t\t\t\t\t\t\t<button id=\"locusNew\" type=\"button\">";
echo isset($_SESSION['tempLocusData']) ?
    _("Edit place...") :
    _("Add place...");
echo "</button>\n";
echo "\t\t\t\t\t\t\t\t<input id=\"isTempLocus\" type=\"hidden\" value=\"";
echo isset($_SESSION['tempLocusData']) ?
    "true" :
    "false";
echo "\">\n";

echo "\t\t\t\t\t\t\t</fieldset>\n";

// time (date & ordinal):

echo "\t\t\t\t\t\t\t<fieldset>\n";
echo "\t\t\t\t\t\t\t\t<legend>"._("Time")."</legend>\n";
echo "\t\t\t\t\t\t\t\t<label for=\"date\">"._("Date")."<sup>*</sup></label>\n";
echo "\t\t\t\t\t\t\t\t<input id=\"date\" type=\"date\" name=\"date\" value=\"";
if ($praxisEdit)
    echo $praxis->getDate();
else if ($tempPraxis)
    echo $_SESSION['tempPraxisData']['date'];
echo "\"/>\n";
echo "\t\t\t\t\t\t\t\t<label for=\"ordinal\">"._("Ordinal")."</label>\n";
echo "\t\t\t\t\t\t\t\t<input id=\"ordinal\" type=\"text\" name=\"ordinal\"".
    " value=\"";
if ($praxisEdit)
    echo $praxis->getOrdinal();
else if ($tempPraxis)
    echo $_SESSION['tempPraxisData']['ordinal'];
echo "\" /><br />\n";
echo "\t\t\t\t\t\t\t</fieldset>\n";

/*
 * participant(s) (whether existing or new).
 * the participans in the experience are presented as a numbered list, in which
 * each item has three parts:
 * i) an ordinal number.
 * ii) two radio buttons with the choice of select an already existing lover
 * or to insert a new one.
 * iii) two plus and minus buttons (in the first lover the minus button is
 * absent), to add or remove lovers from the list.
 */

echo "\t\t\t\t\t\t\t<fieldset>\n";
echo "\t\t\t\t\t\t\t\t<legend>"._("Participant(s)")."</legend>\n";
echo "\t\t\t\t\t\t\t\t<table id=\"amoresTable\" style=\"width: 100%\">\n";

/*
 * multiple lovers can be specified participating in one experience.
 * if no other lovers have been set previously, only the first one is displayed,
 * other lovers can be dynamically added (or deleted) using JavaScript.
 */
$amoresAmount = (isset($_SESSION['tempAmorData'])) ?
    count($_SESSION['tempAmorData']) :
    1;

for ($i = 0; $i < $amoresAmount; $i++) {

    echo "\t\t\t\t\t\t\t\t\t<tr id=\"amor".($i + 1)."\">\n";
    echo "\t\t\t\t\t\t\t\t\t\t<td id=\"amorOrdinal".($i + 1)."\">\n";
    echo "\t\t\t\t\t\t\t\t\t\t\t<p>".($i + 1).".";
    if ($i === 0)
        echo "<sup>*</sup>";
    echo "</p>\n";
    echo "\t\t\t\t\t\t\t\t\t\t</td>\n";
    echo "\t\t\t\t\t\t\t\t\t\t<td>\n";
    echo "\t\t\t\t\t\t\t\t\t\t\t<input type=\"radio\" id=\"amorOriginExisting[".
        $i."]\""." name=\"amorOrigin[".$i."]\"";

/*
 * amorOriginExisting is checked by default in two cases:
 * i) if editing an experience, or
 * ii) when new experience (with doPracticaExist true):
 */

    if ($praxisEdit ||
        (!$praxisEdit && $_SESSION['DBStatus']['doPracticaExist']))
            echo " checked=\"checked\"";

    echo " />\n";
    echo "\t\t\t\t\t\t\t\t\t\t\t<label for=\"amorOriginExisting[".$i."]\">".
        _("Existing lover")." </label>\n";

    echo "\t\t\t\t\t\t\t\t\t\t\t<select id=\"amorID[".$i."]\" name=\"amorID[".
        $i."]\" style=\"width: 70%;\">\n";

    // the table 'amores' is queried to retrieve the existing lovers:
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

        echo "\t\t\t\t\t\t\t\t\t\t\t\t<option value=\"".$row['amorID']."\"";
        if ($praxisEdit &&
            ($praxis->getAmores()[$i] === intval($row['amorID'])))
            echo " selected=\"selected\"";
        echo ">".$row['alias']."</option>\n";

    }

    echo "\t\t\t\t\t\t\t\t\t\t\t</select><br />\n";

    echo "\t\t\t\t\t\t\t\t\t\t\t<input type=\"radio\" id=\"amorOriginNew[".$i.
        "]\""." name=\"amorOrigin[".$i."]\"";

/*
 * amorOriginNew checked by default when:
 * i) new experience and doPracticaExist are false
 * ii) new experience and $_SESSION['tempAmorData']:
 */

    if ((!$praxisEdit && !$_SESSION['DBStatus']['doPracticaExist']) ||
        ($tempPraxis && isset($_SESSION['tempAmorData'][$i])))
        echo " checked=\"checked\"";

    echo " />\n";
    echo "\t\t\t\t\t\t\t\t\t\t\t<label for=\"amorOriginNew[".$i."]\">".
        _("New lover");
    if (isset($_SESSION['tempAmorData']))
        echo " (".$_SESSION['tempAmorData'][$i]['alias'].")";
    echo "</label>\n";
    echo "\t\t\t\t\t\t\t\t\t\t\t<button id=\"amorNew[".$i.
        "]\" type=\"button\">";
    echo isset($_SESSION['tempAmorData'][$i]) ?
        _("Edit lover...") :
        _("Add lover...");
    echo "</button>\n";
    echo "\t\t\t\t\t\t\t\t\t\t</td>\n";
    echo "\t\t\t\t\t\t\t\t\t\t<td style=\"width: 85px;\">\n";
    echo "\t\t\t\t\t\t\t\t\t\t\t<button type=\"button\" id=\"addAmor[".$i.
        "]\">+</button>\n";
    if ($i > 0)
        echo "\t\t\t\t\t\t\t\t\t\t\t<button type=\"button\" id=\"removeAmor[".
            $i."]\">-</button>\n";
    echo "\t\t\t\t\t\t\t\t\t\t</td>\n";
    echo "\t\t\t\t\t\t\t\t\t</tr>\n";
    
    // if there are more than one lover, an horizontal ruler is displayed:
    if ($amoresAmount > 1) {
        
        echo "\t\t\t\t\t\t\t\t\t<tr id=\"hrAfterAmor".($i + 1)."\">\n";
        echo "\t\t\t\t\t\t\t\t\t\t<td colspan=\"3\">\n";
        echo "\t\t\t\t\t\t\t\t\t\t\t<hr />\n";
        echo "\t\t\t\t\t\t\t\t\t\t</td>\n";
        echo "\t\t\t\t\t\t\t\t\t</tr>\n";
        
    }

}

echo "\t\t\t\t\t\t\t\t</table>\n";

echo "\t\t\t\t\t\t\t</fieldset>\n"; // }} lover

echo "\t\t\t\t\t\t</fieldset><!-- general data -->\n"; // }} general data
echo "\t\t\t\t\t</div>\n";

/*
 * section ii) description.
 */

echo "\t\t\t\t\t<div id=\"descr\">\n";
echo "\t\t\t\t\t\t<fieldset>\n";
echo "\t\t\t\t\t\t\t<legend>"._("Description")."</legend>\n";
echo "\t\t\t\t\t\t\t<textarea id=\"descrTxt\" name=\"descr\"".
    " style=\"width: 100%; height: 200px;\">";
if ($praxisEdit)
    echo $praxis->getDescr();
else if ($tempPraxis)
    echo $_SESSION['tempPraxisData']['descr'];
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
if ($praxisEdit && ($praxis->getTQ() === 0) ||
    ($tempPraxis && ($_SESSION['tempPraxisData']['rating'] === 0)))
    echo " selected=\"selected\"";
echo ">"._("undefined")."</option>\n";

echo "\t\t\t\t\t\t\t\t<option value=\"1\"";
if ($praxisEdit && ($praxis->getTQ() === 1) ||
    ($tempPraxis && ($_SESSION['tempPraxisData']['rating'] === 1)))
    echo " selected=\"selected\"";
echo ">"._("E_PRIVATE")."</option>\n";

echo "\t\t\t\t\t\t\t\t<option value=\"2\"";
if ($praxisEdit && ($praxis->getTQ() === 2) ||
    ($tempPraxis && ($_SESSION['tempPraxisData']['rating'] === 2)))
    echo " selected=\"selected\"";
echo ">"._("E_EDIT_TO_SHARE")."</option>\n";

echo "\t\t\t\t\t\t\t\t<option value=\"3\"";
if ($praxisEdit && ($praxis->getTQ() === 3) ||
    ($tempPraxis && ($_SESSION['tempPraxisData']['rating'] === 3)))
    echo " selected=\"selected\"";
echo ">"._("E_SHARE")."</option>\n";

echo "\t\t\t\t\t\t\t\t<option value=\"4\"";
if ($praxisEdit && ($praxis->getTQ() === 4) ||
    ($tempPraxis && ($_SESSION['tempPraxisData']['rating'] === 4)))
    echo " selected=\"selected\"";
echo ">"._("E_SHARE_TO_BROADCAST")."</option>\n";

echo "\t\t\t\t\t\t\t\t<option value=\"5\"";
if ($praxisEdit && ($praxis->getTQ() === 5) ||
    ($tempPraxis && ($_SESSION['tempPraxisData']['rating'] === 5)))
    echo " selected=\"selected\"";
echo ">"._("E_BROADCAST")."</option>\n";

echo "\t\t\t\t\t\t\t</select><br />\n";

// field 'tl':

echo "\t\t\t\t\t\t\t<label for=\"tl\">"._("TL:")."</label>\n";
echo "\t\t\t\t\t\t\t<select id=\"tl\" name=\"tl\">\n";

echo "\t\t\t\t\t\t\t\t<option value=\"0\"";
if ($praxisEdit && ($praxis->getTL() === 0) ||
    ($tempPraxis && ($_SESSION['tempPraxisData']['rating'] === 0)))
    echo " selected=\"selected\"";
echo ">"._("undefined")."</option>\n";

echo "\t\t\t\t\t\t\t\t<option value=\"1\"";
if ($praxisEdit && ($praxis->getTL() === 1) ||
    ($tempPraxis && ($_SESSION['tempPraxisData']['rating'] === 1)))
    echo " selected=\"selected\"";
echo ">"._("E_LANG1")."</option>\n";

echo "\t\t\t\t\t\t\t\t<option value=\"2\"";
if ($praxisEdit && ($praxis->getTL() === 2) ||
    ($tempPraxis && ($_SESSION['tempPraxisData']['rating'] === 2)))
    echo " selected=\"selected\"";
echo ">"._("E_LANG2")."</option>\n";

echo "\t\t\t\t\t\t\t\t<option value=\"3\"";
if ($praxisEdit && ($praxis->getTL() === 3) ||
    ($tempPraxis && ($_SESSION['tempPraxisData']['rating'] === 3)))
    echo " selected=\"selected\"";
echo ">"._("E_LANG3")."</option>\n";

echo "\t\t\t\t\t\t\t\t<option value=\"4\"";
if ($praxisEdit && ($praxis->getTL() === 4) ||
    ($tempPraxis && ($_SESSION['tempPraxisData']['rating'] === 4)))
    echo " selected=\"selected\"";
echo ">"._("E_LANG4")."</option>\n";

echo "\t\t\t\t\t\t\t\t<option value=\"5\"";
if ($praxisEdit && ($praxis->getTL() === 5) ||
    ($tempPraxis && ($_SESSION['tempPraxisData']['rating'] === 5)))
    echo " selected=\"selected\"";
echo ">"._("E_LANG5")."</option>\n";

echo "\t\t\t\t\t\t\t</select><br />\n";

echo "\t\t\t\t\t\t</fieldset><!-- other data -->\n";
echo "\t\t\t\t\t</div>\n";

// form footer:
echo "\t\t\t\t\t<p><sup>*</sup>"._("compulsory fields")."</p>\n";
   
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