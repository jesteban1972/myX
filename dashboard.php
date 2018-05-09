<?php
/*
 * script 'dashboard.php'.
 * 
 * this file is conceived for exclusive use from developer(s)
 * (c) Joaquin Javier ESTEBAN MARTINEZ
 * last update: 2018-05-08
*/

require_once 'core.inc';
require_once 'DB.inc';

$title = "myX - dashboard";
include 'header.inc'; // header of all the pages of the app
echo "\t\t\t<section> <!-- section {{ -->\n";

if (isset($_POST['sent'])) {
    
    if (isset($_POST['unsetSession'])) {
        
        session_unset();
        
    }
    
    
}

echo "\t\t\t\t<form action=\"".$_SERVER['PHP_SELF']."\" method=\"POST\">\n";
echo "\t\t\t\t\t<input type=\"hidden\" name=\"sent\" />\n";
echo "\t\t\t\t\t<input type=\"hidden\" name=\"unsetSession\" />\n";
echo "\t\t\t\t\t<input type=\"submit\" value=\"unset session data\" />\n";
echo "\t\t\t\t</form>\n";

echo "\t\t\t</section> <!-- }} section -->\n\n";
require_once 'footer.inc'; // footer of all the pages of the app

?>