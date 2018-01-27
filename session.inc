<?php

/* 
 * session.inc
 * script to handle session start and timeouts
 * (c) Joaquin Javier ESTEBAN MARTINEZ
 * last update: 2017-12-16
 */

session_start();
//$timeout = 3600; // number of seconds until it times out.
//     
//// check if the timeout field exists:
//if (isset($_SESSION['timeout'])) {
//    
//    // see if the number of seconds since the last visit
//    // is larger than the timeout period:
//    $duration = time() - intval($_SESSION['timeout']);
//    
//    if ($duration > $timeout) {
//        
//        // destroy the session and restart it:
//        session_destroy();
//        session_start();
//    }
//    
//}
//     
//// the timout field of $_SESSION is updated with the current time:
//$_SESSION['timeout'] = time();

?>
