<?php
/**
 * script 'praxis.inc'.
 * 
 * this script contains the implementation of class 'Praxis',
 * the class which represents the abstraction of an experience.
 * (c) Joaquin Javier ESTEBAN MARTINEZ
 * last update: 2018-04-17
 */

require_once 'core.inc';
require_once 'DB.inc';
//require_once 'amor.inc';
require_once 'session.inc';
require_once 'locus.inc';

/**
 * class Praxis
 */
class Praxis {

    // I. properties
    protected $praxisID;    // praxis ID
    protected $achtung;     // achtung
    protected $name;        // name
    protected $rating;      // rating
    protected $favorite;    // favorite
    protected $locus;       // place
    protected $date;        // date
    protected $ordinal;     // ordinal
    protected $descr;       // description
    protected $tq;          // field 'tq'
    protected $tl;          // field 'tl'
    
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
    public function getPraxisID() {
        
        return (int)$this->praxisID;
        
    }

    public function getAchtung() {
        
        return $this->achtung;
        
    }
    
    public function getName() {
        
        return $this->name;
        
    }
    
    public function getLocus() {
        
        return (int)$this->locus;
        
    }

    public function getDate() {
        return $this->date;
    }

    public function getOrdinal() {
        return $this->ordinal;
    }

    

    public function getRating() {
        
        return (int)$this->rating;
        
    }

    /**
     * method getDescription.
     * returns the value of property 'descr' (getter method).
     * @return type
     */
    public function getDescr() {
        
        return $this->descr;
        
    }

    public function getTQ() {
        
        return (int)$this->tq;
        
    }

    public function getTL() {
        
        return (int)$this->tl;
        
    }

    public function isFavorite() {
	
        return (bool)$this->favorite;

    }

    /**
     * method Praxis::__constructor
     * class constructor: initiates an instance of the class,
     * and sets its member variables from the DB
     * @$praxisID
     */
    public function __construct($praxisID) {

        // get a DB connection to work with:
        $pdo = DB::getDBHandle();

        // 2. query the table 'practica'. only one row expected.

        $queryString = <<<QUERY
SELECT *
FROM `myX`.`practica`
WHERE praxisID = :praxisID
QUERY;
        $statement = $pdo->prepare($queryString);
        $statement->bindParam(":praxisID", $praxisID, PDO::PARAM_INT);
        $statement->execute();

        // 3. the data is fetched:
        $row = $statement->fetch();

        // the propierties of the current object are taken from the query:
        $this->praxisID = $praxisID;
        $this->achtung = $row['achtung'];
        $this->name = $row['name'];
        $this->rating = intval($row['rating']);
        $this->favorite = $row['favorite'];
        $this->locus = $row['locus'];
        $this->date = $row['date'];
        $this->ordinal = $row['ordinal'];
        $this->descr = $row['descr'];
        $this->tq = $row['tq'];
        $this->tl = $row['tl'];
        
    } // method Praxis::__construct
    
    /**
     * method Praxis::getAllPractica
     * returns an array of experiences ID's from all the practica.
     */

    public function getAllPractica() {

        /*
         * $practica is the array to be returned.
         * it will be filled up with the IDs of all the experiences.
         */

        $practica = array(); // the array to be returned. it will be filled
        // get a DB handle to work with:
        $pdo = DB::getDBHandle();

        // 2. query the table 'practica':
        $queryString = <<<QRY
SELECT `praxisID`
FROM `myX`.`practica`
WHERE `user` = :userID
ORDER BY `date`, `ordinal`
QRY;

        $statement = $pdo->prepare($queryString);
        $statement->bindParam(":userID", $_SESSION['userID'], PDO::PARAM_INT);
        $statement->execute();

        foreach ($statement as $row) {

            // add a new element in the array (intval needed):
            $practica[] = intval($row['praxisID']);
            
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
        // get a DB handle to work with:
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
    }

// method Praxis::getAmores

    /**
     * method Praxis::getAmoresAmount
     */
    public function getAmoresAmount() {

        // get a DB handle to work with:
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
     * method Praxis::getParticipantsString
     * 
     * TODO: test: p.221(?)
     */
    public function getParticipantsString() {
        
        $participantsString = "";
        
        // get a DB handle to work with:
        $pdo = DB::getDBHandle();
        
        $queryString = <<<QRY
SELECT `alias`
FROM `myX`.`amores`
INNER JOIN `myX`.`assignations`
ON `myX`.`amores`.`amorID` = `myX`.`assignations`.`amor`
WHERE `praxis` = :praxisID
ORDER BY `alias`
QRY;
        $statement = $pdo->prepare($queryString);
        $statement->
            bindParam(":praxisID", $this->getPraxisID(), PDO::PARAM_INT);
        $statement->execute();
        
        // participants amount:
        $participantsAmount = $statement->rowCount();
        
        if ($participantsAmount > 1)
            $currentParticipant = 1; // $currentParticipant is 1-based
        
        foreach ($statement as $row) {
            
            // if multiple participants an ordinal number is inserted:
            if ($participantsAmount > 1)
                $participantsString .= "<b>".strval($currentParticipant).
                    "/</b> ";
            
            $participantsString .= $row['alias'];
            
            // if multiple participants a comma is inserted
            // when the current participant is not the last one,
            // and $currentParticipant is increased by one:
            if ($participantsAmount > 1) {

                if ($currentParticipant < $participantsAmount)
                    $participantsString .= ", ";

                $currentParticipant++;
                
            }
            
        } 
        
        $participantsString .= ".";
            
        return $participantsString;
        
    }

    /**
     * method Praxis::getPracticaAmount
     * returns the amount of experiences. this is a static method
     */
    public static function getPracticaAmount() {

        // get a DB handle to work with:
        $pdo = DB::getDBHandle();

        // 2. query the table 'practica':

        $queryString = <<<QUERY
SELECT COUNT(*)
FROM `myX`.`practica`
WHERE user=:userID
QUERY;
        $statement = $pdo->prepare($queryString);
        $statement->bindParam(":userID", $_SESSION['userID'], PDO::PARAM_INT);
        $statement->execute();

        // 3. the number of rows is retrieved and returned (intval needed):      
        return intval($statement->fetchColumn());
        
    } // method Praxis::getPracticaAmount

    /**
     * method Praxis::HTMLAsidePreview
     * displays a sommary of the experience in the sidebar
     */
    public function HTMLAsidePreview() {
        
        echo "\t\t\t\t<div class=\"HTMLAsidePreview\">\n";
        echo "\t\t\t\t\t<img src=\"".getImage("praxis", "small")."\" alt=\"".
            _("(Image of a gold coin)").
            "\" />\n";
        
        // place:
        $locus = new Locus($this->getLocus());
        
        echo "\t\t\t\t\t<p><img src=\"".getImage("locus", "small")."\" alt=\"".
            _("(Image of a compass)").
            "\" /> ".
            $locus->getName().
            ".</p>\n";
        
        echo "\t\t\t\t\t<p>".
            $this->getDate();//$dateString;

        if ($this->getOrdinal() !== "")
            echo $this->getOrdinal();

        echo "</p>\n";

        echo "\t\t\t\t\t<p><b>".$this->getName()."</b></p>\n";
        echo "\t\t\t\t\t<p>".writtenRate($this->getRating(), false)."</p>\n";
        echo "\t\t\t\t\t<p><img src=\"".getImage("amor","small")."\" alt=\"".
            _("(Image of a cycladic idol)").
            "\" /> ".
            $this->getParticipantsString().
            "</p>\n";
        echo "\t\t\t\t</div>\n";
        
    } // method Praxis::HTMLAsidePreview
    
    /**
     * method 'Praxis::HTMLAsidePreviewPractica'.
     * 
     * displays a summary of the experiences in the sidebar
     */
    public function HTMLAsidePreviewPractica() {
        
        echo "\t\t\t\t<div class=\"HTMLAsidePreview\">\n";
        echo "\t\t\t\t\t<img src=\"".getImage("praxis", "medium")."\" alt=\"".
            _("(Image of a gold coin)").
            "\" />\n";
        
        $practicaAmount = Praxis::getPracticaAmount();
        
        switch ($practicaAmount) {
            
            case 0:
                
                echo "\t\t\t\t\t<p>"._("Not any experiences yet")."</p>\n";
                break;
            
            case 1:
                
                echo "\t\t\t\t\t<p>"._("Only one experience so far")."</p>\n";
                break;
            
            default:
                
                echo "\t\t\t\t\t<p>".
                    sprintf(_("%d experiences"), $practicaAmount).
                    "</p>\n";
                $limits = explode("..", $_SESSION['asideItem']);
                echo "\t\t\t\t\t<p>".
            sprintf(_("Displaying %d<br /><b>from</b> %s<br /><b>until</b> %s"),
                        $_SESSION['navOptions']['resultsPerPage'],
                        $limits[0], $limits[1])."</p>\n";
                
        }

        echo "\t\t\t\t</div>\n";
        
    } // method Praxis::HTMLAsidePreviewPractica
    
    /**
     * method Praxis::HTMLPreview
     * displays a preview of the experience
     * @param int ordinalNr: experience ordinal
     * @param int options: bitwise combination of options (v.gr. EXPERIENCE_RATE & EXPERIENCE_DATE & EXCEPTR_MED)
     */
    public function HTMLPreview($ordinalNr, $options = "") {

        // get a DB connection to work with:
        $pdo = DB::getDBHandle();
        
        echo "\t\t\t\t\t<div class=\"HTMLPreview\">\n";
        /*
         *  first line of the preview (headline):
         *  1/ ordinal
         *  2/ designation (with hyperlink)
         *  3/ evaluation
         */
        // 1. ordinal number:
        echo "\t\t\t\t\t\t<p class=\"medium\"> ";
        if ($ordinalNr !== 0)
            echo $ordinalNr.". "; // ordinal number is 1-based
        
        if (DEBUG)
            echo " <span class=\"debug\">[praxisID <b>".$this->getPraxisID().
                "</b>; ".
                "tq ".$this->getTQ()."; ".
                "tl ".$this->getTL().
                "]</span> ";
        
        // 2. name (with hyperlink):
        echo "<b><a href=\"praxis.php?praxisID=".$this->getPraxisID()."\">".
            $this->getName()."</a></b>";
        
        // 3. evaluation:
        if ($options != self::RATING) { // not shown if in $filter evaluation
            echo " - ";
            echo writtenRate($this->getRating());
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
        
        // 2. place:
        if ($options != self::LOCUS) { // not shown if in locus.php
            
            echo "<b>" . _("VBI") . "</b> ";

            // the place name is queried from the table 'places':
            $queryString = <<<QRY
SELECT `name`
FROM `myX`.`loca`
WHERE `locusID` = :locusID
QRY;
            $statement = $pdo->prepare($queryString);
            $statement->
                bindParam(":locusID", $this->getLocus(), PDO::PARAM_INT);
            $statement->execute();
            
            // 3. the data is fetched:
            $name = $statement->fetchColumn();
            echo $name;
            echo ". ";
            
        }

        // 3. participants:
        if ($options != self::PARTICIPANTS) // not shown if in amor.php
            echo "<b>"._("CVM QVIBVS")."</b> ".$this->getParticipantsString();
        
        // 4. description (or excerpt):
        
        echo " <b>" . _("QVOD") . "</b> ";
        echo languageFlag($this->getTL(), 15);
        echo ' ';

        if (strlen($this->getDescr()) > 510) { // long description
        // 
            // long narration: only a excerpt will be presented
            // a 510 char long string are treamed at it last whitespace
            // TODO: excerpt's length configurable with a parametrer (ex. EXCEPTR_MED)
            $excerpt = substr($this->getDescr(), 0, 510); // retrievess only the firs chars
            $excerpt = substr($excerpt, 0, strrpos($excerpt, " ")); // trims the excerpt in an space
            
            // some substitutions are made:
            // <br /> tags by whitespaces:
             // TODO: check if it works ALWAYS
            $excerpt = str_replace("<br />", " ", $excerpt);
            // <b>, </b>, <i>, </i> tags supressed
            $excerpt = str_replace("<b>", "", $excerpt);
            $excerpt = str_replace("</b>", "", $excerpt);
            $excerpt = str_replace("<i>", "", $excerpt);
            $excerpt = str_replace("</i>", "", $excerpt);
            echo $excerpt;
            echo " [...] <input type=\"button\" value=\"> " .
            _("See more...") .
            "\" onclick=\"window.location.href='praxis.php?praxisID=";
            echo $this->getPraxisID();
            echo "#description'\" />";
            
        } else { // short description (less than 510 characters)
            
            echo $this->getDescr();
            
        }
        
        echo "</p>\n";
        
        // favorite icon:
        if ($this->isFavorite())            
            echo "<div class=\"favorite\"></div>\n";
        
        // ampelmaenchen icon:
        if ($this->getTQ() > 3)            
            echo "<div class=\"ampelmaenchenGruen\"></div>\n";
        else
            echo "<div class=\"ampelmaenchenRot\"></div>\n";
        
        echo "\t\t\t\t\t</div>\n";

    } // method Praxis::HTMLPreview

    /**
     * method 'Praxis::HTMLSynchroton'.
     * 
     * displays the Synchroton, a tool to navigate through the experiences
     * forwards or backwards in time, according to different criteria:
     * i) with the same lover
     * ii) chronologically, or
     * iii) locally
     * @param int praxisID the identifier of the current experience
     * @param int loverID the identifier of the only participant in the current experience
     * @param int placeID the identifier of the place where the current experience happened
     */
    public function HTMLSynchroton($praxisID, $amorID, $locusID) {
        // TODO: rewrite without passed parameters: $praxis->HTMLSynchoton()
        
        /*
         * row 1: previous and next experiences with this lover
         * this option is only available when only one lover participates
         * in the experience. otherwise the received parameter $amorID is null
         */
        if (isset($amorID)) {
            
            $amor = new Amor($amorID);
            
            $practicaAmor = $amor->getPractica(true);
            $practicaAmorIndex = array_search($praxisID, $practicaAmor);
            
            // determines previous and next xperience with this lover
            $prevPraxisAmor = $practicaAmor[$practicaAmorIndex - 1]; // NULL when first xperience with this lover
            $nextPraxisAmor = $practicaAmor[$practicaAmorIndex + 1]; // NULL when last xperience with this lover

        }
        
        /*
         * row 2. experiences chronologically
         * this option is always available when the current experience
         * is neither the first one, nor the last one.
         */
        
        $allPractica = Praxis::getAllPractica();
     
        // experience index within the amount of experiences:
        $praxisIndex = array_search($praxisID, $allPractica);
        
        // previous and next experience chronollogically:
        $prevPraxis = $allPractica[$praxisIndex - 1]; // NULL when first xperience
        $nextPraxis = $allPractica[$praxisIndex + 1]; // NULL when last xperience
        
        /*
         * row 3: experiences locally
         * (previous and next experiences in this place).
         * this option is only available when the amount of experiences
         * performed in this place is more than one.
         * otherwise the received parameter $locusID is null
         */
        $locus = new Locus($locusID);
        $practicaLocus = $locus->getPractica();
        $practicaLocusIndex = array_search($praxisID, $practicaLocus);

        // previous and next experience at this place:
        $prevPraxisLocus = $practicaLocus[$practicaLocusIndex - 1]; // NULL when first xperience at this place
        $nextPraxisLocus = $practicaLocus[$practicaLocusIndex + 1]; // NULL when last xperience at this place
        
        
        echo "\t\t\t\t\t<div id=\"synchroton\"><!-- Synchroton {{ -->\n";
        
        // buttons are displayed (all hidden by default):
        echo <<<HTML
                        <button id="prevAmor" class="customButton">&lt; lover</button>
                        <button id="prevTempus" class="customButton">&lt; time</button>
                        <button id="prevLocus" class="customButton">&lt; place</button>
                        <button id="prevAmorTempus" class="customButton">&lt; lover & time</button>
                        <button id="prevTempusLocus" class="customButton">&lt; time & place</button>
                        <button id="prevAll" class="customButton">&lt;</button>
                        <button id="nextAmor" class="customButton">lover &gt;</button>
                        <button id="nextTempus" class="customButton">time &gt;</button>
                        <button id="nextLocus" class="customButton">place &gt;</button>
                        <button id="nextAmorTempus" class="customButton">lover & time &gt;</button>
                        <button id="nextTempusLocus" class="customButton">time & place &gt;</button>
                        <button id="nextAll" class="customButton">&gt;</button>
                        <!-- <button id="nextLocus" class="customButtonDisabled">locally &gt;</button> -->

HTML;
        
        echo <<<HTML
                        <script type="text/javascript">
                            <!--//--><![CDATA[//><!--

HTML;
                            
        // possible Synchroton scenaria:
        
        // prev experiences:
        echo "\n\t\t\t\t\t\t\t// prev experiences:\n";
        
        // layoutPrevEmpty:
        if (!$prevPraxisAmor && !$prevPraxis && !$prevPraxisLocus) { 
            // first experience: layoutPrevEmpty (no buttons shown)
            echo "\t\t\t\t\t\t\t// (no buttons shown)\n";

            
        } elseif (($prevPraxis === $prevPraxisAmor) &&
            ($prevPraxis === $prevPraxisLocus)) {
            // layoutPrevAll
            
            echo "\t\t\t\t\t\t\t".
                "document.getElementById(\"prevAll\").style.visibility = \"visible\";\n";
            echo "\t\t\t\t\t\t\t".
                "document.getElementById(\"prevAll\").".
                "addEventListener(\"click\", function() {".
                "window.location.href = 'praxis.php?praxisID=".
                strval($prevPraxis)."#description';".
                "}, false);\n";
            
        } elseif (($prevPraxis === $prevPraxisAmor) &&
            ($prevPraxis !== $prevPraxisLocus)) {
            // layoutPrevAliaLocus
            
            echo "\t\t\t\t\t\t\t".
                "document.getElementById(\"prevAmorTempus\").style.visibility = \"visible\";\n";
            echo "\t\t\t\t\t\t\t".
                "document.getElementById(\"prevAmorTempus\").".
                "addEventListener(\"click\", function() {".
                "window.location.href = 'praxis.php?praxisID=".
                strval($prevPraxis)."#description';".
                "}, false);\n";
            
            // button prevLocus not always shown:
            if ($prevPraxisLocus) {
                
                echo "\t\t\t\t\t\t\t".
                    "document.getElementById(\"prevLocus\").style.visibility = \"visible\";\n";
                echo "\t\t\t\t\t\t\t".
                    "document.getElementById(\"prevLocus\").".
                    "addEventListener(\"click\", function() {".
                    "window.location.href = 'praxis.php?praxisID=".
                    strval($prevPraxisLocus)."#description';".
                    "}, false);\n";
            
            }
            
        } elseif (($prevPraxis !== $prevPraxisAmor) &&
            ($prevPraxis === $prevPraxisLocus)) {
            // layoutPrevAmorAlia
            
            // button prevAmor not always shown:
            if ($prevPraxisAmor) {
                
                echo "\t\t\t\t\t\t\t".
                    "document.getElementById(\"prevAmor\").style.visibility = \"visible\";\n";
                echo "\t\t\t\t\t\t\t".
                    "document.getElementById(\"prevAmor\").".
                    "addEventListener(\"click\", function() {".
                    "window.location.href = 'praxis.php?praxisID=".
                    strval($prevPraxisAmor)."#description';".
                    "}, false);\n";
                
            }
            
            echo "\t\t\t\t\t\t\t".
                "document.getElementById(\"prevTempusLocus\").style.visibility = \"visible\";\n";
            echo "\t\t\t\t\t\t\t".
                "document.getElementById(\"prevTempusLocus\").".
                "addEventListener(\"click\", function() {".
                "window.location.href = 'praxis.php?praxisID=".
                strval($prevPraxis)."#description';".
                "}, false);\n";
            
        } elseif (($prevPraxis !== $prevPraxisAmor) &&
            ($prevPraxis !== $prevPraxisLocus)) {
            // layoutNextAmorTempusLocus
            
            // button prevAmor not always shown:
            if ($prevPraxisAmor) {
                
                echo "\t\t\t\t\t\t\t".
                    "document.getElementById(\"prevAmor\").style.visibility = \"visible\";\n";
                echo "\t\t\t\t\t\t\t".
                    "document.getElementById(\"prevAmor\").".
                    "addEventListener(\"click\", function() {".
                    "window.location.href = 'praxis.php?praxisID=".
                    strval($prevPraxisAmor)."#description';".
                    "}, false);\n";
                
            }
            
            echo "\t\t\t\t\t\t\t".
                "document.getElementById(\"prevTempus\").style.visibility = \"visible\";\n";
            echo "\t\t\t\t\t\t\t".
                "document.getElementById(\"prevTempus\").".
                "addEventListener(\"click\", function() {".
                "window.location.href = 'praxis.php?praxisID=".
                strval($prevPraxis)."#description';".
                "}, false);\n";
            
            // button prevLocus not always shown:
            if ($prevPraxisLocus) {
                
                echo "\t\t\t\t\t\t\t".
                    "document.getElementById(\"prevLocus\").style.visibility = \"visible\";\n";
                echo "\t\t\t\t\t\t\t".
                    "document.getElementById(\"prevLocus\").".
                    "addEventListener(\"click\", function() {".
                    "window.location.href = 'praxis.php?praxisID=".
                    strval($prevPraxisLocus)."#description';".
                    "}, false);\n";
            
            }
            
        }
        
        // next experiences:
        echo "\n\t\t\t\t\t\t\t// next experiences:\n";
        
        // layoutNextEmpty:
        if (!$nextPraxisAmor && !$nextPraxis && !$nextPraxisLocus) { 
            // last experience: layoutNextEmpty (no buttons shown)
            echo "\t\t\t\t\t\t\t// (no buttons shown)\n";
                        
        } elseif (($nextPraxis === $nextPraxisAmor) &&
            ($nextPraxis === $nextPraxisLocus)) {
            // layoutNextAll
            
            echo "\t\t\t\t\t\t\t".
                "document.getElementById(\"nextAll\").style.visibility = \"visible\";\n";
            echo "\t\t\t\t\t\t\t".
                "document.getElementById(\"nextAll\").".
                "addEventListener(\"click\", function() {".
                "window.location.href = 'praxis.php?praxisID=".
                strval($nextPraxis)."#description';".
                "}, false);\n";
            
        } elseif (($nextPraxis === $nextPraxisAmor) &&
            ($nextPraxis !== $nextPraxisLocus)) {
            // layoutNexAliaLocus
            
            echo "\t\t\t\t\t\t\t".
                "document.getElementById(\"nextAmorTempus\").style.visibility = \"visible\";\n";
            echo "\t\t\t\t\t\t\t".
                "document.getElementById(\"nextAmorTempus\").".
                "addEventListener(\"click\", function() {".
                "window.location.href = 'praxis.php?praxisID=".
                strval($nextPraxis)."#description';".
                "}, false);\n";
            
            // button nextLocus not always shown:
            if ($nextPraxisLocus) {
                
                echo "\t\t\t\t\t\t\t".
                    "document.getElementById(\"nextLocus\").style.visibility = \"visible\";\n";
                echo "\t\t\t\t\t\t\t".
                    "document.getElementById(\"nextLocus\").".
                    "addEventListener(\"click\", function() {".
                    "window.location.href = 'praxis.php?praxisID=".
                    strval($nextPraxisLocus)."#description';".
                    "}, false);\n";
            
            }
            
        } elseif (($nextPraxis !== $nextPraxisAmor) &&
            ($nextPraxis === $nextPraxisLocus)) {
            // layoutNextAmorAlia
            
            // button nextAmor not always shown:
            if ($nextPraxisAmor) {
                
                echo "\t\t\t\t\t\t\t".
                    "document.getElementById(\"nextAmor\").style.visibility = \"visible\";\n";
                echo "\t\t\t\t\t\t\t".
                    "document.getElementById(\"nextAmor\").".
                    "addEventListener(\"click\", function() {".
                    "window.location.href = 'praxis.php?praxisID=".
                    strval($nextPraxisAmor)."#description';".
                    "}, false);\n";
                
            }
            
            echo "\t\t\t\t\t\t\t".
                "document.getElementById(\"nextTempusLocus\").style.visibility = \"visible\";\n";
            echo "\t\t\t\t\t\t\t".
                "document.getElementById(\"nextTempusLocus\").".
                "addEventListener(\"click\", function() {".
                "window.location.href = 'praxis.php?praxisID=".
                strval($nextPraxis)."#description';".
                "}, false);\n";
            
        } elseif (($nextPraxis !== $nextPraxisAmor) &&
            ($nextPraxis !== $nextPraxisLocus)) {
            // layoutNextAmorTempusLocus
            
            // button nextAmor not always shown:
            if ($nextPraxisAmor) {
                
                echo "\t\t\t\t\t\t\t".
                    "document.getElementById(\"nextAmor\").style.visibility = \"visible\";\n";
                echo "\t\t\t\t\t\t\t".
                    "document.getElementById(\"nextAmor\").".
                    "addEventListener(\"click\", function() {".
                    "window.location.href = 'praxis.php?praxisID=".
                    strval($nextPraxisAmor)."#description';".
                    "}, false);\n";
                
            }
            
            echo "\t\t\t\t\t\t\t".
                "document.getElementById(\"nextTempus\").style.visibility = \"visible\";\n";
            echo "\t\t\t\t\t\t\t".
                "document.getElementById(\"nextTempus\").".
                "addEventListener(\"click\", function() {".
                "window.location.href = 'praxis.php?praxisID=".
                strval($nextPraxis)."#description';".
                "}, false);\n";
            
            // button nextLocus not always shown:
            if ($nextPraxisLocus) {
                
                echo "\t\t\t\t\t\t\t".
                    "document.getElementById(\"nextLocus\").style.visibility = \"visible\";\n";
                echo "\t\t\t\t\t\t\t".
                    "document.getElementById(\"nextLocus\").".
                    "addEventListener(\"click\", function() {".
                    "window.location.href = 'praxis.php?praxisID=".
                    strval($nextPraxisLocus)."#description';".
                    "}, false);\n";
            
            }
            
        }
        
        echo <<<HTML
        
                            //--><!]]>
                        </script>

HTML;
            
        echo "\t\t\t\t\t</div><!-- }} Synchroton -->\n";
        
        // }} rewritten Synchoton
        
    } // method Praxis::HTMLSynchroton

    
} // class Praxis