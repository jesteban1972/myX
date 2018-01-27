<?php

/* 
 * header.inc
 * script with the header of all pages
 * (c) Joaquin Javier ESTEBAN MARTINEZ
 * last update: 2018-01-06
 */

require_once 'session.inc';
require_once 'core.inc';
//require_once 'user.inc';

/*
 * GUI language:
 * independently of the configuration with $_SESSION or $_COOKIE,
 * the GUI language is set if received by POST
 * (clicking on the language abbreviations):
 */
if (isset($_POST['GUILang'])) {
    
    switch ($_POST['GUILang']) {
        
        case "es":
            $_SESSION['options']['GUILang'] = GUI_SPANISH;
            break;
        case "el":
            $_SESSION['options']['GUILang'] = GUI_GREEK;
            break;
        default:
            $_SESSION['options']['GUILang'] = GUI_ENGLISH;            
        
    }
    
}

/*
 * other app initializations
 */
if (!isset($_COOKIE['userOptions'])) {
    
    if (!isset($_SESSION['options']['GUILang']))
        $_SESSION['options']['GUILang'] = GUI_ENGLISH; // default value
    
    $_SESSION['options']['resultsPerPage'] = 25; // default value
    
} else {
    
    if (!isset($_SESSION['options']['GUILang']))
        $_SESSION['options']['GUILang'] = intval($_COOKIE['userOptions']['GUILang']);
    
    $_SESSION['options']['resultsPerPage'] = intval($_COOKIE['userOptions']['resultsPerPage']);
    
}

// initialize gettext:
GUILangInitialize($GUILangCodes[$_SESSION['options']['GUILang']]);

echo <<<HTML
<!DOCTYPE html>
    <head>
        <meta charset="utf-8" />
        <meta name="description" content="{$description}" />
        <meta name="author" content="Joaquin Javier ESTEBAN MARTINEZ" />
        <title>{$title}</title>
        <link rel="stylesheet" type="text/css" href="stylesheets/default.css" />

HTML;
        
if(isset($mapAPI)) {
    
    echo "\t\t<script type=\"text/javascript\" src=\"https://maps.googleapis.com/maps/api/js?key=AIzaSyCzoiaEvQUJDVxv8f_7eA_IgbcO6cJnftc&sensor=false\"></script> <!-- Google Maps API -->\n";
    echo "\t\t<script type=\"text/javascript\" src=\"locaMap.js\"></script> <!-- JavaScript code -->\n";

}
echo <<<HTML
    </head>
    <body>  
        <div id="container"><!-- div container 1024x768 px {{ -->
        
            <header><!-- header {{ -->

HTML;

// <div id="title"> {{
echo "\t\t\t\t<div id=\"title\"><!-- div title {{ -->\n";
echo "\t\t\t\t\t<h1>".$title."</h1>\n";
echo "\t\t\t\t</div><!-- }} div title -->\n";
// }} </div> title

// <div id="GUILangs"> {{
echo "\t\t\t\t<div id=\"GUILangs\" style=\"position: absolute; right: 0%;\"><!-- div GUILangs {{ -->\n";
echo "\t\t\t\t\t<form action=\"".$_SERVER['PHP_SELF']."\" method=\"POST\">\n";
                
echo "\t\t\t\t\t\t<select name=\"GUILang\" onchange=\"this.form.submit();\">\n";

// English:
echo "\t\t\t\t\t\t\t<option value=\"en\"";
if ($_SESSION['options']['GUILang'] === GUI_ENGLISH)
    echo " selected=\"selected\"";
echo ">English</option>\n";

// Spanish:
echo "\t\t\t\t\t\t\t<option value=\"es\"";
if ($_SESSION['options']['GUILang'] === GUI_SPANISH)
    echo " selected=\"selected\"";
echo ">Español</option>\n";

// Greek:
echo "\t\t\t\t\t\t\t<option value=\"el\"";
if ($_SESSION['options']['GUILang'] === GUI_GREEK)
    echo " selected=\"selected\"";
echo ">Ελληνικά</option>\n";
echo "\t\t\t\t\t\t</select>\n";

echo "\t\t\t\t\t</form>\n";
echo "\t\t\t\t</div><!-- }} div GUILangs -->\n";
// }} <div id="GUILangs">

echo "\t\t\t</header><!-- }} header -->\n\n";

require_once 'nav.inc';

?>