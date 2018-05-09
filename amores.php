<?php

/**
 * script amores.php
 * displays a list of lovers
 * (c) Joaquin Javier ESTEBAN MARTINEZ
 * last updated 2018-03-24
*/

require_once 'core.inc';
require_once 'DB.inc';
require_once 'praxis.inc';
require_once 'amor.inc';

// get a DB connection to work with:
$pdo = DB::getDBHandle();

/*
 * initializes $amoresList, and retrieves its components
 * if already storage in $_SESSION, retrieve list;
 * otherwise create an unfiltered list 
 */
if (!isset($_SESSION['amoresQuery'])) {
    
    $amoresQuery = new AmoresQuery();
    $_SESSION['amoresQuery'] = $amoresQuery;
    
} else {
    
    $amoresQuery = $_SESSION['amoresQuery'];
    
}

$designation = $amoresQuery->getDesignation();
$description = $amoresQuery->getDescription();
$queryString = $amoresQuery->getQueryString();

// page header:
$title = "myX - Lovers";
require_once 'header.inc'; // header of all the pages of the app
echo "\t\t\t<section> <!-- section {{ -->\n";

echo <<<HTML
                    <!-- Script amores.php. Part 0: Description of the list -->
                    <article id="start">

HTML;

// list designation and description:

echo "\t\t\t\t\t<p class=\"medium\"><img src=\"".getImage("amor", "small").
    "\" alt=\""._("(Image of a cycladic idol)")."\" /> <b>"._($designation).
    "</b>: "._($description)." ";

/*
 * lovers amount.
 * a first query of amoresList::queryString is performed
 * just to retrieve the amount of lovers
 * Amor::getAmoresAmount() would retrieve the amount of all experiences,
 * but amoresList might be filtered.
 */

$statement = $pdo->prepare($queryString);
$statement->execute();
$amoresAmount = $statement->rowCount();
switch ($amoresAmount) {
	
    case 0:
        
        echo _("(no lovers found)");
        break;
    
    case 1:
        
        echo _("(only <b>one</b> lover found)");
        break;
    
    default:
        
        echo sprintf(_("(<b>%d</b> lovers found)"), $amoresAmount);
            
}
echo "</p>\n";

if (DEBUG)
    echo "<span class=\"debug\">[query string: ".$queryString."]</span> ";

// links to page sections:
echo "\t\t\t\t\t<ul>\n\t\t\t\t\t\t<li><a href=\"#list\">".
    _("List of lovers").
    "</a></li>\n".
    "\t\t\t\t\t\t<li><a href=\"#actions\">".
    _("Actions").
    "</a></li>\n\t\t\t\t\t</ul>\n";

if ($amoresAmount > 0) {
    
    echo <<<HTML
                    </article>
                    
                    <!-- Script amores.php. Part I: List -->
                    <article id="list">

HTML;
    
echo "\t\t\t\t\t\t<h1 onMouseOver=\"this.innerHTML='".
    _("ELENCHUS i.e. list of lovers").
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
    //del $uri = $_SERVER['REQUEST_URI'];
    //del $uriQuery = parse_url($uri)['query'];
    $uriQuery = parse_url($_SERVER['REQUEST_URI'])['query'];

    $data = explode("&", $uriQuery);
    $dataString = "";
    foreach ($data as $value)
        if (substr($value, 0, 5) != "page=")
            $dataString .= $value; // this is the current segment number

    // retrieves the current page (1 if not set)
    $currentPage = ($_GET['page'] !== NULL) ?
        intval($_GET['page']) :
        1; // $page is 1-based

    $pageSettings = pageSettings($amoresAmount, $currentPage);
    $pagesAmount = $pageSettings['numPages'];
    $ordinal = $pageSettings['ordinal']; // $ordinal is 1-based
    $ordinalZeroBased = $ordinal - 1;

    // displays top navigation bar
    if ($pageSettings['navigationBar'])
        navigationBar($_SERVER['PHP_SELF'], $dataString, $currentPage, $pagesAmount);

    ////////////////////////////////////////////////////////////////////////////
    // page contents
/*
 * a new query of amoresList::queryString is performed
 * including ORDER BY and LIMIT criteria
 * to display the appropiate segment of the whole list.
 */

    $queryString .= " ORDER BY `myX`.`amores`.`alias`";
    $queryString .= " LIMIT ".
        $ordinalZeroBased.
        ", ".
        $_SESSION['navigationOptions']['resultsPerPage'];

    if (DEBUG)
        echo "\t\t\t\t\t\t\t<p><span class=\"debug\">[query string: ".
            $queryString.
            "]</span></p>";

    $statement = $pdo->prepare($queryString);
    $statement->execute();
    $numRows = $statement->rowCount(); // used?

/*
 * the results of the query are fetched withing a foreach-as loop.
 */
    foreach ($statement as $row) {

        // creates an instance of class 'Amor' (intval needed):
        $amor = new Amor(intval($row['amorID']));
        
        // calls the method xperience::preview to display a brief preview of the xperience
        $amor->HTMLPreview($ordinal, $preview_options);

        // names of the first and last lovers are stored to be shown in the sidebar
        if ($ordinal === ($_SESSION['navigationOptions']['resultsPerPage'] * ($currentPage - 1)) + 1) {
            
            $firstAmor = $row['alias'];
            
        } elseif ($ordinal === ($_SESSION['navigationOptions']['resultsPerPage']) * $currentPage ||
            $ordinal === ($_SESSION['navigationOptions']['resultsPerPage'] * ($currentPage - 1)) + $numRows) {
            
            $lastAmor = $row['alias'];
        }
        $ordinal++;

    } //foreach


   // displays bottom navigation bar
   if ($pageSettings['navigationBar'])
       navigationBar($_SERVER['PHP_SELF'], $dataString, $currentPage, $pagesAmount);

   echo <<<HTML
                        <p class="quote">«<i>Χαρὰ καὶ μύρο τῆς ζωῆς μου ἡ μνήμη τῶν ὡρῶν<br />
                                           ποὺ ηὗρα καὶ ποὺ κράτηξα τὴν ἡδονὴ ὡς τὴν ἤθελα.<br />
                                           Χαρὰ καὶ μύρο τῆς ζωῆς μου ἐμένα, ποὺ ἀποστράφηκα<br />
                                           τὴν κάθε ἀπόλαυσιν ἐρώτων τῆς ρουτίνας</i>»<br />
                                           (Κ. Π. Καβάφης, 1863-1933: «Ἡδονή», ἐν· Ποιήματα 1916-1918)</p>

HTML;

// link to top of the page:
echo "\t\t\t\t\t\t<p style=\"text-align: center;\">".
    "<img src=\"images/arrow_top.gif\" />".
    " <a href=\"#start\">".
    _("Back to top").
    "</a></p>\n";
    
} // if ($amoresAmount > 0)

echo <<<HTML
                </article>
                <!-- Script amores.php. Part II: Actions -->
                <article id="actions">
                    <h1>Actions</h1>

HTML;

// filter lovers:
echo "\t\t\t\t\t<form action=\"amoresQuery.php\" method=\"POST\">\n";
echo "\t\t\t\t\t\t<input type=\"submit\" name=\"setFilter\" value=\""
    ._("Apply filter").
    "\" />\n";
echo "\t\t\t\t\t\t<input type=\"submit\" name=\"removeFilter\" value=\""
    ._("Remove filter").
    "\" ";
if ($amoresQuery->getDesignation() === "all lovers")
    echo "disabled=\"disabled\" ";
echo "/>\n";
echo "\t\t\t\t\t</form>\n";

// new lover:
echo "\t\t\t\t\t<form action=\"amorEdit.php\" method=\"POST\">\n";
echo "\t\t\t\t\t\t<input type=\"submit\" value=\""._("New lover")."\" />\n";
echo "\t\t\t\t\t</form>\n";

echo "\t\t\t\t</article>\n";

echo "\t\t\t</section><!-- }} section -->\n\n";

// first and last lovers are stored in the session to be read in 'sidebar.inc':
$_SESSION['asideItem'] = $firstAmor."..".$lastAmor;

require_once 'footer.inc'; // footer of all the pages of the app

?>