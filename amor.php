<?php

/**
 * script amor.php
 * displays the detail page of one lover
 * (c) Joaquin Javier ESTEBAN MARTINEZ
 * last updated 2018-01-23
*/

require_once 'session.inc';
require_once 'core.inc';
require_once 'DB.inc';
require_once 'praxis.inc';
require_once 'amor.inc';
require_once 'locus.inc';


// 1. get a DB connection to work with:
$pdo = DB::getDBHandle();

/*
 * amorID is retrieved from $_GET (intval needed)
 * and an object of the class 'Amor' is instantiated using it.
 * this object will be used all throught this script.
 */
$amor = new Amor(intval($_GET['amorID']));

$title = _("Lover");
include 'header.inc'; // header of all the pages of the app
echo "\t\t\t<section> <!-- section {{ -->\n";

$amorAlias = $amor->getAlias(); // also used below in $amorSideview

echo "\t\t\t\t<p class=\"medium\">";
echo "<img src=\"".getImage("amor","small")."\" alt=\"".
    _("(Image of a cycladic idol)").
    "\" />";
echo "<b>{$amorAlias}</b></p>\n";

echo <<<HTML
                <!-- Script amor.php. Part 0: Navigation links -->
                <article id="start">

HTML;

// links to sections:
echo "\t\t\t\t\t<ul>\n";
echo "\t\t\t\t\t\t<li><a href=\"#data\">".
        _("Data").
        "</a></li>\n";
echo "\t\t\t\t\t\t<li><a href=\"#practica\">".
        _("List of experiences").
        "</a></li>\n";
echo "\t\t\t\t\t\t<li><a href=\"#alia\">".
        _("Other data")."</a></li>\n";
echo "\t\t\t\t\t\t<li><a href=\"#actions\">".
        _("Actions")."</a></li>\n";
echo "\t\t\t\t\t</ul>\n";
                    
echo <<<HTML
                </article>

                <!-- Script amor.php. Part I: General data -->
                <article id="data">
                    <h1 onMouseOver="this.innerHTML='1. GENERALIA i.e. general data';" onMouseOut="this.innerHTML='1. GENERALIA';">1. GENERALIA</h1>

HTML;

// alias and evaluation:
echo "\t\t\t\t\t<p class=\"medium\">";

if (DEBUG) {
    
    echo " <span class=\"debug\">[amorID: ".$amor->getAmorID()."]</span> ";
    
}

echo _("Alias and rating").": <b>".$amorAlias."</b> - ";
echo writtenRate($amor->getRating(), TRUE);
echo " </p>\n";

// genre:
echo "\t\t\t\t\t<p class=\"medium\">".
    _("Genre:").
    $amor->getGenre().
    "</p>\n";

// other (TODELETE!!!)
if ($amor->getOther() !== "") {
	echo "\t\t\t\t\t\t<p>".
            _("Other data").
            ": <b>".
            $amor->getOther().
            "</b></p>\n";
}

// description:
$description1 = $amor->getDescription1();
$description2 = $amor->getDescription2();
$description3 = $amor->getDescription3();
$description4 = $amor->getDescription4();

echo <<<HTML
                    <table id="description">
                        <tr style="text-align: center;">
                            <td colspan="2"><p>
HTML;

echo _("DESCRIPTIO i.e. description");

echo <<<HTML
</p></td>
                        </tr>
                        <tr>
                            <td>(1/4)</td>
                            <td><p>{$description1}</p></td>
                        </tr>

HTML;

if ($description2 !== "") {
	
    echo <<<HTML
                        <tr>
                            <td>(2/4)</td>
                            <td><p>{$description2}</p></td>
                        </tr>

HTML;
    
} // if

if ($description3 !== "") {
    
    echo <<<HTML
                        <tr>
                            <td>(3/4)</td>
                            <td><p>{$description3}</p></td>
                        </tr>

HTML;

} // if

if ($description4 !== "") {
    
    echo <<<HTML
                        <tr>
                            <td>(4/4)</td>
                            <td><p>{$description4}</p></td>
                        </tr>
HTML;

} // if
    
echo "\n";

echo <<<HTML
                    </table>
                </article>

HTML;

echo <<<HTML

                <!-- script amor.php. part ii: experiences list -->
                <article id="practica">
                    <h1 onMouseOver="this.innerHTML='2. ELENCHUS i.e. list of the xperiences with her/him';" onMouseOut="this.innerHTML='2. ELENCHUS';">2. ELENCHUS</h1>

HTML;

$locaAmount = $amor->getPracticaAmount();

echo "\t\t\t\t\t<p>";
switch ($amor->getGenre()) {
    
    case GENRE_MASCULINE:
        echo _("Lived with him");
        break;
    case GENRE_FEMININE:
        echo _("Lived with her");
        break;
}
echo " <b>".
    writtenNumber($locaAmount, FEMENINE);
echo ($locaAmount > 1) ? " experiences" : " experience";
echo "</b>.</p>\n";
echo "\t\t\t\t\t<p>".
    _("Chronologic list follows").
    "</p>\n";



/*
 * page settings
 * the script retrieves from the URI the parameter list (v.gr. page=69)
 * in order to display a navigation bar (if neccessary) and to put an ordinal
 * before each entry of the catalogue
 */

/*
 * retrieves the parameter list and composes the string
 * $datatring (without page) that will be passed to navigationBar()
 */
$uri = $_SERVER['REQUEST_URI'];
$uriQuery = parse_url($uri)['query'];
// parse_url: parse a URL, and return its components

$data = explode("&", $uriQuery);
$dataString = "";
foreach ($data as $value) {

    if (substr($value, 0, 5) != "page=") {

            $dataString .= $value;
    }
	 
} // foreach block

// retrieves the current page, NULL if not set
$currentPage = ($_GET['page'] !== NULL) ? intval($_GET['page']) : 1; // $page is 1-based

$pageSettings = pageSettings($xperiencesAmount, $currentPage);
$pagesAmount = $pageSettings['numPages'];
$ordinal = $pageSettings['ordinal'];
$ordinalZeroBased = $ordinal - 1;

// displays top navigation bar
if ($pageSettings['navigationBar']) {
    
    navigationBar($_SERVER['PHP_SELF'], $dataString, $currentPage, $pagesAmount);
        
}

//////////////////////////////////////////////////////////////////////////////////////////
// experiences list


// get an array with all praxisIDs:
$practica = $amor->getPractica();

foreach ($practica as $praxisID) {
    
    // instantiate a 'praxis' object:
    $praxis = new Praxis($praxisID);
    
    // call the method Praxis::XHTMLPreview
    // to display a brief preview of the experience:
    $praxis->HTMLPreview($ordinal, Praxis::PARTICIPANTS);
    
    // increases the ordinal number by one:
    $ordinal++;
    
}

// link to top of the page:
echo "\t\t\t\t\t<p style=\"text-align: center;\">".
    "<img src=\"images/arrow_top.gif\" />".
    " <a href=\"#start\">".
    _("Back to top").
    "</a></p>\n";

echo <<<HTML
                </article>

HTML;

/*
 * complementary data
 */

if ($amor->getAchtung() !== ""
	|| $amor->getWww() !== ""
	|| $amor->getName() !== ""
	|| $amor->getPhoto() !== ""
	|| $amor->getTelephone() !== ""
	|| $amor->getEmail() !== ""
	|| $amor->getOther() !== "") {
    
    
    echo <<<HTML

                <!-- script amor.php. part iii: other -->
                <article id="alia">
                    <h1 onMouseOver="this.innerHTML='3. ALTERA i.e. complementary data';" onMouseOut="this.innerHTML='3. ALTERA';">3. ALTERA</h1>

HTML;

    if ($amor->getAchtung() !== "")
        echo "\t\t\t\t\t<p>".
            _("Achtung:").
            " <b>".
            $amor->getAchtung().
            "</b>.</p>\n";

    if ($amor->getWww() !== "")
        echo "\t\t\t\t\t<p>".
            _("Web:").
            " <b>".
            $amor->getWww().
            "</b>.</p>\n";

    if ($amor->getName() !== "")
        echo "\t\t\t\t\t<p>".
            _("Name:").
            " <b>".
            $amor->getName().
            "</b>.</p>\n";

    if ($amor->getPhoto() !== "")
        echo "\t\t\t\t\t<p>".
            _("Pictures:").
            " <b>".
            $amor->getPhoto().
            "</b>.</p>\n";

    if ($amor->getTelephone() !== "")
        echo "\t\t\t\t\t<p>".
            _("Telephone:").
            " <b>".
            $amor->getTelephone().
            "</b>.</p>\n";

    if ($amor->getEmail() !== "")
        echo "\t\t\t\t\t<p>".
            _("Email:").
            " <b>".
            $amor->getEmail().
            "</b>.</p>\n";

    if ($amor->getOther() !== "")
        echo "\t\t\t\t\t<p>".
            _("Other data:").
            " <b>".
            $amor->getOther().
            "</b>.</p>\n";
    
} // if

echo <<<HTML
                </article>

                <!-- script locus.php. part iv: actions -->
                <article id="actions">

HTML;

echo "\t\t\t\t\t<h1 onMouseOver=\"this.innerHTML='".
        _("ACTIONS i.e. XXX").
        "';\" onMouseOut=\"this.innerHTML='".
        _("ACTIONS").
        "';\">".
        _("ACTIONS").
        "</h1>\n";

// edit lover form:
echo "\t\t\t\t\t<form action=\"amorEdit.php\" method=\"POST\">\n";
echo "\t\t\t\t\t\t<input type=\"hidden\" name=\"amorID\" value=\"".
    $amor->getAmorID().
    "\" />\n";
echo "\t\t\t\t\t\t<input type=\"submit\" value=\"".
    _("Edit lover").
    "\" />\n";
echo "\t\t\t\t\t</form>\n";

// delete lover form:
echo "\t\t\t\t\t<form action=\"amorDelete.php\" method=\"POST\">\n";
echo "\t\t\t\t\t\t<input type=\"hidden\" name=\"amorID\" value=\"".
    $amor->getAmorID().
    "\" />\n";
echo "\t\t\t\t\t\t<input type=\"submit\" value=\"".
    _("Delete lover").
    "\" />\n";
echo "\t\t\t\t\t</form>\n";
                            
// link to previous page:
echo "\t\t\t\t\t<p style=\"text-align: center;\">".
    "<img src=\"images/arrow_back.gif\" />".
    " <a href=\"javascript: history.back();\">".
    _("Back to previous").
    "</a></p>\n";

echo "\t\t\t\t</article>\n";

HTML;

//// $xperienceSideview displays a sommary of the xperience in the sidebar
//// 1-step creation
//$praxisSideview = "\t\t\t\t\t\t<div class=\"HTML_preview_sidebar\">PRAXIS<br /><br />@";
//$praxisSideview .= $praxisLocus;
//$praxisSideview .= "<br /><br />τῇ ";
//$praxisSideview .= $dateString;
//if ($praxisOrdinal !== "") {
//
//    $praxisSideview .= $praxisOrdinal;
//    
//}
//$praxisSideview .= "<br /><br /><b>";
//$praxisSideview .= $praxisName;
//$praxisSideview .= "</b><br /><br />";
//$praxisSideview .= writtenRate($praxisRating, false);
//$praxisSideview .= "</div>";
//
//$_SESSION['praxisSideview'] = $praxisSideview; // stores $praxisSideview in $_SESSION to be read from sidebar.inc

echo "\t\t\t</section> <!-- }} section -->\n\n";
require_once 'footer.inc'; // footer of all the pages of the app

?>