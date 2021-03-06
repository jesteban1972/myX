<?php
/**
 * script 'loca.php'.
 * 
 * this script displays a list of places using an instance of class 'LocaQuery'.
 * 
 * @author Joaquin Javier ESTEBAN MARTINEZ <jesteban1972@me.com>
 * last updated 2018-06-09
*/

require_once 'core.inc';
//require_once 'DB.inc';
//require_once 'praxis.inc';
require_once 'locus.inc';

// get a DB connection to work with:
$pdo = DB::getDBHandle();

/*
 * initializes '$locaQuery' retrieving its components as a saved query
 * or if stored in the session. otherwise an unfiltered query is created.
 */

if (isset($_GET['query'])) {
    
    $query = new Query($_GET['query']);
    $descr = ($query->getDescr() !== "") ?
        $query->getDescr() :
        "";
    $locaQuery = new LocaQuery($query->getName(), $descr,
        $query->getQueryString());
    
} else if (isset($_SESSION['locaQuery'])) {
    
    $locaQuery = $_SESSION['locaQuery'];
    
} else {
    
    $locaQuery = new LocaQuery();
    $_SESSION['locaQuery'] = $locaQuery;
    
}

$name = $locaQuery->getName();
$descr = $locaQuery->getDescr();
$queryString = $locaQuery->getQueryString();

// map center: the coordinates are stored in the session to be read from JS
Locus::getMapCenter();

// page header:
$title = "myX - Places";
$js = "loca.js";
$mapAPI = true; // used to include the Google Maps API key
require_once 'header.inc'; // header of all the pages of the app
echo "\t\t\t<section> <!-- section {{ -->\n";

echo <<<HTML
                <!-- Script loca.php. Part 0: Description of the list -->
                <article id="start">

HTML;

// list designation and description:

echo "\t\t\t\t\t<p class=\"medium\"><img src=\"".
    getImage("locus","small")."\" alt=\""._("(Image of a compass)").
    "\" /> <b>".
    _($name).
    "</b>: ".
    _($descr).
    " ";

/*
 * places amount.
 * a first query of 'locaQuery::queryString' is performed
 * just to retrieve the amount of places.
 * Locus::getLocaAmount() would retrieve the amount of all places,
 * but locaList might be filtered.
 */

$statement = $pdo->prepare($queryString);
$statement->execute();
$locaAmount = $statement->rowCount();

switch ($locaAmount) {
	
    case 0:
        
        echo _("(no places found)");
        break;
        
    case 1:
        
        echo _("(only <b>one</b> place found)");
        break;
        
    default:
        
        echo sprintf(_("(<b>%d</b> places found)"), $locaAmount);
            
}
echo "</p>\n";

if ($locaQuery->getName() !== "all places") {
    
    // save query div/form:
    echo "\t\t\t\t\t\t<div class=\"floppy\">\n";
    echo "\t\t\t\t\t\t\t<form action=\"queryEdit.php\" method=\"POST\">\n";
    echo "\t\t\t\t\t\t\t\t<input type=\"hidden\" name=\"queryString\"".
        " value=\"".$queryString."\" />\n";
    echo "\t\t\t\t\t\t\t\t<input type=\"image\" src=\"images/floppy-small.png\" />\n";
    echo "\t\t\t\t\t\t\t</form>\n";
    echo "\t\t\t\t\t\t</div>\n";
    
}

if (DEBUG)
    echo "<span class=\"debug\">[query string: ".$queryString."]</span> ";

if ($_SESSION['DBStatus']['doPracticaExist']) {
    
    // links to page sections:
    echo "\t\t\t\t\t<ul>\n";
    echo "\t\t\t\t\t\t<li><a href=\"#map\">"._("Map")."</a></li>\n";
    echo "\t\t\t\t\t\t<li><a href=\"#list\">"._("List of places")."</a></li>\n";
    echo "\t\t\t\t\t\t<li><a href=\"#actions\">"._("Actions")."</a></li>\n";
    echo "\t\t\t\t\t</ul>\n";

}

if ($locaAmount > 0) {
    
    echo <<<HTML
                <!-- Script loca.php. Part I: Map -->
                <article id="map">

HTML;
    
    echo "\t\t\t\t\t\t<h1 onMouseOver=\"this.innerHTML='".
        _("CHARTA i.e. map of places").
        "';\" onMouseOut=\"this.innerHTML='".
        _("CHARTA").
        "';\">".
        _("CHARTA").
        "</h1>\n";
    
    echo "\t\t\t\t\t\t<div id=\"mapCanvas\"></div>\n";
        
    echo <<<HTML
                </article>

                <!-- Script loca.php. Part II: List -->
                <article id="list">

HTML;

    echo "\t\t\t\t\t\t<h1 onMouseOver=\"this.innerHTML='".
        _("ELENCHUS i.e. list of places").
        "';\" onMouseOut=\"this.innerHTML='".
        _("ELENCHUS").
        "';\">".
        _("ELENCHUS").
        "</h1>\n";    
    /*
     * page settings
     * the script retrieves from the URI the parameter list (v.gr. page=69)
     * in order to display a navigation bar (if neccessary) and to put an ordinal
     * before each entry of the catalogue
     */

    /*
     * retrieves the parameter list and composes the string
     * $dataString (without page) that will be passed to navigationBar()
     */
    
    $uriQuery = parse_url($_SERVER['REQUEST_URI'])['query'];

    $data = explode("&", $uriQuery);
    $dataString = "";
    foreach ($data as $value)
        if (substr($value, 0, 5) != "page=")
                $dataString .= $value; // this is the current segment number

    // retrieves the current page, 1 if not set:
    $currentPage = (isset($_GET['page'])) ?
        filter_input(INPUT_GET, "page", FILTER_VALIDATE_INT) :
        1; // $page is 1-based

    $pageSettings = pageSettings($locaAmount, $currentPage);
    $pagesAmount = $pageSettings['numPages'];
    $ordinal = $pageSettings['ordinal']; // $ordinal is 1-based
    $ordinalZeroBased = $ordinal - 1;

    // displays top navigation bar
    if ($pageSettings['navBar'])
        navBar($_SERVER['PHP_SELF'], $dataString, $currentPage, $pagesAmount);

    ////////////////////////////////////////////////////////////////////////////
    // page contents
    
/*
 * a new query of locaList::queryString is performed
 * including ORDER BY and LIMIT criteria
 * to display the appropiate segment of the whole list.
 */

    $queryString .= " ORDER BY `myX`.`loca`.`name`";
    $queryString .= " LIMIT ".
        $ordinalZeroBased.
        ", ".
        $_SESSION['navOptions']['resultsPerPage'];

    if (DEBUG)
        echo "\t\t\t\t\t\t\t<p><span class=\"debug\">[query string: ".
            $queryString."]</span></p>";

    $statement = $pdo->prepare($queryString);
    $statement->execute();

/*
 * the results of the query are fetched withing a foreach-as loop.
 */
    foreach ($statement as $row) {

        // creates an instance of class 'Locus' (intval needed):
        $locus = new Locus(intval($row['locusID']));

        /*
         * call the method Locus::XHTMLPreview
         * to display a brief preview of the place
         */
        $locus->HTMLPreview($ordinal, $previewOptions); // $previewOptions?

        $ordinal++;

    } //foreach

    // displays bottom navigation bar:
    if ($pageSettings['navBar'])
        navBar($_SERVER['PHP_SELF'], $dataString, $currentPage, $pagesAmount);

    echo <<<HTML
                    <p class="quote">«Cuando emprendas tu viaje a Ítaca<br />
                    pide que el camino sea largo,<br />
                    lleno de aventuras, lleno de experiencias»<br />(Kavafis)</p>
                    <p style="text-align: center;"><img src="images/arrow_top.gif" /> <a href="#start">Back to top</a></p>
                </article>

HTML;
    
} // if ($locaAmount > 0)

echo <<<HTML
                <!-- Script loca.php. Part III: Actions -->
                <article id="actions">
                    <h1>Actions</h1>

HTML;

if ($_SESSION['DBStatus']['doPracticaExist']) {
    
    // filter places:
    echo "\t\t\t\t\t<form action=\"locaFilter.php\" method=\"POST\">\n";
    echo "\t\t\t\t\t\t<input type=\"submit\" name=\"setFilter\" value=\""
        ._("Apply filter").
        "\" />\n";
    echo "\t\t\t\t\t\t<input type=\"submit\" name=\"removeFilter\" value=\""
        ._("Remove filter").
        "\" ";
    if ($locaQuery->getName() === "all places") {
        
        echo "disabled=\"disabled\" ";
        
    }
    echo "/>\n";
    echo "\t\t\t\t\t</form>\n";

    // edit countries list:
    echo "\t\t\t\t\t<form action=\"countriesEdit.php\" method=\"POST\">\n";
    echo "\t\t\t\t\t\t<input type=\"submit\" value=\""._("Edit countries list").
        "\" />\n";
    echo "\t\t\t\t\t</form>\n";

}

// link to previous page:
echo "\t\t\t\t\t<p style=\"text-align: center;\">".
    "<img src=\"images/arrow_back.gif\" />".
    " <a href=\"javascript: history.back();\">".
    _("Back to previous").
    "</a></p>\n";

echo "\t\t\t\t</article>\n";

echo "\t\t\t</section> <!-- }} section -->\n\n";
require_once 'footer.inc'; // footer of all the pages of the app

?>