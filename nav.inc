<?php

/* 
 * nav.inc
 * navigation bar for all pages of myX
 * (c) Joaquin Javier ESTEBAN MARTINEZ
 * last update: 2018-01-25
 */

echo "\t\t\t<nav><!-- nav {{ -->\n";

// links to the mains sections:
echo "\t\t\t\t<ul>\n";
echo "\t\t\t\t\t<li><a href=\"index.php\">Home</a></li>\n";
if ((isset($_SESSION['userID'])) &&
    ($_SESSION['userID'] !== -1)) { // user logged in

    echo "\t\t\t\t\t<li><a href=\"practica.php\">"._("Experiences")."</a></li>\n";
    echo "\t\t\t\t\t<li><a href=\"amores.php\">"._("Lovers")."</a></li>\n";
    echo "\t\t\t\t\t<li><a href=\"loca.php\">"._("Places")."</a></li>\n";
    echo "\t\t\t\t\t<li><a href=\"queries.php\">"._("Queries")."</a></li>\n";

} else {
    
    echo "\t\t\t\t\t<li><a href=\"info.php\">Info</a></li>\n";
    
}
echo "\t\t\t\t</ul>\n";

echo "\t\t\t</nav><!-- }} nav -->\n\n";

?>