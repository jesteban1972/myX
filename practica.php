<?php
/**
 * script 'practica.php'.
 * 
 * displays a list of experiences based in an instance of class 'PracticaList'
 * (c) Joaquin Javier ESTEBAN MARTINEZ
 * last updated 2018-04-24
*/

require_once 'core.inc';
require_once 'DB.inc';
require_once 'praxis.inc';


// get a DB connection to work with:
$pdo = DB::getDBHandle();

/*
 * initializes $practicaList, and retrieves its components
 * if already storage in $_SESSION, retrieve list;
 * otherwise create an unfiltered list 
 */
if (!isset($_SESSION['practicaQuery'])) {
    
    $practicaQuery = new PracticaQuery();
    $_SESSION['practicaQuery'] = $practicaQuery;
    
} else {
    
    $practicaQuery = $_SESSION['practicaQuery'];
    
}

$designation = $practicaQuery->getDesignation();
$description = $practicaQuery->getDescription();
$queryString = $practicaQuery->getQueryString();

// page header:
$title = "myX - Experiences";
$js = "practica.js";
require_once 'header.inc'; // header of all the pages of the app
echo "\t\t\t<section> <!-- section {{ -->\n";

echo <<<HTML
                <!-- Script practica.php. Part 0: Description of the list -->
                <article id="start">

HTML;

// list designation and description:

echo "\t\t\t\t\t<p class=\"medium\"><img src=\"".getImage("praxis", "small").
    "\" alt=\""._("(Image of a gold coin)")."\" /> <b>"._($designation).
    "</b>: "._($description)." ";

//echo "\t\t\t\t\t<div class=\"sectionTitle\">\n";
//
//echo "\t\t\t\t\t\t<p class=\"large\"><img src=\"".getImage("praxis", "small").
//    "\" alt=\""._("(Image of a gold coin)")."\" /> <b>".
//    _($designation)."</b></p>";
//echo "\t\t\t\t\t\t<p class=\"medium\">"._($description)."</p>\n";

/*
 * experiences list.
 * a first query of practicaList::queryString is performed
 * just to retrieve the amount of experiences.
 * Praxis::getPracticaAmount() would retrieve the amount of all experiences,
 * but practicaList might be filtered.
 */

$statement = $pdo->prepare($queryString);
$statement->execute();
$practicaAmount = $statement->rowCount();
//echo "\t\t\t\t\t\t<p class=\"medium\">";
switch ($practicaAmount) {

    case 0:
        
        echo _("(no experiences found)");
        break;
    
    case 1:
        
        echo _("(only <b>one</b> experience found)");
        break;
    
    default:
        
        echo sprintf(_("(<b>%d</b> experiences found)"), $practicaAmount);
            
}
echo "</p>\n";

if (DEBUG)
    echo "\t\t\t\t\t\t<span class=\"debug\">[query string: ".$queryString."]</span>\n";


// filter icon:
        //if ($this->isFavorite())            
echo "\t\t\t\t\t\t<div class=\"filter\"></div>\n";
//echo "\t\t\t\t\t</div>\n";
    
// links to page sections:
echo "\t\t\t\t\t<ul>\n\t\t\t\t\t\t<li><a href=\"#list\">".
    _("List of experiences").
    "</a></li>\n".
    "\t\t\t\t\t\t<li><a href=\"#actions\">".
    _("Actions").
    "</a></li>\n\t\t\t\t\t</ul>\n";

if ($practicaAmount > 0) {
        
    echo <<<HTML
                </article>

                <!-- Script practica.php. Part I: List -->
                <article id="list">

HTML;
    
    echo "\t\t\t\t\t\t<h1 onMouseOver=\"this.innerHTML='".
        _("ELENCHUS i.e. list of experiences").
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
     * $dataString (without page) that will be passed to navigationBar().
     * 
     * $uriQuery contains URL's arguments.
     * $data is an associative array containing each one of the above arguments.
     * $dataString is XXX
     * - $currentPage is the part of the list ('page') being actually displayed,
     * whose value is retrieved from $_GET, if set. otherwise is set to 1.
     * - $pageSettings is an associative array with the settings which apply
     * to the current part of the list ('page'),
     * depending of $practicaAmount and $currentPage:
     * (numPages: the amount of parts ('pages'),
     * navigationBar: if a navigation bar is needed or not,
     * ordinal: the current part ('page') of the list).
     * - $ordinalZeroBased: the current part ('page') of the list, 0-based
     * 
     */
    
    $uriQuery = parse_url($_SERVER['REQUEST_URI'])['query'];
    // parse_url: parse a URL, and return its components

    $data = explode("&", $uriQuery);
    $dataString = "";
    foreach ($data as $value)
        if (substr($value, 0, 5) != "page=")
            $dataString .= $value; // this is the current page number

    // retrieves the current page (1 if not set)
    $currentPage = ($_GET['page'] !== NULL) ?
        intval($_GET['page']) :
        1; // $page is 1-based

    $pageSettings = pageSettings($practicaAmount, $currentPage);
    //$pagesAmount = $pageSettings['numPages'];
    $ordinal = $pageSettings['ordinal']; // $ordinal is 1-based
    $ordinalZeroBased = $ordinal - 1;

    // displays top navigation bar
    if ($pageSettings['navigationBar'])
        navigationBar($_SERVER['PHP_SELF'], $dataString, $currentPage, $pageSettings['numPages']);

    ////////////////////////////////////////////////////////////////////////////
    // page contents
    
/*
 * a new query of practicaList::queryString is performed
 * including ORDER BY and LIMIT criteria
 * to display the appropiate segment of the whole list.
 */

    switch ($_SESSION['navigationOptions']['listsOrder']) {
        
        case OLDEST_TO_NEWEST:
            
            $queryString .= " ORDER BY `myX`.`practica`.`date`, `myX`.`practica`.`ordinal`";
            break;
        
        case NEWEST_TO_OLDEST:
            
            $queryString .= " ORDER BY `myX`.`practica`.`date` DESC, `myX`.`practica`.`ordinal` DESC";
            break;
        
    }
    
    $queryString .= " LIMIT ".
        $ordinalZeroBased.
        ", ".
        $_SESSION['navigationOptions']['resultsPerPage'];

    if (DEBUG)
        echo "\t\t\t\t\t\t\t<p><span class=\"debug\">[query string: ".$queryString."]</span></p>";

    $statement = $pdo->prepare($queryString);
    $statement->execute();
    $numRows = $statement->rowCount(); // used?

/*
 * the results of the query are fetched withing a foreach-as loop.
 */
    foreach ($statement as $row) {

        // creates an instance of class 'Praxis' (intval needed):
        $praxis = new Praxis(intval($row['praxisID']));

        /*
         * call the method Praxis::XHTMLPreview
         * to display a brief preview of the experience
         */
        $praxis->HTMLPreview($ordinal, $previewOptions); // $previewOptions???

        // names of the first and last lovers are stored to be shown in the sidebar
        if ($ordinal === ($_SESSION['navigationOptions']['resultsPerPage'] * ($currentPage - 1)) + 1) {
            
            $firstPraxis = $row['date'];
            if ($row['ordinal'] !== "")
                $firstPraxis .= $row['ordinal'];
            
        } elseif ($ordinal === ($_SESSION['navigationOptions']['resultsPerPage']) * $currentPage ||
            $ordinal === ($_SESSION['navigationOptions']['resultsPerPage'] * ($currentPage - 1)) + $numRows) {
            
            $lastPraxis = $row['date'];
            if ($row['ordinal'] !== "")
                $lastPraxis .= $row['ordinal'];
            
        }
        $ordinal++;

    } //foreach

    // displays bottom navigation bar:
    if ($pageSettings['navigationBar'])
        navigationBar($_SERVER['PHP_SELF'], $dataString, $currentPage, $pageSettings['numPages']);

//    echo <<<HTML
//                    <p class="quote">«Me rappellant les plaisirs que j'eus je me les renouvelle,<br />
//                        et je vis des peines que j'ai enduré, et que je ne sens plus»
//                        <br />(Giacomo Casanova, Histoire de ma vie, Préface)</p>
//    
//HTML;
    echo <<<HTML
                    <p class="quote">«Me rappellant les plaisirs que j'eus je me les renouvelle,<br />
                        et je vis des peines que j'ai enduré, et que je ne sens plus»
                        <br />(Casanova)</p>
    
HTML;

// link to top of the page:
echo "\t\t\t\t<p style=\"text-align: center;\"><img src=\"images/arrow_top.gif\" /> <a href=\"#start\">".
    _("Back to top").
    "</a></p>\n";

echo <<<HTML
                </article>

HTML;
    
} // if ($practicaAmount > 0)

echo <<<HTML
                <!-- Script practica.php. Part II: Actions -->
                <article id="actions">
                    <h1>Actions</h1>

HTML;

// query experiences:
echo "\t\t\t\t\t<form action=\"practicaQuery.php\" method=\"POST\">\n";
echo "\t\t\t\t\t\t<input type=\"submit\" value=\""
    ._("Apply filter").
    "\" />\n"; //name=\"applyFilter\"
echo "\t\t\t\t\t\t<input type=\"submit\" name=\"removeFilter\" value=\""
    ._("Remove filter").
    "\" ";
if ($practicaQuery->getDesignation() === "all experiences")
    echo "disabled=\"disabled\" ";
echo "/>\n";
echo "\t\t\t\t\t</form>\n";

// new experience:
echo "\t\t\t\t\t<form action=\"praxisEdit.php\" method=\"GET\">\n";
echo "\t\t\t\t\t\t<input type=\"submit\" value=\""._("New experience").
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

// first and last experiences are stored in the session to be read in 'sidebar.inc':
$_SESSION['asideItem'] = $firstPraxis."..".$lastPraxis;

require_once 'footer.inc'; // footer of all the pages of the app

?>