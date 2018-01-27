<?php

/*
 * praxis.inc
 * inc file implementing class xperience
 * (c) Joaquin Javier ESTEBAN MARTINEZ
 * last update: 2017-12-08
*/

require_once 'core.inc';
require_once 'DB.inc';
//require_once 'amor.inc';

session_start();

/**
    class Praxis
*/
class Praxis {

    // I. properties
    protected $praxisID;	// praxis ID
    protected $achtung;		// (mantained for compability with Sarkodeiktes)
    protected $locus;		// place
    protected $date;		// date
    protected $ordinal;		// ordinal
    protected $name;            // name
    protected $rating;          // rating
    protected $description;	// narration
    protected $tq;      	// (mantained for compability with Sarkodeiktes)
    protected $tl;              // (mantained for compability with Sarkodeiktes)
    
    //protected $favorite;	// favorite
	
    //protected static $oldestYear;	// praxis' oldest year ACHTUNG! unused
	
    // II. member constants:
    const RATING = 1;
    const LOCUS = 2;
    const PARTICIPANTS = 3;

    // III. methods

    // getters
    /**
     * method getPraxisID.
     * returns the value of property 'praxisID' (getter method).
     * @return type
     */
    public function getPraxisID() {return $this->praxisID;}
    //public function getAchtung() {return $this->achtung;} // ACHTUNG! unused
    public function getLocus() {return $this->locus;}
    public function getDate() {return $this->date;}
    public function getOrdinal() {return $this->ordinal;}
    public function getName() {return $this->name;}
    public function getRating() {return $this->rating;}
    
    /**
     * method getDescription.
     * returns the value of property 'description' (getter method).
     * @return type
     */
    public function getDescription() {return $this->description;}
    public function getTQ() {return $this->tq;}
    public function getTL() {return $this->tl;}
	
//    private function isFavorite() { // ACHTUNG! unused
//	
//        return ($this->favorite === TRUE) ? TRUE : FALSE;
//
//    }
	
    /**
     * method Praxis::__constructor
     * class constructor: initiates an instance of the class,
     * and sets its member variables from the DB
     * @$praxisID
    */
    public function __construct($praxisID) {
        
        // 1. get a DB connection to work with:
        $pdo = DB::getDBHandle();
        
        // 2. query the table 'practica'. only one row expected.
        
        $queryString = <<<QUERY
SELECT *
FROM `myX`.`practica`
WHERE praxisID=:praxisID
QUERY;

        $statement = $pdo->prepare($queryString);
        $statement->bindParam(":praxisID", $praxisID);
        $statement->execute();
        
        // 3. the data is fetched:
        $row = $statement->fetch();
        
        // the propierties of the current object are taken from the query:
        $this->praxisID = $praxisID;
        $this->achtung = $row['achtung'];
        $this->locus = $row['locus'];
        $this->date = $row['date'];
        $this->ordinal = $row['ordinal'];
        $this->name = $row['name'];
        $this->rating = intval($row['rating']);
        $this->description = $row['description'];
        $this->tq = $row['tq'];
        $this->tl = $row['tl'];
        $this->favorite = $row['favorite'];
        
    } // method Praxis::__construct

    /**
     * method Praxis::getAllPractica
     * returns an array of experiences ID's from all the practica
     * ACHTUNG! unused
    */
    private function getAllPractica() {
        
        /*
         * $practica is the array to be returned.
         * it will be filled up with the IDs of all the practica of the current user
         */
        
        $practica = array(); // the array to be returned. it will be filled
        
        // 1. get a DB handle to work with:
        $pdo = DB::getDBHandle();
        
        // 2. query the table 'assignations':

        $queryString = <<<QRY
SELECT praxisID
FROM `myX`.`practica`
ORDER BY date
QRY;
// ORDER BY time (if INDEX (date, ordinal))
// WHERE user=:userID

        $statement = $pdo->prepare($queryString);
        $statement->execute();
        
        foreach ($statement as $row) {
            
            // add a new element in the array (intval needed):
            $practica[] = intval($row['praxisID']); // fetchColumn???
            
        }

        return $practica;
	
    } // method Praxis::getAllPractica

    /**
     * method Praxis::getAmores
     * returns an array of lover ID's of all the lovers
     * who participate in the experience
    */
    public function getAmores() {

        $amores = array(); // the array to be returned
        
        // 1. get a DB handle to work with:
        $pdo = DB::getDBHandle();
        
        // 2. query the table 'assignations':

        $queryString = <<<QRY
SELECT amorID
FROM `myX`.`amores`
INNER JOIN `myX`.`assignations`
ON `myX`.`amores`.amorID = `myX`.`assignations`.amor
WHERE praxis=:praxisID
QRY;
// posible hacerlo simplemente en assignations?

        $statement = $pdo->prepare($queryString);
        $statement->bindParam(":praxisID", $this->getPraxisID());
        $statement->execute();
        
        foreach ($statement as $row) {
            
            // add a new element in the array
            $amores[] = intval($row['amorID']); // comprobar la necesidad de intval
            
        }

        return $amores;
	
    } // method Praxis::getAmores
    
    /**
     * method Praxis::getAmoresAmount
    */
    public function getAmoresAmount() {
        
        // 1. get a DB handle to work with:
        $pdo = DB::getDBHandle();
        
        // 2. query the table 'assignations':        

        $queryString = <<<QRY
SELECT COUNT(*)
FROM `myX`.`amores`
INNER JOIN `myX`.`assignations`
ON `myX`.`amores`.`amorID` = `myX`.`assignations`.`amor`
WHERE praxis=:praxisID
QRY;

        $statement = $pdo->prepare($queryString);
        $statement->bindParam(":praxisID", $this->getPraxisID());
        $statement->execute();
        
        // fetch the result (intval needed):
        return intval($statement->fetchColumn());

    } // method Praxis::getAmoresAmount
    
    /**
     * method Praxis::getPracticaAmount
     * returns the amount of experiences. this is a static method
    */
    public static function getPracticaAmount() {
        
        // 1. get a DB handle to work with:
        $pdo = DB::getDBHandle();
        
        // 2. query the table 'practica':
        
        $queryString = <<<QUERY
SELECT COUNT(*)
FROM `myX`.`practica`
WHERE user=:userID
QUERY;

        $statement = $pdo->prepare($queryString);
        $statement->bindParam(":userID", $_SESSION['userID']);
        $statement->execute();
        
        // 3. the number of rows is retrieved and returned (intval needed):      
        return intval($statement->fetchColumn());
	
    } // method Praxis::getPracticaAmount
	
    /**
     * method Praxis::HTMLPreview
     * displays a preview of the experience
     * @ordinalNr: experience ordinal
     * @options: bitwise combination of options (v.gr. XPERIENCE_RATE & XPERIENCE_DATE & EXCEPTR_MED)
    */
    public function HTMLPreview($ordinalNr, $options = "") {
	
        // 1. get a DB connection to work with:
        $pdo = DB::getDBHandle();

        echo "\t\t\t\t\t<div class=\"HTML_preview\">\n";

        /*
         *  first line of the preview (headline):
         *  1/ ordinal
         *  2/ designation (with hyperlink)
         *  3/ evaluation
         */

        // 1. ordinal number:
        echo "\t\t\t\t\t\t<p class=\"medium\"> ";
        echo $ordinalNr; // ordinal number is 1-based
        echo ". ";

        if (DEBUG) {
            
            echo " <span class=\"debug\">[praxis ID: ";
            echo $this->getPraxisID();
            echo "]</span> ";
                
        }

        // 2. name (with hyperlink)
        echo "<b><a href=\"praxis.php?praxisID=";
        echo $this->getPraxisID();
        echo "\">";
        echo $this->getName();
        echo "</a></b>";

        // 3. evaluation
        if ($options != self::RATING) { // not shown if in $filter evaluation
            
            echo " - ";
            echo writtenRate ($this->getRating());
            echo " - ";
            
        }

        echo "</p>\n";

        //////////////////////////////////////////////////////////////////////////////////
        // second line of the preview (complementary information):
        // 1. time (date + time ordinal)
        // 2. place
        // 3. participants
        // 4. description or excerpt
        // TODO: displays only the specified infos passed to the function with an argument (ex. XPERIENCE_DATE & XPERIENCE_PARTICIPANTS & ...)

        // 1. time
        // TODO: $year_span = $current_year - $date ['year'];
        echo "\t\t\t\t\t\t<p><b>".
            _("QVANDO").
            "</b> ".
            $this->getDate();

        if (!empty($this->getOrdinal())) {

                echo " ";
                echo writtenOrdinal($this->getOrdinal());

        }
        
        echo ". ";

        // 2. place
        if ($options != self::LOCUS) { // not shown if in locus.php
            
            echo "<b>"._("VBI")."</b> ";
            
            // the place's designation is queried from the table 'places':

            $queryString = <<<QRY
SELECT name
FROM `myX`.`loca`
WHERE locusID=:locusID
QRY;

            $statement = $pdo->prepare($queryString);
            $statement->bindParam(":locusID", $this->getLocus());
            $statement->execute();

            // 3. the data is fetched:
            $name = $statement->fetchColumn();

            echo $name;

            echo ". ";
            
        } // if block
   		   				
        // 3. participants
        if ($options != self::PARTICIPANTS) { // not shown if in amor.php
            
            echo "<b>"._("CVM QVIBVS")."</b> ";

            $queryString = <<<QRY
SELECT alias
FROM `myX`.`amores`
INNER JOIN `myX`.`assignations`
ON `myX`.`amores`.`amorID` = `myX`.`assignations`.`amor`
WHERE praxis=:praxisID
ORDER BY alias
QRY;

            $statement = $pdo->prepare($queryString);
            $statement->bindParam(":praxisID", $this->getPraxisID());
            $statement->execute();
            
            
            // get the amount of participants:
            $multipleParticipants = FALSE; // default value
            $participantsAmount = $statement->rowCount();

            if ($participantsAmount > 1) {

                $multipleParticipants = TRUE;
                $currentParticipant = 1; // $currentParticipant is 1-based

            }

            foreach ($statement as $row) {

                // multiple participants? insert an ordinal number:
                if ($participantsAmount > 1) {

                    echo strval($currentParticipant)."/";

                }

                echo " ".$row['alias'];

                // multiple participants?
                // insert a comma (when the current participant is not the last one)
                // and increase $currentParticipant:
                if ($participantsAmount > 1) {
                    
                    if ($currentParticipant < $participantsAmount) {
                     
                        echo ", ";
                        
                    }
                    
                    $currentParticipant++;

                }

            } // foreach

            echo ". ";

        } // if
   				
        // 4. description or excerpt
        echo "<b>"._("QVOD")."</b> ";
        echo languageFlag($this->getTL(), 15);
        echo ' ';
        
        if (strlen($this->getDescription()) > 510) { // long description

            // long narration: only a excerpt will be presented
            // a 510 char long string are treamed at it last whitespace
            // TODO: excerpt's length configurable with a parametrer (ex. EXCEPTR_MED)
            $excerpt = substr($this->getDescription(), 0, 510); // retrievess only the firs chars
            $excerpt = substr($excerpt, 0, strrpos($excerpt, " ")); // trims the excerpt in an space

            // substitutions:
            // <br /> tags by whitespaces:
            $excerpt = str_replace("<br />", " ", $excerpt); // ACHTUNG! it doesn't work always!!! why?
            // <b>, </b>, <i>, </i> tags supressed
            $excerpt = str_replace("<b>", "", $excerpt);
            $excerpt = str_replace("</b>", "", $excerpt);
            $excerpt = str_replace("<i>", "", $excerpt);
            $excerpt = str_replace("</i>", "", $excerpt);
            echo $excerpt;
            echo " [...] <input type=\"button\" value=\"> ".
                _("See more...").
                "\" onclick=\"window.location.href='praxis.php?praxisID=";
            echo $this->getPraxisID();
            echo "#participants'\" />";

        } else { // short description (less than 510 characters)

                echo $this->getDescription();

        } // if-else block
				
        if (DEBUG) {

                echo " <span class=\"debug\">[text quality: {$this->getTQ()};";
                echo " text language: {$this->getTL()}]</span> ";

        }

        echo "</p>\n";
        echo "\t\t\t\t\t</div>\n";

    } // method Praxis::HTMLPreview
	
    /**
     * method Praxis::HTMLSynchroton
     * displays the SynchrotonTM, tool to navigate xperiences 1/ with same lover, 2/ chronologically or 3/ topically
     * @xperience_id
     * @lover
     * @place
    */
    public function HTMLSynchroton ($praxisID, $amor, $locus) {

        // determines the xperience's index (ordinal)
        $allPractica = Praxis::getAllPractica();
        $praxisIndex = 0;

        foreach ($allPractica as $praxis) { // TODO: use an array function to retrieve the index

            if ($praxis === $praxisID) {
                    break;
            }

            $praxisIndex++;

        } // foreach block

        // determines previous and next xperience chronollogically
        $previousPraxis = $allPractica [$praxisIndex - 1]; // NULL when first xperience
        $nextPraxis = $allPractica [$praxisIndex + 1]; // NULL when last xperience

        echo <<<SynchrotonTM
<table id="SynchrotonTM" align="center" border="1">
    <tr>
        <td>
            <table border="0">
                <tr>
                    <td colspan="2" style="text-align: center"><p>Synchroton&trade;</p></td>
                </tr>
                <tr>
                    <td><p>previous praxis...</p></td><td style="text-align: right"><p>next praxis...</p></td>
                </tr>

SynchrotonTM;

        //////////////////////////////////////////////////////////////////////////////////
        // I. experiences with this lover

        if (isset($amor)) {

            $xperiences_with = $amor->getPractica();
            $xperience_with_index = 0;

            foreach ($xperiences_with as $xperience_with) { // TODO: use an array function to retrieve the index

                if ($xperience_with === $xperience_id) {

                        break;

                }

                $xperience_with_index++;

            } // foreach

            // determines previous and next xperience with this lover
            $previous_xperience_with = $xperiences_with[$xperience_with_index - 1]; // NULL when first xperience with this lover
            $next_xperience_with = $xperiences_with[$xperience_with_index + 1]; // NULL when last xperience with this lover

            // previous xperience with this lover
            echo "<tr>\n<td><input";

            if (!$previous_xperience_with) { // first xperience with this lover

                echo " disabled=\"disabled\"";

            }

            echo " name=\"previous_with_lover\" onclick=\"window.location.href='praxis.php?praxisID=";
            echo strval($previous_xperience_with);
            echo "'\" type=\"button\" value=\"...σὺν αὐτῷ\" /></td>";

            // next xperience with this lover
            echo "<td style=\"text-align: right\"><input";

            if (!$next_xperience_with) {

                    echo " disabled=\"disabled\"";

            }

            echo " name=\"next_with_lover\" onclick=\"window.location.href='praxis.php?praxisID=";
            echo strval($next_xperience_with);
            echo "'\" type=\"button\" value=\"...σὺν αὐτῷ\" /></td>\n</tr>\n";

        } // if

        //////////////////////////////////////////////////////////////////////////////////
        // II. xperiences chronologically

        echo "<tr>\n<td><input";

        if (!$previousPraxis) {

                echo " disabled=\"disabled\"";

        }

        echo " name=\"previous_chronologically\" onclick=\"window.location.href='praxis.php?praxisID=";
        echo strval($previousPraxis);
        echo "'\" type=\"button\" value=\"...χρονικῶς\" /></td>\n";

        echo <<<SynchrotonTM
<td style="text-align: right"><input
SynchrotonTM;

        if (!$nextPraxis) {

            echo " disabled=\"disabled\"";

        }

        echo " name=\"next_chronologically\" onclick=\"window.location.href='praxis.php?praxisID=";
        echo strval($nextPraxis);
        echo "'\" type=\"button\" value=\"...χρονικῶς\" /></td>\n";
        echo "</td>\n";
        echo "</tr>\n";
		
        //////////////////////////////////////////////////////////////////////////////////
        // III. xperiences locally

        if (isset ($place)) {

            $xperiences_at = $place->getXperiences();
            $xperience_at_index = 0;

            foreach ($xperiences_at as $xperience_at) { // TODO: use an array function to retrieve the index

                if ($xperience_at === $xperience_id) {

                        break;

                }

                $xperience_at_index++;

            } // foreach

            // determines previous and next xperience at this place
            $previous_xperience_at = $xperiences_at[$xperience_at_index - 1]; // NULL when first xperience at this place
            $next_xperience_at = $xperiences_at[$xperience_at_index + 1]; // NULL when last xperience at this place

            // previous xperience at this place
            echo "<tr>\n<td><input";

            if (!$previous_xperience_at) { // first xperience at this place

                echo " disabled=\"disabled\"";

            }

            echo " name=\"next_topically\" onclick=\"window.location.href='praxis.php?praxisID=";
            echo strval($previous_xperience_at);
            echo "'\" type=\"button\" value=\"...τοπικῶς\" /></td>\n";

            // next xperience at this place
            echo "<td style=\"text-align: right\"><input";

            if (!$next_xperience_at) { // last xperience at this place

                echo " disabled=\"disabled\"";

            }

            echo " name=\"next_topically\" onclick=\"window.location.href='praxis.php?praxisID=";
            echo strval($next_xperience_at);
            echo "'\" type=\"button\" value=\"...τοπικῶς\" /></td>\n";
            echo "</tr>\n";

        } // if block

        echo <<<SynchrotonTM
            </table>
        </td>
    </tr>
    </table>

SynchrotonTM;
	
    } // method Praxis::HTMLSynchroton
	
} // class Praxis