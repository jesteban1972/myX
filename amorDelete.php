<?php
/**
 * script 'amorDelete.php'.
 * 
 * this script is used previously to the deletion of a lover from the DB.
 * the script displays a warning message
 * about the definitive and irreversible character of this action,
 * and ask the user for confirmation
 * before calling the script 'amorDeleteProcess.php'.
 * although possible, the case use 'Delete lover', should be avoided.
 * the user might not really want to delete the lover,
 * but to edit his/her data instead.
 * please note that the deletion of a lover implies also
 * the deletion of all its associated data (i.e. experiences, places...)
 * because of the constraint 'ON DELETE CASCADE' of the table 'amores'.
 * this constraint guarranties referencial integrity, avoiding that,
 * when lovers get deleted, no unassociate experiences
 * remain in the DB.
 * @author Joaquin Javier ESTEBAN MARTINEZ <jesteban1972@me.com>
 * last updated 2018-05-10
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