<?php

/**
 * script praxis.php
 * displays the experience's detail page
 * (c) Joaquin Javier ESTEBAN MARTINEZ
 * last updated 2017-12-12
*/

require_once 'session.inc';
require_once 'core.inc';
require_once 'DB.inc';
require_once 'praxis.inc';
require_once 'amor.inc';
require_once 'locus.inc';


// 1. get a DB connection to work with:
$pdo = DB::getDBHandle();

/*
 * praxisID is retrieved from $_GET (intval needed)
 * and an object of the class 'Praxis' is instantiated using it.
 * this object will be used all throught this script.
 */
$praxis = new Praxis(intval($_GET['praxisID']));


$title = _("Experience");
include 'header.inc'; // header of all the pages of the app
echo "\t\t\t<section> <!-- section {{ -->\n";

echo <<<HTML
                    <!-- Script praxis.php. Part 0: Navigation links -->
                    <article id="start">

HTML;

echo "\t\t\t\t\t\t<p class=\"medium\">";
echo "<img src=\"".getImage("praxis","small")."\" alt=\"".
    _("(Image of a gold coin)").
    "\" />";
echo "<b>{$praxis->getName()}</b></p>\n";

// links to sections:
echo "\t\t\t\t\t\t<ul>\n";
echo "\t\t\t\t\t\t\t<li><a href=\"#data\">".
        _("Data").
        "</a></li>\n";
echo "\t\t\t\t\t\t\t<li><a href=\"#participants\">".
        _("Participants").
        "</a></li>\n";
echo "\t\t\t\t\t\t\t<li><a href=\"#description\">".
        _("Description")."</a></li>\n";
echo "\t\t\t\t\t\t<li><a href=\"#actions\">".
        _("Actions")."</a></li>\n";
echo "\t\t\t\t\t\t</ul>\n";

echo <<<HTML
                    </article>
                    
                    <!-- Script praxis.php. Part I: General data -->
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

// 1. place
$locus = new Locus($praxis->getLocus()); // used also below in $xperienceSideview

// place string is echoed:
echo "\t\t\t\t\t\t<p class=\"medium\">"._("Place:").
    " <b><a href=\"locus.php?locusID=".
    $locus->getLocusID().
    "\">".
    $locus->getName().
    "</a></b>".
    ampelmaenchen().
    " (".
    writtenNumber($locus->getPracticaAmount(), FEMENINE).
    " ".($locus->getPracticaAmount() > 1 ? _("experiences") : _("experience")).
    ")</p>\n";

// 2. time
// format the time stamp
echo "\t\t\t\t\t\t<p class=\"medium\">"._("Time:")." <b>";
$date = strtotime($praxis->getDate());
$dateString = date("Y-m-d", $date); // used also below in $xperienceSideview
echo $dateString;

$praxisOrdinal = $praxis->getOrdinal(); // used also below in $xperienceSideview
if ($praxisOrdinal !== "") {

    echo " ";
    echo writtenOrdinal($praxisOrdinal);
    
}
echo "</b> (";
// weekDay is echoed:
echo sprintf(_("the day was %s, "), $weekDays[date("w", $date)]);
// moon phase is echoed:
$date_elems = explode("-", $dateString);
echo moonPhase(intval($date_elems[0]), intval($date_elems[1]), intval($date_elems[2]));
echo " was the moon, ";
// user age is echoed:
echo sprintf(_("I was %d years old"), myAge($date)).
    ")</p>\n";

// 3. designation
$praxisName = $praxis->getName(); // used also below in $xperienceSideview
echo "\t\t\t\t\t\t<p class=\"medium\">Name: <b>{$praxisName}</b></p>\n";
	
// 4. rating	
// displays rating with explication
$praxisRating = $praxis->getRating(); // used also below in $xperienceSideview
echo "\t\t\t\t\t\t<p class=\"medium\">".
    _("Rating:").
    " ".
    writtenRate($praxisRating, true).
    "</p>\n";

echo <<<HTML
                    </article>

                    <!-- Script praxis.php. Part II: Participants -->
                    <article id="participants">

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
//echo "\t\t\t\t\t\t<ul>\n";
		
$amores = $praxis->getAmores();

$ordinalNr = 1;
foreach ($amores as $amorID) {

    $amor = new Amor($amorID);

    if (DEBUG) {

        if ($amoresAmount > 1) {

            if ($i > 0) {

                $participants_list .= " & ";

            }

            $i++;
            $participants_list .= "$i/ ";
        }

        $participants_list .= "$amorID {$amor->getAlias()}";
        
    }
				
    // creates hyperlink
//    echo "\t\t\t\t\t\t\t<li><p class=\"medium\"><a href=\"amor.php?amorID=";
//    echo $amor->getAmorID();
//    echo "#data\">";
//    echo $amor->getAlias();
//    echo "</a>";
//    echo ampelmaenchen();
//    echo " - ";
//
//    // lover evaluation
//    echo writtenRate($amor->getRating());
//
//    echo " - (";

//    $practicaAmount = $amor->getPracticaAmount();
//
//    if ($practicaAmount === 1) {
//
//        echo _("one night stand");
//
//    } else {
//
//        echo sprintf(_("%s  experiences"),
//            writtenNumber($amor->getPracticaAmount(), FEMENINE));
//
//    }

    //echo "): ";
    //echo $amor->getCombinedDescription();
    echo $amor->HTMLPreview($ordinalNr, $options);
    //echo ".</p></li>\n";
    $ordinalNr++;
    
} // foreach ($amores as $amorID)
			
//echo "\t\t\t\t\t\t</ul>\n";

echo <<<HTML
                    </article>
    
                    <!-- Script praxis.php. Part III: Description -->
                    <article id="description">

HTML;

echo "\t\t\t\t\t\t<h1 onMouseOver=\"this.innerHTML='".
    _("NARRATIO i.e. description of the facts").
    "';\" onMouseOut=\"this.innerHTML='".
    _("NARRATIO").
    "';\">".
    _("NARRATIO").
    "</h1>\n";
		
$description = $praxis->getDescription();

// divides the description in an array of paragraphs separated by HTML-tag <br />:
$paragraphs = explode("<br />", $description);
		
for ($i = 0; $i < count($paragraphs); $i++) {
    
    echo "\t\t\t\t\t\t<p class=\"large\"";

    if ($i != 0) {
        
        echo " style=\"text-indent: 50px;\""; // TODO: CSS

    }
    echo ">";

    if ($i === 0) { // put the language flag before the first paragraph
        
        echo languageFlag($praxis->getTL(), 25);
        echo " ";
        
    }

    if ((DEBUG) && ($i === 0)) {

        echo " <span class=\"debug\">[xperience ID: ";
        echo $praxis->getPraxisID();
        echo "; participant(s): ";
        echo $participants_list;
        echo "; text quality: ".$praxis->getTQ();
        echo "; text language: ".$praxis->getTL();  
        echo "]</span> ";

    }

    echo $paragraphs[$i];
    echo "</p>\n";
        
} // for block
	    
if (strlen($praxis->getDescription()) > 1000) { // TODO: ἂς ὀρισθῇ κριτήριον βάσει τῶν ἰδιοτήτων τῆς ὀθόνης
    
    $link_to_start = true;
        
}

// link to top of the page:
echo "\t\t\t\t\t\t<p style=\"text-align: center;\"><img src=\"images/arrow_top.gif\" /> <a href=\"#start\">".
    _("Back to top").
    "</a></p>\n";

/**
 * Synchroton(R)
 * this part should be rewritten!!!
*/

if ($amoresAmount > 1) {
    
    $amor = NULL;
        
} elseif ($amor->getPracticaAmount() < 2) {
    
    $amor = NULL; //!
        
}

if ($locus->getPracticaAmount() < 2) {
    
    $locus = NULL; //!
        
}

Praxis::HTMLSynchroton($praxis->getPraxisID(),
    $amor,
    $locus);

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
echo "\t\t\t\t\t<form action=\"praxisEdit.php\" method=\"POST\">\n";
echo "\t\t\t\t\t\t<input type=\"hidden\" name=\"praxisID\" value=\"".
    $praxis->getPraxisID().
    "\" />\n";
echo "\t\t\t\t\t\t<input type=\"submit\" value=\"".
    _("Edit experience").
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

HTML;

echo "\t\t\t</section> <!-- }} section -->\n\n";
require_once 'footer.inc'; // footer of all the pages of the app

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
?>