<?php
/**
 * script 'sessionFromJS.php'.
 * 
 * this microscript is used to store a variable in the session
 * interactuating asynchronously with a JS script.
 * (c) Joaquin Javier ESTEBAN MARTINEZ
 * last updated 2018-04-26
*/

require_once 'core.inc';

if ($_SERVER['REQUEST_METHOD'] !== "POST") {
    /*
     * script called from outside the normal flush, throw exception
     */
    header ("Location: index.php");
    
}

foreach ($_POST as $key => $value) {
    
    if ($key === "tempAmorData") {
        
        if (!isset($_SESSION['tempAmorData']))
            $_SESSION['tempAmorData'] = array();
        array_push($_SESSION['tempAmorData'], json_decode($value, true));
        
    } else {
        
        $_SESSION[$key] = json_decode($value, true);
        
    }
    
}
    