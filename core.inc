<?php
/** script 'core.inc'.
 * 
 * this file contains core definitions for the web application myX
 * (c) Joaquin Javier ESTEBAN MARTINEZ
 * last update: 2018-03-28
*/

//require_once 'exceptions.inc'")';

require_once 'query.inc';
require_once 'session.inc';

// constants definition {{

define("DEBUG", 1); // DEBUG: turn to 0 in production environment

// genres
define("GENRE_MASCULINE", 1);
define("GENRE_FEMININE", 2);
$genres = array("dummy", "man", "woman");
// other genres can be added if needed

/*
 * what is meant with 'other genres'? XXX bigender, butch, femme...
 * as this software tries to be as inclussive as possible,
 * all other genres should be considered.
 */

// rating values
define("UNDEFINED", 0);
define("VERY_BAD", 1);
define("BAD", 2);
define("GOOD", 3);
define("VERY_GOOD", 4);
define("EXCELLENT", 5);

// user kinds:
define("USER_VISITOR", -1);
define("USER_SUPER", 0);
define("USER_PREMIUM", 1);

// GUI languages:
define("GUI_ENGLISH", 1);
define("GUI_SPANISH", 2);
define("GUI_GREEK", 3);
$GUILanguages = array("dummy", "English", "Español", "Ελληνικά");
$GUILangCodes = array("dummy", "en", "es", "el");
// (add other languages on demand)

// lists order:
define("OLDEST_TO_NEWEST", 1);
define("NEWEST_TO_OLDEST", 2);


$weekDays = Array("Sunday",
    "Monday",
    "Tuesday",
    "Wednesday",
    "Thursday",
    "Friday",
    "Saturday");
/*
 * error kinds
 * two kinds of errors are contempled:
 * a) user-generated errors  (input error, non matching passwords etc); in the
 * corresponding handling exceptions there should be the possiblity to go back
 * to the previous page to try again with valid values
 * b) application-generated errors (argument errors, database errors etc); in
 * the corresponding handling exceptions there should be a message telling the
 * user "we are sorry... try again later"
 */
define("ERROR_FRONTEND", 0); // user-generated
define("ERROR_BACKEND", 1); // application-generated

// other
define("SYNCHROTON", 1);

// καταργητέα {{
// navigation liks:
define("LINK_TO_START", '<p style="text-align: center"><img src="images/arrow_top.gif" /> <a href="#start">Back to top of the page</a></p>');
define("LINK_TO_PREVIOUS", '<p style="text-align: center"><img src="images/arrow_back.gif" /> <a href="history.back();">Back to previous page</a></p>');
// other:
define("AMPELMAENCHEN_ROT", '<img src="images/ampelmaenchen_rot.gif" style="width: 15px; height: 15px;" />');
define("AMPELMAENCHEN_GRUEN", '<img src="images/ampelmaenchen_gruen.gif" style="width: 15px; height: 15px;" />');
// }} καταργητέα
define("ROT", 0);
define("GRUEN", 1);

// }} constants definition

date_default_timezone_set("Europe/Berlin");

// XXX. global functions

/**
 * function ampelmaenchen.
 * locates a small icon, green or red, indicating that the access is
 * whether allowed or forbidden
*/
function ampelmaenchen($kind = GRUEN/*, $size = 15*/) {
    
    $output = '<sup><img src="images/ampelmaenchen';
    
    switch ($kind) {
        
        case GRUEN:
            $output .= 'Gruen';
            break;
        case ROT:
            $output .= 'Rot';
            break;
    
    } // switch block
    
    $output .= '.gif " style="width: 15px; height: 15px;" /></sup>';
    
    return $output;

} // function ampelmaenchen

/**
 * function getPraxisImage
 * initializes the image of an experience from a random set
 */
function getImage($kind, $size) {
    
    $file = "images/".$kind;
    
    $number = random_int(1, 6);
    $file .= strval($number);

    switch ($size) {
        
        case "big":
            $file .= "-big.png";
            break;
        case "medium":
            $file .= "-medium.png";
            break;
        case "small":
            $file .= "-small.png";
            break;
    }
    
    return $file;
    
}

/**
 * function GUILangInitialize
 * initializes gettext to work with the GUI language
 * @param string $GUILangCode
 */
function GUILangInitialize($GUILangCode) {

    putenv("LANG=".$GUILangCode); 
    setlocale(LC_ALL, $GUILangCode);

    $domain = "GUIStrings";
    bindtextdomain($domain, "locale"); 
    bind_textdomain_codeset($domain, "UTF-8");
    textdomain($domain);
}

/**
 * function languageFlag
 * @param type $language
 * @param type $size
 * @return string
 */
function languageFlag($language, $size) {
    
    $output = '<img src="images/lang';
    
    switch ($language) {
        
        case 1: // Spanish only
            $output .= 'Spanish';
            break;
        case 2: // Spanish with Greek additions
            $output .= 'Spanish';
            break;
        case 3: // katharevousa Greek
        case 6: // romaic with katharevousa
            $output .= 'KingdomGreek';
            break;
        case 4: // koine Greek
            $output .= 'HellenisticGreek';
            break;
        case 5: // romaic Greek
            $output .= 'RomaicGreek';
            break;
        
    } // switch block
    
    $output .= '.png" style="width: '.$size.'px; height: '.$size.'px;" />';
    
    return $output;
    
} // function languageFlag

/**
 * function moonPhase
 * TODO: check for accuracy
 * (algorithm taken from http://www.voidware.com/moon_phase.htm)
 */
function moonPhase($year, $month, $day) {

	/*
    calculates the moon phase (0-7), accurate to 1 segment.
    0: new moon.
    4: full moon.
    */

	//int $c, $e;
	//float $jd;
	//int $b;

	if ($month < 3) {
            
            $year--;
            $month += 12;
                
	}
	++$month;
	$c = intval(365.2498 * $year);
	$e = intval(30.6 * $month);
	$jd = floatval($c + $e + $day - 694039.09); // $jd is total days elapsed
	$jd /= 29.53;                               // divide by the moon cycle (29.53 days)
	$ret = intval($jd);                         // int($jd) -> $ret, take integer part of $jd
	$jd -= $ret;                                // subtract integer part to leave fractional part of original $jd
	$ret = ($jd * 8) + 0.5;                     // scale fraction from 0-8 and round by adding 0.5
	$ret = $ret & 7;                            // 0 and 8 are the same, so turn 8 into 0
        
	switch ($ret) {
            
		case 0:
			return "new moon";
		case 1:
			return "waxing crescent";
		case 2:
			return "first quarter";
		case 3:
			return "waxing gibbous";
		case 4:
			return "full moon";
		case 5:
			return "waning gibbous";
		case 6:
			return "last quarter";
		case 7:
			return "waning crescent";
                    
	} // switch block
        
} // function moonPhase

/**
 * function 'navigationBar'.
 * 
 * this function displays a navigation bar using in long lists (i.e. those
 * having more items than $_SESSION['navigationOptions']['resultsPerPage']).
 * @param string $targetScript script to jump to
 * @param string $dataString XXXarguments list (except page)XXX
 * @param int $page current part ('page'), (1-based)
 * @param int $pagesAmount amount of parts ('pages')
 */
function navigationBar($targetScript, $dataString, $currentPage, $pagesAmount) {

    echo "\t\t\t\t\t\t<table align=\"center\" border=\"0\">\n";
    echo "\t\t\t\t\t\t\t<tr>\n";
	
    // first page button:

    echo "\t\t\t\t\t\t\t\t<td>\n";
    echo "\t\t\t\t\t\t\t\t\t<input type=\"button\" value=\"<< ".
        _("First Page").
        "\" ";
    echo "onclick=\"window.location.href='".
        $targetScript.
        "?";
    if ($dataString !== "") {

        echo $dataString;
        echo "&";

    }
    echo "page=1#list';\" ";
    
    // disables the button if current page is the first one:
    if ($currentPage === 1)
        echo "disabled=\"disabled\" ";
    
    echo "/>\n";
    echo "\t\t\t\t\t\t\t\t</td>\n";

    // previous page button:

    echo "\t\t\t\t\t\t\t\t<td>\n";
    echo "\t\t\t\t\t\t\t\t\t<input type=\"button\" value=\"< ".
        _("Previous Page").
        "\" ";
    echo "onclick=\"window.location.href='".
        $targetScript.
        "?";
    if ($dataString !== "") {
            echo $dataString;
            echo "&";
    }
    echo "page=";
    echo $currentPage - 1;
    echo "#list';\" ";
    
    // disables the button if current page is the first one
    if ($currentPage === 1)
        echo "disabled=\"disabled\" ";
    
    echo "/>\n";    
    echo "\t\t\t\t\t\t\t\t</td>\n";
	
    /*
     * current part ('page') and parts ('pages') amount:
     * display current page and amount of pages
     * TODO: check JavaScript (event 'change'): it should jump to the referred page 
     */
    
    echo "\t\t\t\t\t\t\t\t<td>\n";
    echo "\t\t\t\t\t\t\t\t\t<p>"._("Page").
        " <input type=\"text\" name=\"directPageInput\" size=\"10\" value=\""
        .$currentPage."\" /> "._("of")." ".$pagesAmount."</p>\n";
    echo "\t\t\t\t\t\t\t\t\t<input type=\"hidden\" id=\"pagesAmount\" value=\"".
        $pagesAmount."\" />\n"; // this value is read from JavaScript
    echo "\t\t\t\t\t\t\t\t</td>\n";
	
    // next page button:

    echo "\t\t\t\t\t\t\t\t<td>\n";
    echo "\t\t\t\t\t\t\t\t\t<input type=\"button\" value=\"".
        _("Next Page").
        " >\" ";

    echo "onclick=\"window.location.href='".
        $targetScript.
        "?";
    if ($dataString !== "") {

        echo $dataString;
        echo "&";

    }
    echo "page=";
    echo $currentPage + 1;
    echo "#list';\" ";
    
    // disables the button if current page is the last one:
    if ($currentPage === $pagesAmount)            
        echo "disabled=\"disabled\" ";
    
    echo "/>\n";
    echo "\t\t\t\t\t\t\t\t</td>\n";

    // last page button:

    echo "\t\t\t\t\t\t\t\t<td>\n";
    echo "\t\t\t\t\t\t\t\t\t<input type=\"button\" value=\"".
        _("Last Page").
        " >>\" ";

    echo "onclick=\"window.location.href='";
    echo $targetScript;
    echo "?";

    if ($dataString !== "") {

        echo $dataString;
        echo "&";

    }
    echo "page=";
    echo $pagesAmount;
    echo "#list';\" ";
    
    // disables the button if current page is the last one:
    if ($currentPage === $pagesAmount)            
        echo "disabled=\"disabled\" ";
    
    echo "/>\n";
    echo "\t\t\t\t\t\t\t\t</td>\n";

    echo "\t\t\t\t\t\t\t</tr>\n";
    echo "\t\t\t\t\t\t</table>\n";

    return;

} // function navigationBar

/**
 * global function 'pageSettings'.
 * 
 * this function is called in pages displaying a list:
 * i) list pages ('practica.php', 'amores.php' and 'loca.php'), and
 * ii) XXX from lover detail page ('amor.php').
 * it composes an associative array with the following page settings:
 * - numPages: the pages amount which composes the list. this value
 * depends on the setting '$_SESSION['navigationOptions']['resultsPerPage']'.
 * - navigationBar: a boolean value indicating if a navigation bar is needed
 * (when the amount of list elements is bigger than 'resultsPerPage')
 * - ordinal: the XXX 
 * used in listed pages, determines the page settings.
 * @param integer $amount the number of entries in a list.
 * @param int page the current page(?).
 * @return array containing the page settings.
 */
function pageSettings($amount, $page) {

    $navigationBar = FALSE; // default return value (navigatioBar not needed)

    // calculates total number of pages
    $numPages =
       intval(ceil($amount / $_SESSION['navOptions']['resultsPerPage']));

    // determines if navigation bar is necessary:
    if ($amount > $_SESSION['navOptions']['resultsPerPage'])            
        $navigationBar = TRUE;

    // etablishes the initial ordinal of the page
    // $ordinal is 1-based
    $ordinal =
        (($page - 1) * $_SESSION['navOptions']['resultsPerPage'] + 1);

    return array('numPages' => $numPages,
        'navigationBar' => $navigationBar,
        'ordinal' => $ordinal);

} // function pageSettings

/**
 * function writtenNumber
 * @param type $number
 * @param type $genre
 * @return type
 */
function writtenNumber($number, $genre = MASCULINE) {

    $writtenNumber = "";

    switch ($number) {
        
        case 1:
            switch ($genre) {
                    case FEMENINE:
                            $writtenNumber = _("one"); // μία gettext?
                            break;
                    default: // MASCULINE
                            $writtenNumber = _("one"); // εἷς
                            break;
                    }
            break;
        case 2:
            $writtenNumber = _("two");
            break;
        case 3:
            $writtenNumber = _("three");
            break;
        case 4:
            $writtenNumber = _("four");
            break;
        default:
            $writtenNumber = strval($number);
            break;
            
    } // switch block

    return $writtenNumber;

} // function writtenNumber

/**
 * function writtenOrdinal
 * returns an ordinal value (a, b...) in a user-friendly fashion (ἡ μὲν α´, ἡ δὲ β´...)
 * TODO: rewrite with instead a loop which takes the ASCII codes and return values of an array
 * TODO: add an argument to determine the genre (ἡ μὲν α´, τὸ μὲν α´, etc)
 * @$ordinal ordinal value
 */
function writtenOrdinal($ordinal) {
    
    switch ($ordinal) {
        
        case "a":
            return _("(1st)"); // ἡ μὲν α´
            break;
        case "b":
            return _("(2nd)"); // ἡ δὲ β´
            break;
        case "c":
            return _("(3rd)");
            break;
        case "d":
            return _("(4th)");
            break;
        case "e":
            return _("(5th)");
            break;
        case "f":
            return _("(6th)");
            break;
        case "g":
            return _("(7th)");
            break;
        case "h":
            return _("(8th)");
            break;
        case "i":
            return _("(9th)");
            break;
        case "j":
            return _("(10th)");
            break;
        case "k":
            return _("(11th)");
            break;
        case "l":
            return _("(12th)");
            break;
        case "m":
            return _("(13th)");
            break;
        case "n":
            return _("(14th)");
            break;
        case "o":
            return _("(15th)");
            break;
        case "p":
            return _("(16th)");
            break;
        case "q":
            return _("(17th)");
            break;
        case "r":
            return _("(18th)");
            break;
        case "s":
            return _("(19th)");
            break;
        case "t":
            return _("(20th)");
            break;
        case "u":
            return _("(21st)");
            break;
        case "v":
            return _("(22nd)");
            break;
        case "w":
            return _("(23rd)");
            break;
        case "x":
            return _("(24th)");
            break;
        case "y":
            return _("(25th)");
            break;
        case "z":
            return _("(26th)");
            break;
        default:
            if ($ordinal !== "") {
                
                return $ordinal;
                
            }
            
    } // switch block
    
} // function writtenOrdinal

/**
 * function writtenRate
 * returns a string with the written equivalence to the numeric evaluation rate passed as argument
 * @arg
 * @arg
*/
function writtenRate($evaluation, $explication = false) {

    $ret = "";  // string to be returned

    switch ($evaluation) {
        
        case EXCELLENT:
                $ret = "<img src=\"images/rating_star.gif\" /><img src=\"images/rating_star.gif\" /><img src=\"images/rating_star.gif\" /><img src=\"images/rating_star.gif\" /><img src=\"images/rating_star.gif\" />";
                if ($explication) {
                    
                    $ret .= " (".
                        _("excellent").
                        ")";
                    
                }
                break;
        case VERY_GOOD:
                $ret = '<img src="images/rating_star.gif" /><img src="images/rating_star.gif" /><img src="images/rating_star.gif" />';
                if ($explication) {
                        
                    $ret .= " ("._("very good").")";
                    
                }
                break;
        case GOOD:
                $ret = '<img src="images/rating_star.gif" />';
                if ($explication) {
                        
                    $ret .= " ("._("good").")";
                    
                }
                break;
        case BAD:
                $ret = '<img src="images/rating_bad.gif" />';
                if ($explication) {
                        
                    $ret .= " ("._("bad").")";
                    
                }
                break;
        case VERY_BAD:
                $ret = '<img src="images/rating_worst.gif" />';
                if ($explication) {
                        
                    $ret .= " ("._("very bad").")";
                    
                }
                break;
        default:
                $ret = '<img src="images/rating_undefined.gif" />';
                if ($explication) {
                    
                    $ret .= " ("._("undefined").")";
                    
                }
                break;
                
    } // switch block

    return $ret;
    
        
} // function writtenRate

/**
 * function LINK_TO_START
 */
function LINK_TO_START($i) {

    $ret = "";

    if ($i % 10 === 0) {
        
            $ret = LINK_TO_START;
            
    }

    return $ret;
	
} // function LINK_TO_START

?>