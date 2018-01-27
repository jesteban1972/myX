<?php

/**
 * script amorDelete.php
 * contains the form to confirm the deletion of a lover
 * (c) Joaquin Javier ESTEBAN MARTINEZ
 * last updated 2018-01-23
*/

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    
    $title = _("Delete lover");
    include 'header.inc'; // header of all the pages of the app
    echo "\t\t\t<section> <!-- section {{ -->\n";
    
    echo "\t\t\t\t<h1>".
        _("Atention!").
        "</h1>\n";
    echo "\t\t\t\t<p>".
        _("Are you sure you want to delete the current lover?").
        "</p>\n";
    echo "\t\t\t\t<p>".
        _("Lover details and its associated data will be erased").
        ". ".
        _("This action cannot be undone").
        ".</p>\n";
    
    // the form is echoed:

    echo "\t\t\t\t".
        "<form action=\"amorDeleteProcess.php\" method=\"POST\">\n";
    echo "\t\t\t\t\t<input type=\"hidden\" name=\"amorID\" value=\"".
        $_POST['amorID'].
        "\" />\n";
    echo "\t\t\t\t\t<input type=\"submit\" value=\"".
        _("Delete lover").
        "\" />\n";
    echo "\t\t\t\t\t<input type=\"button\" name=\"cancel\" value=\"".
        _("Cancel").
        "\" onclick=\"javascript: history.back();\" />\n";
    echo "\t\t\t\t</form>\n";
    
    echo "\t\t\t</section> <!-- }} section -->\n";
    require_once 'footer.inc'; // footer of all the pages of the app

} /*else script called from outside the normal flush, throw exception*/

?>