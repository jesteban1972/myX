<?php
/**
 * script 'user.inc'.
 * 
 * this script contains the implementation of class 'User',
 * the class which represents the abstraction of a user of the application.
 * (c) Joaquin Javier ESTEBAN MARTINEZ
 * last update: 2018-05-10
 */

require_once 'core.inc';
require_once 'DB.inc';
require_once 'exceptions.inc';

/**
 * class 'User'.
 * 
 * this class manages the core interactions with the users of the app.
 * it manages both users and user logins;
 * users using the table 'users' of the DB,
 * and logins using the table 'loggedInUsers'.
 * it is also used for verification purposes:
 * to check if a user exists,
 * if a user is logged in, etc.
 */
class User {
    
    // I. attributes
    
    /**
     * userID: the unique user identifier
     * @var int
     */
    private $userID;
    
    /**
     * username: the user's username
     * @var string
     */
    private $username;
    
    /**
     * password: the user's password
     */
    private $password;
    
    /**
     * email: the user's email
     * @var string
     */
    private $email;
    
    /**
     * birthdate: the user's birthdate
     * @var date
     */
    private $birthdate;
    
    /**
     * @var int userKind the kind of user, as defined in the class constants
     */
    private $userKind;
    
    // II. class constants
    const KIND_ADMIN = 1;
    const KIND_USER = 2;
    
    // III. methods
    
    public function getUserID() {return $this->userID;}
    public function getUserName() {return $this->username;}
    public function getEmail() {return $this->email;}
    
    /**
     * method 'User::getUserKind'.
     * 
     * this method returns the attribute 'userKind'.
     */
    public function getUserKind() {
        
        return $this->userKind;
        
    }
    
    /**
     * method User::__construct
     * 
     * this method creates an instance of the class 'User'.
     * we can instantiate an object 'User' in two different ways:
     * i) passing the default value -1 to the constructor:
     * a new user is created with empty fields.
     * ii) passing a userID of an existing user:
     * XXX (?)
     */
    function __construct($userID = -1) {

        // 0. check internal paremeter:
        if (!is_integer($userID)) {
            
            throw new ParameterException("The provided parameter is not an integer");
            
        }
        
        $this->userID = $userID;
        
        if ($userID === -1) { // default creation mechanism for a dummy user
            
            /*
             * a dummy user (with userID -1 and the other fields empty)
             * is created when a user is not logged in
             * but several user methods should be performed
             * (v.gr. createUserAccount, isValidUsername, loginProcess...)
             */
            
            $this->username = "";
            $this->password = "";
            $this->email = "";
            
            return;
            
        }
        
        // get a DB connection to work with:
        $pdo = DB::getDBHandle();
         
        // 2. get the record with the given userID:
        
        $queryString = <<<QUERY
SELECT `username`, `password`, `email`, `userKind`
FROM `myx`.`users`
WHERE `userID` = :userID
QUERY;

        $statement = $pdo->prepare($queryString);
        $statement->bindParam(":userID", $userID, PDO::PARAM_INT);
        $statement->execute();
        
        // 3. the data are fetched:
        $row = $statement->fetch();
        
        // 4. check that only one record was fetched:
        $amount = $statement->rowCount();
        //var_dump($amount);
//        $amount = ?
//        if ($amount === 0) {
//            
//            throw new Exception;
//            
//        } elseif ($amount > 1) {
//            
//            throw new Exception;
//            
//        }
        
        // 4. the attributes of the class are assigned
        // with the values read from the DB:
        $this->username = $row['username'];
        $this->password = $row['password'];
        $this->email = $row['email'];
        $this->userKind = intval($row['userKind']);
        
    } // method User::__construct
    
    /**
     * method User::clearLoginEntriesForUser
     * 
     * this method removes any existing entries in the table 'usersLoggedIn'
     * for the given userID.
     * 
     * parameters:
     *  userID
     * 
     * TODO: make this method private?
     */
    static public function clearLoginEntriesForUser($userID) {
        
        // 0. check internal arguments:
        if (!is_integer($userID)) {
            
            throw new ParameterException("the provided parameter is not an integer");
            
        }
        
        // get a DB handle to work with:
        $pdo = DB::getDBHandle();
        
        // 2. delete any rows for this userID in the table 'usersLoggedIn':

        $queryString = <<<QUERY
DELETE
FROM `myX`.`usersLoggedIn`
WHERE `userID` = :userID
QUERY;
        
        $statement = $pdo->prepare($queryString);
        $statement->bindParam(":userID", $userID, PDO::PARAM_INT);
        $statement->execute();
        
        return;
        
    } // method User::clearLoginEntriesForUser
    
    /**
     * method User::confirmUsernamePassword
     * 
     * this method looks in the table 'users'
     * for a user with the given username.
     * if found, it makes sure that the passwords are the same,
     * (and then returns the user ID on success?).
     * otherwise it throws an LoginException
     * indicating that the information is invalid.
     * note that we will not help foil attackers learn
     * whatever it was the username or the password
     * that was the problem failure.
     * 
     * parameters:
     *  username
     *  password
     * 
     * returns:
     *  TRUE if username and password match
     *  FALSE otherwise
     * 
     * TODO: make this method private?
     */
    public function confirmUsernamePassword($username, $password) {
        
        // 0. check internal parameters:
        if (trim($username) === "" || trim($password) === "") {
            
            throw new ParameterException("$username, $password");
        }
        
        $returnValue = FALSE; // default return value
        
        // get a DB handle to work with:
        $pdo = DB::getDBHandle();
        
        
        // 3. get the record with the given username:
        
        // 3.1 the SELECT statement is prepared:
        $queryString = <<<QUERY
SELECT `username`, `password`
FROM `myx`.`users`
WHERE `username` = :username
QUERY;

        $statement = $pdo->prepare($queryString);
        
        // 3.2. the parameter is binded:
        $statement->bindParam(":username", $username, PDO::PARAM_STR);
        
        // 3.3. the statement is executed:
        $statement->execute();
        
        // 4. check that only one record was returned:
        $amount = $statement->rowCount();
        //var_dump($amount);
        // if...
        //        if ($amount === 0) {
//            
//            throw new LoginException;
//            
//        } elseif ($amount > 1) {
//            
//            throw new InternalException("Multiple users with the same username");
//            
//        }
        
        // 5. the data is fetched:
        $row = $statement->fetch();
        
        // 6. check that the password matches:
        if (strcmp(md5($password), $row['password']) === 0) {
            
            $returnValue = true;
            
        }
        
        return $returnValue;// TODO: check
        
    } // method User::confirmUsernamePassword
    
    /**
     * method User::createUserAccount
     * 
     * this method creates a user account
     * using the given username, password and email.
     * the userID will be calculated by increasing the highest used ID.
     * 
     * parameters:
     *  username
     *  password
     *  email
     * 
     * returns:
     *  userID
     */
    static public function createUserAccount($username, $password, $email, $birthdate) {
        
        $userKind = 1; // default userKind value for all users
        
        // 0. ckeck internal parameters
        // and validate input:
        if (trim($username) === ""
                || trim($password) === ""
                || !User::isValidUserName($username)) {
            
            throw new InvalidInputException();
            
        }
        
//        // 1. make sure username does not already exist:
//        (this functionality has been tranferred to userSignUpProcess.php)
//        if (User::doesUsernameExist($username)) {
//
//            throw new Exception;
//            
//        }
        
        // 1. encrypt the password for storage
        $password = md5($password);
        
        // 2. get a DB handle to work with:
        $pdo = DB::getDBHandle();            
            
        // 3. query the table 'users' to get the highest used ID:
        $queryString = <<<QUERY
SELECT MAX(`userID`)
FROM `myX`.`users`
QUERY;
        $maxID = $pdo->query($queryString)->fetchColumn();

        // 4. userID is calculated:
        $userID = $maxID + 1;

        // 5. insert the user in the table 'users':

        // 5.1. the INSERT statement is prepared:    
        $queryString = <<<QUERY
INSERT
INTO `myx`.`users` (userID, username, password, email, birthdate, userKind)
VALUES (:userID, :username, :password, :email, :birthdate, :userKind)
QUERY;

        $statement = $pdo->prepare($queryString);

        // 5.2. the parameters are binded:
        $statement->bindParam(":userID", $userID, PDO::PARAM_INT);
        $statement->bindParam(":username", $username, PDO::PARAM_STR);
        $statement->bindParam(":password", $password, PDO::PARAM_STR);
        $statement->bindParam(":email", $email, PDO::PARAM_STR);
        $statement->bindParam(":birthdate", $birthdate, PDO::PARAM_STR);
        $statement->bindParam(":userKind", $userKind, PDO::PARAM_INT);

        // 5.3. the statement is executed
        $statement->execute();
        
    } // method User::createUserAccount
    
    /**
     * method doesUsernameExist
     * 
     * this method checks whether a user with the given username
     * already exists in the table 'users'.
     * 
     * parameters:
     *  username
     * 
     * returns:
     *  TRUE if the username already exists
     *  FALSE otherwise
     * 
     * TODO: make this method private?
     */
    static public function doesUsernameExist($username) { // private???
        
        // get a DB handle to work with:
        $pdo = DB::getDBHandle();
        
        // 2. query the table 'users':
        
        $queryString = <<<QUERY
SELECT COUNT(`username`)
FROM `myX`.`users`
WHERE `username` = :username
QUERY;

        $statement = $pdo->prepare($queryString);
        $statement->bindParam(":username", $username, PDO::PARAM_STR);
        $statement->execute();
        
        // 3. the number of rows is checked (intval needed):
        $amount = intval($statement->fetchColumn());
        
        if ($amount !== 0) // username already exists
            return true;
        else
            return false;
        
    } // method User::doesUsernameExist
    
    /**
     * method User::getAge
     * calculation algorithm:
     * having i) the date in which the experience happened
     * and ii) the birthdate of the user (read from the DB),
     * both Unix timestamps created using function 'strtotime',
     * the age is the integer value of their difference
     * divided by 86400 (i.e. 60 x 60 x 24, number of seconds in a day)
     * and by 365.25 (i.e. number of days in a year)
     */
    public function getAge($date) {
        
        $pdo = DB::getDBHandle();
        
        $queryString = <<<QUERY
SELECT `birthdate`
FROM `myX`.`users`
WHERE `userID` = :userID
QUERY;

        $statement = $pdo->prepare($queryString);
        $statement->
            bindParam(":userID", strval($_SESSION['userID']), PDO::PARAM_STR);
        $statement->execute();        
        $birthdate = strtotime($statement->fetchColumn());
        
        $elapsedTime = $date - $birthdate;
	return intval($elapsedTime / (86400 * 365.25));
        
    } // method User::getAge
	
    
    /**
     * method User::getUserIDFromUsername
     * 
     * this method retrieves the userID from a given username.
     * 
     * parameters:
     *  username
     * 
     * returns:
     *  userID
     */
    private function getUserIDFromUsername($username) {
        
        // 0. check internal arguments:
        if (trim($username) === "") {
            
            throw new ParameterException("one argument missing");
            
        }
        
        // get a DB handle to work with:
        $pdo = DB::getDBHandle();
        
        // 2. query the table 'users' to get the userID of the given username:
        
        $queryString = <<<QUERY
SELECT `userID`
FROM `myX`.`users`
WHERE `username` = :username
QUERY;

        $statement = $pdo->prepare($queryString);
        $statement->bindParam(":username", $username, PDO::PARAM_STR);
        $statement->execute();
        
        // 3. userID is fetched (intval needed)
        // and returned:
        return intval($statement->fetchColumn());
        
    } // method User::getUserIDFromUsername
    
    /**
     * method User::getUsernameFromUserID
     * 
     * this method queries the table 'users'
     * and gets the username from a given userID.
     * 
     * parameters:
     *  userID
     * 
     * returns:
     *  username
     */
    static public function getUsernameFromUserID($userID) {
        
        // 0. check internal parameters:
        if(!is_integer($userID)) {
            
            throw new ParameterException("the provided parameter is not an integer");
            
        }
        
        // get a DB handle to work with:
        $pdo = DB::getDBHandle();
        
        // 2. query the table 'users' to find the corresponding usename:
        
        $queryString = <<<QUERY
SELECT `username`
FROM `myX`.`users`
WHERE `userID` = :userID
QUERY;

        $statement = $pdo->prepare($queryString);
        $statement->bindParam(":userID", $userID, PDO::PARAM_INT);
        $statement->execute();
        
        // 3. the username is fetched and returned:
        return $statement->fetchColumn();
        
    } // method User::getUsernameFromUserID
    
    /**
     * method 'User::getNavOptions'.
     * 
     * this method returns an associative array containing the navigation options,
     * values which have been taken from the DB (if set).
     * the considered user options are the following fields
     * of the table 'users':
     * i) 'GUILang', the language of the GUI.
     * ii) 'resultsPerPage' the number of elements wich will be considered.
     * in lists scripts ('practica.php', 'amores.php' and 'loca.php'.
     * iii) the order for lists: ascending or descending
     * (i.e., from oldest to newest or from newest to oldest).
     */
    public static function getNavOptions () {
        
        // array to be returned:
        $navigationOptions = array();
        
        // get a DB handle to work with:
        $pdo = DB::getDBHandle();

        // query the table 'users':

        $queryString = <<<QUERY
SELECT `GUILang`, `resultsPerPage`, `listsOrder`
FROM `myX`.`users`
WHERE `userID` = :userID
QUERY;

        $statement = $pdo->prepare($queryString);
        $statement->bindParam(":userID", $_SESSION['userID'], PDO::PARAM_INT);
        $statement->execute();
        $row = $statement->fetch();
        
        if ($row['GUILang'] !== "")
            $navigationOptions['GUILang'] = intval($row['GUILang']);
        if ($row['resultsPerPage'] !== "")
            $navigationOptions['resultsPerPage'] =
                intval($row['resultsPerPage']);
        if ($row['listsOrder'] !== "")
            $navigationOptions['listsOrder'] = intval($row['listsOrder']);
        
        
        //return:
        return $navigationOptions;
        
    } // method User::getNavOptions
    
    /**
     * method User::getUserOptions
     * 
     * this method returns an associative array containing the user options,
     * values which have been taken from the DB (if set).
     * the considered user options are the following fields
     * of the table 'users':
     * i) 'defaultGenre', the default genre for lovers;
     * ii-v) 'descr1' .. 'descr4', the custom meaning of a lover's description.
     */
    public static function getUserOptions () {
        
        // array to be returned:
        $userOptions = array();
        
        // get a DB handle to work with:
        $pdo = DB::getDBHandle();

        // query the table 'users':

        $queryString = <<<QUERY
SELECT `defaultGenre`, `descr1`, `descr2`, `descr3`, `descr4`
FROM `myX`.`users`
WHERE `userID` = :userID
QUERY;

        $statement = $pdo->prepare($queryString);
        $statement->bindParam(":userID", $_SESSION['userID'], PDO::PARAM_INT);
        $statement->execute();
        $row = $statement->fetch();
        
        if ($row['defaultGenre'] !== "")
            $userOptions['defaultGenre'] = intval($row['defaultGenre']);
        if ($row['descr1'] !== "")
            $userOptions['descr1'] = $row['descr1'];
        if ($row['descr2'] !== "")
            $userOptions['descr2'] = $row['descr2'];
        if ($row['descr3'] !== "")
            $userOptions['descr3'] = $row['descr3'];
        if ($row['descr4'] !== "")
            $userOptions['descr4'] = $row['descr4'];
        
        //return:
        return $userOptions;
        
    } // method User::getUserOptions
    
    /**
     * method User::isValidUsername
     * 
     * this method checks if a given username is valid or not.
     * 
     * parameters:
     *  username
     * 
     * returns:
     *  TRUE if username is valid
     *  FALSE otherwise
     */
    static public function isValidUsername($username) {
        
//        // 0. check internal arguments:
//        if (trim($username) === "") {
//            
//            throw new ParameterException("one argument missing");
//            
//        }
         
        if (preg_match("/^[a-zA-Z0-9 _-]+$/", $username) &&
            trim($username) !== "") {
            
            return true;
            
        } else {
        
            return false;
        
        }
        
    } // method User::isValidUsername
    
    /**
     * method User::loginProcess
     * 
     * this method performs system logins following a two-step mechanism:
     * i) firstly it clears out any existing login information for the user
     * (otherwise if the user logs in from a different browser or computer
     * and never logs off we would have a new session ID,
     * but an entry for him may still exists in the table 'usersLoggedIn').
     * ii) secondly this method adds the username and session ID to the table
     * 'usersLoggedIn'. the session ID associated with the user is also stored.
     * the method sets the time when the login was performed for two reasons:
     * stale logins can be eliminated and,
     * if we receive a page request from this user
     * and there is already an entry for him/her in the table 'usersLoggedIn'
     * we will not make him/her go through the login process again.
     * 
     * parameters:
     *  username
     *  password
     * 
     * returns:
     *  userID
     */
    static public function loginProcess($username, $password) {
        
        // 0. check internal parameters:
        if (trim($username) === "" || trim($password) === "") {
            
            throw new ParameterException("one or more arguments missing");
            
        }
        
        // 2. check that username and password match
        // with the values stored in the table 'users':
        //$this->confirmUsernamePassword($username, $password);
        
        // 3. the userID is retrieved:
        $userID = User::getUserIDFromUsername($username);
        
        // 4. clear out existing entries in the table 'usersLoggedIn'
        User::clearLoginEntriesForUser($userID);
        
        // 5. get a DB handle to work with:
        $pdo = DB::getDBHandle();
        
        // 6. insert data in the 'usersLoggedIn' table:
       
        $queryString = <<<QUERY
INSERT
INTO `myX`.`usersLoggedIn` (sessionID, userID, lastUpdate)
VALUES (:sessionID, :userID, NOW())
QUERY;

        $statement = $pdo->prepare($queryString);
        $statement->bindParam(":sessionID", session_id(), PDO::PARAM_STR);
        $statement->bindParam(":userID", $userID, PDO::PARAM_INT);
        $statement->execute();
                
        // 99. return userID:
        return $userID;
        
    } // method User::loginProcess
    
    /**
     * method User::logoutProcess
     * 
     * this method deletes all the entries in the table 'usersLoggedIn'
     * with the current session ID.
     * 
     * no parameters are needed, because the current session ID is used.
     * 
     * returns:
     *  nothing
     */
    static public function logoutProcess() {
        
        // get a DB handle to work with:
        $pdo = DB::getDBHandle();
        
        // 2. execute DELETE statement to do the cleanup:
        
        $queryString = <<<QUERY
DELETE
FROM `myX`.`usersLoggedIn`
WHERE `sessionID` = :sessionID
QUERY;

        $statement = $pdo->prepare($queryString);
        $statement->bindParam(":sessionID", session_id(), PDO::PARAM_STR);
        $statement->execute();       
        
    } // method User::logoutProcess
    
    /**
     * method User::sessionLoggedIn
     * 
     * this method searches records in the table 'usersLoggedIn'
     * with the current session ID.
     * if found -i.e. user is active- updates last access time;
     * if not found, it returns -1.
     * 
     * parameters:
     *  none
     * 
     * returns:
     *  userID if user is logged
     *  -1 otherwise
     */
    static public function sessionLoggedIn() {
        
        $userID = -1; // default return value (user not logged in)
        
        // get a DB handle to work with:
        $pdo = DB::getDBHandle();

        // 2. query the table 'usersLoggedIn'
        // to get the userID from the current session ID
        // (only one record, or none, expected):

        $queryString = <<<QUERY
SELECT `userID`
FROM `myX`.`usersLoggedIn`
WHERE `sessionID` = :sessionID
QUERY;

        $statement = $pdo->prepare($queryString);
        $statement->bindParam(":sessionID", session_id(), PDO::PARAM_STR);
        $statement->execute();
        
        if ($statement->rowCount() > 0) {
            
            // the data is fetched and assigned to $userID (intval needed):
            $userID = intval($statement->fetchColumn());
            
        }
        
        // 3. check that none or only one record is returned:
//        $amount = $statement->fetchColumn();
//        if ($amount === 1) { // user is already logged in
//            
//            $userID = intval($statement->fetchColumn());
//            
//        } elseif ($amount > 1) {
//            
//            throw new Exception("too many rows");
//            
//        }
        
        
        
        // userID is returned:
        return $userID;
        
    } // method User::sessionLoggedIn
    
    /**
     * method 'User::setNavOptions'.
     * 
     * XXX
     */
    public static function setNavOptions ($GUILang, $resultsPerPage,
            $listsOrder) {
        
        // get a DB handle to work with:
        $pdo = DB::getDBHandle();

        // update the table 'users':

        $queryString = <<<QUERY
UPDATE `myX`.`users`
SET `GUILang` = :GUILang,
    `resultsPerPage` = :resultsPerPage,
    `listsOrder` = :listsOrder
WHERE `userID` = :userID
QUERY;

        $statement = $pdo->prepare($queryString);
        $statement->bindParam(":GUILang", $GUILang, PDO::PARAM_INT);
        $statement->bindParam(":resultsPerPage", $resultsPerPage,
            PDO::PARAM_INT);
        $statement->bindParam(":listsOrder", $listsOrder, PDO::PARAM_INT);
        $statement->bindParam(":userID", $_SESSION['userID'], PDO::PARAM_INT);
        $statement->execute();
        
        //return:
        return;
        
    } // method User::setNavOptions
    
    /**
     * method User::setUserOptions
     * 
     * XXX
     */
    public static function setUserOptions ($defaultGenre,
        $descr1, $descr2, $descr3, $descr4) {
        
        // get a DB handle to work with:
        $pdo = DB::getDBHandle();

        // update the table 'users':

        $queryString = <<<QUERY
UPDATE `myX`.`users`
SET `defaultGenre` = :defaultGenre,
    `descr1` = :descr1,
    `descr2` = :descr2,
    `descr3` = :descr3,
    `descr4` = :descr4
WHERE `userID` = :userID
QUERY;

        $statement = $pdo->prepare($queryString);
        $statement->bindParam(":defaultGenre", $defaultGenre, PDO::PARAM_INT);
        $statement->bindParam(":descr1", $descr1, PDO::PARAM_STR);
        $statement->bindParam(":descr2", $descr2, PDO::PARAM_STR);
        $statement->bindParam(":descr3", $descr3, PDO::PARAM_STR);
        $statement->bindParam(":descr4", $descr4, PDO::PARAM_STR);
        $statement->bindParam(":userID", $_SESSION['userID'], PDO::PARAM_INT);
        $statement->execute();
        
        //return:
        return;
        
    } // method User::setUserOptions
    
} // class User

?>