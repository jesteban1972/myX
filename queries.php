<?php
/**
 * script 'queries.php'.
 * 
 * this script displays a list of experiences using an instance of class
 * 'Query'.
 * 
 * @author Joaquin Javier ESTEBAN MARTINEZ <jesteban1972@me.com>
 * last updated 2018-06-03
*/

require_once 'core.inc';
require_once 'DB.inc';
//require_once 'praxis.inc';


// get a DB connection to work with:
$pdo = DB::getDBHandle();

$name = "all queries"/*$query->getName()*/;
//$descr = $query->getDescr();

// page header:
$title = "myX - Queries";
//$js = "practica.js";
require_once 'header.inc'; // header of all the pages of the app
echo "\t\t\t<section> <!-- section {{ -->\n";

echo <<<HTML
                <!-- Script queries.php. part 0: description of the list -->
                <article id="start">

HTML;

// list designation and description:

echo "\t\t\t\t\t<p class=\"medium\"><img src=\"".getImage("praxis", "small").
    "\" alt=\""._("(Image of a gold coin)")."\" /> <b>"._("Saved queries").
    "</b> ";


/*
 * queries list.
 * a first query of queryList::queryString is performed
 * just to retrieve the amount of queries.
 * XXXPraxis::getPracticaAmount() would retrieve the amount of all experiences,
 * but practicaList might be filtered.
 */
$queryString2 = <<<QUERY
SELECT COUNT(*)
FROM `myX`.`queries`
WHERE `user` = :userID
QUERY;

$statement = $pdo->prepare($queryString2);
$statement->bindParam(":userID", $_SESSION['userID'], PDO::PARAM_INT);
$statement->execute();
$queriesAmount = intval($statement->fetchColumn());
//echo "\t\t\t\t\t\t<p class=\"medium\">";
switch ($queriesAmount) {

    case 0:
        
        echo _("(no saved queries found)");
        break;
    
    case 1:
        
        echo _("(only <b>one</b> saved query found)");
        break;
    
    default:
        
        echo sprintf(_("(<b>%d</b> saved queries found)"), $queriesAmount);
            
}
echo "</p>\n";

if (DEBUG)
    echo "\t\t\t\t\t\t<span class=\"debug\">[query string: ".$queryString.
        "]</span>\n";

    
// links to page sections:
echo "\t\t\t\t\t<ul>\n\t\t\t\t\t\t<li><a href=\"#list\">".
    _("List of saved queries").
    "</a></li>\n".
    "\t\t\t\t\t\t<li><a href=\"#actions\">".
    _("Actions").
    "</a></li>\n\t\t\t\t\t</ul>\n";

if ($queriesAmount > 0) {
        
    echo <<<HTML
                </article>

                <!-- Script queries.php. Part i: List of queries -->
                <article id="list">

HTML;
    
    echo "\t\t\t\t\t\t<h1 onMouseOver=\"this.innerHTML='".
        _("ELENCHUS i.e. list of queries").
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

    $pageSettings = pageSettings($queriesAmount, $currentPage);
    $pagesAmount = $pageSettings['numPages'];
    $ordinal = $pageSettings['ordinal']; // $ordinal is 1-based
    $ordinalZeroBased = $ordinal - 1;

    // displays top navigation bar
    if ($pageSettings['navBar'])
        navBar($_SERVER['PHP_SELF'], $dataString, $currentPage, $pagesAmount);

    ////////////////////////////////////////////////////////////////////////////
    // page contents
    
/*
 * a query against the DB is performed
 * including ORDER BY and LIMIT criteria
 * to display the appropiate segment of the whole list.
 */

    $queryString = "SELECT * FROM `myX`.`queries` WHERE `user` = ".
        $_SESSION['userID']." ORDER BY `name`"." LIMIT ".$ordinalZeroBased.", ".
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

        // creates an instance of class 'Query' (intval needed):
        $query = new Query(intval($row['queryID']));

        /*
         * call the method 'Query::HTMLPreview'
         * to display a brief preview of the query.
         */
        $query->HTMLPreview($ordinal, $previewOptions); // $previewOptions???

        $ordinal++;

    } //foreach

    // displays bottom navigation bar:
    if ($pageSettings['navBar'])
        navBar($_SERVER['PHP_SELF'], $dataString, $currentPage, $pagesAmount);

    // cite (original text):
//    echo <<<HTML
//                    <p class="quote">«Αἰτεῖτε καὶ δοθήσεται ὑμῖν,<br />
//                    ζητεῖτε καὶ εὑρήσετε,<br />
//                    κρούετε καὶ ἀνοιγήσετε ὑμῖν.<br />
//                    Καὶ ὅσα ἂν αἰτήσετε πιστεύοντες λήψεσθε»<br />
//                        <br />(N.T. Mt. 7.7)</p>
//    
//HTML;
    
    echo <<<HTML
                    <p class="quote">«Pedid, y se os dará; buscad, y hallaréis; llamad, y se os abrirá.<br />
                    Porque todo el que pide, recibe; y el que busca, halla; y al que llama, se le abrirá»<br />
                        <br />(Evangelio según Mateo)</p>
    
HTML;
    
// link to top of the page:
echo "\t\t\t\t<p style=\"text-align: center;\">".
    "<img src=\"images/arrow_top.gif\" /> <a href=\"#start\">"._("Back to top").
    "</a></p>\n";

echo <<<HTML
                </article>

HTML;
    
} // if ($practicaAmount > 0)

echo <<<HTML
                <!-- Script queries.php. Part ii: Actions -->
                <article id="actions">
                    <h1>Actions</h1>

HTML;

// query experiences:
//echo "\t\t\t\t\t<form action=\"practicaQuery.php\" method=\"POST\">\n";
//echo "\t\t\t\t\t\t<input type=\"submit\" value=\""
//    ._("Apply filter").
//    "\" />\n"; //name=\"applyFilter\"
//echo "\t\t\t\t\t\t<input type=\"submit\" name=\"removeFilter\" value=\""
//    ._("Remove filter").
//    "\" ";
//if ($practicaQuery->getDesignation() === "all experiences")
//    echo "disabled=\"disabled\" ";
//echo "/>\n";
//echo "\t\t\t\t\t</form>\n";
//
//// new experience:
//echo "\t\t\t\t\t<form action=\"praxisEdit.php\" method=\"GET\">\n";
//echo "\t\t\t\t\t\t<input type=\"submit\" value=\""._("New experience").
//    "\" />\n";
//echo "\t\t\t\t\t</form>\n";

// link to previous page:
echo "\t\t\t\t\t<p style=\"text-align: center;\">".
    "<img src=\"images/arrow_back.gif\" />".
    " <a href=\"javascript: history.back();\">".
    _("Back to previous").
    "</a></p>\n";

echo "\t\t\t\t</article>\n";

echo "\t\t\t</section> <!-- }} section -->\n\n";

// first and last experiences are stored in the session to be read in 'sidebar.inc':
//$_SESSION['asideItem'] = $firstPraxis."..".$lastPraxis;

require_once 'footer.inc'; // footer of all the pages of the app

?>