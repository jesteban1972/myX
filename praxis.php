<?php
/**
 * script 'praxis.php'.
 * 
 * this script builds an experience´s detail page.
 * it is called using a parameter 'praxisID' within the URL.
 * using this lover identificator an object of class 'Praxis' is created,
 * whose data are read from database.
 * the page´s parts will be created using this object.
 * @author Joaquin Javier ESTEBAN MARTINEZ <jesteban1972@me.com>
 * last updated 2018-05-10
*/

require_once 'core.inc';
//require_once 'DB.inc';
require_once 'praxis.inc';
require_once 'amor.inc';
require_once 'locus.inc';
require_once 'user.inc';

$title = "myX - Experience";
include 'header.inc'; // header of all the pages of the app

// get a DB connection to work with:
$pdo = DB::getDBHandle();

/*
 * praxisID is retrieved from $_GET (intval needed)
 * and an object of the class 'Praxis' is instantiated using it.
 * this object will be used all throught this script.
 */
$praxis = new Praxis(intval($_GET['praxisID']));

echo "\t\t\t<section> <!-- section {{ -->\n";

echo <<<HTML
                    <!-- script praxis.php. part 0: navigation links -->
                    <article id="start">

HTML;

echo "\t\t\t\t\t\t<p class=\"large\">";
echo "<img src=\"".getImage("praxis","small")."\" alt=\"".
    _("(Image of a gold coin)")."\" />";
echo " <b>".$praxis->getName()."</b></p>\n";

// links to sections:
echo "\t\t\t\t\t\t<ul>\n";
echo "\t\t\t\t\t\t\t<li><a href=\"#data\">"._("Data")."</a></li>\n";
echo "\t\t\t\t\t\t\t<li><a href=\"#list\">"._("List of participants").
    "</a></li>\n";
echo "\t\t\t\t\t\t\t<li><a href=\"#description\">".
    _("Description")."</a></li>\n";
echo "\t\t\t\t\t\t<li><a href=\"#actions\">"._("Actions")."</a></li>\n";
echo "\t\t\t\t\t\t</ul>\n";

echo <<<HTML
                    </article>
                    
                    <!-- script praxis.php. part i: general data -->
                    <article id="data">

HTML;

echo "\t\t\t\t\t\t<h1 onMouseOver=\"this.innerHTML='".
    _("GENERALIA i.e. general data").
    "';\" onMouseOut=\"this.innerHTML='".
    _("GENERALIA").
    "';\">".
    _("GENERALIA").
    "</h1>\n";

HTML;

// name:
$praxisName = $praxis->getName(); // TODO: check (used also below in $xperienceSideview)
echo "\t\t\t\t\t\t<p class=\"medium\">"._("Name").": <b>".$praxisName.
    "</b>.</p>\n";
	
// rating:	
// displays rating with explication
$praxisRating = $praxis->getRating(); // TODO: check (used also below in $xperienceSideview)
echo "\t\t\t\t\t\t<p class=\"medium\">"._("Rating").": <b>".
    writtenRate($praxisRating, true)."</b>.</p>\n";

// place:

$locus = new Locus($praxis->getLocus()); // TODO: check (used also below in $xperienceSideview)

// place string is echoed:
echo "\t\t\t\t\t\t<p class=\"medium\">"._("Place:").
    " <b><a href=\"locus.php?locusID=".$locus->getLocusID()."\">".
    $locus->getName()."</a></b>".ampelmaenchen()." (".
    writtenNumber($locus->getPracticaAmount(), FEMENINE)." ".
    ($locus->getPracticaAmount() > 1 ? _("experiences") : _("experience")).
    ").</p>\n";

// time:

// format the time stamp
echo "\t\t\t\t\t\t<p class=\"medium\">"._("Time:")." <b>";
$date = strtotime($praxis->getDate());
$dateString = date("Y-m-d", $date);
echo $dateString;

if ($praxis->getOrdinal() !== "") {

    echo " ";
    echo writtenOrdinal($praxis->getOrdinal());
    
}
echo "</b> (";

// weekDay:
echo sprintf(_("the day was %s, "), _($weekDays[date("w", $date)]));

// moon phase:
$date_elems = explode("-", $dateString);
echo sprintf(_("the moon was %s, "), _(moonPhase(intval($date_elems[0]), intval($date_elems[1]), intval($date_elems[2]))));
$user = new User($_SESSION['userID']);

// user age:
echo sprintf(_("I was %d years old"), $user->getAge($date)).
    ").</p>\n";

echo <<<HTML
                    </article>

                    <!-- script praxis.php. part ii: participants -->
                    <article id="list">

HTML;

echo "\t\t\t\t\t\t<h1 onMouseOver=\"this.innerHTML='".
    _("CONFRATRES i.e. participants in the experience").
    "';\" onMouseOut=\"this.innerHTML='".
    _("CONFRATRES").
    "';\">".
    _("CONFRATRES").
    "</h1>\n";

// 5. participants

$amoresAmount = $praxis->getAmoresAmount(); // used also below
echo "\t\t\t\t\t\t<p>";
if ($amoresAmount > 1) {
    
    echo sprintf(_("Apart from myself, <b>%s</b> lovers participated in this experience:"),
        writtenNumber($amoresAmount));
    
} else {
    
    echo _("Apart from myself, only <b>one</b> lover participated in this experience:");
    
}
echo "\t\t\t\t\t\t<p>";

// participant list is echoed:
		
$amores = $praxis->getAmores();

$ordinalNr = 1;
foreach ($amores as $amorID) {

    $amor = new Amor($amorID);

    if (DEBUG) {

        if ($amoresAmount > 1) {

            if ($i > 0)
                $participants_list .= " & ";

            $i++;
            $participants_list .= "$i/ ";
        }

        $participants_list .= "<b>".$amorID."</b> ".$amor->getAlias();
        
    }
    
    echo $amor->HTMLPreview($ordinalNr, $options, "praxis.php?praxisID=".$praxis->getPraxisID());
    $ordinalNr++;
    
} // foreach ($amores as $amorID)
			

echo <<<HTML
                    </article>
    
                    <!-- script praxis.php. part iii: description -->
                    <article id="description">

HTML;

echo "\t\t\t\t\t\t<h1 onMouseOver=\"this.innerHTML='".
    _("NARRATIO i.e. description of the facts").
    "';\" onMouseOut=\"this.innerHTML='".
    _("NARRATIO").
    "';\">".
    _("NARRATIO").
    "</h1>\n";
		
$description = $praxis->getDescr();

// divides the description in an array of paragraphs separated by '<br />':
$paragraphs = explode("<br />", $description);
		
for ($i = 0; $i < count($paragraphs); $i++) {
    
    echo "\t\t\t\t\t\t";
    
    if ($i === 0) {
        
        echo "<p class=\"large\">".languageFlag($praxis->getTL(), 25)." ";
        
    } else {
        
        echo "<p class=\"description\">";

    }

    if ((DEBUG) && ($i === 0))
        echo " <span class=\"debug\">[praxisID <b>".$praxis->getPraxisID().
            "</b>; participant(s) ".$participants_list.
            "; tq ".$praxis->getTQ().
            "; tl ".$praxis->getTL()."]</span> ";

    echo $paragraphs[$i];
    echo "</p>\n";
        
} // for block
	    

 // Synchroton {{

// set loverID being passed to Synchroton.
// if there is more than one participant, row experience-with is disabled
$amorID = ($amoresAmount === 1) ?
    $praxis->getAmores()[0] :
    NULL;

Praxis::HTMLSynchroton($praxis->getPraxisID(),
    $amorID,
    $praxis->getLocus());

// }} Synchroton

// link to top of the page:
echo "\t\t\t\t\t<p style=\"text-align: center;\">".
    "<img src=\"images/arrow_top.gif\" /> <a href=\"#start\">".
    _("Back to top")."</a></p>\n";

echo <<<HTML
                </article>

                <!-- script locus.php. part iv: actions -->
                <article id="actions">

HTML;

echo "\t\t\t\t\t<h1 onMouseOver=\"this.innerHTML='".
    _("ACTIONS i.e. XXX").
    "';\" onMouseOut=\"this.innerHTML='".
    _("ACTIONS").
    "';\">".
    _("ACTIONS").
    "</h1>\n";

// edit experience form:
echo "\t\t\t\t\t<form action=\"praxisEdit.php\" method=\"GET\">\n";
echo "\t\t\t\t\t\t<input type=\"hidden\" name=\"praxisID\" value=\"".
    $praxis->getPraxisID()."\" />\n";
echo "\t\t\t\t\t\t<input type=\"submit\" value=\""._("Edit experience").
    "\" />\n";
echo "\t\t\t\t\t</form>\n";

// delete experience form:
echo "\t\t\t\t\t<form action=\"praxisDelete.php\" method=\"POST\">\n";
echo "\t\t\t\t\t\t<input type=\"hidden\" name=\"praxisID\" value=\"".
    $praxis->getPraxisID().
    "\" />\n";
echo "\t\t\t\t\t\t<input type=\"submit\" value=\"".
    _("Delete experience").
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

// praxis ID is stored in the session to be read in 'sidebar.inc':
$_SESSION['asideItem'] = $praxis->getPraxisID();

require_once 'footer.inc'; // footer of all the pages of the app

?>