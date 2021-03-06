<?php

/**
 * script userDelete.php
 * contains a message to confirm the deletion of an user
 * @author Joaquin Javier ESTEBAN MARTINEZ <jesteban1972@me.com>
 * last updated 2018-03-25
*/

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    
    $title = _("Delete user");
    include 'header.inc'; // header of all the pages of the app
    echo "\t\t\t<section> <!-- section {{ -->\n";
    
    echo "\t\t\t\t<h1>".
        _("Atention!").
        "</h1>\n";
    echo "\t\t\t\t<p class=\"medium\">".
        _("Are you sure you want to delete your account?").
        "</p>\n";
    echo "\t\t\t\t<p class=\"medium\">".
        _("User info and all associated data will be erased").
        ". ".
        _("This action cannot be undone").
        ".</p>\n";
    
    // the form is echoed:
    
    echo "\t\t\t\t".
        "<form action=\"userDeleteProcess.php\" method=\"POST\">\n";
//    echo "\t\t\t\t\t<input type=\"hidden\" name=\"userID\" value=\"".
//        $_SESSION['userID'].
//        "\" />\n";
    echo "\t\t\t\t\t<input type=\"submit\" value=\"".
        _("Delete User").
        "\" />\n";
    echo "\t\t\t\t\t<input type=\"button\" name=\"cancel\" value=\"".
        _("Cancel").
        "\" onclick=\"javascript: history.back();\" />\n";
    echo "\t\t\t\t</form>\n";
    
    echo "\t\t\t</section> <!-- }} section -->\n";
    require_once 'footer.inc'; // footer of all the pages of the app

} /*else script called from outside the normal flush, redirect to 'index.php'*/

?>