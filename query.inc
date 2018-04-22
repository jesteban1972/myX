<?php
/*
 * query.inc
 * inc file implementing class 'Query'
 * (c) Joaquin Javier ESTEBAN MARTINEZ
 * last update: 2018-03-28
 */

/**
 * class Query
 * this is the base class of PracticaQuery, AmoresQuery and LocaQuery
 * used to store a list of experiences, lovers or places respectively
 * containing:
 * a) their designation/title,
 * b) a description of it, and
 * c) the SQL query used to retrieve the list
 * TODO: when entering into each list entry details, the former catalogue should
 * be loaded calling the method backToPreviousList()
 */
class Query {

    // I. member variables
    
    protected $designation; // list designation or title
    protected $description; // list description in a somehow extended way
    protected $queryString; // SQL query used to retrieve the list
    
    // II. class constants
    
    const RULES_BINDING_ALL = 0;
    const RULES_BINDING_ANY = 1;

    // III. implementation methods

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
    public function __construct($designation = "",
            $description = "",
            $queryString = "") {

        $this->designation = $designation;
        $this->description = $description;
        $this->queryString = $queryString;
            
    } // method List::__construct
    
} // class GenericList

/**
 * class PracticaList
 * used to be displayed in the scripts 'practica.php' and 'amor.php'
 */
class PracticaQuery extends Query {

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

        if ($designation === "" || $description === "" || $queryString === "") {
            // empty args, full list
            
            $this->designation = "all experiences";
            $this->description = "unfiltered list of experiences";
            $this->queryString = "SELECT * FROM `myX`.`practica`";
            $this->queryString .= " WHERE `user` = ".$_SESSION['userID'];
                        
        } else {

            parent::__construct($designation, $description, $queryString);

        }

    } // method PracticaList::__construct
		
} // class PracticaList

/**
 * class AmoresList, used to be displayed by the script amoresList.php
 */
class AmoresQuery extends Query {

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

        if ($designation === "" || $description === "" || $queryString === "") {
            // empty args, full list
            
            $this->designation = "all lovers";
            $this->description = "unfiltered list of lovers";
            $this->queryString = "SELECT * FROM `myX`.`amores`";
            $this->queryString .= " WHERE `user` = ".$_SESSION['userID'];
            
        } else {
            
            parent::__construct($designation, $description, $queryString);
            
        }

    } // method AmoresList::__construct
		
} // class AmoresList

/**
 * class LocaList, used to be displayed by the script locaList.php
 */
class LocaQuery extends Query {

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

        if ($designation === "" || $description === "" || $queryString === "") {
            // empty args, full list

            $this->designation = "all places";
            $this->description = "unfiltered list of places";
            $this->queryString = "SELECT * FROM `myX`.`loca`";
            $this->queryString .= " WHERE `user` = ".$_SESSION['userID'];

        } else {

            parent::__construct($designation, $description, $queryString);

        }

    } // method LocaList::__construct
		
} // class LocaList