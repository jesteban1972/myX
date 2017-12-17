<?php

/*
 * amor.inc
 * inc file implementing class 'Amor'
 * (c) Joaquin Javier ESTEBAN MARTINEZ
 * last update: 2017-12-12
*/

require_once 'core.inc'; // needed?!!!
require_once 'DB.inc';

session_start();

/**
 * class Amor
*/
class Amor {

    // I. properties
    protected $loverID;       // loverID (ἀριθμὸς-κλείς)
    protected $achtung;       // achtung (τυχὸν ἐκκρεμότητες)
    protected $alias;         // alias (ψευδώνυμον)
    protected $description1;  // description1 (γενικὴ περιγραφή)
    protected $description2;  // description2 (περιγραφὴ σώματος
    protected $description3;  // description3 (περιγραφὴ ἐμπροσθίων γεννητικῶν ὀργάνων: πέος, ὄρχεις)
    protected $description4;  // description4 (περιγραφὴ ὀπισθίων γεννητικῶν ὀργάνων: κῶλος)
    protected $rating;    // evaluation (ἀξιολόγησις)
    protected $web;           // web (δικτύωσις)
    protected $name;          // name (ὀνοματεπώνυμον)
    protected $photo;         // photo (ὕπαρξις φωτογραφιῶν)
    protected $telephone;     // telephone (τηλέφωνον ἢ τηλέφωνα)
    protected $email;         // email (ἠλεκτρονικὸν ταχυδρομεῖον)
    protected $other;         // other (παραλειπόμενα)

    // II. member constants
    const RATING = 1;
    //const PLACE = 2;
    //const PARTICIPANTS = 3;

    // III. methods
	
    // getters:
    public function getAmorID() {return $this->loverID;}
    public function getAchtung() {return $this->achtung;}
    public function getAlias() {return $this->alias;}
    public function getDescription1() {return $this->description1;}
    public function getDescription2() {return $this->description2;}
    public function getDescription3() {return $this->description3;}
    public function getDescription4() {return $this->description4;}
    public function getRating() {return $this->rating;}
    public function getWeb() {return $this->web;}
    public function getName() {return $this->name;}
    public function getPhoto() {return $this->photo;}
    public function getTelephone() {return $this->telephone;}
    public function getEmail() {return $this->email;}
    public function getOther() {return $this->other;}
	
    // other methods:
    
    /**
     * Amor::__construct
     * constructor
     * initiates an instance of the class, and sets its member variables from the DB
     * @$loverID
    */
    public function __construct($amorID) {
        
        // 1. get a DB connection to work with:
        $pdo = DB::getDBHandle();
        
        // 2. query the table 'amores'. only one row expected.
        
        $queryString = <<<QUERY
SELECT *
FROM `myX`.`amores`
WHERE amorID=:amorID
QUERY;

        $statement = $pdo->prepare($queryString);
        $statement->bindParam(":amorID", $amorID);
        $statement->execute();
        
        // 3. the data is fetched:
        $row = $statement->fetch();
        
        // the propierties of the current object are taken from the query:
        $this->loverID = $amorID;
        $this->achtung = $row['achtung'];
        $this->alias = $row['alias'];
        $this->description1 = $row['descr1'];
        $this->description2 = $row['descr2'];
        $this->description3 = $row['descr3'];
        $this->description4 = $row['descr4'];
        $this->rating = $row['evaluation'];
        $this->web = $row['web'];
        $this->name = $row['name'];
        $this->photo = $row['photo'];
        $this->telephone = $row['telephone'];
        $this->email = $row['email'];
        $this->other = $row['other'];

    } // method Amor::__construct
	
    /**
     * method Amor::getAmoresAmount
     * retrieves from the DB the total amount of lovers. this function is a class method, no instance needed
    */
    public static function getAmoresAmount() {
        
        // 1. get a DB handle to work with:
        $pdo = DB::getDBHandle();
        
        // 2. query the table 'practica':
        
        $queryString = <<<QUERY
SELECT COUNT(*)
FROM `myX`.`amores`
WHERE user=:userID
QUERY;

        $statement = $pdo->prepare($queryString);
        $statement->bindParam(":userID", $_SESSION['userID']);
        $statement->execute();
        
        // 3. the number of rows is retrieved and returned (intval needed):      
        return intval($statement->fetchColumn());
        
    } // method Amor::getAmoresAmount
    
    /**
     * method Amor::HTMLPreview
     * displays an HTML preview of the lover
     * @ordinalNr: page's ordinal to be represented at the beginning
     * @options: bitwise combination of options
    */
    function HTMLPreview($ordinalNr, $options) {
	
        // 1. get a DB connection to work with:
        $pdo = DB::getDBHandle();

        echo "\t\t\t\t\t\t<div class=\"HTML_preview\">\n";

        /*
         * first line (headline):
         * 1/ ordinal number
         * 2/ alias (with hyperlink)
         * 3/ evaluation
         * 4/ xperiences amount
         */

        // 1. ordinal number:
        echo "\t\t\t\t\t\t\t<p class=\"medium\"> ";
        echo $ordinalNr; // ordinal number is 1-based
        echo ". ";

        if (DEBUG) {

                echo " <span class=\"debug\">[D/ lover ID: ".$this->getAmorID()."]</span> ";

        }

        // 2. alias with hyperlink:
        echo "<b><a href=\"amor.php?amorID=";
        echo $this->getAmorID();
        echo "\">";
        echo $this->getAlias();
        echo "</a></b>";

        // 3. evaluation
        if ($options != self::RATING) { // not shown if in $filter evaluation

            echo " - ";
            echo writtenRate($this->getRating());
            echo " - ";

        }

        echo "</p>\n";


        //////////////////////////////////////////////////////////////////////////
        // 2nd line: combined description

        echo "<p>";
        echo $this->getCombinedDescription();
        echo "</p>\n";

        //////////////////////////////////////////////////////////////////////////
        // third line: xperiences amount
        // 1. xperiences amount
        // 2. evaluation (absolut or average)

        echo "<p>";

        // 1. xperiences amount

        $xperiencesAmount = $this->getPracticaAmount();

        echo writtenNumber($xperiencesAmount, FEMENINE);
        echo " ";
        echo ($xperiencesAmount > 1) ? "φάσεις" : "φάσις";
        echo " - ";

        // 2. evaluation (or middle evaluation)
        // TOFIX: fix average evaluation (e.g. for 2081 Ἀναστάσιος Β´, SOLL good, IST bad)

        $cumulate = 0;
        $average = 0;

        $queryString = <<<QRY
SELECT rating
FROM `myX`.`practica`
INNER JOIN `myX`.`assignations`
ON `myX`.`practica`.`praxisID`=`myX`.`assignations`.`praxis`
WHERE amor=:amorID
QRY;
        
        $statement = $pdo->prepare($queryString);
        $statement->bindparam(":amorID", $this->getAmorID());
        $statement->execute();
        
        foreach ($statement as $row) {
            
            $cumulate += intval($row['rating']);
            
        }
        
        $average = ceil($cumulate / $xperiencesAmount);
        echo writtenRate($average);
        echo " - ";

        if ($xperiencesAmount > 1) { // average value

                echo " (average)";

        }
        echo "</p>\n";

        echo "</div>\n";

    } // method Amor::HTMLPreview

    /**
     * method Amor::getCombinedDescription
     * join all four partial descriptions in one string
    */
    public function getCombinedDescription() {

        $combinedDescription = $this->getDescription1();

        if ($this->getDescription2() !== "") {

            $combinedDescription .= ". ".$this->getDescription2();

        }

        if ($this->getDescription3() !== "") {

            $combinedDescription .= ". ".$this->getDescription3();

        }

        if ($this->getDescription4() !== "") {

            $combinedDescription .= ". ".$this->getDescription4();

        }

        return $combinedDescription;

    } // method Amor::getCombinedDescription
	
    /**
     * method Amor::getPractica
    */
    public function getPractica() {
        
        $practica = array(); // the array to be returned
        
        // 1. get a DB handle to work with:
        $pdo = DB::getDBHandle();
        
        // 2. query the table 'assignations':

        $queryString = <<<QRY
SELECT praxisID
FROM `myX`.`practica`
INNER JOIN `myX`.`assignations`
ON `myX`.`practica`.`praxisID`=`myX`.`assignations`.`praxis`
WHERE `myX`.`assignations`.`amor`=:amorID
ORDER BY date
QRY;
// posible hacerlo simplemente en assignations?

        $statement = $pdo->prepare($queryString);
        $statement->bindParam(":amorID", $this->getAmorID());
        $statement->execute();
        
        foreach ($statement as $row) {
            
            // add a new element in the array (intval needed):
            $practica[] = intval($row['praxisID']);
            
        }

        return $practica;
	
    } // method Amor::getPractica


    /**
     * method Amor::getPracticaAmount
     * Achtung! this method is not to be confused with Praxis::getPracticaAmount
    */
    public function getPracticaAmount() {
       
        // 1. get a DB handle to work with:
        $pdo = DB::getDBHandle();
        
        // 2. query the table 'assignations':  check the query!!!      
        
//        $queryString = <<<QRY
//SELECT COUNT(*)
//FROM `myX`.`practica`
//INNER JOIN `myX`.`assignations`
//ON `myX`.`practica`.`praxisID` = `myX`.`assignations`.`praxis`
//WHERE amor=:amorID
//QRY;

        $queryString = <<<QRY
SELECT COUNT(*)
FROM `myX`.`assignations`
WHERE amor=:amorID
QRY;

        $statement = $pdo->prepare($queryString);
        $statement->bindParam(":amorID", $this->getAmorID());
        $statement->execute();
        
        // fetch and return the result (intval needed):
        return intval($statement->fetchColumn());

    } // method Amor::getPracticaAmount
				
} // class Amor