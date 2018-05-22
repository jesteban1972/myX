<?php
/**
 * script 'locus.inc'.
 * 
 * this script contains the implementation of class 'Locus',
 * the class which represents the abstraction of a place.
 * (c) Joaquin Javier ESTEBAN MARTINEZ
 * last update: 2018-05-22
*/

require_once 'DB.inc';

/**
 * class 'Locus'.
 * 
 * this class represents the abstraction of a place entity, i.e. the physical
 * location where one or more experiences happen(s).
 * a place is always linked to every experience.
 * among a place data, we can specify the country and the kind of place it is
 * (the database can be queried against these data).
 * in the DB every place is linked with the user propietary of the information.
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
     * method 'Locus::getCountryName'.
     * 
     * this method returns the name of the country associated with the place
     * from which the method is called.
    */
    public function getCountryName() {
        
        // get a DB handle to work with:
        $pdo = DB::getDBHandle();
        
        // the tables 'countries' and 'loca' are queried:
        $queryString = <<<QUERY
SELECT `countries`.`name`
FROM `myX`.`loca` INNER JOIN `myX`.`countries`
ON `myX`.`loca`.`country` = `myX`.`countries`.`countryID`                
WHERE `loca`.`locusID` = :locusID
QUERY;
        $statement = $pdo->prepare($queryString);
        $statement->bindParam(":locusID", $this->getLocusID(), PDO::PARAM_INT);
        $statement->execute();
        
        // the retrieved name is fetched and returned:
        return $statement->fetchColumn();
        
    } // method 'Locus::getCountryName'
		
    /**
     * method 'Locus::__constructor'.
     * 
     * this method is the constructor of the class. it initializes an instance
     * of the class, having its values taken from the DB.
     * @param int locusID the identifier of the place being constructed.
    */
    public function __construct($locusID) {
                
        // get a DB connection to work with:
        $pdo = DB::getDBHandle();
        
        // the table 'practica' is queried (only one row expected):
        $queryString = <<<QUERY
SELECT *
FROM `myX`.`loca`
WHERE `locusID` = :locusID
QUERY;
        $statement = $pdo->prepare($queryString);
        $statement->bindParam(":locusID", $locusID, PDO::PARAM_INT);
        $statement->execute();
        
        // the data are fetched:
        $row = $statement->fetch();
        
        // the propierties of the current object are taken from the query:
        $this->locusID = intval($locusID);
        $this->achtung = $row['achtung'];
        $this->name = $row['name'];
        $this->rating = intval($row['rating']);
        $this->address = $row['address'];
        $this->country = intval($row['country']);
        $this->kind = intval($row['kind']);
        $this->descr = $row['descr'];
        $this->coordExact = $row['coordExact'];
        $this->coordGeneric = $row['coordGeneric'];
        $this->web = $row['web'];

    } // method 'Locus::__construct'
    
    /**
     * method 'Locus::getAllLoca'.
     * 
     * this method returns an array with the identifiers of all places
     * of the current logged in user.
     */
    public function getAllLoca() {

        $loca = array(); // the array to be returned
        
        // get a DB handle to work with:
        $pdo = DB::getDBHandle();

        // the table 'loca' is queried:
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
        
        // the array is returned:
        return $amores;
        
    } // method 'Locus::getAllLoca'

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
    * method 'Locus::getMapCenter'.
    * 
    * this static method retrieves all the existing coordinates from the places
    * in the table 'loca', calculates with them the geographic center, and sets
    * the variable $_SESSION['DBStatus']['mapCenter']. this value will be read
    * from the script 'locaMapFetchXML.php' to display the map's center.
    */
    public static function getMapCenter() {
        
        $longs = array(); // array to store longitudes
        $lats = array(); // array to store latitudes
        
        // get a DB handle to work with:
        $pdo = DB::getDBHandle();
        
/*
 * we first verify that there are some places
 * '$_SESSION['DBStatus']['doPracticaExist']'.
 */
        
        $queryString = <<<QUERY
SELECT COUNT(*)
FROM `myX`.`loca`
WHERE `user` = :userID
QUERY;
        $statement = $pdo->prepare($queryString);
        $statement->bindParam(":userID", $_SESSION['userID'], PDO::PARAM_INT);
        if ($statement->fetchColumn() === 0)
            return;
        //else $_SESSION['DBStatus']['doPracticaExist'] = true;
        // flag '$_SESSION['DBStatus']['doPracticaExist']' already set
        // queriyng Praxis::doPracticaExist.

/*
 * all coordenates are retrieved and their values, whether exact of generic,
 * stored in both arrays '$longs' and '$lats'.
 */
        $queryString = <<<QUERY
SELECT `coordExact`, `coordGeneric`
FROM `myX`.`loca`
WHERE `user` = :userID
QUERY;

        $statement = $pdo->prepare($queryString);
        $statement->bindParam(":userID", $_SESSION['userID'], PDO::PARAM_INT);
        $statement->execute();
        
        foreach ($statement as $row) {
            
            // loop when there are not any coordinates in the current place:
            if ($row['coordExact'] === "" && $row['coordGeneric'] === "")
                break;
            
            // the coordinates -either exact or generic- are retrieved:
            $coordinates =
                ($row['coordExact'] !== "") ?
                $row['coordExact'] :
                $row['coordGeneric'];
            
//            $long = explode(", ", $coordinates)[0];
//            $lat = explode(", ", $coordinates)[1];
            
            // the numeric values are extracted and stored:
            $longs[] = explode(", ", $coordinates)[0]/*$long*/;
            $lats[] = explode(", ", $coordinates)[1]/*$lat*/;
             
        }
        
/*
 * jesteban1972:
 * N boundary: 55.957570, -3.192459 (Edinburgh/UK)
 * S boundary: 31.757469, 35.208082 (Jerusalem/Israel)
 * W boundary: 37.374629, -5.990226 (Seville/Spain)
 * E boundary: 31.952229, 35.939134 (Amman/Jordan)
 * 
 * maxLongDiff: 35.939134 - (-5.990226) = ...
 * maxLatDiff: 55.957570 - 31.757469 = ...
 */
        
/*
 * the coordinates of the geographic center are calculated using the maximal
 * and minimal values of longitude and latitude.
 * with the calculated values a string is composed and stored in
 * $_SESSION['DBStatus']['mapCenter'].
 */
        $maxLong = max($longs);
        $minLong = min($longs);
        $maxLat = max($lats);
        $minLat = min($lats);
        $centerLong = ($maxLong - abs($minLong)) / 2;
        $centerLat = ($maxLat - abs($minLat)) / 2;

//        $mapCenter = strval($centerLong).", ".strval($centerLat);
//                strval($minLong + (($maxLong - abs($minLong)) / 2)).
//                ", ".
//                strval($minLat + (($maxLat - abs($minLat)) / 2));
        
        $_SESSION['DBStatus']['mapCenter'] =
            strval($centerLong).", ".strval($centerLat);//$mapCenter;
        
        return;

    } // method Locus::getMapCenter
    
    /**
     * method 'Locus::getPractica'.
     * 
     * this public method queries the table 'practica' and returns an array
     * with the identifiers of all the experiences, ordered chronologically
     * and by ordinal.
     * this method is used by the Synchroton.
    */
    public function getPractica() {
        
        $practica = array(); // array to be returned
        
        // get a DB handle to work with:
        $pdo = DB::getDBHandle();
        
        // the table 'practica' is queried:
        $queryString = <<<QRY
SELECT `praxisID`
FROM `myX`.`practica`
WHERE `locus` = :locusID
ORDER BY `date`, `ordinal`
QRY;
        $statement = $pdo->prepare($queryString);
        $statement->bindParam(":locusID", $this->getLocusID(), PDO::PARAM_INT);
        $statement->execute();
        
        foreach ($statement as $row) {
            
            // add a new element in the array (intval needed):
            $practica[] = intval($row['praxisID']);
            
        }

        // the array is returned:
        return $practica;
	
    } // method Locus::getPractica

    /**
     * method 'Locus::getPracticaAmount'.
     * 
     * this method returns the amount of the experiences which happened in the
     * place from which the method is called.
    */
    public function getPracticaAmount() {
        
        // get a DB handle to work with:
        $pdo = DB::getDBHandle();
        
        // the table 'practica' is queried:
        $queryString = <<<QUERY
SELECT COUNT(*)
FROM `myX`.`practica`
WHERE `locus` = :locusID
QUERY;
        $statement = $pdo->prepare($queryString);
        $statement->bindParam(":locusID", $this->locusID, PDO::PARAM_INT);
        $statement->execute();
        
        // the data is fetched and returned (intval needed):
        return intval($statement->fetchColumn());
        
    } // method 'Locus::getPracticaAmount'

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
     * method 'Locus::HTMLPreview'.
     * 
     * this method builds and displays HTML code representing the preview of
     * the place from which the method is called.
     * the preview of a place is very simple and consist of two lines:
     * - the first line (headline) contains an ordinal number, the place name
     * (which is an hyperlink to the place detail page), and the amount of
     * experiences happened in the place.
     * - the second line contains, if any, the description of the place,
     * the address, and the URL.
     * 
     * param int $ordinalNr page's ordinal number, to be represented at the
     * beginning of the preview when presented in a list.
    */
    function HTMLPreview($ordinalNr) {
		
        echo "\t\t\t\t\t\t<div class=\"HTMLPreview\">\n";
	
        ////////////////////////////////////////////////////////////////////////
        // first line
        
        echo "\t\t\t\t\t\t\t<p class=\"medium\">";

        // ordinal number:
        if ($ordinalNr !== 0)
            echo $ordinalNr.". "; // ordinal number is 1-based

        if (DEBUG)
            echo " <span class=\"debug\">[locusID <b>".$this->getLocusID().
                "</b>]</span> ";
        
        // name with hyperlink:
        echo "<b><a href=\"locus.php?locusID=".$this->getLocusID()."\">".
            $this->getName()."</a></b>";

        // amount of experiences:
        $practicaAmount = $this->getPracticaAmount();
        echo " (";
        echo writtenNumber($practicaAmount, FEMENINE);
        echo " ";
        echo $practicaAmount > 1 ? _("experiences") : _("experience");
        echo ")";
        
        echo"</p>\n";

        ////////////////////////////////////////////////////////////////////////
        // second line
        if ($this->getName() !== "" || $this->getAddress() !== "" ||
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
		
    } // method 'Locus::HTMLPreview'
		
} // class 'Locus'

?>
