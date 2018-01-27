<?php

/**
 * script amores.php
 * displays a list of lovers
 * (c) Joaquin Javier ESTEBAN MARTINEZ
 * last updated 2018-01-04
*/

require_once 'core.inc';
require_once 'session.inc';
require_once 'DB.inc';
require_once 'praxis.inc';
require_once 'amor.inc';

// 1. get a DB connection to work with:
$pdo = DB::getDBHandle();

/*
 * initializes $amoresList, and retrieves its components
 * if already storage in $_SESSION, retrieve list;
 * otherwise create an unfiltered list 
 */
if (!isset($_SESSION['amoresList'])) {
    
    $amoresList = new AmoresList();
    $_SESSION['amoresList'] = $amoresList;
    
} else {
    
    $amoresList = $_SESSION['amoresList'];
    
}

$designation = $amoresList->getDesignation();
$description = $amoresList->getDescription();
$queryString = $amoresList->getQueryString();

// page header:
$title = _("Lovers");
require_once 'header.inc'; // header of all the pages of the app
echo "\t\t\t<section> <!-- section {{ -->\n";

echo <<<HTML
                    <!-- Script amores.php. Part 0: Description of the list -->
                    <article id="start">

HTML;

// list designation and description, and lovers amount:

echo "\t\t\t\t\t\t<p class=\"medium\"><b>".
    $designation.
    "</b>: ".
    $description.
    " ";

if (DEBUG)
    echo "<span class=\"debug\">[query string: ".$queryString."]</span> ";

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

// links to page sections:
echo "\t\t\t\t\t<ul>\n\t\t\t\t\t\t<li><a href=\"#list\">".
    _("List of lovers").
    "</a></li>\n".
    "\t\t\t\t\t\t<li><a href=\"#actions\">".
    _("Actions").
    "</a></li>\n\t\t\t\t\t</ul>\n";

if ($amoresAmount > 1) {
    
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

    $pageSettings = pageSettings($amoresAmount, $currentPage);
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
 * a new query of amoresList::queryString is performed
 * including ORDER BY and LIMIT criteria
 * to display the appropiate segment of the whole list.
 */

    $queryString .= " ORDER BY `myX`.`amores`.`alias`";
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

        // creates an instance of class 'Amor' (intval needed):
        $amor = new Amor(intval($row['amorID']));
        
        // calls the method xperience::preview to display a brief preview of the xperience
        $amor->HTMLPreview($ordinal, $preview_options);

        $ordinal++;

    } //foreach


   // displays bottom navigation bar
   if ($pageSettings['navigationBar']) {

       navigationBar($_SERVER['PHP_SELF'], $dataString, $currentPage, $pagesAmount);

   }

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
    
} // if ($amoresAmount > 1)

echo <<<HTML
                </article>
                <!-- Script amores.php. Part II: Actions -->
                <article id="actions">
                    <h1>Actions</h1>

HTML;

// filter lovers:
echo "\t\t\t\t\t<form action=\"amoresFilter.php\" method=\"POST\">\n";
echo "\t\t\t\t\t\t<input type=\"submit\" name=\"set_filter\" value=\""
    ._("Apply filter").
    "\" />\n";
echo "\t\t\t\t\t</form>\n";

// new lover:
echo "\t\t\t\t\t<form action=\"amorEdit.php\" method=\"POST\">\n";
echo "\t\t\t\t\t\t<input type=\"submit\" value=\""._("New lover")."\" />\n";
echo "\t\t\t\t\t</form>\n";

//// edit countries list:
//echo "\t\t\t\t\t<form action=\"countriesEdit.php\" method=\"POST\">\n";
//echo "\t\t\t\t\t\t<input type=\"submit\" value=\""._("Edit countries list")."\" />\n";
//echo "\t\t\t\t\t</form>\n";

echo "\t\t\t\t</article>\n";

echo "\t\t\t</section><!-- }} section -->\n\n";
require_once 'footer.inc'; // footer of all the pages of the app

?>