<?php

/* 
 * aside.inc
 * sidebar for all pages of myX
 * (c) Joaquin Javier ESTEBAN MARTINEZ
 * last update: 2018-01-10
 */

require_once 'session.inc';
require_once 'user.inc';

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

// the current userID is retrieved from $_SESSION (intval not??? needed)
$userID = $_SESSION['userID'];

// divide the URL in parts in order to filter actions according with $fileName:
$resourceParts = explode('/', $_SERVER['PHP_SELF']); // SCRIPT_NAME, SCRIPT_FILENAME
$fileName = end($resourceParts); // alternatively: $file_name = $resource_parts[count($URL_parts) - 1]

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

echo "\t\t\t</aside><!-- }} aside -->\n\n";

//require_once("core.inc");
//require_once("user.inc");
//
//session_start();
//
//// display the site's main options:
//echo <<<HTML
//                <div id="aside"> <!-- sidebar {{ -->
//                    <aside>
//                        <img src="pictures/_pndnct_logo.jpg" />
//                        <ul class="sidebar0">
//                            <li><a href="index.php">HOME</a></li>
//                            <li><a href="about.php">INFORMATIONES</a></li>
//                            <li><a href="sarkika_analekta.php">ΣΑΡΚΙΚΑ ΑΝΑΛΕΚΤΑ</a></li>
//                            <ul class="sidebar1">
//                                <li><a href="xperiencesCatalogueProcess.php">PRACTICA - QVOD</a></li>
//                                <li><a href="lovers_catalogue_process.php">AMORES - CVM QVIBUS</a></li>
//                                <li><a href="places_catalogue_process.php">LOCA - VBI</a></li>
//                                <li><a href="statistics_n_querys.php">στατιστικαί ϰ ἀναζητήσεις</a></li>
//                            </ul>
//                            <li><a href="contact.php">COMMUNICATIO</a></li>
//                        </ul>
//
//HTML;
//
//// retrieve user ID from $_SESSION:
//if (!isset($_SESSION['userID'])) {
//    
//    $_SESSION['userID'] = -1; // not logged in
//    
//}
//
//$currentUser = new User(intval($_SESSION['userID']));
//
//if (DEBUG) {
//        
//    echo " <span class=\"debug\">[user ID: ";
//    echo $_SESSION['userID'];
//    echo "]</span>\n";
//
//}
//
//// divide the URL in parts in order to filter action after $fileName:
//$resourceParts = explode('/', $_SERVER['PHP_SELF']); // SCRIPT_NAME, SCRIPT_FILENAME
//$fileName = end($resourceParts); // alternatively: $file_name = $resource_parts[count($URL_parts) - 1]
//
//switch ($fileName) {
//    
//    /**
//     * index.php
//     * displays a ...
//     */
//    case "index.php":
//        
//        if ($_SESSION['userID'] !== -1) { // user logged in
//            
//            $username = $currentUser->usernameFromUserID(intval($_SESSION['userID']));
//            
//            echo <<<HTML
//                        <h1>welcome back, {$username}</h1>
//                        <p>(<a href="logout_process.php">log out</a>)</p>
//
//HTML;
//            
//        } else { // user not logged in
//        
//            echo <<<HTML
//                        <h1>εἴσοδος μελῶν</h1>
//                        <form action="login_process.php" method="POST">
//                            <p>χρήστης: <input type="text" name="username" /></p>
//                            <p>μυστικὸς κώδηξ: <input type="password" name="password" /></p>
//                            <p align="right"><input type="checkbox" name="remember_user" />μνήσθητί μου</p>
//                            <p><input type="submit" value="Login" /></p>
//                        </form>
//                        <p>δὲν εἶσαι χρήστης; <a href="sign_up.php">ἀπόκτησεν λογαριασμόν</a> (<a href="info_users.php">πληροφορίαι</a>).</p>
//
//HTML;
//        } // if-else block
//        
//        break;
//    
//    case "xperience.php":
//        $xperienceSideview = $_SESSION['xperienceSideview'];
//        echo $xperienceSideview;
//        echo "\n";
//        break;
//    
//    case "lover.php":
//    
//        $loverSideview = $_SESSION['loverSideview'];
//        echo $loverSideview;
//        echo "\n";
//        break;
//    
//    case "places_catalogue.php":
//    
//        echo "<p>LOCA ἤτοι τόποι</p>\n";
//        echo "<a href=\"places_map.php\"><img src=\"images/charta.jpg\" /></a>\n";
//        break;
//    
//    case "place.php":
//        //echo "<p>LOCUS ἤτοι τόπος</p>\n";
//        $placeSideview = $_SESSION['placeSideview'];
//        echo $placeSideview;
//        echo "\n";
//        break;
//    
//} // switch block
//
//echo <<<HTML
//                    </aside>
//                </div> <!-- }} sidebar -->
//
//HTML;

?>