<?php
/** 
 * script 'DB.inc'.
 * 
 * implementation of class 'DB'.
 * 
 * @author Joaquin Javier ESTEBAN MARTINEZ <jesteban1972@me.com>
 * last update: 2018-06-10
 */

require_once 'DBConnectionInfo.inc';
require_once 'exceptions.inc';

/**
 * class 'DB'.
 * 
 * class to manage the handle to access to the DB.
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
            
            try {
                
                $currentDBHandle = new PDO($DSN, $user, $password, $options);
                
            } catch (PDOException $e) {
                
                echo "Failed to get DB handle: {$e->getMessage()}.";
                
            }
            
            DB::$DBHandle = $currentDBHandle;
            
        }
        
        return DB::$DBHandle;
        
    } // method getDBHandle
    
} // class 'DB'

?>