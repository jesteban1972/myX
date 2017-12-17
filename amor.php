<?php

/**
 * script amor.php
 * displays the detail page of one lover
 * (c) Joaquin Javier ESTEBAN MARTINEZ
 * last updated 2017-12-14
*/

require_once 'session.inc';
require_once 'core.inc';
require_once 'DB.inc';
require_once 'praxis.inc';
require_once 'amor.inc';
require_once 'locus.inc';


// 1. get a DB connection to work with:
$pdo = DB::getDBHandle();


$title = "Amor";
include 'header.inc'; // header of all the pages of the app

/*
 * amorID is retrieved from $_GET (intval needed)
 * and an object of the class 'Amor' is instantiated using it.
 * this object will be used all throught this script.
 */
$amor = new Amor(intval($_GET['amorID']));

$amorAlias = $amor->getAlias(); // also used below in $amorSideview

echo "\t\t\t\t\t\t<p class=\"medium\"><b>{$amorAlias}</b></p>\n";

echo <<<HTML
                    <!-- Script amor.php. Part 0: Navigation links -->
                    <article id="start">
                        <p class="center"><a href="#data"><img src="images/generalia-medium.jpg" title="General data" /></a><a href="#catalogue">List of experiences<img src="images/ampelmaenchen_rot.gif" style="width: 15px; height: 15px;"</a>
	<a href="#alia"><img src="images/altera-medium.jpg" title="Other data" /></a></p>
                        <p style="text-align: center"><img src="images/arrow_back.gif" /> <a href="history.back();">Back to previous page</a></p>
                    </article>
                    
                    <!-- Script amor.php. Part I: General data -->
                    <article id="data">
                        <h1 onMouseOver="this.innerHTML='1. GENERALIA i.e. general data';" onMouseOut="this.innerHTML='1. GENERALIA';">1. GENERALIA</h1>

HTML;

// 1. alias, evaluation, detailed alias comps
echo "\t\t\t\t\t\t<p class=\"medium\">";

if (DEBUG) {
    
    echo " <span class=\"debug\">[amorID: ".$amor->getAmorID()."]</span> ";
    
}

echo "Alias and rating: <b>{$amorAlias}</b> - ";
echo writtenRate($amor->getRating(), TRUE);
echo " </p>\n";

// 2. other
if ($amor->getOther() !== "") {
	echo "\t\t\t\t\t\t<p>Other data: <b>{$amor->getOther()}</b></p>\n";
}

// 3. description
$description1 = $amor->getDescription1();
$description2 = $amor->getDescription2();
$description3 = $amor->getDescription3();
$description4 = $amor->getDescription4();

echo <<<HTML
                        <table align="center" border="1">
                            <tr>
                                <td>
                                    <table border="0">
                                        <tr style="text-align: center;">
                                            <td colspan="2"><p>DESCRIPTIO i.e. description</p></td>
                                        </tr>
                                        <tr>
                                            <td valign="middle"><img src="images/descriptio1-small.jpg" alt="Γενικὴ περιγραφή" /></td><td valign="middle"><p class="medium" style="margin-top: 0em">{$description1}</p></td>
                                        </tr>

HTML;

if ($description2 !== "") {
	
    echo <<<HTML
                                        <tr>
                                            <td valign="middle"><img src="images/descriptio2-small.jpg" alt="Περιγραφή σώματος" /></td><td><p class="medium" style="margin-top: 0em;">{$description2}</p></td>
                                        </tr>

HTML;
    
    } // if

if ($description3 !== "") {
    
    echo <<<HTML
                                        <tr>
                                            <td valign="middle"><img src="images/descriptio3-small.jpg" alt="Περιγραφὴ ἐμπροσθίων γεννητικῶν ὀργάνων" /></td><td><p class="medium" style="margin-top: 0em;">{$description3}</p></td>
                                        </tr>

HTML;

    } // if

if ($description4 !== "") {
    
    echo <<<HTML
                                        <tr>
                                            <td valign="middle"><img src="images/descriptio4-small.jpg" alt="Περιγραφὴ ὀπισθίων γεννητικῶν ὀργάνων" /></td><td><p class="medium" style="margin-top: 0em;">{$description4}</p></td>
                                        </tr>
HTML;

    } // if
    
echo "\n";

echo <<<HTML
                                    </td>
                                </tr>
                            </table>
                        </table>
                        <p style="text-align: center;"><img src="images/arrow_top.gif" /> <a href="#start">Top of the page</a></p>
                    </article>

                    <!-- Script amor.php. Part II: experiences list -->
                    <article id="practicaList">
                        <h1 onMouseOver="this.innerHTML='2. ELENCHUS i.e. list of the xperiences with her/him';" onMouseOut="this.innerHTML='2. ELENCHUS';">2. ELENCHUS</h1>

HTML;

$locaAmount = $amor->getPracticaAmount();

echo "\t\t\t\t\t\t<p>Lived with her/him <b>";
echo writtenNumber($locaAmount, FEMENINE);
echo ($locaAmount > 1) ? " experiences" : " experience";
echo "</b>, thus·</p>\n";

echo "\t\t\t\t\t\t\t<p>Chronologic list follows</a>.</p>\n";



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

// put a link to the top of the page, and closes the tag <article>
echo <<<HTML
                        <p style="text-align: center;"><img src="images/arrow_top.gif" /> <a href="#start">Back to top of the page</a></p>
                    </article>

HTML;

/*
 * section 'altera' (complementary data)
 */

if ($amor->getAchtung() !== ""
	|| $amor->getWeb() !== ""
	|| $amor->getName() !== ""
	|| $amor->getPhoto() !== ""
	|| $amor->getTelephone() !== ""
	|| $amor->getEmail() !== ""
	|| $amor->getOther() !== "") {
    
    // ACHTUNG! αἱ πρηροφορίαι αὗται πρέπει νὰ εἶναι προσιταὶ μόνο εἰς τὸν superuser
    
    echo <<<HTML

                    <!-- Script amor.php. Part III: Other -->
                    <article id="alia">
                        <h1 onMouseOver="this.innerHTML='3. ALTERA i.e. complementary data';" onMouseOut="this.innerHTML='3. ALTERA';">3. ALTERA</h1>

HTML;

    if ($amor->getAchtung() !== "") {
            echo "\t\t\t\t\t\t<p>Ἐκκρεμότητες: <b>";
            echo $amor->getAchtung();
            echo "</b>.</p>\n";
    }

    if ($amor->getWeb() !== "") {
            echo "\t\t\t\t\t\t<p>Δικτύωσις: <b>";
            echo $amor->getWeb();
            echo "</b>.</p>\n";
    }

    if ($amor->getName() !== "") {
            echo "\t\t\t\t\t\t<p>Ὀνοματεπώπυμον: <b>";
            echo $amor->getName();
            echo "</b>.</p>\n";
    }

    if ($amor->getPhoto() !== "") {
            echo "\t\t\t\t\t\t<p>ὕπαρξις φωτογραφιῶν: <b>";
            echo $amor->getPhoto();
            echo "</b>.</p>\n";
    }

    if ($amor->getTelephone() !== "") {
            echo "\t\t\t\t\t\t<p>Τηλέφωνον: <b>";
            echo $amor->getTelephone();
            echo "</b>.</p>\n";
    }

    if ($amor->getEmail() !== "") {
            echo "\t\t\t\t\t\t<p>Ἠλεκτρονικὸν ταχυδρομεῖον: <b>";
            echo $amor->getEmail();
            echo "</b>.</p>\n";
    }

    if ($amor->getOther() !== "") {
            echo "\t\t\t\t\t\t<p>Παραλοιπόμενα: <b>";
            echo $amor->getOther();
            echo "</b>.</p>\n";
    }

    echo <<<HTML
                        <p style="text-align: center"><img src="images/arrow_back.gif" /> <a href="JavaScript: history.back();">Ἐπαναφορὰ εἰς τὴν προηγουμένην σελίδα</a></p>
                    </article>

HTML;
    
} // if

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

require_once 'footer.inc'; // footer of all the pages of the app

?>