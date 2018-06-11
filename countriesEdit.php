<?php
/**
 * script 'countriesEdit.php'.
 * 
 * script to edit the countries list.
 * 
 * @author Joaquin Javier ESTEBAN MARTINEZ <jesteban1972@me.com>
 * last update: 2018-01-15
 */


require_once 'session.inc';
require_once 'DB.inc';

// get a DB connection to work with:
$pdo = DB::getDBHandle();

$title = _("Edit countries list");

require_once 'header.inc'; // header of all the pages of the app
echo "\t\t\t<section> <!-- section {{ -->\n";

// existing countries:

echo "\t\t\t\t<p>"._("Existing countries:")."</p>\n";

$queryString = <<<QUERY
SELECT `countryID`, `name`
FROM `countries`
WHERE `user`=:userID
ORDER BY `name`
QUERY;

$statement = $pdo->prepare($queryString);
$statement->bindParam(":userID", intval($_SESSION['userID']));
$statement->execute();

echo "\t\t\t\t<form action=\"countriesEditProcess\"". // it does not exist!
    " method=\"POST\" accept-charset=\"utf-8\">\n";
foreach ($statement as $row) {
    
    echo "\t\t\t\t\t\t<input type=\"text\" value=\"".$row['name'].
        "\" /><br />\n";
    
}
echo "\t\t\t\t\t<input type=\"submit\" value=\""._("Save changes")."\" />\n";
echo "\t\t\t\t\t<input type=\"reset\" value=\""._("Discard changes")."\" />\n";
echo "\t\t\t\t</form>\n";

echo "\t\t\t</section> <!-- }} section -->\n\n";
require_once 'footer.inc'; // footer of all the pages of the app

?>