<?php

/**
 * script practica.php
 * displays a list of experiences based in an instance of class 'PracticaList'
 * (c) Joaquin Javier ESTEBAN MARTINEZ
 * last updated 2018-01-24
*/

require_once 'core.inc';
require_once 'session.inc';
require_once 'DB.inc';
require_once 'praxis.inc';


// 1. get a DB connection to work with:
$pdo = DB::getDBHandle();

/*
 * initializes $practicaList, and retrieves its components
 * if already storage in $_SESSION, retrieve list;
 * otherwise create an unfiltered list 
 */
if (!isset($_SESSION['practicaList'])) {
    
    $practicaList = new PracticaList();
    $_SESSION['practicaList'] = $practicaList;
    
} else {
    
    $practicaList = $_SESSION['practicaList'];
    
}

$designation = $practicaList->getDesignation();
$description = $practicaList->getDescription();
$queryString = $practicaList->getQueryString();

// page header:
$title = _("Experiences");
require_once 'header.inc'; // header of all the pages of the app
echo "\t\t\t<section> <!-- section {{ -->\n";

echo <<<HTML
                <!-- Script practica.php. Part 0: Description of the list -->
                <article id="start">

HTML;

// list designation and description

echo "\t\t\t\t\t<p class=\"medium\"><b>".
    $designation.
    "</b>: ".
    $description.
    " ";

if (DEBUG)
    echo " <span class=\"debug\">[query string: ".$queryString."]</span> ";

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
    
// links to page sections:
echo "\t\t\t\t\t<ul>\n\t\t\t\t\t\t<li><a href=\"#list\">".
    _("List of experiences").
    "</a></li>\n".
    "\t\t\t\t\t\t<li><a href=\"#actions\">".
    _("Actions").
    "</a></li>\n\t\t\t\t\t</ul>\n";

if ($practicaAmount >= 1) {
        
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

HTML;

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
    $uri = $_SERVER['REQUEST_URI'];
    $uriQuery = parse_url($uri)['query'];
    // parse_url: parse a URL, and return its components

    $data = explode("&", $uriQuery);
    $dataString = "";
    foreach ($data as $value) {

        if (substr($value, 0, 5) != "page=") {

            $dataString .= $value; // this is the current segment number
        }

    } // foreach block

    // retrieves the current segment, NULL if not set
    $currentPage = ($_GET['page'] !== NULL) ? intval($_GET['page']) : 1; // $page is 1-based

    $pageSettings = pageSettings($practicaAmount, $currentPage);
    $pagesAmount = $pageSettings['numPages'];
    $ordinal = $pageSettings['ordinal']; // $ordinal is 1-based
    $ordinalZeroBased = $ordinal - 1;

    // displays top navigation bar
    if ($pageSettings['navigationBar']) {

        navigationBar($_SERVER['PHP_SELF'], $dataString, $currentPage, $pagesAmount);

    }

    ////////////////////////////////////////////////////////////////////////////
    // page contents
    
/*
 * a new query of practicaList::queryString is performed
 * including ORDER BY and LIMIT criteria
 * to display the appropiate segment of the whole list.
 */

    $queryString .= " ORDER BY `myX`.`practica`.`date`";
    $queryString .= " LIMIT ".
        $ordinalZeroBased.
        ", ".
        $_SESSION['options']['resultsPerPage'];

    if (DEBUG) {

        echo "\t\t\t\t\t\t\t<p><span class=\"debug\">[query string: ".$queryString."]</span></p>";

    }

    $statement = $pdo->prepare($queryString);
    $statement->execute();

/*
 * the results of the query are fetched
 * withing a foreach...as loop.
 */
    foreach ($statement as $row) {

        // creates an instance of class 'Praxis' (intval needed):
        $praxis = new Praxis(intval($row['praxisID']));

        /*
         * call the method Praxis::XHTMLPreview
         * to display a brief preview of the experience
         */
        $praxis->HTMLPreview($ordinal, $previewOptions); // $previewOptions?

        $ordinal++;

    } //foreach

    // displays bottom navigation bar:
    if ($pageSettings['navigationBar']) {

        navigationBar($_SERVER['PHP_SELF'], $dataString, $currentPage, $pagesAmount);

    }

    echo <<<HTML
                    <p class="quote">«Me rappellant les plaisirs que j'eus je me les renouvelle,<br />
                        et je vis des peines que j'ai enduré, et que je ne sens plus»
                        <br />(Giacomo Casanova, Histoire de ma vie, Préface)</p>
    
HTML;

// link to top of the page:
echo "\t\t\t\t<p style=\"text-align: center;\"><img src=\"images/arrow_top.gif\" /> <a href=\"#start\">".
    _("Back to top").
    "</a></p>\n";

echo <<<HTML
                </article>

HTML;
    
} // if ($practicaAmount > 1)

echo <<<HTML
                <!-- Script practica.php. Part II: Actions -->
                <article id="actions">
                    <h1>Actions</h1>

HTML;

// filter experiences:
echo "\t\t\t\t\t<form action=\"practicaFilter.php\" method=\"POST\">\n";
echo "\t\t\t\t\t\t<input type=\"submit\" name=\"set_filter\" value=\""
    ._("Apply filter").
    "\" />\n";
echo "\t\t\t\t\t</form>\n";

// new experience:
echo "\t\t\t\t\t<form action=\"praxisEdit.php\" method=\"POST\">\n";
echo "\t\t\t\t\t\t<input type=\"submit\" value=\"".
    _("New experience").
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

?>