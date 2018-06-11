<?php

/**
 * script praxisDelete.php
 * contains the form to confirm the deletion of an experience
 * @author Joaquin Javier ESTEBAN MARTINEZ <jesteban1972@me.com>
 * last updated 2018-01-23
*/

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    
    $title = _("Delete experience");
    include 'header.inc'; // header of all the pages of the app
    echo "\t\t\t<section> <!-- section {{ -->\n";
    
    echo "\t\t\t\t<h1>".
        _("Atention!").
        "</h1>\n";
    echo "\t\t\t\t<p class=\"medium\">".
        _("Are you sure you want to delete the current experience?")." ".
        _("(you might want to edit its data instead).").
        "</p>\n";
    echo "\t\t\t\t<p class=\"medium\">".
        _("Experience details and its associated data will be erased").
        ". ".
        _("This action cannot be undone").
        ".</p>\n";
    
    // the form is echoed:

    echo "\t\t\t\t".
        "<form action=\"praxisDeleteProcess.php\" method=\"POST\">\n";
    echo "\t\t\t\t\t<input type=\"hidden\" name=\"praxisID\" value=\"".
        $_POST['praxisID'].
        "\" />\n";
    echo "\t\t\t\t\t<input type=\"submit\" value=\"".
        _("Delete experience").
        "\" />\n";
    echo "\t\t\t\t\t<input type=\"button\" name=\"cancel\" value=\"".
        _("Cancel").
        "\" onclick=\"javascript: history.back();\" />\n";
    echo "\t\t\t\t</form>\n";
    
    echo "\t\t\t</section> <!-- }} section -->\n";
    require_once 'footer.inc'; // footer of all the pages of the app

} /*else script called from outside the normal flush, redirect to 'index.php'*/

?>