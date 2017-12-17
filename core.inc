<?php

/** core.inc
 * inc file
 * contains core definitions for the web application myX
 * (c) Joaquin Javier ESTEBAN MARTINEZ
 * last update: 2017-12-08
*/

//require_once 'exceptions.inc'")';

session_start();

// constants definition {{

define("DEBUG", 1); // DEBUG: turn to 0 in production environment

// genres
define("GENRE_MASCULINE", 1);
define("GENRE_FEMININE", 2);
// other genres can be added if needed

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
define("MY_BIRTHDATE", 93222000); // timestamp of 1972-12-15, obtained using mktime(00, 00, 00, 12, 15, 1972);

define ("USER", isset($_SESSION['userID'])?intval($_SESSION['userID']):-1);

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

/**
 * class ListGeneric
 * this is the base class of PracticaList, AmoresList and LocaList
 * used to store a list of experiences, lovers or places respectively
 * containing:
 * a) their designation/title,
 * b) a description of it, and
 * c) the SQL query used to retrieve the list
 * TODO: when entering into each list entry details, the former catalogue should
 * be loaded calling the method backToPreviousList()
 */
class GenericList {

    // I. member variables
    
    protected $designation; // list designation or title
    protected $description; // list description in a somehow extended way
    protected $queryString; // SQL query used to retrieve the list

    // II. implementation methods

    // getters:
    public function getDesignation() {return $this->designation;}
    public function getDescription() {return $this->description;}
    public function getQueryString() {return $this->queryString;}

    /**
     * method List::__construct
     * class constructor
     * @designation: list designation or title
     * @description: list description in a somehow extended way
     * @queryString: SQL query used to retrieve the list
     */
    public function __construct($designation = "", $description = "", $queryString = "") {

        $this->designation = $designation;
        $this->description = $description;
        $this->queryString = $queryString;
            
    } // method List::__construct
    
} // class GenericList

/**
 * class PracticaList
 * used to be displayed in the scripts 'practica.php' and 'amor.php'
 */
class PracticaList extends GenericList {

    // I. member variables: inherited from GenericList

    // II. implementation methods

    // getties: inherited from GenericList

    /**
     * method PracticaList::__construct
     * class constructor
     */
    public function __construct($designation = "",
        $description = "",
        $queryString = "") {

        // when called without arguments, the list will be unfiltered
        if ($designation === "" || $description === "" || $queryString === "") {
            
            $this->designation = "all experiences";
            $this->description = "unfiltered list of all experiences";
            $this->queryString = "SELECT * FROM `myX`.`practica`";
            $this->queryString .= " WHERE user=".$_SESSION['userID'];
                        
        } else {

            parent::__construct($designation, $description, $queryString);

        }

    } // method PracticaList::__construct
		
} // class PracticaList

/**
 * class AmoresList, used to be displayed by the script amoresList.php
 */
class AmoresList extends GenericList {

    // I. member variables: inherited from GenericList
    // 
    // II. implementation methods

    // getties: inherited from GenericList

    /**
     * method LoversList::__construct
     * class constructor
     */
    public function __construct($designation = "",
        $description = "",
        $queryString = "") {

        if ($designation === "" || $description === "" || $queryString === "") { // empty args, full list
            
            $this->designation = "all lovers";
            $this->description = "unfiltered list of all lovers";
            $this->queryString = "SELECT * FROM `myX`.`amores`";
            $this->queryString .= " WHERE user=".$_SESSION['userID'];
            
        } else {
            
            parent::__construct($designation, $description, $queryString);
            
        }

    } // method AmoresList::__construct
		
} // class AmoresList

/**
 * class LocaList, used to be displayed by the script locaList.php
 */
class LocaList extends GenericList {

    // I. member variables: inherited from GenericList

    // II. implementation methods

    // getties: inherited from GenericList

    /**
     * method LocaList::__construct
     * class constructor
     */
    public function __construct($designation = "",
        $description = "",
        $queryString = "") {

        if ($designation === "" || $description === "" || $queryString === "") { // empty args, full list

            $this->designation = "all places";
            $this->description = "unfiltered list of all places";
            $this->queryString = "SELECT * FROM `myX`.`loca`";
            $this->queryString .= " WHERE user=".$_SESSION['userID'];

        } else {

            parent::__construct($designation, $description, $queryString);

        }

    } // method LocaList::__construct
		
} // class LocaList

// XXX. global functions

/**
 * function ampelmaenchen.
 * locates a small icon, green or red, indicating that the access is
 * whether allowed or forbidden
*/
function ampelmaenchen($kind = GRUEN/*, $size = 15*/) {
    
    $output = '<sup><img src="images/ampelmaenchen_';
    
    switch ($kind) {
        
        case GRUEN:
            $output .= 'gruen';
            break;
        case ROT:
            $output .= 'rot';
            break;
    
    } // switch block
    
    $output .= '.gif " style="width: 15px; height: 15px;" /></sup>';
    
    return $output;

} // function ampelmaenchen

/**
 * function languageFlag
 * @param type $language
 * @param type $size
 * @return string
 */
function languageFlag($language, $size) {
    
    $output = '<img src="images/language_';
    
    switch ($language) {
        
        case 1: // Spanish only
            $output .= 'spanish';
            break;
        case 2: // Spanish with Greek additions
            $output .= 'spanish';
            break;
        case 3: // katharevousa Greek
        case 6: // romaic with katharevousa
            $output .= 'kingdom_greek';
            break;
        case 4: // koine Greek
            $output .= 'hellenistic_greek';
            break;
        case 5: // romaic Greek
            $output .= 'romaic_greek';
            break;
        
    } // switch block
    
    $output .= '.png" style="width: '.$size.'px; height: '.$size.'px;" />';
    
    return $output;
    
} // function languageFlag

/**
 * function moonPhase
 * TODO: check for accuracy
 * (from http://www.voidware.com/moon_phase.htm)
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
 * function myAge
 * TODO: check for correctly functionnement!
 */
function myAge($date) {

	$birthdate = MY_BIRTHDATE;
	$elapsedTime = $date - $birthdate;
	return intval($elapsedTime / (86400 * 365.25));

} // function myAge

/**
 * function navigationBar
 * displays a navigation bar for pages having more contents than
 * $options['resultsPerPage']
 * @$target_script script to jump to
 * @$args arguments list (except page)
 * @$page current page (1-based)
 * @$num_pages pages amount
 */
function navigationBar($targetScript, $dataString, $page, $pagesAmount) {

	echo <<<HTML
                        <table align="center" border="0">
                            <tr>

HTML;
	
	// composes first page button:
	
        echo "\t\t\t\t\t\t\t\t<td>\n";
	echo "\t\t\t\t\t\t\t\t\t<input";
        
	// disables the button in the first page
	if ($page === 1) {
            
            echo " disabled=\"disabled\"";
                
	}
	echo " name=\"previous_page\" onclick=\"window.location.href='";
	echo $targetScript;
	echo "?";
	if ($dataString !== "") {

            echo $dataString;
            echo "&";
            
	}
	echo "page=1';\" type=\"button\" value=\"<< πρώτη σελίς\" />\n";
	echo "\t\t\t\t\t\t\t\t</td>\n";
	
	// composes previous page button:
        
	echo "\t\t\t\t\t\t\t\t<td>\n";
	echo "\t\t\t\t\t\t\t\t\t<input";
	// disables the button in the first page
	if ($page === 1) {
            
            echo " disabled=\"disabled\"";
            
	}
        
	echo " name=\"previous_page\" onclick=\"window.location.href='";
	echo $targetScript;
	echo "?";
	if ($dataString !== "") {
		echo $dataString;
		echo "&";
	}
	echo "page=";
	echo $page - 1;
	echo "';\" type=\"button\" value=\"< προηγούμενος σελίς\" />\n";
	echo "\t\t\t\t\t\t\t\t</td>\n";
	
	//////////////////////////////////////////////////////////////////////////////////////
	// current page and pages' amount
	// display current page and page's amount
	// TODO: when updating current page's textbox (onhaschange?) it should jump to the referred page
	$pageDisplayed = $page; //  displays current page
	echo <<<HTML
                                <td>
                                    <p>σελὶς <input name="current_page" onhaschange="window.location.href='{$targetScript}';" size="10" type="text" value="{$pageDisplayed}" /> ἐκ συνολικῶς {$pagesAmount}</p>
                                </td>

HTML;
	
	// composes next page button:
	
        echo "\t\t\t\t\t\t\t\t<td>\n";
	echo "\t\t\t\t\t\t\t\t\t<input";
	// disables the button in the last page
	if ($page === $pagesAmount) {
            
            echo " disabled=\"disabled\"";
                
	}
	echo " name=\"next_page\" onclick=\"window.location.href='";
	echo $targetScript;
	echo "?";
	if ($dataString !== "") {
            
            echo $dataString;
            echo "&";
                
	}
	echo "page=";
	echo $page + 1;
	echo "';\" type=\"button\" value=\"ἑπόμενος σελίς >\" />\n";
	echo "\t\t\t\t\t\t\t\t</td>\n";
	
	// composes last page button:
        
	echo "\t\t\t\t\t\t\t\t<td>\n";
	echo "\t\t\t\t\t\t\t\t\t<input";
	// disables the button in the last page
	if ($page === $pagesAmount) {
            
            echo " disabled=\"disabled\"";
            
	}
	echo " name=\"last_page\" onclick=\"window.location.href='";
	echo $targetScript;
	echo "?";
        
	if ($dataString !== "") {
            
            echo $dataString;
            echo "&";
                
	}
	echo "page=";
	echo $pagesAmount;
	echo "';\" type=\"button\" value=\"τελευταία σελίς >>\" />\n";
	echo "\t\t\t\t\t\t\t\t</td>\n";
		
	echo <<<HTML
                            </tr>
                        </table>

HTML;
	
	return;

} // function navigationBar

/**
 * function pageSettings
 * used in listed pages, determines the page settings
 * @amount
 * @page the current page(?)
 * returns an array with the page settings, being these:
 * - numPages: the pages amount(?)
 * - navigationBar: a boolean value true if a navigation bar is needed
 * - ordinal: the 
 */
function pageSettings($amount, $page) {

        $navigationBar = FALSE; // default return value
    
	// calculates total number of pages
	$numPages = intval(ceil($amount / $_SESSION['options']['resultsPerPage']));

	// determines if navigation bar is necessary:
	if ($amount > $_SESSION['options']['resultsPerPage']) {
            
            $navigationBar = TRUE;
                
	}

	// etablishes the initial ordinal of the page
	$ordinal = (($page - 1) * $_SESSION['options']['resultsPerPage'] + 1); // $ordinal is 1-based
	
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
                            $writtenNumber = "one"; // μία
                            break;
                    default: // MASCULINE
                            $writtenNumber = "one"; // εἷς
                            break;
                    }
            break;
        case 2:
            $writtenNumber = "two";
            break;
        case 3:
            $writtenNumber = "three";
            break;
        case 4:
            $writtenNumber = "four";
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
            return "(ἡ μὲν α´)";
            break;
        case "b":
            return "(ἡ δὲ β´)";
            break;
        case "c":
            return "(ἡ δὲ γ´)";
            break;
        case "d":
            return "(ἡ δὲ δ´)";
            break;
        case "e":
            return "(ἡ δὲ ε´)";
            break;
        case "f":
            return "(ἡ δὲ ϛ´)";
            break;
        case "g":
            return "(ἡ δὲ ζ´)";
            break;
        case "h":
            return "(ἡ δὲ η´)";
            break;
        case "i":
            return "(ἡ δὲ θ´)";
            break;
        case "j":
            return "(ἡ δὲ ι´)";
            break;
        case "k":
            return "(ἡ δὲ ια´)";
            break;
        case "l":
            return "(ἡ δὲ ιβ´)";
            break;
        case "m":
            return "(ἡ δὲ ιγ´)";
            break;
        case "n":
            return "(ἡ δὲ ιδ´)";
            break;
        case "o":
            return "(ἡ δὲ ιε´)";
            break;
        case "p":
            return "(ἡ δὲ ιϛ´)";
            break;
        case "q":
            return "(ἡ δὲ ιζ´)";
            break;
        case "r":
            return "(ἡ δὲ ιη´)";
            break;
        case "s":
            return "(ἡ δὲ ιθ´)";
            break;
        case "t":
            return "(ἡ δὲ κ´)";
            break;
        case "u":
            return "(ἡ δὲ κα´)";
            break;
        case "v":
            return "(ἡ δὲ κβ´)";
            break;
        case "w":
            return "(ἡ δὲ κγ´)";
            break;
        case "x":
            return "(ἡ δὲ κδ´)";
            break;
        case "y":
            return "(ἡ δὲ κε´)";
            break;
        case "z":
            return "(ἡ δὲ κϛ´)";
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
                        $ret .= ' (excellent)';
                }
                break;
        case VERY_GOOD:
                $ret = '<img src="images/rating_star.gif" /><img src="images/rating_star.gif" /><img src="images/rating_star.gif" />';
                if ($explication) {
                        $ret .= ' (very good)';
                }
                break;
        case GOOD:
                $ret = '<img src="images/rating_star.gif" />';
                if ($explication) {
                        $ret .= ' (good)';
                }
                break;
        case BAD:
                $ret = '<img src="images/rating_bad.gif" />';
                if ($explication) {
                        $ret .= ' (bad)';
                }
                break;
        case VERY_BAD:
                $ret = '<img src="images/rating_worst.gif" />';
                if ($explication) {
                        $ret .= ' (very bad)';
                }
                break;
        default:
                $ret = '<img src="images/rating_undefined.gif" />';
                if ($explication) {
                        $ret .= ' (undefined)';
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