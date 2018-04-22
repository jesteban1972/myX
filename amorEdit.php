<?php
/**
 * script 'amorEdit.php'.
 * 
 * this is the script used for both adding a new lover
 * or to edit an existing one.
 * the value of $_POST['loverID'] is used to differentiate both scenarios:
 * if the variable is set, the flag $amorEdit is set to true
 * and a Amor object is instantiated to work with;
 * otherwise $amorEdit is set to false.
 * this script echoes a form whose fields correspond with those of the table
 * 'amores'.
 * (c) Joaquin Javier ESTEBAN MARTINEZ
 * last updated 2018-04-20
*/

require_once 'session.inc';
//require_once 'core.inc';
//require_once 'DB.inc';
//require_once 'praxis.inc';
require_once 'amor.inc';
//require_once 'locus.inc';

if ($_SERVER['REQUEST_METHOD'] !== "POST") {
    /*
     * script called from outside the normal flush, throw exception
     */
    header ("Location: index.php");
    
}
    
// amorEdit is set and eventually an object of class 'Amor' instantiated:
if (isset($_POST['amorID'])) { // script called from 'amor.php'

    $amorEdit = true;
    $amor = new Amor(intval($_POST['amorID']));

} else { // script called from 'amores.php'

    $amorEdit = false;
    
}

// get a DB connection to work with:
//$pdo = DB::getDBHandle();

$title = $amorEdit ? _("Edit lover") : _("New lover");
$js = "amorEdit.js";

include 'header.inc'; // header of all the pages of the app
echo "\t\t\t<section> <!-- section {{ -->\n";

// the form is echoed:

echo "\t\t\t\t<form action=\"amorEditProcess.php\"".
    " method=\"POST\" accept-charset=\"utf-8\">\n";

/*
 * section i) general data.
 */

echo "\t\t\t\t\t<div id=\"generalData\">\n";
echo "\t\t\t\t\t\t<fieldset>\n";
echo "\t\t\t\t\t\t\t<legend>"._("General data")."</legend>\n";

// alias:
echo "\t\t\t\t\t\t\t<label for=\"alias\">"._("Alias:")." </label>\n";
echo "\t\t\t\t\t\t\t<input type=\"text\" name=\"alias\" value=\"";
if ($amorEdit)
    echo $amor->getAlias();
echo "\" style=\"width: 80%\" /><br />\n";

// rating:

echo "\t\t\t\t\t\t\t<label for=\"rating\">"._("Rating:")." </label>\n";
echo "\t\t\t\t\t\t\t<select name=\"rating\">\n";

echo "\t\t\t\t\t\t\t\t<option value=\"0\"";
if ($amorEdit && ($amor->getRating() === 0))
    echo " selected=\"selected\"";
echo ">"._("undefined")."</option>\n";

echo "\t\t\t\t\t\t\t\t<option value=\"1\"";
if ($amorEdit && ($amor->getRating() === 1))
    echo " selected=\"selected\"";
echo ">"._("very bad")."</option>\n";

echo "\t\t\t\t\t\t\t\t<option value=\"2\"";
if ($amorEdit && ($amor->getRating() === 2))
    echo " selected=\"selected\"";
echo ">"._("bad")."</option>\n";

echo "\t\t\t\t\t\t\t\t<option value=\"3\"";
if ($amorEdit && ($amor->getRating() === 3))
    echo " selected=\"selected\"";
echo ">"._("good")."</option>\n";

echo "\t\t\t\t\t\t\t\t<option value=\"4\"";
if ($amorEdit && ($amor->getRating() === 4))
    echo " selected=\"selected\"";
echo ">"._("very good")."</option>\n";

echo "\t\t\t\t\t\t\t\t<option value=\"5\"";
if ($amorEdit && ($amor->getRating() === 5))
    echo " selected=\"selected\"";
echo ">"._("excellent")."</option>\n";

echo "\t\t\t\t\t\t\t</select><br />\n";

// genre:

echo "\t\t\t\t\t\t\t<label for=\"genre\">"._("Genre:")." </label>\n";
echo "\t\t\t\t\t\t\t<select name=\"genre\">\n";

echo "\t\t\t\t\t\t\t\t<option value=\"1\"";
if ($amorEdit && ($amor->getGenre() === GENRE_MASCULINE))
    echo " selected=\"selected\"";
echo ">"._("man")."</option>\n";

echo "\t\t\t\t\t\t\t\t<option value=\"2\"";
if ($amorEdit && ($amor->getGenre() === GENRE_FEMININE))
    echo " selected=\"selected\"";
echo ">"._("woman")."</option>\n";

echo "\t\t\t\t\t\t\t</select><br />\n";

echo "\t\t\t\t\t\t</fieldset>\n";
echo "\t\t\t\t\t</div>\n";

/*
 * section ii) description.
 */

echo "\t\t\t\t\t<div id=\"description\">\n";
echo "\t\t\t\t\t\t<fieldset>\n";
echo "\t\t\t\t\t\t\t<legend>"._("Description")."</legend>\n";

echo "\t\t\t\t\t\t\t<label for=\"descr1\">"._("Description 1");
if (isset($_SESSION['userOptions']['descr1']) &&
    ($_SESSION['userOptions']['descr1'] !== ""))
        echo " (".$_SESSION['userOptions']['descr1'].")";
echo ":</label><br />\n";
echo "\t\t\t\t\t\t\t<input type=\"text\" name=\"descr1\" value=\"";
if ($amorEdit)
    echo $amor->getDescr1();
echo "\" style=\"width: 100%\" /><br />\n";

echo "\t\t\t\t\t\t\t<label for=\"descr2\">"._("Description 2");
if (isset($_SESSION['userOptions']['descr2']) &&
    ($_SESSION['userOptions']['descr2'] !== ""))
        echo " (".$_SESSION['userOptions']['descr2'].")";
echo ":</label><br />\n";
echo "\t\t\t\t\t\t\t<input type=\"text\" name=\"descr2\" value=\"";
if ($amorEdit)
    echo $amor->getDescr2();
echo "\" style=\"width: 100%\" /><br />\n";

echo "\t\t\t\t\t\t\t<label for=\"descr3\">"._("Description 3");
if (isset($_SESSION['userOptions']['descr3']) &&
    ($_SESSION['userOptions']['descr3'] !== ""))
        echo " (".$_SESSION['userOptions']['descr3'].")";
echo ":</label><br />\n";
echo "\t\t\t\t\t\t\t<input type=\"text\" name=\"descr3\" value=\"";
if ($amorEdit)
    echo $amor->getDescr3();
echo "\" style=\"width: 100%\" /><br />\n";

echo "\t\t\t\t\t\t\t<label for=\"descr4\">"._("Description 4");
if (isset($_SESSION['userOptions']['descr4']) &&
    ($_SESSION['userOptions']['descr4'] !== ""))
        echo " (".$_SESSION['userOptions']['descr4'].")";
echo ":</label><br />\n";
echo "\t\t\t\t\t\t\t<input type=\"text\" name=\"descr4\" value=\"";
if ($amorEdit)
    echo $amor->getDescr4();
echo "\" style=\"width: 100%\" /><br />\n";

echo "\t\t\t\t\t\t</fieldset><!-- description -->\n";
echo "\t\t\t\t\t</div>\n";

/*
 * section iii) other data.
 */

echo "\t\t\t\t\t<div id=\"otherData\">\n";
echo "\t\t\t\t\t\t<fieldset>\n";
echo "\t\t\t\t\t\t\t<legend>"._("Other data")."</legend>\n";

// web:
echo "\t\t\t\t\t\t\t<label for=\"web\">"._("Web:")." </label>\n";
echo "\t\t\t\t\t\t\t<input type=\"text\" name=\"web\" value=\"";
if ($amorEdit)
    echo $amor->getWeb();
echo "\" /><br />\n";

// name:
echo "\t\t\t\t\t\t\t<label for=\"name\">"._("Name:")." </label>\n";
echo "\t\t\t\t\t\t\t<input type=\"text\" name=\"name\" value=\"";
if ($amorEdit)
    echo $amor->getName();
echo "\" /><br />\n";

// photo:
// favorite:
echo "\t\t\t\t\t\t\t<input type=\"checkbox\" name=\"favorite\"";
if ($amorEdit && $amor->getPhoto())
    echo " checked=\"checked\"";
echo " />\n";
echo "\t\t\t\t\t\t\t<label for=\"favorite\">"._("Photo")."</label><br />\n";

// telephone:
echo "\t\t\t\t\t\t\t<label for=\"telephone\">"._("Telephone:")." </label>\n";
echo "\t\t\t\t\t\t\t<input type=\"text\" name=\"telephone\" value=\"";
if ($amorEdit)
    echo $amor->getPhone();
echo "\" /><br />\n";

// email:
echo "\t\t\t\t\t\t\t<label for=\"email\">"._("Email:")." </label>\n";
echo "\t\t\t\t\t\t\t<input type=\"text\" name=\"email\" value=\"";
if ($amorEdit)
    echo $amor->getEmail();
echo "\" /><br />\n";

// other:
echo "\t\t\t\t\t\t\t<label for=\"other\">"._("Other:")." </label>\n";
echo "\t\t\t\t\t\t\t<input type=\"text\" name=\"other\" value=\"";
if ($amorEdit)
    echo $amor->getOther();
echo "\" /><br />\n";

echo "\t\t\t\t\t\t</fieldset>\n";
echo "\t\t\t\t\t</div>\n";

// form footer:

if ($amorEdit)
    echo "\t\t\t\t\t<input type=\"hidden\" name=\"amorID\" value=\"".
        $amor->getAmorID()."\" />\n";

echo "\t\t\t\t\t<input type=\"submit\" value=\""._("Submit data")."\" />\n";
echo "\t\t\t\t\t<input type=\"button\" name=\"cancel\" value=\""._("Cancel").
    "\" onclick=\"javascript: history.back();\" />\n";
echo "\t\t\t\t</form>\n";


echo "\t\t\t</section> <!-- }} section -->\n\n";
require_once 'footer.inc'; // footer of all the pages of the app

?>