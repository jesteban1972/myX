<?php

/* 
 * aside.inc
 * sidebar for all pages of myX
 * (c) Joaquin Javier ESTEBAN MARTINEZ
 * last update: 2018-01-10
 */

require_once 'session.inc';
require_once 'user.inc';
require_once 'praxis.inc';
require_once 'amor.inc';
require_once 'locus.inc';

echo "\t\t\t<aside><!-- aside {{ -->\n";
            
// login:
echo "\t\t\t\t<!-- login {{ -->\n";

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

// current userID is retrieved from $_SESSION:
$userID = $_SESSION['userID'];

// divide the URL in parts in order to filter actions according with $fileName:
$resourceParts = explode('/', $_SERVER['PHP_SELF']); // SCRIPT_NAME, SCRIPT_FILENAME
$fileName = end($resourceParts);
// alternatively: $scriptΝame = $resource_parts[count($URL_parts) - 1]

if ($fileName !== "userSignUp.php") { // login form not shown when signing up
    
    if ($userID === -1) { // user not logged in

        echo <<<HTML
                        <form action="userLoginProcess.php" method="POST">
                            <fieldset>

HTML;

    echo "\t\t\t\t\t\t\t<legend>"._("Log in")."</legend>\n";
    echo "\t\t\t\t\t\t\t<label for=\"username\">".
        _("Username:")." </label><br />\n";
    echo "\t\t\t\t\t\t\t<input type=\"text\" name=\"username\" /><br />\n";
    echo "\t\t\t\t\t\t\t<label for=\"password\">".
        _("Password:")." </label><br />\n";
    echo "\t\t\t\t\t\t\t<input type=\"password\" name=\"password\" /><br />\n";
    echo "\t\t\t\t\t\t</fieldset>\n";
    echo "\t\t\t\t\t\t<input type=\"submit\" value=\""._("Log In")."\" />\n";
    echo "\t\t\t\t\t</form>\n";
    echo "<p>".
        _("Not yet user?").
        " <a href=\"userSignUp.php\">".
        _("Sign Up!").
        "</a></p>\n";

    } else { // user already logged in

        $username = User::getUsernameFromUserID($_SESSION['userID']);

        echo "\t\t\t\t<p>";
        // show a welcome message if $_GET['welcomeMessage'] is true:
        if (filter_input(INPUT_GET, "welcomeMessage", FILTER_VALIDATE_BOOLEAN)) {

            echo sprintf(_("Welcome back, <b>%s</b>"), $username)."<br />\n";

        } else {

            echo "<b>".$username."</b><br />\n";

        }
        if ($title !== "User options")
            echo "\t\t\t\t<a href=\"userOptions.php\">".
                _("Options").
                "</a><br />\n";
        echo "\t\t\t\t<a href=\"userLogoutProcess.php\">".
            _("Log Out").
            "</a></p>\n";

    }
    echo "\t\t\t\t<!-- }} login -->\n";

}
// }} login

// sidebar content:

switch ($fileName) {
    
    case "amor.php":
        $amor = new Amor($_SESSION['asideItem']);
        $amor->HTMLAsidePreview();
        break;
    case "amores.php":
        Amor::HTMLAsidePreviewAmores();
        break;
    case "loca.php":
        Locus::HTMLAsidePreviewLoca();
        break;
    case "locus.php":
        $locus = new Locus($_SESSION['asideItem']);
        $locus->HTMLAsidePreview();
        break;
    case "praxis.php":
        $praxis = new Praxis($_SESSION['asideItem']);
        $praxis->HTMLAsidePreview();
        break;
    case "practica.php":
        Praxis::HTMLAsidePreviewPractica();
        break;
}

echo "\t\t\t</aside><!-- }} aside -->\n\n";

?>