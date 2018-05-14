<?php
/**
 * script 'locus.inc'.
 * 
 * this script contains the implementation of class 'Locus',
 * the class which represents the abstraction of a place.
 * (c) Joaquin Javier ESTEBAN MARTINEZ
 * last update: 2018-05-10
*/

require_once 'DB.inc';

/**
 * class Locus
*/
class Locus {

    // I. properties
    protected $locusID;         // place ID
    protected $achtung;         // achtung
    protected $name;            // name
    protected $rating;          // rating
    protected $address;         // address
    protected $country;         // country
    protected $kind;            // kind
    protected $descr;           // description
    protected $coordExact;      // exact coordinates
    protected $coordGeneric;    // generic coordinates
    protected $web;             // web

    // II. implementation methods
    
    // getters:
    
    public function getLocusID() {
        
        return $this->locusID;
        
    }
    public function getAchtung() {return $this->achtung;}
    public function getName() {return $this->name;}
    public function getRating() {return $this->rating;}
    public function getAddress() {return $this->address;}
    public function getCountry() {return $this->country;}
    public function getKind() {return $this->kind;}
    public function getDescr() {return $this->descr;}
    public function getCoordExact() {return $this->coordExact;}
    public function getCoordGeneric() {return $this->coordGeneric;}
    public function getWeb() {return $this->web;}
    
    /**
     * method Locus::getCountryName
    */
    public function getCountryName() {
        
        // get a DB handle to work with:
        $pdo = DB::getDBHandle();
        
        // query the tables 'loca' and 'kinds':
        
        $queryString = <<<QUERY
SELECT `countries`.`name`
FROM `myX`.`loca` INNER JOIN `myX`.`countries`
ON `myX`.`loca`.`country` = `myX`.`countries`.`countryID`                
WHERE `loca`.`locusID` = :locusID
QUERY;

        $statement = $pdo->prepare($queryString);
        $statement->bindParam(":locusID", $this->getLocusID(), PDO::PARAM_INT);
        $statement->execute();
        
        // the retrieved name is returned:
        return ($statement->fetchColumn());
        
    } // method Locus::getCountryName
		
    /**
     * method Locus::__constructor
     * class constructor: initiates an instance of the class,
     * and sets its member variables from the DB
     * @$amorID
    */
    public function __construct($locusID) {
                
        // get a DB connection to work with:
        $pdo = DB::getDBHandle();
        
        // 2. query the table 'practica'. only one row expected.
        
        $queryString = <<<QUERY
SELECT *
FROM `myX`.`loca`
WHERE `locusID` = :locusID
QUERY;

        $statement = $pdo->prepare($queryString);
        $statement->bindParam(":locusID", $locusID);
        $statement->execute();
        
        // 3. the data is fetched:
        $row = $statement->fetch();
        
        // the propierties of the current object are taken from the query:
        $this->locusID = intval($locusID);
        $this->name = $row['name'];
        $this->rating = intval($row['rating']);
        $this->address = $row['address'];
        $this->country = intval($row['country']);
        $this->kind = intval($row['kind']);
        $this->descr = $row['descr'];
        $this->coordExact = $row['coordExact'];
        $this->coordGeneric = $row['coordGeneric'];
        $this->web = $row['web'];

    } // method Locus::__construct
    
    /**
     * method Locus::getAllLoca
     * returns an array of lover ID's from all places.
     */

    public function getAllLoca() {

        /*
         * $loca is the array to be returned.
         * it will be filled up with the IDs of all places.
         */

        $loca = array(); // the array to be returned. it will be filled
        
        // get a DB handle to work with:
        $pdo = DB::getDBHandle();

        // 2. query the table 'loca':
        $queryString = <<<QRY
SELECT `locusID`
FROM `myX`.`loca`
WHERE `user` = :userID
QRY;

        $statement = $pdo->prepare($queryString);
        $statement->bindParam(":userID", $_SESSION['userID'], PDO::PARAM_INT);
        $statement->execute();

        foreach ($statement as $row) {

            // add a new element in the array (intval needed):
            $amores[] = intval($row['locusID']);
            
        }
        
        return $amores;
        
    } // method Locus::getAllLoca

    /**
     * method Locus::getDifferentDatesAmount
     * returns the number of different dates where experiences are documented in this place
    */
    public function getDifferentDatesAmount() {
        
        // get a DB handle to work with:
        $pdo = DB::getDBHandle();
        
        // 2. query the table 'practica':

        $queryString = <<<QUERY
SELECT COUNT(DISTINCT date)
FROM `myX`.`practica`
WHERE `locus`=:locusID
QUERY;
        
        // " AND user=:userID" not needed; each user has his/her own places
                
        $statement = $pdo->prepare($queryString);
        $statement->bindParam(":locusID", $this->locusID, PDO::PARAM_INT);
        $statement->execute();
        
        // 3. the number of rows is retrieved and returned (intval needed):      
        return intval($statement->fetchColumn());

    } // method Locus::getDifferentDatesAmount
    
    /**
     * method Locus::getKindName
    */
    public function getKindName() {
        
        // get a DB handle to work with:
        $pdo = DB::getDBHandle();
        
        // query the tables 'loca' and 'kinds':
        
        $queryString = <<<QUERY
SELECT `kinds`.`name`
FROM `myX`.`loca` INNER JOIN `myX`.`kinds`
ON `myX`.`loca`.`kind` = `myX`.`kinds`.`kindID`                
WHERE `loca`.`locusID` = :locusID
QUERY;

        $statement = $pdo->prepare($queryString);
        $statement->bindParam(":locusID", $this->getLocusID(), PDO::PARAM_INT);
        $statement->execute();
        
        // the retrieved name is returned:
        return ($statement->fetchColumn());
        
    } // method Locus::getKindName
    
    /**
     * method Locus::getLocaAmount
     * retrieves from the DB the total amount of lovers. this function is a class method, no instance needed
    */
    public static function getLocaAmount() {
        
        // get a DB handle to work with:
        $pdo = DB::getDBHandle();
        
        // 2. query the table 'loca':
        
        $queryString = <<<QUERY
SELECT COUNT(*)
FROM `myX`.`loca`
WHERE `user`=:userID
QUERY;

        $statement = $pdo->prepare($queryString);
        $statement->bindParam(":userID", $_SESSION['userID'], PDO::PARAM_INT);
        $statement->execute();
        
        // 3. the number of rows is retrieved and returned (intval needed):      
        return intval($statement->fetchColumn());
        
    } // method Locus::getLocaAmount
	
   /**
     * method Locus::getMapCenter
    */
    public function getMapCenter() {
        
        $longs = array();
        $lats = array();
        
        // get a DB handle to work with:
        $pdo = DB::getDBHandle();
        
        // verify that there are some places:
        // TODO: check or use $_SESSION['DBStatus']['doPracticaExist']
        $queryString = <<<QUERY
SELECT COUNT(*)
FROM `myX`.`loca`
WHERE `user` = :userID
QUERY;
        $statement = $pdo->prepare($queryString);
        $statement->bindParam(":userID", $_SESSION['userID'], PDO::PARAM_INT);
        if ($statement->fetchColumn() === 0)
            return;
        else $_SESSION['DBStatus']['doPracticaExist'] = true;

        $queryString = <<<QUERY
SELECT `coordExact`, `coordGeneric`
FROM `myX`.`loca`
WHERE `user` = :userID
QUERY;

        $statement = $pdo->prepare($queryString);
        $statement->bindParam(":userID", $_SESSION['userID'], PDO::PARAM_INT);
        $statement->execute();
        
        foreach ($statement as $row) {
            
            if ($row['coordExact'] === "" &&
                $row['coordGeneric'] === "")
                break;
            
            $coordinates =
                $row['coordExact'] !== "" ?
                $row['coordExact'] :
                $row['coordGeneric'];
            
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
        
        //$_SESSION['mapCenter'] = $mapCenter;
        $_SESSION['DBStatus']['mapCenter'] = $mapCenter;
        
        return;

    } // method Locus::getMapCenter
    
    /**
     * method Locus::getPractica
    */
    public function getPractica() {
        
        $practica = array(); // the array to be returned
        
        // get a DB handle to work with:
        $pdo = DB::getDBHandle();
        
        // 2. query the table 'practica':

        $queryString = <<<QRY
SELECT `praxisID`
FROM `myX`.`practica`
WHERE `locus`=:locusID
ORDER BY `date`, `ordinal`
QRY;

        $statement = $pdo->prepare($queryString);
        $statement->bindParam(":locusID", $this->getLocusID(), PDO::PARAM_INT);
        $statement->execute();
        
        foreach ($statement as $row) {
            
            // add a new element in the array (intval needed):
            $practica[] = intval($row['praxisID']);
            
        }

        return $practica;
	
    } // method Locus::getPractica

    /**
     * method Locus::getPracticaAmount
    */
    public function getPracticaAmount() {
        
        // get a DB handle to work with:
        $pdo = DB::getDBHandle();
        
        // 2. query the table 'practica':
        
        $queryString = <<<QUERY
SELECT COUNT(*)
FROM `myX`.`practica`
WHERE `locus`=:locusID
QUERY;

        $statement = $pdo->prepare($queryString);
        $statement->bindParam(":locusID", $this->locusID, PDO::PARAM_INT);
        $statement->execute();
        
        // 3. the fetched row is returned (intval needed):
        return intval($statement->fetchColumn());


    } // method Locus::getPracticaAmount

    /**
     * method Locus::HTMLAsidePreview
    */
    function HTMLAsidePreview() {

        echo "\t\t\t\t<div class=\"HTMLAsidePreview\">\n";
        
        echo "\t\t\t\t\t<img src=\"". getImage("locus", "small")."\" alt=\"".
            _("(Image of a compass)").
            "\" />\n";
        
        echo "\t\t\t\t\t<p><b>".$this->getName()."</b></p>\n";
        echo "\t\t\t\t\t".writtenRate($this->getRating(), false)."\n";
        
        // experiences amount:
        echo "\t\t\t\t\t<p>".$this->getPracticaAmount()." ";
        echo ($this->getPracticaAmount() > 1) ?
            _("experiences") : _("experience");
        echo "</p>\n";
        
        echo "\t\t\t\t</div>\n";

    } // method Locus::HTMLAsidePreview
    
    /**
     * method Praxis::HTMLAsidePreviewLoca
     * displays a sommary of the places in the sidebar
     */
    public function HTMLAsidePreviewLoca() {
        
        echo "\t\t\t\t<div class=\"HTMLAsidePreview\">\n";
        echo "\t\t\t\t\t<img src=\"".getImage("locus", "medium")."\" alt=\"".
            _("(Image of a gold coin)").
            "\" />\n";
        
        $locaAmount = Locus::getLocaAmount();
        
        switch ($locaAmount) {
            
            case 0:
                echo "\t\t\t\t\t<p>"._("Not any places yet")."</p>\n";
                break;
            case 1:
                echo "\t\t\t\t\t<p>"._("Only one place so far")."</p>\n";
                break;
            default:
                echo "\t\t\t\t\t<p>".
                    sprintf(_("%d places"), $locaAmount).
                    "</p>\n";
                
        }

        echo "\t\t\t\t</div>\n";
        
    } // method Praxis::HTMLAsidePreviewLoca
    
    /**
     * method Locus::HTMLPreview
     * 
     * displays a preview of the place
     * 
     * parameters:
     *  $ordinalNr: page's ordinal number to be represented at the beginning
    */
    function HTMLPreview($ordinalNr) {
		
        echo "\t\t\t\t\t\t<div class=\"HTMLPreview\">\n";
	
        //////////////////////////////////////////////////////////////////////////////////
        // first line (headline): ordinal, designation with hyperlink and xperiences amount

        // 1. ordinal number
        echo "\t\t\t\t\t\t\t<p class=\"medium\">";
        if ($ordinalNr !== 0)
            echo $ordinalNr.". "; // ordinal number is 1-based

        if (DEBUG)
            echo " <span class=\"debug\">[locusID <b>".
                $this->getLocusID().
                "</b>]</span> ";
        
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
        echo $practicaAmount > 1 ? _("experiences") : _("experience");
        echo ")</p>\n";

        //////////////////////////////////////////////////////////////////////////
        // second line: description, address, www
        if ($this->getName() !== "" ||
            $this->getAddress() !== "" ||
            $this->getWeb() !== "") {
            echo "\t\t\t\t\t\t\t<p>";
            if ($this->getName() !== "")                
                echo $this->getName().".";
            if ($this->getAddress() !== "")                
                echo " ".$this->getAddress().". ";
            if ($this->getWeb() !== "")                
                echo " ".$this->getWeb().".";
            echo "</p>\n";
        }
		
        echo "</div>\n";		
		
    } // method Locus::HTMLPreview
		
} // class Locus

?>
