<?php

/**
 * script amorEdit.php
 * contains the form to edit a lover or to add a new one
 * (c) Joaquin Javier ESTEBAN MARTINEZ
 * last updated 2018-01-04
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
    
if (isset($_POST['amorID'])) { // script called from 'amor.php'

    $amorEdit = true;
    $amor = new Amor(intval($_POST['amorID']));

} else { // script called from 'amores.php'

    $amorEdit = false;
}


$title = $amorEdit ? _("Edit lover") : _("New lover");
include 'header.inc'; // header of all the pages of the app
echo "\t\t\t<section> <!-- section {{ -->\n";

// the form is echoed:

echo "\t\t\t\t<form action=\"amorEditProcess.php\" method=\"POST\" accept-charset=\"utf-8\">\n";
echo "\t\t\t\t\t<fieldset>\n";
echo "\t\t\t\t\t\t<legend>"._("General data")."</legend>\n";

// alias:
echo "\t\t\t\t\t\t<label for=\"alias\">".
    _("Alias:").
    " </label>\n";
echo "\t\t\t\t\t\t<input type=\"text\" name=\"alias\" value=\"";
if ($amorEdit)
    echo $amor->getAlias();
echo "\" /><br />\n";

// genre:
echo "\t\t\t\t\t\t<label for=\"genre\">".
    _("Genre:").
    " </label>\n";
echo "\t\t\t\t\t\t<select name=\"genre\">\n";

echo "\t\t\t\t\t\t\t<option value=\"1\"";
if ($amorEdit && ($amor->getGenre() === GENRE_MASCULINE))
    echo " selected=\"selected\"";
echo ">".
    _("man").
    "</option>\n";

echo "\t\t\t\t\t\t\t<option value=\"2\"";
if ($amorEdit && ($amor->getGenre() === GENRE_FEMININE))
    echo " selected=\"selected\"";
echo ">".
    _("woman").
    "</option>\n";

echo "\t\t\t\t\t\t</select><br />\n";

// description:
echo "\t\t\t\t\t\t<label for=\"description1\">".
    _("Description (1/4):").
    " </label>\n";
echo "\t\t\t\t\t\t<input type=\"text\" name=\"description1\" value=\"";
if ($amorEdit)
    echo $amor->getDescription1();
echo "\" /><br />\n";
echo "\t\t\t\t\t\t<label for=\"description2\">".
    _("Description (2/4):").
    " </label>\n";
echo "\t\t\t\t\t\t<input type=\"text\" name=\"description2\" value=\"";
if ($amorEdit)
    echo $amor->getDescription2();
echo "\" /><br />\n";
echo "\t\t\t\t\t\t<label for=\"description3\">".
    _("Description (3/4):").
    " </label>\n";
echo "\t\t\t\t\t\t<input type=\"text\" name=\"description3\" value=\"";
if ($amorEdit)
    echo $amor->getDescription3();
echo "\" /><br />\n";
echo "\t\t\t\t\t\t<label for=\"description4\">".
    _("Description (4/4):").
    " </label>\n";
echo "\t\t\t\t\t\t<input type=\"text\" name=\"description4\" value=\"";
if ($amorEdit)
    echo $amor->getDescription4();
echo "\" /><br />\n";

// rating:
echo "\t\t\t\t\t\t<label for=\"rating\">".
    _("Rating:").
    " </label>\n";
echo "\t\t\t\t\t\t<select name=\"rating\">\n";

echo "\t\t\t\t\t\t\t<option value=\"0\"";
if ($amorEdit && ($amor->getRating() === 0))
    echo " selected=\"selected\"";
echo ">".
    _("undefined").
    "</option>\n";

echo "\t\t\t\t\t\t\t<option value=\"1\"";
if ($amorEdit && ($amor->getRating() === 1))
    echo " selected=\"selected\"";
echo ">".
    _("very bad").
    "</option>\n";

echo "\t\t\t\t\t\t\t<option value=\"2\"";
if ($amorEdit && ($amor->getRating() === 2))
    echo " selected=\"selected\"";
echo ">".
    _("bad").
    "</option>\n";

echo "\t\t\t\t\t\t\t<option value=\"3\"";
if ($amorEdit && ($amor->getRating() === 3))
    echo " selected=\"selected\"";
echo ">".
    _("good").
    "</option>\n";

echo "\t\t\t\t\t\t\t<option value=\"4\"";
if ($amorEdit && ($amor->getRating() === 4))
    echo " selected=\"selected\"";
echo ">".
    _("very good").
    "</option>\n";

echo "\t\t\t\t\t\t\t<option value=\"5\"";
if ($amorEdit && ($amor->getRating() === 5))
    echo " selected=\"selected\"";
echo ">".
    _("excellent").
    "</option>\n";

echo "\t\t\t\t\t\t</select><br />\n";

echo "\t\t\t\t\t</fieldset>\n";
echo "\t\t\t\t\t<fieldset>\n";
echo"\t\t\t\t\t\t<legend>Complementary data</legend>\n";

// web:
echo "\t\t\t\t\t\t<label for=\"web\">".
    _("Web:").
    " </label>\n";
echo "\t\t\t\t\t\t<input type=\"text\" name=\"web\" value=\"";
if ($amorEdit)
    echo $amor->getWww();
echo "\" /><br />\n";

// name:
echo "\t\t\t\t\t\t<label for=\"name\">".
    _("Name:").
    " </label>\n";
echo "\t\t\t\t\t\t<input type=\"text\" name=\"name\" value=\"";
if ($amorEdit)
    echo $amor->getName();
echo "\" /><br />\n";

// photo:
echo "\t\t\t\t\t\t<label for=\"photo\">".
    _("Photo:").
    " </label>\n";
echo "\t\t\t\t\t\t<input type=\"text\" name=\"photo\" value=\"";
if ($amorEdit)
    echo $amor->getPhoto();
echo "\" /><br />\n";

// telephone:
echo "\t\t\t\t\t\t<label for=\"telephone\">".
    _("Telephone:").
    " </label>\n";
echo "\t\t\t\t\t\t<input type=\"text\" name=\"telephone\" value=\"";
if ($amorEdit)
    echo $amor->getTelephone();
echo "\" /><br />\n";

// email:
echo "\t\t\t\t\t\t<label for=\"email\">".
    _("Email:").
    " </label>\n";
echo "\t\t\t\t\t\t<input type=\"text\" name=\"email\" value=\"";
if ($amorEdit)
    echo $amor->getEmail();
echo "\" /><br />\n";

// other:
echo "\t\t\t\t\t\t<label for=\"other\">".
    _("Web:").
    " </label>\n";
echo "\t\t\t\t\t\t<input type=\"text\" name=\"other\" value=\"";
if ($amorEdit)
    echo $amor->getOther();
echo "\" /><br />\n";

echo "\t\t\t\t\t</fieldset>\n";

if ($amorEdit)
    echo "\t\t\t\t\t<input type=\"hidden\" name=\"amorID\" value=\"".
        $amor->getAmorID().
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