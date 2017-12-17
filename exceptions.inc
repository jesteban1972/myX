<?php

/* 
 * exceptions.inc
 * 
 * script with the implementation of
 * i) exception classes (...)
 * ii) myX's own exception handler
 * (c) Joaquín Javier ESTEBAN MARTÍNEZ
 * last update: 2017-11-09
 */

// I. classes derived from Exception

/**
 * class DBException
 * potentially thrown by:
 * ...
 */
class DBException extends Exception {
    
    //private static $responsability = ERROR_BACKEND;
    
    function __construct($msg) {
        
        parent::__construct("Database error: {$msg}.");
    }
} // class DBException

/**
 * class InputException
 * 
 * this frontend exception is thrown when the input data
 * does not match the input wanted.
 * 
 * potentially thrown by:
 *  userSignUpProcess.php
 */
class InputException extends Exception {
    
    //private static $responsability = ERROR_FRONTEND;
    
    function __construct($msg) {
        
        parent::__construct("Input error: {$msg}.");
        
    }
    
} // class InputException

/**
 * class LoginException
 * potentially thrown by:
 * User::confirmUsernamePassword
 */
class LoginException extends Exception {
    
    //private static $responsability = ERROR_FRONTEND;
    
    function __construct($msg) {
        
        //parent::__construct("Login error: {$msg}.");
        parent::__construct("Login error.");
        
    }
} // class LoginException

/**
 * class NonMatchingPasswordsException
 * potentially thrown by:
 * User::confirmUsernamePassword
 */
//class NonMatchingPasswordsException extends Exception {
//    
//    //private static $responsability = ERROR_FRONTEND;
//    
//    function __construct($msg) {
//        
//        parent::__construct("the input passwords do not match.");
//        
//    }
//} // class NonMatchingPasswordsException

/**
 * class ParameterException
 * potentially thrown by:
 *  User::__construct
 *  User::clearLoginEntriesForUser
 *  User::confirmUsernamePassword
 *  User::loginProcess
 *  User::getUserIDFromUsername
 *  User::getUsernameFromUserID
 */
class ParameterException extends Exception {
    
    //private static $responsability = ERROR_FRONTEND;
    
    function __construct($msg) {
        
        parent::__construct("Parameter error: {$msg}.");
        
    }
    
} // class ParameterException

/**
 * class usernameExistsException
 * potentially thrown by:
 *  userSignUpProcess.php
 */
class usernameExistsException extends Exception {
    
    //private static $responsability = ERROR_BACKEND; //???
    
    function __construct() {
        
        parent::__construct("The given username already exists. Please choose another one.");
        
    }
    
} // class usernameExistsException

// II. myX's exception handler

function exceptionHandler($exception) {
    
    $msg = $exception->getMessage();
    
    $title = "myX error";
    
    $description = "Application error";
    
    include_once 'header.inc';
    
    echo <<<XHTML
                    <article>
                        <p>We are sorry, but an error occured while executing the application. The retrived error follows.</p>
                        <p style="color: red; text-align: center;">{$msg}</p>
                        <p>Back to <a href="javascript: history.back()">previous page</a></p>
                        <p>Back to <a href="index.php">start page</a></p>
                    </article>

XHTML;

    error_log("Unhandled exception: "
            .$msg." "
            .$exception->getFile()." "
            .$exception->getLine()." "
            .$exception->getCode(), 1); // does it work???
    
    include_once 'footer.inc';
    
} // function exceptionHandler

// set of function exceptionHandler:
set_exception_handler("exceptionHandler");

?>