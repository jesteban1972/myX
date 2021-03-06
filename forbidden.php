<?php
/**
 * script 'forbidden.php'.
 * 
 * contains a message "access forbidden"
 * @author Joaquin Javier ESTEBAN MARTINEZ <jesteban1972@me.com>
 * last updated 2018-03-25
*/

    
    $title = _("Access forbidden");
    include 'header.inc'; // header of all the pages of the app
    echo "\t\t\t<section> <!-- section {{ -->\n";
    
    echo "\t\t\t\t<h1>".
        _("403 Forbidden").
        "</h1>\n";
    echo "\t\t\t\t<p class=\"large\">".
        _("We are sorry, but the access to this page is not allowed").
        ".</p>\n";
    echo "\t\t\t\t<p  class=\"medium\"><a href=\"index.php\">".
        _("Click here to go to the start page").".</a></p>\n";
    // "Get back or visit our home page"?
   
    
    echo "\t\t\t</section> <!-- }} section -->\n";
    require_once 'footer.inc'; // footer of all the pages of the app

?>