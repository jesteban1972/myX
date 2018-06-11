<?php
/** 
 * script 'DBConnInfo.inc'.
 * 
 * data used to establish the DB connection. this data should be edited when
 * testing the app in another computer.
 * 
 * @author Joaquin Javier ESTEBAN MARTINEZ <jesteban1972@me.com>
 * last update: 2018-06-10
 */

function getDBInfo() {
    
    $server = "localhost";
    
    if ($server === "localhost") {
        
        $DBInfo = array("server" => "localhost",    // server
            "user" => "root",                       // user
            "password" => "Aquiles0184",            // password
            "DBname" => "myX");                     // DB
    }
    
    return $DBInfo;
    
}

?>