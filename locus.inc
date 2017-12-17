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
    protected $locusID;             // place ID (ἀριθμὸς-κλείς)
    protected $name;         // designation (ὀνομασία)
    protected $country;             // country (χώρα)
    protected $kind;                // kind (εἶδος)
    protected $description;         // description (περιγραφή)
    protected $address;             // address (διεύθυνσις)
    protected $coordinatesExact;    // coordinates (exact)
    protected $coordinatesGeneric;  // coordinates (generic)
    protected $www;                 // www (δικτύωσις)

    // II. implementation methods
    
    // getters:
    
    public function getLocusID() {
        
        return $this->locusID;
        
    }
    public function getName() {return $this->name;}
    public function getCountry() {return $this->country;}
    public function getKind() {return $this->kind;}
    public function getDescription() {return $this->description;}
    public function getAddress() {return $this->address;}
    public function getCoordinatesExact() {return $this->coordinatesExact;}
    public function getCoordinatesGeneric() {return $this->coordinatesGeneric;}
    public function getWww() {return $this->www;} // TOFIX: returns NULL
	
    /**
     * method Locus::genericQuery
     * auxiliary method used to query the DB. complete $queryString after neccessity
    */
//    protected function genericQuery() {
//		
//        // returns a DB connection to work with:
//        $currentDBConnection = DB::getDBConnection();
//
//        $queryString = <<<QRY
//SELECT *
//FROM 
//QRY;
//
//        $resultset = @$currentDBConnection->query($queryString); // TOFIX: try-catch block?
//
//        if ($resultset === FALSE || $resultset === NULL) {
//
//            $currentDBConnection->close();
//            throw new DBErrorException($currentDBConnection->error);
//
//        } else {
//
//            while (($tuple = @$resultset->fetch_assoc()) !== NULL) {
//
//                    // $xperiences[] = intval($tuple['xperience_id']);
//
//            } // while block
//
//        }  // if-else block
//
//        // cleans up result set:
//        $resultset->close();	
//
//        return;
//	
//    } // method Locus::genericQuery
		
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
        $this->description = $row['address'];
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
        $statement->execute(); //!!!
        
        // 3. the number of rows is retrieved and returned (intval needed):      
        return intval($statement->fetchColumn());

    } // method Locus::getDifferentDatesAmount
	
    /**
     * method Locus::getGeographicCenter
     * ACHTUNG! unfinish & unused
    */
//    protected function getGeographicCenter() {
//		
//        // returns a DB connection to work with:
//        $currentDBConnection = DB::getDBConnection();
//
//        $queryString = <<<QRY
//SELECT `coordinates_exact`, `coordinates_generic`
//FROM `pndnct`.`places`
//QRY;
//
//        $resultset = @$currentDBConnection->query($queryString);
//
//        if ($resultset === FALSE || $resultset === NULL) {
//
//            $currentDBConnection->close();
//            throw new DBException($currentDBConnection->error);
//
//        } else {
//
//            while (($tuple = @$resultset->fetch_assoc()) !== NULL) {
//
//                // TODO: determinate maximal positive latitude, maximal negative latitude,
//                // maximal positive longitude, maximal negative longitude,
//                // in order to get the exact geographic center
//                $coordinates = ($tuple['coordinates_exact'] == '' ?
//                        $tuple['coordinates_exact'] :
//                        $tuple['coordinates_generic']);
//                // if...
//
//            } // while
//
//        }  // if-else block
//
//        // cleans up result set:
//        $resultset->close();	
//
//        return;	
//	
//    } // method Locus::getGeographicCenter
    
    /**
     * method Locus::getJSCoordenates ACHTUNG! makes nothing!
     * 
     * used to display a JavaScript array with Google Maps LatLng objects
     * representing each place in the table places
    */
//    protected function getJSCoordenates() {
//
//        $currentDBConnection = DB::getDBConnection(); // DB connection handle
//
//        $queryString = <<<QRY
//SELECT COUNT(*) AS places_amount
//FROM `pndnct`.`places`
//QRY;
//
//        try {
//
//            $resultset = @$currentDBConnection->query($queryString);
//
//            if ($resultset === FALSE || $resultset === NULL) {
//
//                throw new DBException ($currentDBConnection->error);
//
//            } else {
//
//                $tuple = @$resultset->fetch_assoc(); // only one tuple expected
//
//                var_dump($tuple['places_amount']);
//
//
//            } // if-else block
//            
//            $resultset->close();
//
//        } catch (DBException $e) {
//
//            DB::closeDBConnection(); // cleans up DB connection
//            throw $e;
//
//        } // try ... catch
//
//        DB::closeDBConnection (); // cleans up DB connection
//        
//    } // method Locus::getJSCoordenates
	
    /**
     * method Locus::getXperiences
     * returns an array of experience IDs for the current place
    */
//    public function getXperiences() {
//	
//        $currentDBConnection = DB::getDBConnection(); // returns a DB connection
//
//        $xperiences = array();
//
//        $queryString = <<<QRY
//SELECT xperience_id
//FROM `pndnct`.`xperiences`
//WHERE `pndnct`.`xperiences`.`place` = {$this->getPlaceID()}
//ORDER BY date
//QRY;
//// TOFIX: ORDER BY time
//
//        $resultset = @$currentDBConnection->query($queryString); // TOFIX: try-catch block?
//
//        if ($resultset === FALSE || $resultset === NULL) {
//
//            $currentDBConnection->close();
//            throw new DBErrorException($currentDBConnection->error);
//
//        } else {
//
//            while (($tuple = @$resultset->fetch_assoc()) !== NULL) {
//
//                $xperiences[] = intval($tuple['xperience_id']);
//
//            } // while block
//
//        }  // if-else block
//
//        $resultset->close(); // cleans up result set
//
//        return $xperiences;
//	
//    } // method Locus::getXperiences

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