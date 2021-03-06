<?php
/**
 * script 'locus.php'.
 * 
 * this script builds a place´s detail page.
 * it is called using a parameter 'locusID' within the URL.
 * using this lover identificator an object of class 'Locus' is created,
 * whose data are read from database.
 * the page´s parts will be created using this object.
 * 
 * @author Joaquin Javier ESTEBAN MARTINEZ <jesteban1972@me.com>
 * last updated 2018-05-10
*/

require_once 'core.inc';
//require_once 'DB.inc';
require_once 'praxis.inc';
//require_once 'amor.inc';
require_once 'locus.inc';

// get a DB connection to work with:
$pdo = DB::getDBHandle();

/*
 * locusID is retrieved from $_GET (intval needed)
 * and an object of the class 'Locus' is instantiated using it.
 * this object will be used all throught this script.
 */
$locus = new Locus(intval($_GET['locusID']));

$title = "myX - Place";
$js = "locus.js";
include 'header.inc'; // header of all the pages of the app
echo "\t\t\t<section> <!-- section {{ -->\n";

echo "\t\t\t\t<p class=\"large\">"."<img src=\"".getImage("locus", "small").
    "\" alt=\""._("(Image of a compass)")."\" />";
echo " <b>".$locus->getName()."</b></p>\n";

echo <<<HTML
                <!-- script locus.php. part 0: links to sections -->
                <article id="start">

HTML;

// links to sections {{

echo "\t\t\t\t\t<ul>\n";
echo "\t\t\t\t\t\t<li><a href=\"#data\">"._("Data")."</a></li>\n";
echo "\t\t\t\t\t\t<li><a href=\"#list\">"._("List of experiences").
        "</a></li>\n";
if ($locus->getCoordExact() !== "" || $locus->getCoordGeneric() !== "") {
    
    $coordSet = true;
    echo "\t\t\t\t\t\t<li><a href=\"#map\">"._("Map")."</a></li>\n";
    
} else {
    
    $coordSet = false;
}

echo "\t\t\t\t\t\t<li><a href=\"#actions\">"._("Actions")."</a></li>\n";
echo "\t\t\t\t\t</ul>\n";

// }} links to sections

echo <<<HTML
                </article>

                <!-- script locus.php. part i: general data -->
                <article id="data">

HTML;

echo "\t\t\t\t\t<h1 onMouseOver=\"this.innerHTML='".
    _("GENERALIA i.e. general data")."';\" onMouseOut=\"this.innerHTML='".
    _("GENERALIA")."';\">"._("GENERALIA")."</h1>\n";

// name:
echo "\t\t\t\t\t<p class=\"medium\">";
if (DEBUG) {
    
    echo " <span class=\"debug\">[locusID <b>".$locus->getLocusID().
        "</b>]</span> ";
    
}
echo _("Name").": <b>".$locus->getName()."</b>.</p>\n";

// rating:
echo "\t\t\t\t\t<p class=\"medium\">"._("Rating").": <b>".
    writtenRate($locus->getRating(), TRUE)."</b>.</p>\n";

// address:
if ($locus->getAddress() !== "") {
    
    echo "\t\t\t\t\t<p class=\"medium\">"._("Address").": <b>".
        $locus->getAddress()."</b>.</p>\n";
    
}

// country:
echo "\t\t\t\t\t<p class=\"medium\">"._("Country").": <b>".
    $locus->getCountryName()."</b>.</p>\n";

// kind:
echo "\t\t\t\t\t<p class=\"medium\">"._("Kind of place").": <b>".
    $locus->getKindName()."</b>.</p>\n";

// description:
if ($locus->getDescr() !== "") {
    
    echo "\t\t\t\t\t<p class=\"medium\">"._("Place description").": <b>".
        $locus->getDescr()."</b>.</p>\n";
    
}

echo <<<HTML
                </article>

                <!-- script locus.php. part ii: practica -->
                <article id="list">

HTML;

echo "\t\t\t\t\t<h1 onMouseOver=\"this.innerHTML='".
    _("ELENCHUS i.e. experiences list")."';\" onMouseOut=\"this.innerHTML='".
    _("ELENCHUS")."';\">"._("ELENCHUS")."</h1>\n";
		
// the amount of experiences in this place is retrieved:
$practicaAmount = $locus->getPracticaAmount(); // used also for page's settings

// the amount of different dates when these experiences happened is retrieved:
$differentDatesAmount = $locus->getDifferentDatesAmount();

echo "\t\t\t\t\t<p>";

if ($practicaAmount === 1) {
    
    echo _("In this place was performed only <b>one</b> experience");
    
} else {
    
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

    }
    
}
echo ".</p>\n";

// page settings

// retrieves the parameter list (if any) and composes $dataString (without page)
$uri = $_SERVER ['REQUEST_URI'];
$uriQuery = parse_url($uri)['query'];
$data = explode("&", $uriQuery);
$dataString = "";
foreach ($data as $value) {
    
    if (substr($value, 0, 5) !== "page=") {
        
        $dataString .= $value;
        
    }
    
}

// retrieves the current page, 1 if not set:
$currentPage = (isset($_GET['page'])) ?
    filter_input(INPUT_GET, "page", FILTER_VALIDATE_INT) :
    1; // $page is 1-based

$pageSettings = pageSettings ($practicaAmount, $currentPage);
$pagesAmount = $pageSettings['numPages'];
$ordinal = $pageSettings['ordinal'];
$ordinalZeroBased = $ordinal - 1;

if ($pageSettings['navBar']) {
    
    navBar($_SERVER['PHP_SELF'], $dataString, $currentPage, $pagesAmount);
    
}

// page contents (list of experiences):
$queryString = <<<QRY
SELECT `praxisID`
FROM `myX`.`practica`
WHERE `locus` = :locusID
ORDER BY `date`, `ordinal`
LIMIT :ordinalZeroBased, :resultsPerPage
QRY;

$statement = $pdo->prepare($queryString);
$statement->bindParam(":locusID", $locus->getlocusID());
$statement->bindParam(":ordinalZeroBased", $ordinalZeroBased, PDO::PARAM_INT);
$statement->bindParam(":resultsPerPage",
    intval($_SESSION['navOptions']['resultsPerPage']), PDO::PARAM_INT);
$statement->execute();

foreach ($statement as $row) {
    
    // instantiate a 'praxis' object:
    $praxis = new Praxis(intval($row['praxisID']));
    
    // call the method Praxis::XHTMLPreview
    // to display a brief preview of the experience:
    $praxis->HTMLPreview($ordinal, Praxis::LOCUS);
    
    // increases the ordinal number by one:
    $ordinal++;
    
}

// displays bottom navigation bar
if ($pageSettings['navBar']) {
    
    navBar($_SERVER['PHP_SELF'], $dataString, $currentPage, $pagesAmount);
    
}

// link to top of the page:
echo "\t\t\t\t\t<p style=\"text-align: center;\">".
    "<img src=\"images/arrow_top.gif\" /> <a href=\"#start\">"._("Back to top").
    "</a></p>\n";

echo <<<HTML
                </article>

                <!-- script locus.php. part iii: map -->
                <article id="map">

HTML;

echo "\t\t\t\t\t<h1 onMouseOver=\"this.innerHTML='".
    _("CHARTA i.e. map of the place")."';\" onMouseOut=\"this.innerHTML='".
    _("CHARTA")."';\">"._("CHARTA")."</h1>\n";
   
if ($coordSet) {

    // coordinates:
    echo "\t\t\t\t\t<p>"._("Coordinates:")." ";
    if ($locus->getCoordExact() !== "") { // exact coordinates

        $coord = $locus->getCoordExact();
        $markerColor = "red";
        echo $coord." ("._("exact position").")";

    } else { // generic coordinates if exact coordinates are missing

        $coord = $locus->getCoordGeneric();
        $markerColor = "orange";
        echo $coord." ("._("approximate position").")";

    }
    echo "</p>\n";
    
    echo "\t\t\t\t\t<p>"._("Map:")."</p>\n";
    echo "\t\t\t\t\t<div style=\"text-align: center;\">\n";

    // map 1 (zoom 5, national):
    $mapURL =
        "https://maps.googleapis.com/maps/api/staticmap".
        "?center=".$coord.
        "&zoom=5&size=640x480".
        "&markers=color:".$markerColor."%7C".$coord.
        "&key=AIzaSyC53MmLcDNNRxf-Lw05fPHXuj6DIcUnhlo";
    echo "\t\t\t\t\t\t<img src=\"".$mapURL."\" width=\"640\" height=\"480\"".
        " style=\"border: solid thin black;\" />\n";
    
    // map 2 (zoom 10, regional):
    $mapURL =
        "https://maps.googleapis.com/maps/api/staticmap".
        "?center=".$coord.
        "&zoom=10&size=640x480".
        "&markers=color:".$markerColor."%7C".$coord.
        "&key=AIzaSyC53MmLcDNNRxf-Lw05fPHXuj6DIcUnhlo";
    echo "\t\t\t\t\t\t<img src=\"".$mapURL."\" width=\"640\" height=\"480\"".
        " style=\"border: solid thin black;\" />\n";
    
    // map 3 (zoom 15, local):
    $mapURL =
        "https://maps.googleapis.com/maps/api/staticmap".
        "?center=".$coord.
        "&zoom=15&size=640x480".
        "&markers=color:".$markerColor."%7C".$coord.
        "&key=AIzaSyC53MmLcDNNRxf-Lw05fPHXuj6DIcUnhlo";
    echo "\t\t\t\t\t\t<img src=\"".$mapURL."\" width=\"640\" height=\"480\"".
        " style=\"border: solid thin black;\" />\n";

    echo "\t\t\t\t\t</div>\n";
    
} // if

// web:
if ($locus->getWeb() !== "") {
    
    echo "\t\t\t\t\t<p>"._("Web:")." <a href=\"http:\\\\".$locus->getWeb().
        "\" target=\"_blank\">".$locus->getWeb()."</a></p>\n";
    
}

// link to top of the page:
echo "\t\t\t\t\t<p style=\"text-align: center;\">".
    "<img src=\"images/arrow_top.gif\" /> <a href=\"#start\">"._("Back to top").
    "</a></p>\n";

echo "\t\t\t\t</article>\n";

echo "\n\t\t\t\t<!-- script locus.php. part iv: actions -->\n";
echo "\t\t\t\t<article id=\"actions\">\n";

echo "\t\t\t\t\t<h1 onMouseOver=\"this.innerHTML='"._("ACTIONS i.e. XXX").
    "';\" onMouseOut=\"this.innerHTML='"._("ACTIONS")."';\">"._("ACTIONS").
    "</h1>\n";

// edit place form:
echo "\t\t\t\t\t<form action=\"locusEdit.php\" method=\"GET\">\n";
echo "\t\t\t\t\t\t<input type=\"hidden\" name=\"locusID\" value=\"".
    $locus->getLocusID()."\" />\n";
echo "\t\t\t\t\t\t<input type=\"submit\" value=\""._("Edit place")."\" />\n";
echo "\t\t\t\t\t</form>\n";

// delete place form:
echo "\t\t\t\t\t<form action=\"locusDelete.php\" method=\"POST\">\n";
echo "\t\t\t\t\t\t<input type=\"hidden\" name=\"locusID\" value=\"".
    $locus->getLocusID()."\" />\n";
echo "\t\t\t\t\t\t<input type=\"submit\" value=\""._("Delete place")."\" />\n";
echo "\t\t\t\t\t</form>\n";
                            
// link to previous page:
echo "\t\t\t\t\t<p style=\"text-align: center;\">".
    "<img src=\"images/arrow_back.gif\" />".
    " <a href=\"javascript: history.back();\">"._("Back to previous").
    "</a></p>\n";

echo "\t\t\t\t</article>\n";

echo "\t\t\t</section> <!-- }} section -->\n\n";


// locus ID is stored in the session to be read in 'sidebar.inc':
$_SESSION['asideItem'] = $locus->getLocusID();

require_once 'footer.inc'; // footer of all the pages of the app

?>