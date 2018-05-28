<?php

/* 
 * DBConnInfo.inc
 * 
 * data used to etablish the DB connection
 * @author Joaquin Javier ESTEBAN MARTINEZ <jesteban1972@me.com>
 * last update: 2017-11-04
 */

function getDBInfo() {
    
    $server = "localhost"; // rewrite it using $_SERVER!
    
    if ($server === "localhost") {
        
        $DBInfo = array("server" => "localhost",    // server
            "user" => "root",                       // user
            "password" => "Aquiles0184",            // password
            "DBname" => "myX");                     // DB
    }
    
    return $DBInfo;
    
} // function getDBInfo

?>