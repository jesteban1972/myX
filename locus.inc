<?php

/*
 * locus.inc
 * inc file with the declaration of class 'Locus'
 * (c) Joaquin Javier ESTEBAN MARTINEZ
 * last update: 2017-12-12
*/

require_once 'DB.inc';

/**
 * class Locus
*/
class Locus {

    // I. properties
    protected $locusID; // place ID
    protected $name; // name
    protected $country; // country
    protected $kind; // kind
    protected $description; // description
    protected $rating; // rating
    protected $address; // address
    protected $coordinatesExact; // coordinates
    protected $coordinatesGeneric; // coordinates
    protected $www; // www

    // II. implementation methods
    
    // getters:
    
    public function getLocusID() {
        
        return $this->locusID;
        
    }
    public function getName() {return $this->name;}
    public function getCountry() {return $this->country;}
    public function getKind() {return $this->kind;}
    public function getDescription() {return $this->description;}
    public function getRating() {return $this->rating;}
    public function getAddress() {return $this->address;}
    public function getCoordinatesExact() {return $this->coordinatesExact;}
    public function getCoordinatesGeneric() {return $this->coordinatesGeneric;}
    public function getWww() {return $this->www;} // TOFIX: returns NULL
	
		
    /**
     * method Locus::__constructor
     * class constructor: initiates an instance of the class,
     * and sets its member variables from the DB
     * @$amorID
    */
    public function __construct($locusID) {
                
        // 1. get a DB connection to work with:
        $pdo = DB::getDBHandle();
        
        // 2. query the table 'practica'. only one row expected.
        
        $queryString = <<<QUERY
SELECT *
FROM `myX`.`loca`
WHERE locusID=:locusID
QUERY;

        $statement = $pdo->prepare($queryString);
        $statement->bindParam(":locusID", $locusID);
        $statement->execute();
        
        // 3. the data is fetched:
        $row = $statement->fetch();
        
        // the propierties of the current object are taken from the query:
        $this->locusID = intval($locusID);
        $this->name = $row['name'];
        $this->country = $row['country'];
        $this->kind = $row['kind'];
        $this->description = $row['description'];
        $this->address = $row['address'];
        $this->coordinatesExact = $row['coordinatesExact'];
        $this->coordinatesGeneric = $row['coordinatesGeneric'];
        $this->www = $row['www'];

    } // method Locus::__construct

    /**
     * method Locus::getDifferentDatesAmount
     * returns the number of different dates where experiences are documented in this place
    */
    public function getDifferentDatesAmount() {
        
        // 1. get a DB handle to work with:
        $pdo = DB::getDBHandle();
        
        // 2. query the table 'practica':

        $queryString = <<<QUERY
SELECT COUNT(DISTINCT date)
FROM `myX`.`practica`
WHERE locus=:locusID
QUERY;
        
        // " AND user=:userID" not needed; each user has his/her own places
                
        $statement = $pdo->prepare($queryString);
        $statement->bindParam(":locusID", $this->locusID);
        $statement->execute();
        
        // 3. the number of rows is retrieved and returned (intval needed):      
        return intval($statement->fetchColumn());

    } // method Locus::getDifferentDatesAmount
	
   /**
     * method Locus::getMapCenter
    */
    public function getMapCenter() {
        
        $longs = array();
        $lats = array();
        
        // get a DB handle to work with:
        $pdo = DB::getDBHandle();
        
//!!!
        // verify that there are some places:
        $queryString = <<<QUERY
SELECT COUNT(*)
FROM `myX`.`loca`
WHERE `user`=:userID
QUERY;
        $statement = $pdo->prepare($queryString);
        $statement->bindParam(":userID", $_SESSION['userID'], PDO::PARAM_INT);
        if ($statement->fetchColumn() === 0)
            return;
//!!!
        $queryString = <<<QUERY
SELECT `coordinatesExact`, `coordinatesGeneric`
FROM `myX`.`loca`
WHERE `user`=:userID
QUERY;

        $statement = $pdo->prepare($queryString);
        $statement->bindParam(":userID", $_SESSION['userID'], PDO::PARAM_INT);
        $statement->execute();
        
        foreach ($statement as $row) {
            
            $coordinates =
                $row['coordinatesExact'] !== "" ?
                $row['coordinatesExact'] :
                $row['coordinatesGeneric'];
            
            $long = explode(", ", $coordinates)[0];
            $lat = explode(", ", $coordinates)[1];
            
            $longs[] = $long;
            $lats[] = $lat;
             
        }
        
        $maxLong = max($longs);
        $minLong = min($longs);
        $maxLat = max($lats);
        $minLat = min($lats);
        $centerLong = strval(($maxLong - $minLong) / 2);
        $centerLat = strval(($maxLat - $minLat) / 2);
        
//        $mapBoundaries["longMax"] = strval($maxLong);
//        $mapBoundaries["longMin"] = $minLong;
//        $mapBoundaries["latMax"] = $maxLat;
//        $mapBoundaries["latMin"] = $minLat;
        $mapCenter =
                strval($minLong + (($maxLong - $minLong) / 2)).
                ", ".
                strval($minLat + (($maxLat - $minLat) / 2));
        
        $_SESSION['mapCenter'] = $mapCenter;
        
        return;

    } // method Locus::getMapCenter

    /**
     * method Locus::getPracticaAmount
    */
    public function getPracticaAmount() {
        
        // 1. get a DB handle to work with:
        $pdo = DB::getDBHandle();
        
        // 2. query the table 'practica':
        
        $queryString = <<<QUERY
SELECT COUNT(*)
FROM `myX`.`practica`
WHERE locus=:locusID
QUERY;

        $statement = $pdo->prepare($queryString);
        $statement->bindParam(":locusID", $this->locusID);
        $statement->execute();
        
        // 3. the fetched row is returned (intval needed):
        return intval($statement->fetchColumn());


    } // method Locus::getPracticaAmount

    /**
     * method Locus::HTMLPreview
     * 
     * displays a preview of the place
     * 
     * parameters:
     *  $ordinalNr: page's ordinal number to be represented at the beginning
    */
    function HTMLPreview($ordinalNr) {
		
        echo "\t\t\t\t\t\t<div class=\"HTML_preview\">\n";
	
        //////////////////////////////////////////////////////////////////////////////////
        // first line (headline): ordinal, designation with hyperlink and xperiences amount

        // 1. ordinal number
        echo "\t\t\t\t\t\t\t<p class=\"medium\">";
        echo $ordinalNr; // ordinal number is 1-based
        echo ". ";

        if (DEBUG) {

                echo " <span class=\"debug\">[place_id: ";
                echo $this->getLocusID();
                echo "]</span> ";

        }

        // 2. designation with hyperlink
        echo "<b><a href=\"locus.php?locusID=";
        echo $this->getLocusID();
        echo "\">";
        echo $this->getName();
        echo "</a></b>";

        // 3. xperiences amount
        $practicaAmount = $this->getPracticaAmount();
        echo " (";
        echo writtenNumber($practicaAmount, FEMENINE);
        echo " ";
        echo $practicaAmount > 1 ? "experiences" : "experience";
        echo ")</p>\n";

        //////////////////////////////////////////////////////////////////////////
        // second line: description
        if ($this->getName() !== "") {
            
            echo "\t\t\t\t\t\t\t<p>";
            echo $this->getName();
            echo "</p>\n";
            
        }
		
        echo "</div>\n";		
		
    } // method Locus::HTMLPreview
		
} // class Locus

?>