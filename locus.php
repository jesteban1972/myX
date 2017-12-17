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


$title = "Locus";
include 'header.inc'; // header of all the pages of the app

/*
 * locusID is retrieved from $_GET (intval needed)
 * and an object of the class 'Locus' is instantiated using it.
 * this object will be used all throught this script.
 */
$locus = new Locus(intval($_GET['locusID']));

echo <<<HTML
                    <!-- Script locus.php. Part 0: Navigation links -->
                    <article id="start">
                        <p class="center"><a href="#data"><img src="images/generalia-medium.jpg" title="Γενικὰ στοιχεῖα" /></a><a href="#amores"><img src="images/confratres-medium.jpg" title="Μεθέξοντες τῆς φάσεως" /></a><a href="#description"><img src="images/narratio-medium.jpg" title="Ἀφήγησις τῶν πεπραγμένων" /></a></p>
                        <p style="text-align: center"><img src="images/arrow_back.gif" /> <a href="JavaScript: history.back();">Back to previous page</a></p>
                    </article>
                    
                    <!-- Script locus.php. Part I: General data -->
                    <article id="data">
                        <h1 onMouseOver="this.innerHTML='1. GENERALIA i.e. general data';" onMouseOut="this.innerHTML='1. GENERALIA';">1. GENERALIA</h1>

HTML;


echo <<<HTML
                        <p style="text-align: center"><img src="images/arrow_back.gif" /> <a href="JavaScript: history.back();">Ἐπαναφορὰ εἰς τὴν προηγουμένην σελίδα</a></p>
                    </article>

HTML;

echo "\t\t\t\t\t\t<p class=\"medium\">";
if (DEBUG) {
    
    echo " <span class=\"debug\">[place_id: ";
    echo $locus->getLocusID();
    echo "]</span> ";
        
}
echo "Name: <b>{$locus->getName()}</b></p>\n";

if ($locus->getDescription() !== "") {
    
    echo "\t\t\t\t\t\t<p class=\"medium\">Place description: {$locus->getDescription()}</p>\n";
    
}

echo <<<HTML
                    </article>
                    
                    <!-- Script place.php. Part II: List -->
                    <article id="list">
                        <h1 onMouseOver="this.innerHTML='2. ELENCHUS i.e. list of the experiences in this place';" onMouseOut="this.innerHTML='2. ELENCHUS';">2. ELENCHUS</h1>

HTML;
		
// the amount of experiences in this place is retrieved:
$practicaAmount = $locus->getPracticaAmount(); // used also for page's settings

// the amount of different dates where all these experiences happened
// is retrieved:
$differentDatesAmount = $locus->getDifferentDatesAmount();

echo "\t\t\t\t\t\t<p>";

switch ($practicaAmount) {

	case 0:
            echo "No experiences were performed in this place";
            break;
	case 1: // only one xperience
            echo "In this place was performed only <b>one</b> experience";
            break;
	default: // more than one xperience
        echo "In this place were performed the following <b>".writtenNumber($practicaAmount, FEMENINE)."</b> experiences";
        echo ", happened ";
        switch ($differentDatesAmount) {

                case 1: // all the same day
                    echo "the <b>same</b> day";
                    break;
                default: // more than one day
                    echo "in <b>".writtenNumber($differentDatesAmount, FEMENINE)."</b> different days";
                    echo " (i.e. ".round($practicaAmount/$differentDatesAmount, 2)." experiences/day as average)";

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
$statement->bindParam(":ordinalZeroBased", $ordinalZeroBased, \PDO::PARAM_INT);
$statement->bindParam(":resultsPerPage", intval($_SESSION['options']['resultsPerPage']), \PDO::PARAM_INT);
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

echo <<<HTML
                        <p style="text-align: center"><img src="images/arrow_back.gif" /> <a href="JavaScript: history.back();">Ἐπαναφορὰ εἰς τὴν προηγούμενον σελίδα</a></p>
                    </article>
                    
                    <!-- Script place.php. Part III: Map -->
                    <article id="map">
                        <h1 onMouseOver="this.innerHTML='3. CHARTA ἤτοι χάρτης';" onMouseOut="this.innerHTML='3. CHARTA';">3. CHARTA</h1>

HTML;

// address
if ($currentPlace->getAddress() !== "") {
	echo "\t\t\t\t\t\t<p>Διεύθυνσις: {$currentPlace->getAddress()}</p>\n";
}

if ($coordinatesSet) {

	// coordinates
	echo "\t\t\t\t\t\t<p>γεωγραφικαὶ συντεταγμένες: ";
    
    if ($currentPlace->getCoordinatesExact() !== "") { // exact coordinates

        $coordinates = $currentPlace->getCoordinatesExact();
        $coordinatesSetExact = TRUE;
        $markerColor = "red";
        echo $coordinates." (τοποθεσία ἀκριβής, κατὰ τὸ μᾶλλον ἢ ἦττον)";

    } else { // generic coordinates if exact coordinates are missing

        $coordinates = $currentPlace->getCoordinatesGeneric();
        $coordinatesSetGeneric = TRUE;
        $markerColor = "orange";
        echo $coordinates." (τοποθεσία κατὰ προσέγγυσιν)";

    }
	echo "</p>\n";

	// parse coordinates (URL-escaped) necessary?
	// $coordinates = XXX ($coordinates);

    /* 
    1st approach: Google Static Maps API V1
        pros: simplicity
        cons: not possible to scroll or zoom in or out the map
        echo <<<HTML
                        <img src="https://maps.googleapis.com/maps/api/staticmap
                            ?zoom=15
                            &size=640x640
                            &format=jpg
                            &markers=color:{$marker_color}%7C{$coordinates}
                            &sensor=false" width="640" height="640" alt="(χάρτης τοῦ τόπου: {$place->get_designation ()})" />
HTML;
    */

    /*
    2nd approach: Google Maps Embed API (since march 2014)
    best solution because of its features and simplicity
    TODO:
        1/ delete adress popup (or personalize it with the place's designation instead of the coordinates)
        2/ marker color

	echo <<<HTML
                        <p>Χάρτης:</p>
                        <iframe width="640" height="480" frameborder="0" style="border: 0;" src="https://www.google.com/maps/embed/v1/place?key=AIzaSyAHwEfIR7d0ICuaj_FSaDnLuNQJY48kWKI&q={$coordinates}"></iframe>

HTML;
    */
    
    /*
        3rd approach: Static Maps V2
        pros: easy to use, possibility to add customized marker(s)
        cons: not possible to scroll or zoom in or out the map; three maps with three zoom levels
    */
    
	echo <<<HTML
                        <p>χάρτης:</p>
                        <div style="text-align: center;">
                            <img src="https://maps.googleapis.com/maps/api/staticmap?zoom=5&size=640x480&markers=color:{$markerColor}%7C{$coordinates}" width="640" height="480" />
                            <img src="https://maps.googleapis.com/maps/api/staticmap?zoom=10&size=640x480&markers=color:{$markerColor}%7C{$coordinates}" width="640" height="480" />
                            <img src="https://maps.googleapis.com/maps/api/staticmap?zoom=15&size=640x480&markers=color:{$markerColor}%7C{$coordinates}" width="640" height="480" />
                        </div>

HTML;
    
    // <img src="https://maps.googleapis.com/maps/api/staticmap?center={$coordinates}&zoom=13&size=640x480&markers=color:{$marker_color}%7Clabel:G" />
    
    // latitude: -90..90
    // longitude -180..180
    
	} // if

// www
if ($currentPlace->getWww() !== "") {
    
    echo "\t\t\t\t\t\t<p>δικτύωσις: <a href=\"http:\\\\";
    echo $currentPlace->getWww();
    echo "\" target=\"_blank\">{$currentPlace->getWww()}";
    echo "</a></p>\n";
        
}

echo <<<HTML
                        <p style="text-align: center"><img src="images/arrow_back.gif" /> <a href="JavaScript: history.back();">ἐπαναφορὰ εἰς τὴν προηγούμενον σελίδα</a></p>
                    </article>

HTML;


// displays bottom navigation bar
if ($pageSettings['navigationBar']) {
    
	navigationBar($_SERVER['PHP_SELF'], $dataString, $currentPage, $pagesAmount);
        
}



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

require_once 'footer.inc'; // footer of all the pages of the app

?>