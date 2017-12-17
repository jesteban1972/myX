<?php

/* 
 * user.inc
 * script with the implementation of 'User' class
 * (c) Joaquín Javier ESTEBAN MARTÍNEZ
 * last update: 2017-12-15
 * 
 * to manage the users of the application,
 * an instance of class 'User' provides all methods needed.
 */

require_once 'core.inc';
require_once 'DB.inc';
require_once 'exceptions.inc';

//session_start(); // needed? (any call to $_SESSION?)

// CLEAR_STALE_PROB: number 1..100 indicating the probability that
// clearStaleLoginEntries() will actually execute a query
define("CLEAR_STALE_PROB", 50); // needed? working?

// STALE_LOGIN_INTERVAL: how long before we consider logins stale.
// this is directry specified in MySQL syntax
define("STALE_LOGIN_INTERVAL", "1 HOUR"); // needed? working?

/**
 * class 'User'
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
    
    // II. methods
    
    // II.1. getters
    public function getUserName() {return $this->username;}
    public function getEmail() {return $this->email;} // needed?
    
    // II.2 constructor
    
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
        
        // 1. get a DB connection to work with:
        $pdo = DB::getDBHandle();
         
        // 2. get the record with the given userID:
        
        $queryString = <<<QUERY
SELECT username, password, email
FROM `myx`.`users`
WHERE userID=:userID
QUERY;

        $statement = $pdo->prepare($queryString);
        $statement->bindParam(":userID", $userID);
        $statement->execute();
        
        // 3. the data is fetched:
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
     * returns:
     *  (to determine)!!!
     */
    static public function clearLoginEntriesForUser($userID) { // private???
        
        // 0. check internal arguments:
        if (!is_integer($userID)) {
            
            throw new ParameterException("the provided parameter is not an integer");
            
        }
        
        // 1. get a DB handle to work with:
        $pdo = DB::getDBHandle();
        
        // 2. delete any rows for this userID in the table 'usersLoggedIn':

        // 2.1. the DELETE statement is prepared:
        $queryString = <<<QUERY
DELETE
FROM `myx`.`usersLoggedIn`
WHERE userID=:userID
QUERY;
        
        $statement = $pdo->prepare($queryString);
        
        // 2.2. the parameter is binded:
        $statement->bindParam(":userID", $userID);

        // 2.3. the statement is executed:
        $statement->execute();
        
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
     */
    public function confirmUsernamePassword($username, $password) { // private???
        
        // 0. check internal parameters:
        if (trim($username) === "" || trim($password) === "") {
            
            throw new ParameterException("$username, $password");
        }
        
        $returnValue = FALSE; // default return value
        
        // 1. get a DB handle to work with:
        $pdo = DB::getDBHandle();
        
        
        // 3. get the record with the given username:
        
        // 3.1 the SELECT statement is prepared:
        $queryString = <<<QUERY
SELECT username, password
FROM `myx`.`users`
WHERE username=:username
QUERY;

        $statement = $pdo->prepare($queryString);
        
        // 3.2. the parameter is binded:
        $statement->bindParam(":username", $username);
        
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
            
            $returnValue = TRUE;
            
        }
        
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
    static public function createUserAccount($username, $password, $email) {
        
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
SELECT MAX(userID)
FROM `myx`.`users`
QUERY;
        $maxID = $pdo->query($queryString)->fetchColumn();

        // 4. userID is calculated:
        $userID = $maxID + 1;

        // 5. insert the user in the table 'users':

        // 5.1. the INSERT statement is prepared:    
        $queryString = <<<QUERY
INSERT INTO `myx`.`users` (userID, username, password, email, userKind)
VALUES (:userID, :username, :password, :email, :userKind)
QUERY;

        $statement = $pdo->prepare($queryString);

        // 5.2. the parameters are binded:
        $statement->bindParam(":userID", $userID);
        $statement->bindParam(":username", $username);
        $statement->bindParam(":password", $password);
        $statement->bindParam(":email", $email);
        $statement->bindParam(":userKind", $userKind);

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
     */
    static public function doesUsernameExist($username) { // private???
        
        $returnValue = FALSE; // default return value
        
        // 1. get a DB handle to work with:
        $pdo = DB::getDBHandle();
        
        // 2. query the table 'users':
        
        $queryString = <<<QUERY
SELECT COUNT(username)
FROM `myx`.`users`
WHERE username=:username
QUERY;

        $statement = $pdo->prepare($queryString);
        $statement->bindParam(":username", $username);
        $statement->execute();
        
        // 3. the number of rows is checked:
        $amount = intval($statement->fetchColumn());
        if ($amount !== 0) { // username already exists
            
            $returnValue = TRUE;
            
        }
        
        // 99. return:
        return $returnValue;
        
    } // method User::doesUsernameExist
    
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
        //var_dump($username);
        
        // 0. check internal arguments:
        if (trim($username) === "") {
            
            throw new ParameterException("the provided {$username} ...");
            
        }
        
        // 1. get a DB handle to work with:
        $pdo = DB::getDBHandle();
        
        // 2. query the table 'users' to get the userID of the given username:
        
        // 2.1. the SELECT statement is prepared:
        $queryString = <<<QUERY
SELECT userID
FROM `myx`.`users`
WHERE username=:username
QUERY;

        $statement = $pdo->prepare($queryString);
        
        // 2.2. the parameter is binded:
        $statement->bindParam(":username", $username);
        
        // 2.3. the statement is executed:
        $statement->execute();
        //var_dump($statement);
        
        // 3. the data is fetched:
        $userID = intval($statement->fetchColumn());
        //var_dump($row);

        //$userID = intval($row[0]); //'userID'
        
        // 98. clean up DB handle:
        $pdo = NULL;
        
        // 99. return:
        return $userID;
        
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
        
        // 1. get a DB handle to work with:
        $pdo = DB::getDBHandle();
        
        // 2. query the table 'users' to find the corresponding usename:
        
        // 2.1. the SELECT statement is prepared:
        $queryString = <<<QUERY
SELECT username
FROM `myx`.`users`
WHERE userID=:userID
QUERY;

        $statement = $pdo->prepare($queryString);
        
        // 2.2. the parameter is binded:
        $statement->bindParam(":userID", $userID);
        
        // 2.3. the statement is executed:
        $statement->execute();
        
        // 3. fetch username:
        $username = $statement->fetchColumn();

//        $resultset = $pdo->query($queryString);
//        $row = $resultset->fetch();
//        $username = $row['username'];
        
        // 99. return:
        return $username;
        
    } // method User::getUsernameFromUserID
    
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
        
        $returnValue = FALSE; // default return value
        
        if (trim($username) === ""
                || preg_match("[ˆa-zA-Z0-9 _-]", $username) > 0) {
            
            $returnValue = TRUE;
            
        }
        
        return $returnValue;
        
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
        
        // 1. the sessionID is retrieved:
        $sessionID = session_id();
        
        // 2. check that username and password match
        // with the values stored in the table 'users':
        //$this->confirmUsernamePassword($username, $password);
        
        // 3. the userID is retrieved:
        $userID = User::getUserIDFromUsername($username);
        //var_dump($userID);
        
        // 4. clear out existing entries in the table 'usersLoggedIn'
        User::clearLoginEntriesForUser($userID);
        
        // 5. get a DB handle to work with:
        $pdo = DB::getDBHandle();
        
        // 6. insert data in the 'usersLoggedIn' table:
       
        $queryString = <<<QUERY
INSERT
INTO `myx`.`usersLoggedIn` (sessionID, userID, lastUpdate)
VALUES (:sessionID, :userID, NOW())
QUERY;

        $statement = $pdo->prepare($queryString);
        $statement->bindParam(":sessionID", $sessionID);
        $statement->bindParam(":userID", $userID);
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
        
        // 1. get a DB handle to work with:
        $pdo = DB::getDBHandle();
        
        // 2. execute DELETE statement to do the cleanup:
        
        $queryString = <<<QUERY
DELETE
FROM `myx`.`usersLoggedIn`
WHERE sessionID=:sessionID
QUERY;

        $statement = $pdo->prepare($queryString);
        $statement->bindParam(":sessionID", session_id());
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
        
        // 1. get a DB handle to work with:
        $pdo = DB::getDBHandle();

        // 2. query the table 'usersLoggedIn'
        // to get the userID from the current session ID:

        $queryString = <<<QUERY
SELECT userID
FROM `myx`.`usersLoggedIn`
WHERE sessionID=:sessionID
QUERY;

        $statement = $pdo->prepare($queryString);
        $statement->bindParam(":sessionID", session_id());
        $statement->execute();
        
        if ($statement->rowCount() === 0) { // user not logged in
            
            $userID = -1;
            
        } else {
            
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
        
        
        
        // 99. return:
        return $userID;
        
    } // method User::sessionLoggedIn
    
} // class User

?>