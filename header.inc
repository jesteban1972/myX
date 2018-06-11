<?php
/** 
 * script 'header.inc'.
 * 
 * script with the header of all pages of the app.
 * 
 * @author Joaquin Javier ESTEBAN MARTINEZ <jesteban1972@me.com>
 * last update: 2018-04-21
 */

require_once 'core.inc';
require_once 'user.inc';
require_once 'praxis.inc';

/*
 * initialization of userOptions and navigationOptions:
 * user and navigation options are read:
 * i) from $_SESSION (if any)
 * iii) from the DB, if not set in $_SESSION
 * iii) GUILang set from $_POST, if set.
 */

if ((isset($_SESSION['userID']) && ($_SESSION['userID'] !== -1))) { // user logged in
    
    $navOptions = User::getNavOptions();
    
    if ($navOptions['GUILang'] !== null/* &&
        !isset($_SESSION['navOptions']['GUILang'])*/)
            $_SESSION['navOptions']['GUILang'] = $navOptions['GUILang'];
    
    if ($navOptions['resultsPerPage'] !== null)
        $_SESSION['navOptions']['resultsPerPage'] =
            $navOptions['resultsPerPage'];
    if ($navOptions['listsOrder'] !== null)
        $_SESSION['navOptions']['listsOrder'] =
            $navOptions['listsOrder'];
            
    $userOptions = User::getUserOptions();
    
    if ($userOptions['defaultGenre'] !== null)
        $_SESSION['userOptions']['defaultGenre'] = $userOptions['defaultGenre'];
    if ($userOptions['descr1'] !== null)
        $_SESSION['userOptions']['descr1'] = $userOptions['descr1'];
    if ($userOptions['descr2'] !== null)
        $_SESSION['userOptions']['descr2'] = $userOptions['descr2'];
    if ($userOptions['descr3'] !== null)
        $_SESSION['userOptions']['descr3'] = $userOptions['descr3'];
    if ($userOptions['descr4'] !== null)
        $_SESSION['userOptions']['descr4'] = $userOptions['descr4'];
    
    /*
    * set $_SESSION[DBStatus]['doPracticaExist'] to check
    * if there are any experiences yet
    * and consequently any lover(s), place(s), countri(es) and kind(s).
    */

   if (!isset($_SESSION['DBStatus']['doPracticaExist'])) {
       
       if (Praxis::getPracticaAmount() > 0) {
           
           $_SESSION['DBStatus']['doPracticaExist'] = true;
           
        }

    } else {
        
        if (Praxis::getPracticaAmount() === 0) {
            
            unset($_SESSION['DBStatus']['doPracticaExist']);
            
        }
        
    }
            
} else { // user not logged in, use defaults
    
    $_SESSION['navOptions']['GUILang'] = GUI_ENGLISH;
    $_SESSION['navOptions']['resultsPerPage'] = 25;
    $_SESSION['navOptions']['listsOrder'] = OLDEST_TO_NEWEST;
    
}

/*
 * GUI language: independently of the above configuration,
 * GUILang is set if received by POST (i.e. changing the language dropbox).
 */
if (isset($_POST['GUILang'])) {
    
    switch ($_POST['GUILang']) {
        
        case "es":
            
            $_SESSION['navOptions']['GUILang'] = GUI_SPANISH;
            break;
        
        case "el":
            
            $_SESSION['navOptions']['GUILang'] = GUI_GREEK;
            break;
        
        default:
            
            $_SESSION['navOptions']['GUILang'] = GUI_ENGLISH;            
        
    }
    
}

// initialize gettext:
GUILangInitialize($GUILangCodes[$_SESSION['navOptions']['GUILang']]);

// the top of the page is echoed:

echo "<!DOCTYPE html>\n";
echo "<html>\n";
echo "\t<head>\n";
echo "\t\t<meta charset=\"utf-8\" />\n";
echo "\t\t<meta name=\"description\" content=\"".$description."\" />\n";
echo "\t\t<meta name=\"author\"".
    " content=\"Joaquin Javier ESTEBAN MARTINEZ\" />\n";
echo "\t\t<title>"._($title)."</title>\n";

if (isset($js)) {
    
    echo "\t\t<script type=\"text/javascript\" src=\"".$js.
        "\"></script> <!-- JavaScript code -->\n";
    
}

if (isset($mapAPI)) {
    
    echo "\t\t<script type=\"text/javascript\" src=\"https://maps.googleapis.com/maps/api/js?key=AIzaSyCzoiaEvQUJDVxv8f_7eA_IgbcO6cJnftc&sensor=false\"></script> <!-- Google Maps API -->\n";
    
}

/*
 * if current script is 'index.php' include additional bootstrap JS and CSS
 * for the slider:
 */

if (end(explode('/', $_SERVER['PHP_SELF'])) === "index.php") {
    // additional JS and stylesheets for the slider
    
    echo <<<HTML
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet"/>
        <style>
            .HTMLPreview {
                position: absolute;
                display: inline-block;
                width: 90%;
                top: 50%;
                transform: translateY(-50%);
            }
        </style>

HTML;
    
}

echo "\t\t<link rel=\"stylesheet\" type=\"text/css\"".
    " href=\"stylesheets/default.css\" />\n";
echo "\t</head>\n";
echo "\t<body>\n";
echo "\t\t<div id=\"container\"><!-- div container 1024x768 px {{ -->\n\n";
echo "\t\t\t<header><!-- header {{ -->\n";

// <div id="title"> {{
echo "\t\t\t\t<div id=\"title\"><!-- div title {{ -->\n";
echo "\t\t\t\t\t<h1>".$title."</h1>\n";
echo "\t\t\t\t</div><!-- }} div title -->\n";
// }} </div> title

// <div id="GUILangs"> {{
echo "\t\t\t\t<div id=\"GUILangs\" style=\"position: absolute; right: 0%;\">".
    "<!-- div GUILangs {{ -->\n";

// parameters are retrieved from $_GET in case GUI language changes:
$getString = "";
if (sizeof($_GET) > 0) {
    
    $getString .= "?";
    
}
foreach ($_GET as $key => $value) {
    
    $getString .= $key."=".$value;
    
}

// GUI language form is echoed:

echo "\t\t\t\t\t<form action=\"".$_SERVER['PHP_SELF'].$getString.
    "\" method=\"POST\">\n";
                
echo "\t\t\t\t\t\t<select name=\"GUILang\" onchange=\"this.form.submit();\">\n";

// English:
echo "\t\t\t\t\t\t\t<option value=\"en\"";
if ($_SESSION['navOptions']['GUILang'] === GUI_ENGLISH) {
    
    echo " selected=\"selected\"";
    
}
echo ">English</option>\n";

// Spanish:
echo "\t\t\t\t\t\t\t<option value=\"es\"";
if ($_SESSION['navOptions']['GUILang'] === GUI_SPANISH) {
    
    echo " selected=\"selected\"";
    
}
echo ">Español</option>\n";

// Greek:
echo "\t\t\t\t\t\t\t<option value=\"el\"";
if ($_SESSION['navOptions']['GUILang'] === GUI_GREEK) {
    
    echo " selected=\"selected\"";
    
}
echo ">Ελληνικά</option>\n";
echo "\t\t\t\t\t\t</select>\n";

echo "\t\t\t\t\t</form>\n";
echo "\t\t\t\t</div><!-- }} div GUILangs -->\n";
// }} <div id="GUILangs">

echo "\t\t\t</header><!-- }} header -->\n\n";

require_once 'nav.inc';

?>