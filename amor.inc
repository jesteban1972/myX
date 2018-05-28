<?php
/**
 * script 'amor.inc'.
 * 
 * this script contains the implementation of class 'Amor',
 * the class which represents the abstraction of a lover.
 * @author Joaquin Javier ESTEBAN MARTINEZ <jesteban1972@me.com>
 * last update: 2018-05-10.
*/

require_once 'core.inc';
require_once 'DB.inc';

//session_start();

/**
 * class Amor
*/
class Amor {

    // I. properties
    protected $amorID;  // amor ID
    protected $achtung; // achtung
    protected $alias;   // alias
    protected $genre;   // genre
    protected $descr1;  // description 1
    protected $descr2;  // description 2
    protected $descr3;  // description 3
    protected $descr4;  // description 4
    protected $rating;  // rating
    protected $web;     // web
    protected $name;    // name
    protected $photo;   // photo
    protected $phone;   // telephone
    protected $email;   // email
    protected $other;   // other

    // II. member constants
    const RATING = 1;
    //const PLACE = 2;
    //const PARTICIPANTS = 3;
    
    const GENRE_MASCULINE = 1;
    const GENRE_FEMININE = 2;
    // ...
    //const GENRES = Array("dummy", _("man"), _("woman"));

    // III. methods
	
    // getters:
    public function getAmorID() {return $this->amorID;}
    public function getAchtung() {return $this->achtung;}
    public function getAlias() {return $this->alias;}
    public function getRating() {return $this->rating;}
    public function getGenre() {return $this->genre;}
    public function getDescr1() {return $this->descr1;}
    public function getDescr2() {return $this->descr2;}
    public function getDescr3() {return $this->descr3;}
    public function getDescr4() {return $this->descr4;}
    public function getWeb() {return $this->web;}
    public function getName() {return $this->name;}
    public function getPhoto() {return $this->photo;}
    public function getPhone() {return $this->phone;}
    public function getEmail() {return $this->email;}
    public function getOther() {return $this->other;}
	
    // other methods:
    
    /**
     * Amor::__construct
     * class constructor: initiates an instance of the class,
     * and sets its properties from the DB.
     * 
     * @param int $amorID the identifier of the lover being constructed.
    */
    public function __construct($amorID) {
        
        // get a DB connection to work with:
        $pdo = DB::getDBHandle();
        
        // query the table 'amores'. only one row expected.
        
        $queryString = <<<QUERY
SELECT *
FROM `myX`.`amores`
WHERE `amorID` = :amorID
QUERY;

        $statement = $pdo->prepare($queryString);
        $statement->bindParam(":amorID", $amorID, PDO::PARAM_INT);
        $statement->execute();
        
        // the data is fetched:
        $row = $statement->fetch();
        
        // the propierties of the current object are taken from the query:
        $this->amorID = $amorID;
        $this->achtung = $row['achtung'];
        $this->alias = $row['alias'];
        $this->rating = intval($row['rating']); // TODO: intval needed?
        $this->genre = intval($row['genre']); // TODO: intval needed?
        $this->descr1 = $row['descr1'];
        $this->descr2 = $row['descr2'];
        $this->descr3 = $row['descr3'];
        $this->descr4 = $row['descr4'];
        $this->web = $row['web'];
        $this->name = $row['name'];
        $this->photo = $row['photo'];
        $this->phone = $row['phone'];
        $this->email = $row['email'];
        $this->other = $row['other'];

    } // method Amor::__construct
    
    /**
     * method Amor::getAllAmores
     * returns an array of lover ID's from all lovers.
     */

    public function getAllAmores() {

        /*
         * $practica is the array to be returned.
         * it will be filled up with the IDs of all lovers.
         */

        $amores = array(); // the array to be returned. it will be filled
        // get a DB handle to work with:
        $pdo = DB::getDBHandle();

        // 2. query the table 'amores':
        $queryString = <<<QRY
SELECT `amorID`
FROM `myX`.`amores`
WHERE `user` = :userID
QRY;

        $statement = $pdo->prepare($queryString);
        $statement->bindParam(":userID", $_SESSION['userID'], PDO::PARAM_INT);
        $statement->execute();

        foreach ($statement as $row) {

            // add a new element in the array (intval needed):
            $amores[] = intval($row['amorID']);
            
        }
        
        return $amores;
        
    } // method Amor::getAllAmores
	
    /**
     * method Amor::getAmoresAmount
     * retrieves from the DB the total amount of lovers. this function is a class method, no instance needed
    */
    public static function getAmoresAmount() {
        
        // get a DB handle to work with:
        $pdo = DB::getDBHandle();
        
        // query the table 'amores':
        
        $queryString = <<<QUERY
SELECT COUNT(*)
FROM `myX`.`amores`
WHERE `user` = :userID
QUERY;

        $statement = $pdo->prepare($queryString);
        $statement->bindParam(":userID", $_SESSION['userID'], PDO::PARAM_INT);
        $statement->execute();
        
        // 3. the number of rows is retrieved (intval needed) and returned :
        return intval($statement->fetchColumn());
        
    } // method Amor::getAmoresAmount
    
    /**
     * method 'Amor::getAverageRating'.
     * 
     * this private method retrieves from the DB the average rating
     * of the experiences lived with the lover ...
     * note that only experiences having an effective ratting (i.e. > 0)
     * are taken into account.
    */
    private function getAverageRating() {
        
        // initialize values:
        $cumulate = 0;
        $average = 0;
        
        // get a DB handle to work with:
        $pdo = DB::getDBHandle();
        
        // query the tables 'practica' and 'assignations':

        $queryString = <<<QRY
SELECT `rating`
FROM `myX`.`practica`
INNER JOIN `myX`.`assignations`
ON `myX`.`practica`.`praxisID`=`myX`.`assignations`.`praxis`
WHERE `amor` = :amorID
QRY;
        
        $statement = $pdo->prepare($queryString);
        $statement->bindparam(":amorID", $this->getAmorID());
        $statement->execute();
        
        // only experiences with rating other than 0 (undefined)
        // are to be taken into account:
        $countableRating = 0;
        
        foreach ($statement as $row) {
            
            if (intval($row['rating']) !== 0) {
                
                $cumulate += intval($row['rating']);
                $countableRating++;
                
            }
            
        }
        
        if ($countableRating === 0)
            $countableRating = 1; // prevents division by 0
        
        $average = intval(round($cumulate / $countableRating));
        
        // the average rating is returned:
        return $average;
        
    } // method Amor::getAverageRating
    
    /**
     * method Amor::HTMLAsidePreview
    */
    function HTMLAsidePreview() {

        echo "\t\t\t\t<div class=\"HTMLAsidePreview\">\n";
        
        echo "\t\t\t\t\t<img src=\"".getImage("amor","small")."\" alt=\"".
    _("(Image of a cycladic idol)").
    "\" />\n";
        echo "\t\t\t\t\t<p><b>".$this->getAlias()."</b></p>\n";
        echo "\t\t\t\t\t<p>".$this->getCombinedDescription()."</p>\n";
        echo "\t\t\t\t\t".writtenRate($this->getRating(), false)."\n";
        
        // experiences amount:
        echo "\t\t\t\t\t<p>".$this->getPracticaAmount()." ";
        echo ($this->getPracticaAmount() > 1) ?
            _("experiences") : _("experience");
        echo "</p>\n";
        
        echo "\t\t\t\t</div>\n";

    } // method Amor::HTMLAsidePreview
    
    /**
     * method Praxis::HTMLAsidePreviewAmores
     * displays a sommary of the experiences in the sidebar
     */
    public function HTMLAsidePreviewAmores() {
        
        echo "\t\t\t\t<div class=\"HTMLAsidePreview\">\n";
        echo "\t\t\t\t\t<img src=\"".getImage("amor", "medium")."\" alt=\"".
            _("(Image of a cycladic idol)").
            "\" />\n";
        
        $amoresAmount = Amor::getAmoresAmount();
        
        switch ($amoresAmount) {
            
            case 0:
                echo "\t\t\t\t\t<p>"._("Not any lovers yet")."</p>\n";
                break;
            case 1:
                echo "\t\t\t\t\t<p>"._("Only one lover so far")."</p>\n";
                break;
            default:
                echo "\t\t\t\t\t<p>".
                    sprintf(_("%d lovers"), $amoresAmount).
                    "</p>\n";
                $limits = explode("..", $_SESSION['asideItem']);
                echo "\t\t\t\t\t<p>".
            sprintf(_("Displaying %d<br /><b>from</b> %s<br /><b>until</b> %s"),
    $_SESSION['navOptions']['resultsPerPage'], $limits[0], $limits[1]).
                    "</p>\n";
        }

        echo "\t\t\t\t</div>\n";
        
    } // method Praxis::HTMLAsidePreviewAmores
    
    /**
     * method Amor::HTMLPreview
     * displays an HTML preview of the lover
     * @ordinalNr: page's ordinal to be represented at the beginning
     * @options: bitwise combination of options
    */
    function HTMLPreview($ordinalNr, $options = "", $script = "amores.php") {
	
        // get a DB connection to work with:
        $pdo = DB::getDBHandle();

        echo "\t\t\t\t\t\t<div class=\"HTMLPreview\">\n";

        /*
         * first line (headline):
         * 1/ ordinal number
         * 2/ alias (with hyperlink)
         * 3/ evaluation
         * 4/ experiences amount
         */

        // 1. ordinal number:
        echo "\t\t\t\t\t\t\t<p class=\"medium\"> ";
        if ($ordinalNr !== 0)
            echo $ordinalNr.". "; // ordinal number is 1-based

        if (DEBUG)
            echo " <span class=\"debug\">[amorID <b>".
                $this->getAmorID().
                "</b>]</span> ";

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
        // third line: experiences amount
        // 1. experiences amount (when > 1)
        // 2. evaluation (absolut or average)
        
        if ($this->getPracticaAmount() > 1) {
            
            $praxisID = substr($script, 20);
            // only praxisID (and not 'praxis.php?praxisID=') considered.
            
            $practica = $this->getPractica(true);
            // flag 'true' needed for chronologically order.
            
            $currentPraxis = array_search($praxisID, $practica) + 1;
            // currentPraxis is 1-based.
            
//            echo "<p>".writtenNumber($this->getPracticaAmount(), FEMENINE)." ".
//                _("experiences").", this is the ".$currentPraxis.
//                " - ".writtenRate($this->getAverageRating()).
//                " ("._("as average").") -</p>\n";
            
            echo sprintf(_("<b>%s</b> experiences"),
                writtenNumber($this->getPracticaAmount()));
            if ($script !== "amores.php")
                echo sprintf(_(", this one #%s"),
                    $currentPraxis);
            echo " - ".writtenRate($this->getAverageRating())." (".
                _("as average").") -</p>\n";
            
        }
        
        echo "</div>\n";

    } // method Amor::HTMLPreview

    /**
     * method Amor::getCombinedDescription
     * join all four partial descriptions in one string
    */
    public function getCombinedDescription() {

        $combinedDescription = $this->getDescr1();

        if ($this->getDescr2() !== "")
            $combinedDescription .= ". ".$this->getDescr2();

        if ($this->getDescr3() !== "")
            $combinedDescription .= ". ".$this->getDescr3();

        if ($this->getDescr4() !== "")
            $combinedDescription .= ". ".$this->getDescr4();
        
        $combinedDescription .= ".";

        return $combinedDescription;

    } // method Amor::getCombinedDescription
    
        /**
     * method Amor::getDifferentDatesAmount
     * returns the number of different dates where experiences are documented with this lover
    */
    public function getDifferentDatesAmount() {
        
        // get a DB handle to work with:
        $pdo = DB::getDBHandle();
        
        // 2. query the table 'practica':

        $queryString = <<<QUERY
SELECT COUNT(DISTINCT date)
FROM `myX`.`practica`
INNER JOIN `myX`.`assignations`
ON `assignations`.`praxis` = `practica`.`praxisID`
WHERE `amor`=:amorID
QUERY;
        
        $statement = $pdo->prepare($queryString);
        $statement->bindParam(":amorID", $this->amorID, PDO::PARAM_INT);
        $statement->execute();
        
        // 3. the number of rows is retrieved and returned (intval needed):      
        return intval($statement->fetchColumn());

    } // method Amor::getDifferentDatesAmount
	
    /**
     * method Amor::getPractica
     * 
     * this method returns an array with the IDs of the experiences
     * lived with this lover.
     * the parameter $synchoton is used by the Synchroton and Amor::HTMLPreview
     * to order the results alphabetically independently of listsOrders.
    */
    public function getPractica($synchroton = false) {
        
        $practica = array(); // the array to be returned
        
        // get a DB handle to work with:
        $pdo = DB::getDBHandle();
        
        // query the table 'assignations':

        $queryString = <<<QRY
SELECT `praxisID`
FROM `myX`.`practica`
INNER JOIN `myX`.`assignations`
ON `myX`.`practica`.`praxisID` = `myX`.`assignations`.`praxis`
WHERE `myX`.`assignations`.`amor` = :amorID

QRY;
// ORDER BY `date`, `ordinal`
// ORDER BY `myX`.`practica`.`date`, `myX`.`practica`.`ordinal`
// posible hacerlo simplemente en assignations?
        
        if ($synchroton) {
            
            $queryString .= " ORDER BY `myX`.`practica`.`date`, `myX`.`practica`.`ordinal`";
            
        } else {        
        
            switch ($_SESSION['options']['listsOrder']) {

                case OLDEST_TO_NEWEST:

                    $queryString .= " ORDER BY `myX`.`practica`.`date`, `myX`.`practica`.`ordinal`";
                    break;

                case NEWEST_TO_OLDEST:

                    $queryString .= " ORDER BY `myX`.`practica`.`date` DESC, `myX`.`practica`.`ordinal` DESC";
                    break;

            }
            
        }

        $statement = $pdo->prepare($queryString);
        $statement->bindParam(":amorID", $this->getAmorID(), PDO::PARAM_INT);
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
       
        // get a DB handle to work with:
        $pdo = DB::getDBHandle();
        
        // query the table 'assignations':

        $queryString = <<<QRY
SELECT COUNT(*)
FROM `myX`.`assignations`
WHERE amor = :amorID
QRY;
// old query:
//SELECT COUNT(*)
//FROM `myX`.`practica`
//INNER JOIN `myX`.`assignations`
//ON `myX`.`practica`.`praxisID` = `myX`.`assignations`.`praxis`
//WHERE amor=:amorID

        $statement = $pdo->prepare($queryString);
        $statement->bindParam(":amorID", $this->getAmorID());
        $statement->execute();
        
        // fetch and return the result (intval needed):
        return intval($statement->fetchColumn());

    } // method Amor::getPracticaAmount
				
} // class Amor
