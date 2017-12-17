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


$title = "Praxis";
include 'header.inc'; // header of all the pages of the app

/*
 * praxisID is retrieved from $_GET (intval needed)
 * and an object of the class 'Praxis' is instantiated using it.
 * this object will be used all throught this script.
 */
$praxis = new Praxis(intval($_GET['praxisID']));

echo <<<HTML
                    <!-- Script praxis.php. Part 0: Navigation links -->
                    <article id="start">
                        <p class="center"><a href="#data"><img src="images/generalia-medium.jpg" title="Γενικὰ στοιχεῖα" /></a><a href="#amores"><img src="images/confratres-medium.jpg" title="Μεθέξοντες τῆς φάσεως" /></a><a href="#description"><img src="images/narratio-medium.jpg" title="Ἀφήγησις τῶν πεπραγμένων" /></a></p>
                        <p style="text-align: center"><img src="images/arrow_back.gif" /> <a href="JavaScript: history.back();">Back to previous page</a></p>
                    </article>
                    
                    <!-- Script praxis.php. Part I: General data -->
                    <article id="data">
                        <h1 onMouseOver="this.innerHTML='1. GENERALIA i.e. general data';" onMouseOut="this.innerHTML='1. GENERALIA';">1. GENERALIA</h1>

HTML;

// 1. place
$locus = new Locus($praxis->getLocus()); // used also below in $xperienceSideview

echo "\t\t\t\t\t\t<p class=\"medium\">Place: <b><a href=\"locus.php?locusID=";
echo $locus->getLocusID();
echo "\">";
echo $locus->getName();
echo "</a></b>";
echo ampelmaenchen();
echo " (";
echo writtenNumber($locus->getPracticaAmount(), FEMENINE);
echo ($locus->getPracticaAmount() > 1) ? " experiences" : " experience";
echo ")</p>\n";

// 2. time
// format the time stamp
echo "\t\t\t\t\t\t<p class=\"medium\">Time: <b>";
$date = strtotime($praxis->getDate());
$dateString = date("Y-m-d", $date); // used also below in $xperienceSideview
echo $dateString;

$praxisOrdinal = $praxis->getOrdinal(); // used also below in $xperienceSideview
if ($praxisOrdinal !== "") {

    echo " ";
    echo writtenOrdinal($praxisOrdinal);
    
}
echo "</b>, ";
switch (date("w", $date)) {
	case 0:
		echo "Sunday";
		break;
	case 1:
		echo "Monday";
		break;
	case 2:
		echo "Tuesday";
		break;
	case 3:
		echo "Wednesday";
		break;
	case 4:
		echo "Thursday";
		break;
	case 5:
		echo "Friday";
		break;
	case 6:
		echo "Saturday";
		break;
}
echo " was the day, ";
$date_elems = explode("-", $dateString);
echo moonPhase(intval($date_elems[0]), intval($date_elems[1]), intval($date_elems[2]));
echo " was the moon, ";
echo myAge($date);
echo " years old I was</p>\n";

// 3. designation
$praxisName = $praxis->getName(); // used also below in $xperienceSideview
echo "\t\t\t\t\t\t<p class=\"medium\">Name: <b>{$praxisName}</b></p>\n";
	
// 4. rating	
// displays rating with explication
echo "\t\t\t\t\t\t<p class=\"medium\">Rating: ";
$praxisRating = $praxis->getRating(); // used also below in $xperienceSideview
echo writtenRate($praxisRating, true);
echo "</p>\n";

echo <<<HTML
                    </article>

                    <!-- Script praxis.php. Part II: Participants -->
                    <article id="participants">
                        <h1 onMouseOver="this.innerHTML='2. AMORES i.e. participants in the experience';" onMouseOut="this.innerHTML='2. CONFRATRES';">2. CONFRATRES</h1>

HTML;

$amoresAmount = $praxis->getAmoresAmount(); // used also below
				
echo "\t\t\t\t\t\t<p>";
echo ($amoresAmount > 1) ? "συμμετείχαν" : "συμμετείχεν";
echo " -πλὴν ἐμοῦ- <b>";
echo writtenNumber($amoresAmount);
echo ($amoresAmount > 1) ? "</b> lovers" : "</b> lover";
echo ", ἤτοι·</p>\n";

// participant list
echo "\t\t\t\t\t\t<ul>\n";
		
$amores = $praxis->getAmores();
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
    echo "\t\t\t\t\t\t\t<li><p class=\"medium\"><a href=\"amor.php?amorID=";
    echo $amor->getAmorID();
    echo "#data\">";
    echo $amor->getAlias();
    echo "</a>";
    echo ampelmaenchen();
    echo " - ";

    // lover evaluation
    echo writtenRate($amor->getRating());

    echo " - (";

    $locaAmount = $amor->getPracticaAmount();

    if ($locaAmount === 1) {

        echo "one night stand";

    } else {

        echo writtenNumber($amor->getPracticaAmount(), FEMENINE);
        echo " experiences";

    }

    echo "): ";
    echo $amor->getCombinedDescription();
    echo ".</p></li>\n";
						
} // foreach ($amores as $amorID)
			
echo "\t\t\t\t\t\t</ul>\n";

echo <<<HTML
                    </article>
    
                    <!-- Script praxis.php. Part III: Description -->
                    <article id="description">
                        <h1 onMouseOver="this.innerHTML='3. NARRATIO i.e. description of the facts';" onMouseOut="this.innerHTML='3. NARRATIO';">3. NARRATIO</h1> 

HTML;
		
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

echo <<<HTML
                        <p style="text-align: center;"><img src="images/arrow_top.gif" /> <a href="#start">Ἐπαναφορὰ εἰς τὴν ἀρχὴν τῆς σελίδος</a></p>

HTML;

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
                        <p style="text-align: center"><img src="images/arrow_back.gif" /> <a href="JavaScript: history.back();">Ἐπαναφορὰ εἰς τὴν προηγουμένην σελίδα</a></p>
                    </article>

HTML;

// $xperienceSideview displays a sommary of the xperience in the sidebar
// 1-step creation
$praxisSideview = "\t\t\t\t\t\t<div class=\"HTML_preview_sidebar\">PRAXIS<br /><br />@";
$praxisSideview .= $locus->getName();
$praxisSideview .= "<br /><br />τῇ ";
$praxisSideview .= $dateString;
if ($praxisOrdinal !== "") {

    $praxisSideview .= $praxisOrdinal;
    
}
$praxisSideview .= "<br /><br /><b>";
$praxisSideview .= $praxisName;
$praxisSideview .= "</b><br /><br />";
$praxisSideview .= writtenRate($praxisRating, false);
$praxisSideview .= "</div>";

$_SESSION['praxisSideview'] = $praxisSideview; // stores $praxisSideview in $_SESSION to be read from sidebar.inc

require_once 'footer.inc'; // footer of all the pages of the app

?>