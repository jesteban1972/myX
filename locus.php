<?php

/**
 * script locus.php
 * displays the detail page of a place
 * (c) Joaquin Javier ESTEBAN MARTINEZ
 * last updated 2017-12-16
*/

require_once 'session.inc';
require_once 'core.inc';
require_once 'DB.inc';
require_once 'praxis.inc';
//require_once 'amor.inc';
require_once 'locus.inc';

// 1. get a DB connection to work with:
$pdo = DB::getDBHandle();

/*
 * locusID is retrieved from $_GET (intval needed)
 * and an object of the class 'Locus' is instantiated using it.
 * this object will be used all throught this script.
 */
$locus = new Locus(intval($_GET['locusID']));

$title = _("Place");
//$mapAPI = true; // used to include the JavaScript code in the <header> section
include 'header.inc'; // header of all the pages of the app
echo "\t\t\t<section> <!-- section {{ -->\n";

echo <<<HTML
                <!-- script locus.php. part 0: links to sections -->
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
if ($locus->getCoordinatesExact() !== "" ||
    $locus->getCoordinatesGeneric() !== "") {
    
    $coordinatesSet = true;
    echo "\t\t\t\t\t\t<li><a href=\"#map\">".
        _("Map")."</a></li>\n";
    
} else {
    
    $coordinatesSet = false;
}

echo "\t\t\t\t\t\t<li><a href=\"#actions\">".
        _("Actions")."</a></li>\n";
echo "\t\t\t\t\t</ul>\n";

echo <<<HTML
                </article>

                <!-- script locus.php. part i: general data -->
                <article id="data">

HTML;

echo "\t\t\t\t\t<h1 onMouseOver=\"this.innerHTML='".
    _("GENERALIA i.e. general data").
    "';\" onMouseOut=\"this.innerHTML='".
    _("GENERALIA").
    "';\">".
    _("GENERALIA").
    "</h1>\n";

echo "\t\t\t\t\t<p class=\"medium\">";
if (DEBUG) {
    
    echo " <span class=\"debug\">[place_id: ";
    echo $locus->getLocusID();
    echo "]</span> ";
        
}
echo _("Name").": <b>".$locus->getName()."</b></p>\n";

if ($locus->getDescription() !== "") {
    
    echo "\t\t\t\t\t<p class=\"medium\">"._("Place description").
        ": ".$locus->getDescription()."</p>\n";
    
}

echo <<<HTML
                </article>

                <!-- script locus.php. part ii: practica -->
                <article id="practica">

HTML;

echo "\t\t\t\t\t<h1 onMouseOver=\"this.innerHTML='".
    _("ELENCHUS i.e. experiences list").
    "';\" onMouseOut=\"this.innerHTML='".
    _("ELENCHUS").
    "';\">".
    _("ELENCHUS").
    "</h1>\n";
		
// the amount of experiences in this place is retrieved:
$practicaAmount = $locus->getPracticaAmount(); // used also for page's settings

// the amount of different dates where all these experiences happened
// is retrieved:
$differentDatesAmount = $locus->getDifferentDatesAmount();

echo "\t\t\t\t\t<p>";

switch ($practicaAmount) {

	case 0:
            echo _("No experiences were performed in this place");
            break;
	case 1: // only one xperience
            echo _("In this place was performed only <b>one</b> experience");
            break;
	default: // more than one xperience
        echo sprintf(
            _("In this place were performed the following <b>%s</b> experiences"),
            writtenNumber($practicaAmount, FEMENINE));
        switch ($differentDatesAmount) {

            case 1: // all the same day
                echo ", happened the <b>same</b> day";
                break;
            default: // more than one day
                echo sprintf(_(", happened in <b>%s</b> different days"),
                    writtenNumber($differentDatesAmount, FEMENINE));
                echo sprintf(_(" (i.e. %.2f experiences/day as average)"),
                    round($practicaAmount/$differentDatesAmount, 2));

        } // switch block
}
echo ".</p>\n";

// page settings

// retrieves the parameter list (if any) and composes $data_string (without page)
$uri = $_SERVER ['REQUEST_URI'];
$uriQuery = parse_url($uri)['query'];
$data = explode("&", $uriQuery);
$dataString = "";
foreach ($data as $value) {

    if (substr($value, 0, 5) !== "page=") {

        $dataString .= $value;
            
    }
	 
} // foreach

// retrieves the current page
$currentPage = $_GET['page'] != "" ? intval($_GET ['page']) : 1; // $page is 1-based

$pageSettings = pageSettings ($practicaAmount, $currentPage);
$pagesAmount = $pageSettings['numPages'];
$ordinal = $pageSettings['ordinal'];
$ordinalZeroBased = $ordinal - 1;

if ($pageSettings['navigationBar']) {
    
    navigationBar($_SERVER['PHP_SELF'], $dataString, $currentPage, $pagesAmount);
        
}

// page contents (xperiences catalogue)
$queryString = <<<QRY
SELECT praxisID
FROM `myX`.`practica`
WHERE locus=:locusID
ORDER BY date
LIMIT :ordinalZeroBased, :resultsPerPage
QRY;

$statement = $pdo->prepare($queryString);
$statement->bindParam(":locusID", $locus->getlocusID());
$statement->bindParam(":ordinalZeroBased", $ordinalZeroBased, PDO::PARAM_INT);
$statement->bindParam(":resultsPerPage", intval($_SESSION['options']['resultsPerPage']), PDO::PARAM_INT);
$statement->execute();

foreach ($statement as $row) {
    
    // instantiate a 'praxis' object:
    $praxis = new Praxis($row['praxisID']);
    
    // call the method Praxis::XHTMLPreview
    // to display a brief preview of the experience:
    $praxis->HTMLPreview($ordinal, Praxis::LOCUS);
    
    // increases the ordinal number by one:
    $ordinal++;
    
}

// displays bottom navigation bar
if ($pageSettings['navigationBar']) {
    
	navigationBar($_SERVER['PHP_SELF'], $dataString, $currentPage, $pagesAmount);
        
}

// link to top of the page:
echo "\t\t\t\t\t<p style=\"text-align: center;\">".
    "<img src=\"images/arrow_top.gif\" />".
    " <a href=\"#start\">".
    _("Back to top").
    "</a></p>\n";

echo <<<HTML
                </article>

                <!-- script locus.php. part iii: map -->
                <article id="map">

HTML;

echo "\t\t\t\t\t<h1 onMouseOver=\"this.innerHTML='".
    _("CHARTA i.e. map of the place").
    "';\" onMouseOut=\"this.innerHTML='".
    _("CHARTA").
    "';\">".
    _("CHARTA").
    "</h1>\n";

// address
if ($locus->getAddress() !== "") {
    
    echo "\t\t\t\t\t<p>".
        _("Address:").
        " ".
        $locus->getAddress().
        "</p>\n";
}

if ($coordinatesSet) {

    // coordinates:
    echo "\t\t\t\t\t<p>"._("Coordinates:")." ";
    if ($locus->getCoordinatesExact() !== "") { // exact coordinates

        $coordinates = $locus->getCoordinatesExact();
        $markerColor = "red";
        echo $coordinates." ("._("exact position").")";

    } else { // generic coordinates if exact coordinates are missing

        $coordinates = $locus->getCoordinatesGeneric();
        $markerColor = "orange";
        echo $coordinates." ("._("approximate position").")";

    }
    echo "</p>\n";
    //var_dump($markerColor);

    // map:
    $mapURL =
        "https://maps.googleapis.com/maps/api/staticmap?".
        "zoom=5&size=640x480&markers=color:".
        $markerColor.
        "%7C".
        $coordinates;
    
    echo "\t\t\t\t\t<p>"._("Map:")."</p>\n";
    echo "\t\t\t\t\t<div style=\"text-align: center;\">\n";
    
    echo "\t\t\t\t\t\t<img src=\"".
        $mapURL.
        "\" width=\"640\" height=\"480\" />\n";
    
    echo <<<HTML
                        <img src="https://maps.googleapis.com/maps/api/staticmap?zoom=5&size=640x480&markers=color:red%7C37.683205, -0.734315" width="640" height="480" />

HTML;
    // ...?zoom=5&...
    // ...?zoom=10&...
    // ...?zoom=15&...

    echo "\t\t\t\t\t</div>\n";
    
} // if

// www:
if ($locus->getWww() !== "") {
    
    echo "\t\t\t\t\t<p>".
        _("Web:").
        " <a href=\"http:\\\\".
        $locus->getWww().
        "\" target=\"_blank\">".
        $locus->getWww().
        "</a></p>\n";
        
}

// link to top of the page:
echo "\t\t\t\t\t<p style=\"text-align: center;\">".
    "<img src=\"images/arrow_top.gif\" />".
    " <a href=\"#start\">".
    _("Back to top").
    "</a></p>\n";


// displays bottom navigation bar
if ($pageSettings['navigationBar']) {
    
	navigationBar($_SERVER['PHP_SELF'], $dataString, $currentPage, $pagesAmount);
        
}

echo "\t\t\t\t</article>\n";

echo "\n\t\t\t\t<!-- script locus.php. part iv: actions -->\n";
echo "\t\t\t\t<article id=\"actions\">\n";

echo "\t\t\t\t\t<h1 onMouseOver=\"this.innerHTML='".
    _("ACTIONS i.e. XXX").
    "';\" onMouseOut=\"this.innerHTML='".
    _("ACTIONS").
    "';\">".
    _("ACTIONS").
    "</h1>\n";

// edit place form:
echo "\t\t\t\t\t<form action=\"locusEdit.php\" method=\"POST\">\n";
echo "\t\t\t\t\t\t<input type=\"hidden\" name=\"locusID\" value=\"".
    $locus->getLocusID().
    "\" />\n";
echo "\t\t\t\t\t\t<input type=\"submit\" value=\"".
    _("Edit place").
    "\" />\n";
echo "\t\t\t\t\t</form>\n";

// delete place form:
echo "\t\t\t\t\t<form action=\"locusDelete.php\" method=\"POST\">\n";
echo "\t\t\t\t\t\t<input type=\"hidden\" name=\"locusID\" value=\"".
    $locus->getLocusID().
    "\" />\n";
echo "\t\t\t\t\t\t<input type=\"submit\" value=\"".
    _("Delete place").
    "\" />\n";
echo "\t\t\t\t\t</form>\n";
                            
// link to previous page:
echo "\t\t\t\t\t<p style=\"text-align: center;\">".
    "<img src=\"images/arrow_back.gif\" />".
    " <a href=\"javascript: history.back();\">".
    _("Back to previous").
    "</a></p>\n";

echo "\t\t\t\t</article>\n";

echo "\t\t\t</section> <!-- }} section -->\n\n";
require_once 'footer.inc'; // footer of all the pages of the app

//// $xperienceSideview displays a sommary of the xperience in the sidebar
//// 1-step creation
//$praxisSideview = "\t\t\t\t\t\t<div class=\"HTML_preview_sidebar\">PRAXIS<br /><br />@";
//$praxisSideview .= $locus->getName();
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

?>