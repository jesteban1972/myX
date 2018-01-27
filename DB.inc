<?php

/* 
 * DB.inc
 * implementation of class DB
 * (c) Joaquin Javier ESTEBAN MARTINEZ
 * last update: 2017-11-04
 */

require_once 'DBConnectionInfo.inc';
require_once 'exceptions.inc';

/**
 * class DB
 * class to manage the handle to access to the DB
 */
class DB {
    
    // I. attributes
    
    private static $DBHandle; // DB handle
    
    // II. methods
    
    /**
     * method DB::getDBHandle
     * returns a PDO object representing the DB connection
     */
    public static function getDBHandle() {
        
        if (DB::$DBHandle === NULL) {
            
            // the information about the connection is retrieved:
            $DBAccess = getDBInfo();
            
            // DSN (Data Source Name) containing both the PDO driver name
            // and the PDO driver-specific connection syntax:
            $DSN = "mysql:host="
                    .$DBAccess['server']
                    .";dbname="
                    .$DBAccess['DBname']
                    .";charset=utf8";
            $user = $DBAccess['user'];
            $password = $DBAccess['password'];
            $options = array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            );
//            $DSN = "mysql:host="
//                    .$DBAccess['server']
//                    .";dbname="
//                    .$DBAccess['DBname'];
//            $user = $DBAccess['user'];
//            $password = $DBAccess['password'];
//            $options = array(
//                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
//                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
//                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
//                );
            
            try {
                
                $currentDBHandle = new PDO($DSN, $user, $password, $options);
                //var_dump($currentDBHandle);
                
            } catch (PDOException $e) {
                
                echo "Failed to get DB handle: {$e->getMessage()}.";
                
            }
            
            // should be avoided because of SQL injection {{
            // // make sure the connection is set for utf8 communications:
            //$statement = $currentDBConnection->query("SET NAMES 'utf8'");
            // }}
            
            DB::$DBHandle = $currentDBHandle;
            
        } // if
        
        return DB::$DBHandle;
        
    } // method getDBHandle
    
    /**
     * method DB::closeDBHandle
     * method used to close the connection handle freeing resources
     */
//    public static function closeDBHandle() {
//        
//        DB::$DBHandle = NULL;
//        
//    } // method DB::closeDBHandle
    
} // class DB

?>