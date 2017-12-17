<?php

/* 
 * header.inc
 * script with the header of all pages
 * (c) Joaquín Javier ESTEBAN MARTÍNEZ
 * last update: 2017-12-15
 */

require_once 'session.inc';
require_once 'core.inc';
require_once 'user.inc';
//var_dump($_SESSION['userID']);

echo <<<XHTML
<!DOCTYPE html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <meta name="description" content="{$description}" />
        <meta name="author" content="Joaquin Javier ESTEBAN MARTINEZ" />
        <title>{$title}</title>
        <link rel="stylesheet" type="text/css" href="stylesheets/defaultsoll.css" />
    </head>
    <body>
        <div id="container"><!-- container {{ -->
            <div id="content"><!-- content {{ -->
                <header>
                    <h1>{$title}</h1>
                </header>
                <nav>
                    <p><a href="index.php">Home</a>
XHTML;

// links to the mains sections are displayed only if a user is logged in:
if (!isset($_SESSION['userID']) || $_SESSION['userID'] !== -1) {

    echo " | <a href=\"practica.php\">Practica</a>";
    echo " | <a href=\"amores.php\">Amores</a>";
    echo " | <a href=\"loca.php\">Loca</a></p>\n";

} else {
    
    echo "\n";
    
}

//{{ user logins
echo "\t\t\t\t\t<section id=\"login\">\n";

/**
 * in order to handle user logins,
 * an instance of the class 'User' and the global variable '$_SESSION' are used:
 * 
 * if the user is logged in,
 * $_SESSION['userID'] stores the userID of the user.
 * otherwise $_SESSION['userID'] is set to -1
 */

if (!isset($_SESSION['userID'])) { // $_SESSION['userID'] not yet set
    
    // userID is assigned. -1 when user is not logged in
    $_SESSION['userID'] = User::sessionLoggedIn();
    
} 

// the current userID is retrieved from $_SESSION (intval not needed)
$userID = $_SESSION['userID'];

if ($userID === -1) { // user not logged in

    echo <<<XHTML
                        <form action="userLoginProcess.php" method="POST">
                            <p>Username: <input type="text" name="username" /></p>
                            <p>Password: <input type="password" name="password" /></p>
                            <p><input type="submit" value="Log In" /></p>
                        </form>
                        <p>Not yet user? <a href="userSignUp.php">Sign Up</a>!</p>

XHTML;

} else { // user already logged in
        
    $username = User::getUsernameFromUserID(intval($_SESSION['userID']));
    echo "\t\t\t\t\t\t<p>";
    // show a welcome message if $_GET['welcomeMessage'] is true
    // (filter_input is used to prevent XXX):
    if (filter_input(INPUT_GET, "welcomeMessage", FILTER_SANITIZE_STRING)) {
        
        echo "Welcome back, ";
        
    }
    //echo filter_input(INPUT_GET, "welcomeMessage", FILTER_SANITIZE_STRING);
    echo "<b>".$username."</b> [<a href=\"userLogoutProcess.php\">Log Out</a>]</p>\n";

}
                    
echo <<<XHTML
                    </section>
                </nav>

XHTML;

?>