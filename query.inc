<?php
/*
 * script 'query.inc'.
 * 
 * this script contains the implementation of class 'Query',
 * the class which represents the abstraction of a query, as well as its 
 * derivate classes 'PracticaQuery', 'AmoresQuery' and 'LocaQuery'.
 * @author Joaquin Javier ESTEBAN MARTINEZ <jesteban1972@me.com>
 * last update: 2018-05-27
 */

/**
 * class 'Query'.
 *
 * this class represents the abstraction of a query entity, i.e. a logical
 * query to the DB after experiences, lovers and/or places.
 * 
 * in the DB every query is linked with the user proprietary of the information.
 *  
 * 'Query' is the base class of classes 'PracticaQuery', 'AmoresQuery' and
 * 'LocaQuery' used to store a list of experiences, lovers or places
 * respectively.
 * 
 * every query entity contains:
 * a) a designation/title,
 * b) a description of it, and
 * c) the SQL query used to retrieve the list
 */
class Query {

    // I. properties
    
    protected $queryID; // identifier of the query
    protected $name; // list designation or title
    protected $descr; // list description in a somehow extended way
    protected $queryString; // SQL query used to retrieve the list
    
    // II. class constants
    
    const RULES_BINDING_ALL = 0;
    const RULES_BINDING_ANY = 1;

    // III. implementation methods

    // getters:
    
    /**
     * method 'Query::getName'.
     * 
     * returns the value of property 'name' (getter method).
     * 
     * @return string returns the query name attribute.
     */
    public function getName() {
        
        return $this->name;
        
    }
    
    /**
     * method 'Query::getDescr'.
     * 
     * returns the value of property 'descr' (getter method).
     * 
     * @return string returns the query description attribute.
     */
    public function getDescr() {
        
        return $this->descr;
        
    }
    
    /**
     * method 'Query::getQueryString'.
     * 
     * returns the value of property 'queryString' (getter method).
     * 
     * @return string returns the query SQL string attribute.
     */
    public function getQueryString() {
        
        return $this->queryString;
        
    }
    
    // constructors:

    /**
     * method 'Query::__construct'
     * 
     * class constructor: initiates an instance of the class.
     * 
     * the instance can be initialized in two different ways:
     * i) with a single parameter (queryID)
     * ii) with three parameters (name, description and queryString)
     * 
     * as the method '__construct' can not be overridden, the arguments passed
     * to the method are checked to determine which method is being used.
     * 
     * @param int $queryID the identifier of the query being constructed.
     * @param string $name the name given to the query.
     * @param string $descr the description given to the query.
     * @param string $queryString SQL sentence which defines the query.
     */
    public function __construct(/*$name = "",
            $descr = "",
            $queryString = ""*/) {
        
        $args = func_get_args(); 

        switch(sizeof(func_get_args())) {

            case 1: // one argument, queryID

                $queryID = $args[0];

                // get a DB connection to work with:
                $pdo = DB::getDBHandle();

                // the table 'queries' is queried. only one row expected.
                $queryString = <<<QUERY
SELECT *
FROM `myX`.`queries`
WHERE queryID = :queryID
QUERY;
                $statement = $pdo->prepare($queryString);
                $statement->bindParam(":queryID", $queryID, PDO::PARAM_INT);
                $statement->execute();

                // the data are fetched:
                $row = $statement->fetch();

                // the propierties of the current object are taken from the query:
                $this->queryID = $queryID;
                $this->name = $row['name'];
                $this->descr = $row['descr'];
                $this->queryString = $row['queryString'];

                break;              

            case 3:  // three arguments, name, descr and queryString

                $name = $args[0];
                $descr = $args[1];
                $queryString = $args[2];

                if ($name === "" && $descr === "" && $queryString === "") {
                // empty args, full list

                    $this->name = "all queries";
                    $this->descr = "unfiltered list of queries";
                    $this->queryString = "SELECT * FROM `myX`.`queries`";
                    $this->queryString .= " WHERE `user` = ".$_SESSION['userID'];

                } else {

                    $this->name = $name;
                    $this->descr = $descr;
                    $this->queryString = $queryString;

                }

                break;            

        }
            
    } // method 'Query::__construct'
    
    /**
     * method 'Query::__construct'
     * 
     * class constructor: initiates an instance of the class,
     * and sets its properties from the DB.
     * 
     * @param int $queryID the identifier of the query being constructed.
     */
//    public function __construct($queryID) {
//        
//        // get a DB connection to work with:
//        $pdo = DB::getDBHandle();
//
//        // the table 'queries' is queried. only one row expected.
//        $queryString = <<<QUERY
//SELECT *
//FROM `myX`.`queries`
//WHERE queryID = :queryID
//QUERY;
//        $statement = $pdo->prepare($queryString);
//        $statement->bindParam(":queryID", $queryID, PDO::PARAM_INT);
//        $statement->execute();
//
//        // the data are fetched:
//        $row = $statement->fetch();
//
//        // the propierties of the current object are taken from the query:
//        $this->queryID = $queryID;
//        $this->name = $row['name'];
//        $this->descr = $row['descr'];
//            
//    } // method 'Query::__construct'
    
    /**
     * method 'Query::HTMLPreview'.
     * 
     * this method displays a preview of the query with a link which redirects
     * to 'practica.php' passing the query ID as parameter.
     * 
     * @param int $ordinalNr experience ordinal in a given list.
     * @return nothing, taken into account that the method echoes HTML code.
     */
    public function HTMLPreview($ordinalNr) {

        // get a DB connection to work with:
        $pdo = DB::getDBHandle();
        
        echo "\t\t\t\t\t<div class=\"HTMLPreview\">\n";
        
/*
 * first line (headline): 1/ ordinal and 2/ name (with hyperlink).
 */
        
        // 1. ordinal number:
        echo "\t\t\t\t\t\t<p class=\"medium\"> ".$ordinalNr.". ";
        
        if (DEBUG)
            echo " <span class=\"debug\">[queryString <b>".
                $this->getQueryString()."</b>]</span> ";
        
        // 2. name (with hyperlink):
        echo "<b><a href=\"practica.php?query=".$this->queryID."\">".
            $this->getName()."</a></b>";
        
        echo "</p>\n";
        
/*
 * second line: description.
 */
        echo "\t\t\t\t\t\t<p>".$this->getDescr();"</p>\n";
        
        echo "\t\t\t\t\t</div>\n";
        
    } // method 'Query::HTMLPreview'
    
} // class 'Query'

/**
 * class 'PracticaQuery'.
 * 
 * used to be displayed in the scripts 'practica.php' and 'amor.php'
 */
class PracticaQuery extends Query {

    // I. member variables: inherited from class 'Query'.

    // II. implementation methods

    // getters: inherited from class 'Query'.

    /**
     * method 'PracticaQuery::__construct'.
     * 
     * class constructor
     * @param string $name the name given to the query.
     * @param string $descr the description given to the query.
     * @param string $queryString SQL sentence which defines the query.
     */
    public function __construct($name = "", $descr = "", $queryString = "") {

        if ($name === "" && $descr === "" && $queryString === "") {
            // empty args, full list
            
            $this->name = "all experiences";
            $this->descr = "unfiltered list of experiences";
            $this->queryString = "SELECT * FROM `myX`.`practica`";
            $this->queryString .= " WHERE `user` = ".$_SESSION['userID'];
                        
        } else {

            parent::__construct($name, $descr, $queryString);

        }

    } // method 'PracticaQuery::__construct'
		
} // class 'PracticaQuery'

/**
 * class 'AmoresQuery'.
 * 
 * used to be displayed by the script amoresList.php
 */
class AmoresQuery extends Query {

    // I. member variables: inherited from class 'Query'.
    // 
    // II. implementation methods

    // getties: inherited from class 'Query'.

    /**
     * method 'AmoresQuery::__construct'.
     * 
     * class constructor
     * @param string $name the name given to the query.
     * @param string $descr the description given to the query.
     * @param string $queryString SQL sentence which defines the query.
     */
    public function __construct($name = "", $descr = "", $queryString = "") {

        if ($name === "" || $descr === "" || $queryString === "") {
            // empty args, full list
            
            $this->name = "all lovers";
            $this->descr = "unfiltered list of lovers";
            $this->queryString = "SELECT * FROM `myX`.`amores`";
            $this->queryString .= " WHERE `user` = ".$_SESSION['userID'];
            
        } else {
            
            parent::__construct($name, $descr, $queryString);
            
        }

    } // method 'AmoresQuery::__construct'
		
} // class 'AmoresQuery'

/**
 * class 'LocaQuery'.
 * 
 * used to be displayed by the script 'locaList.php'.
 */
class LocaQuery extends Query {

    // I. member variables: inherited from class 'Query'.

    // II. implementation methods

    // getties: inherited from class 'Query'.

    /**
     * method 'LocaQuery::__construct'.
     * 
     * class constructor.
     * 
     * @param string $name the name given to the query.
     * @param string $descr the description given to the query.
     * @param string $queryString SQL sentence which defines the query.
     */
    public function __construct($name = "", $descr = "", $queryString = "") {

        if ($name === "" || $descr === "" || $queryString === "") {
            // empty args, full list

            $this->name = "all places";
            $this->descr = "unfiltered list of places";
            $this->queryString = "SELECT * FROM `myX`.`loca`";
            $this->queryString .= " WHERE `user` = ".$_SESSION['userID'];

        } else {

            parent::__construct($name, $descr, $queryString);

        }

    } // method 'LocaQuery::__construct'
		
} // class 'LocaQuery'