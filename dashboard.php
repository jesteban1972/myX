<?php
/*
 * script 'dashboard.php'.
 * 
 * this file is conceived for exclusive use from developer(s)
 * @author Joaquin Javier ESTEBAN MARTINEZ <jesteban1972@me.com>
 * last update: 2018-05-12
*/

require_once 'core.inc';
require_once 'DB.inc';

$title = "myX - dashboard";
$js = "dashboard.js";
include 'header.inc'; // header of all the pages of the app
echo "\t\t\t<section> <!-- section {{ -->\n";

if (isset($_POST['sent'])) {
    
    if (isset($_POST['unsetSession'])) {
        
        session_unset();
        
    }
    
    
}

echo "\t\t\t\t<form id=\"goToForm\" method=\"GET\">\n";
echo "\t\t\t\t\t<fieldset>\n";
echo "\t\t\t\t\t<legend>basic actions</legend>\n";

echo "\t\t\t\t\t\t<input type=\"radio\" id=\"GoToPraxis\" name=\"goTo\" />\n";
echo "\t\t\t\t\t\t<label for=\"GoToPraxis\">Go to experience</label><br />\n";

echo "\t\t\t\t\t\t<input type=\"radio\" id=\"GoToAmor\" name=\"goTo\" />\n";
echo "\t\t\t\t\t\t<label for=\"GoToAmor\">Go to lover</label><br />\n";

echo "\t\t\t\t\t\t<input type=\"radio\" id=\"GoToLocus\" name=\"goTo\" />\n";
echo "\t\t\t\t\t\t<label for=\"GoToLocus\">Go to place</label><br />\n";

echo "\t\t\t\t\t\t<input type=\"text\" id=\"ID\" />\n"; // name added by JS

echo "\t\t\t\t\t\t<input type=\"submit\" value=\"Go\" /><br />\n";
echo "\t\t\t\t\t</fieldset>\n";
echo "\t\t\t\t</form>\n";

echo "\t\t\t\t<form action=\"".$_SERVER['PHP_SELF']."\" method=\"POST\">\n";
echo "\t\t\t\t\t<input type=\"hidden\" name=\"sent\" />\n";
echo "\t\t\t\t\t<input type=\"hidden\" name=\"unsetSession\" />\n";
echo "\t\t\t\t\t<input type=\"submit\" value=\"unset session data\" />\n";
echo "\t\t\t\t</form>\n";

echo "\t\t\t</section> <!-- }} section -->\n\n";
require_once 'footer.inc'; // footer of all the pages of the app

?>