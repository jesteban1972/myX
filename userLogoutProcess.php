<?php
/** 
 * script 'userLogoutProcess.php'.
 * 
 * this script process the logout of a currently logged in user. it also reset
 * the session variables.
 * 
 * @author Joaquin Javier ESTEBAN MARTINEZ <jesteban1972@me.com>
 * last update: 2018-06-09
 */

require_once 'core.inc';
require_once 'user.inc';

// retrieve userID from $_SESSION:
$userID = isset($_SESSION['userID']) ?
    $_SESSION['userID'] :
    -1;

// the user is logged out of the system (if he is currently logged in):
if ($userID !== -1) {
    
    User::logoutProcess();
    
    // clean up all the $_SESSION variables:
    $_SESSION['userID'] = -1;
    unset($_SESSION['practicaQuery']);
    unset($_SESSION['amoresQuery']);
    unset($_SESSION['locaQuery']);
    unset($_SESSION['userOptions']);
    unset($_SESSION['navOptions']);
    
}

// redirect to the start page:
header("Location: index.php");

?>