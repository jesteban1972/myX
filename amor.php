<?php
/**
 * script ᾽amor.php᾽.
 * 
 * this script builds a lover´s detail page.
 * it is called using a parameter 'amorID' within the URL.
 * using this lover identificator an object of class 'Amor' is created,
 * whose data are read from database.
 * the page´s parts will be created using this object.
 * 
 * @author Joaquin Javier ESTEBAN MARTINEZ <jesteban1972@me.com>
 * last updated 2018-06-09
*/

require_once 'core.inc';
//require_once 'DB.inc';
require_once 'praxis.inc';
require_once 'amor.inc';
require_once 'locus.inc';


// get a DB connection to work with:
$pdo = DB::getDBHandle();

/*
 * amorID is retrieved from $_GET (intval needed)
 * and an object of the class 'Amor' is instantiated using it.
 * this object will be used all throught this script.
 */
$amor = new Amor(intval($_GET['amorID']));

$title = "myX - Lover";
$js = "amor.js";
include 'header.inc'; // header of all the pages of the app
echo "\t\t\t<section> <!-- section {{ -->\n";

echo "\t\t\t\t<p class=\"large\">";
echo "<img src=\"".getImage("amor", "small")."\" alt=\"".
    _("(Image of a cycladic idol)")."\" />";
echo " <b>".$amor->getAlias()."</b></p>\n";

echo <<<HTML
                <!-- Script amor.php. Part 0: Navigation links -->
                <article id="start">

HTML;

// links to sections:
echo "\t\t\t\t\t<ul>\n";
echo "\t\t\t\t\t\t<li><a href=\"#data\">"._("Data")."</a></li>\n";
echo "\t\t\t\t\t\t<li><a href=\"#list\">"._("List of experiences").
        "</a></li>\n";
echo "\t\t\t\t\t\t<li><a href=\"#alia\">"._("Other data")."</a></li>\n";
echo "\t\t\t\t\t\t<li><a href=\"#actions\">"._("Actions")."</a></li>\n";
echo "\t\t\t\t\t</ul>\n";
                    
echo <<<HTML
                </article>

                <!-- script amor.php. part i: general data -->
                <article id="data">
                    <h1 onMouseOver="this.innerHTML='GENERALIA i.e. general data';" onMouseOut="this.innerHTML='GENERALIA';">GENERALIA</h1>

HTML;

// alias and rating:
echo "\t\t\t\t\t<p class=\"medium\">";

if (DEBUG) {
    
    echo " <span class=\"debug\">[amorID <b>".$amor->getAmorID()."</b> ".
        $amor->getAlias()."]</span> ";
    
}

echo _("Alias").": <b>".$amor->getAlias()."</b>.</p>\n";

// rating:
echo "\t\t\t\t\t<p class=\"medium\">"._("Rating").": <b>".
    writtenRate($amor->getRating(), TRUE)."</b>.</p>\n";

// genre:
echo "\t\t\t\t\t<p class=\"medium\">"._("Genre").": <b>".
    _($genres[$amor->getGenre()])."</b>.</p>\n";

// description:
$descr1 = $amor->getDescr1();
$descr2 = $amor->getDescr2();
$descr3 = $amor->getDescr3();
$descr4 = $amor->getDescr4();

echo "\t\t\t\t\t<table class=\"amorDescription\"".
    " summary=\"table containing the description of a lover\">\n";
echo "\t\t\t\t\t<caption>"._("Lover description")."</caption>\n";

echo "\t\t\t\t\t\t<tbody>\n";

// description 1:
echo "\t\t\t\t\t\t\t<tr>\n";
echo "\t\t\t\t\t\t\t\t<td>".$_SESSION['userOptions']['descr1']."</td>\n";
echo "\t\t\t\t\t\t\t</tr>\n";
echo "\t\t\t\t\t\t\t<tr>\n";
echo "\t\t\t\t\t\t\t\t<td>".$descr1."</td>\n";
echo "\t\t\t\t\t\t\t</tr>\n";

if ($descr2 !== "") {
	
    // description 2:
    echo "\t\t\t\t\t\t\t<tr>\n";
    echo "\t\t\t\t\t\t\t\t<td>".$_SESSION['userOptions']['descr2']."</td>\n";
    echo "\t\t\t\t\t\t\t</tr>\n";
    echo "\t\t\t\t\t\t\t<tr>\n";
    echo "\t\t\t\t\t\t\t\t<td>".$descr2."</td>\n";
    echo "\t\t\t\t\t\t\t</tr>\n";
    
}

if ($descr3 !== "") {
    
    // description 3:
    echo "\t\t\t\t\t\t\t<tr>\n";
    echo "\t\t\t\t\t\t\t\t<td>".$_SESSION['userOptions']['descr3']."</td>\n";
    echo "\t\t\t\t\t\t\t</tr>\n";
    echo "\t\t\t\t\t\t\t<tr>\n";
    echo "\t\t\t\t\t\t\t\t<td>".$descr3."</td>\n";
    echo "\t\t\t\t\t\t\t</tr>\n";

}

if ($descr4 !== "") {
    
    // description 4:
    echo "\t\t\t\t\t\t\t<tr>\n";
    echo "\t\t\t\t\t\t\t\t<td>".$_SESSION['userOptions']['descr4']."</td>\n";
    echo "\t\t\t\t\t\t\t</tr>\n";
    echo "\t\t\t\t\t\t\t<tr>\n";
    echo "\t\t\t\t\t\t\t\t<td>".$descr4."</td>\n";
    echo "\t\t\t\t\t\t\t</tr>\n";

}

echo "\t\t\t\t\t\t<tbody>\n";
echo "\t\t\t\t\t</table>\n";

echo <<<HTML
                </article>

HTML;

echo <<<HTML

                <!-- script amor.php. part ii: experiences list -->
                <article id="list">
                    <h1 onMouseOver="this.innerHTML='ELENCHUS i.e. list of the experiences with her/him';" onMouseOut="this.innerHTML='ELENCHUS';">ELENCHUS</h1>

HTML;

// the amount of experiences is retrieved:
$practicaAmount = $amor->getPracticaAmount();

// the amount of different dates when these experiences happened is retrieved:
$differentDatesAmount = $amor->getDifferentDatesAmount();

echo "\t\t\t\t\t<p>";
switch ($amor->getGenre()) {
    
    case GENRE_MASCULINE:
        
        echo _("Lived with him");
        break;
    
    case GENRE_FEMININE:
        
        echo _("Lived with her");
        break;
    
}
echo " <b>".
    writtenNumber($practicaAmount, FEMENINE); // rewrite with sprintf
echo ($practicaAmount > 1) ? " experiences" : " experience";
echo "</b>";

if ($practicaAmount > 1) {
    
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

/*
 * page settings
 * the script retrieves from the URI the parameter list (v.gr. page=69)
 * in order to display a navigation bar (if neccessary) and to put an ordinal
 * before each entry of the catalogue
 */

/*
 * retrieves the parameter list and composes the string
 * $datatring (without page) that will be passed to navigationBar().
 */

$uriQuery = parse_url($_SERVER['REQUEST_URI'])['query'];

$data = explode("&", $uriQuery);
$dataString = "";
foreach ($data as $value) {
    
    if (substr($value, 0, 5) != "page=") {
        
        $dataString .= $value; // this is the current page number
        
    }
    
}

// retrieves the current page, 1 if not set:
$currentPage = ($_GET['page'] !== NULL) ?
    filter_input(INPUT_GET, "page", FILTER_VALIDATE_INT) :
    1; // $page is 1-based

$pageSettings = pageSettings($practicaAmount, $currentPage);
$pagesAmount = $pageSettings['numPages'];
$ordinal = $pageSettings['ordinal']; // $ordinal is 1-based
$ordinalZeroBased = $ordinal - 1;

// displays top navigation bar
if ($pageSettings['navBar']) {
    
    navBar($_SERVER['PHP_SELF'], $dataString, $currentPage, $pagesAmount);
    
}

//////////////////////////////////////////////////////////////////////////////////////////
// experiences list

/*
 * Amor::getPractica() is not appropiate to retrieve the experiences,
 * (the query result is not divided into sections -LIMIT-,
 * and it is not ordered -ORDER BY- taken into account
 * the parameter $_SESSION['options']['listsOrder']
 */
//$practica = $amor->getPractica();
$queryString = <<<QRY
SELECT `praxisID`
FROM `myX`.`practica`
INNER JOIN `myX`.`assignations`
ON `myX`.`practica`.`praxisID`=`myX`.`assignations`.`praxis`
WHERE `myX`.`assignations`.`amor` = :amorID
QRY;

switch ($_SESSION['navOptions']['listsOrder']) {
        
    case OLDEST_TO_NEWEST:

        $queryString .=
            " ORDER BY `myX`.`practica`.`date`, `myX`.`practica`.`ordinal`";
        break;

    case NEWEST_TO_OLDEST:

        $queryString .=
    " ORDER BY `myX`.`practica`.`date` DESC, `myX`.`practica`.`ordinal` DESC";
        break;
        
}
$queryString .= " LIMIT ".$ordinalZeroBased.", ".
    $_SESSION['navOptions']['resultsPerPage'];

if (DEBUG) {
    
    echo "\t\t\t\t\t\t\t<p><span class=\"debug\">[query string: ".$queryString.
        "]</span></p>";
    
}

$statement = $pdo->prepare($queryString);
$statement->bindParam(":amorID", $amor->getAmorID(), PDO::PARAM_INT);
$statement->execute();

foreach ($statement as $row) {
    
    // instantiate a 'praxis' object:
    $praxis = new Praxis($row['praxisID']);
    
    // call the method Praxis::XHTMLPreview
    // to display a brief preview of the experience:
    $praxis->HTMLPreview($ordinal, Praxis::PARTICIPANTS);
    
    // increases the ordinal number by one:
    $ordinal++;
    
}

// displays bottom navigation bar:
if ($pageSettings['navBar']) {
    
    navBar($_SERVER['PHP_SELF'], $dataString, $currentPage, $pagesAmount);
    
}

// link to top of the page:
echo "\t\t\t\t\t<p style=\"text-align: center;\">".
    "<img src=\"images/arrow_top.gif\" /> <a href=\"#start\">"._("Back to top").
    "</a></p>\n";

echo <<<HTML
                </article>

HTML;

/*
 * complementary data
 */

if ($amor->getAchtung() !== ""
    || $amor->getWeb() !== ""
    || $amor->getName() !== ""
    || $amor->getPhoto() !== ""
    || $amor->getPhone() !== ""
    || $amor->getEmail() !== ""
    || $amor->getOther() !== "") {
    
    echo <<<HTML

                <!-- script amor.php. part iii: other -->
                <article id="alia">
                    <h1 onMouseOver="this.innerHTML='ALTERA i.e. complementary data';" onMouseOut="this.innerHTML='ALTERA';">ALTERA</h1>

HTML;

    if ($amor->getAchtung() !== "") {
        
        echo "\t\t\t\t\t<p class=\"medium\">"._("Achtung").": <b>".
            $amor->getAchtung()."</b>.</p>\n";
        
    }

    if ($amor->getWeb() !== "") {
        
        echo "\t\t\t\t\t<p class=\"medium\">"._("Web").": <b>".$amor->getWeb().
            "</b>.</p>\n";
        
    }

    if ($amor->getName() !== "") {
        
        echo "\t\t\t\t\t<p class=\"medium\">"._("Name").": <b>".
            $amor->getName()."</b>.</p>\n";
        
    }

/*
 * photo: a boolean value is stored, which indicates just
 * if there are any pictures or not. desideratum: display rather a checkbox.
 * in a more evaluated version this should be a real picture to display.
 */
    if ($amor->getPhoto() !== "") {
        
        echo "\t\t\t\t\t<p class=\"medium\">"._("Pictures").": <b>".
            $amor->getPhoto()."</b>.</p>\n";
        
    }

    if ($amor->getPhone() !== "") {
        
        echo "\t\t\t\t\t<p class=\"medium\">"._("Phone").": <b>".
            $amor->getPhone()."</b>.</p>\n";
        
    }

    if ($amor->getEmail() !== "") {
        
        echo "\t\t\t\t\t<p class=\"medium\">"._("Email").": <b>".
            $amor->getEmail()."</b>.</p>\n";
        
    }

    if ($amor->getOther() !== "") {
        
        echo "\t\t\t\t\t<p class=\"medium\">"._("Other data").": <b>".
            $amor->getOther()."</b>.</p>\n";
        
    }
    
}

echo <<<HTML
                </article>

                <!-- script amor.php. part iv: actions -->
                <article id="actions">

HTML;

echo "\t\t\t\t\t<h1 onMouseOver=\"this.innerHTML='".
        _("ACTIONS i.e. XXX").
        "';\" onMouseOut=\"this.innerHTML='"._("ACTIONS")."';\">"._("ACTIONS").
        "</h1>\n";

// edit lover form:
echo "\t\t\t\t\t<form action=\"amorEdit.php\" method=\"GET\">\n";
echo "\t\t\t\t\t\t<input type=\"hidden\" name=\"amorID\" value=\"".
    $amor->getAmorID()."\" />\n";
echo "\t\t\t\t\t\t<input type=\"submit\" value=\""._("Edit lover")."\" />\n";
echo "\t\t\t\t\t</form>\n";

// delete lover form:
echo "\t\t\t\t\t<form action=\"amorDelete.php\" method=\"POST\">\n";
echo "\t\t\t\t\t\t<input type=\"hidden\" name=\"amorID\" value=\"".
    $amor->getAmorID()."\" />\n";
echo "\t\t\t\t\t\t<input type=\"submit\" value=\""._("Delete lover")."\" />\n";
echo "\t\t\t\t\t</form>\n";
                            
// link to previous page:
echo "\t\t\t\t\t<p style=\"text-align: center;\">".
    "<img src=\"images/arrow_back.gif\" />".
    " <a href=\"javascript: history.back();\">"._("Back to previous").
    "</a></p>\n";

echo "\t\t\t\t</article>\n";

echo "\t\t\t</section> <!-- }} section -->\n\n";

// amor ID is stored in the session to be read in 'sidebar.inc':
$_SESSION['asideItem'] = $amor->getAmorID();

require_once 'footer.inc'; // footer of all the pages of the app

?>