<?php

/**
 * script locaQuery.php
 * XXX
 * (c) Joaquin Javier ESTEBAN MARTINEZ
 * last updated 2018-04-06
*/



require_once 'core.inc';
//require_once 'DB.inc';
//require_once 'praxis.inc';
//require_once 'amor.inc';
//require_once 'locus.inc';

// get a DB connection to work with:
//$pdo = DB::getDBHandle();


$title = "myX - Query Places";
$js = "locaQuery.js";

if ($_SERVER['REQUEST_METHOD'] !== "POST") {
    // script called from outside the normal flush, throw exception

    
}
    
    
/*
 * we first check if button 'remove filter' have been pressed in
 * 'loca.php', in which case $_SESSION['amoresList] will be unset
 */

if (isset($_POST['removeFilter'])) {

    unset($_SESSION['locaQuery']);

    // redirect to 'loca.php':
    header("Location: loca.php");

}
    
//    if (isset($_POST['sent']) && intval($_POST['sent']) === 1) { // form already sent
//
//        $designation = "Filtered query";
//        $description = "Filtered query";
//        $queryString = "SELECT * FROM `myX`.`loca`";
//
//
//        $queryString .= " WHERE ".$_POST['ruleField'];
//
//        switch ($_POST['ruleCriterion']) {
//
//            case "contains":
//                $queryString .= " LIKE '%".$_POST['ruleString']."%'";
//                break;
//            case "doesNotContain":
//                $queryString .= " NOT LIKE '%".$_POST['ruleString']."%'";
//                break;
//            case "is":
//                $queryString .= " LIKE ".$_POST['ruleString'];
//                break;
//            case "isNot":
//                $queryString .= " NOT LIKE ".$_POST['ruleString'];
//                break;
//            case "beginsWith":
//                $queryString .= " LIKE '".$_POST['ruleString']."%'";
//                break;
//            case "endsWith":
//                $query .= " LIKE '%".$_POST['ruleString']."'";
//                break;
//
//        }
//            
//        // include only the data of the current user:
//        $queryString .= " AND `user`=".$_SESSION['userID'];
//
//        $locaQuery = new LocaQuery($designation, $description, $queryString);
//
//        // saves current list to $_SESSION:
//        $_SESSION['locaQuery'] = $locaQuery;
//
//        // redirect to 'amores.php':
//        header("Location: loca.php");

        
include 'header.inc'; // header of all the pages of the app
echo "\t\t\t<section> <!-- section {{ -->\n";

echo <<<HTML
                <!-- script locaFilter.php -->
                <article id="start">

HTML;

/*
 * one or more rules are set to query the table 'loca'.
 * each one of this rules consist in three parts:
 * 
 * i) a rule field, which is the field taken in consideration in the rule
 * (v.gr. name).
 * 
 * ii) a rule criterion, which is the criterion applied over the field
 * (v.gr. contains). this criterion will be 'translated' in the SQL query
 * (v.gr. 'contains' becomes LIKE '% ... %')
 * 
 * iii) a rule string, the value against which the value of the field
 * is evaluated using the selected criterion (if e.g. string 'kk' is used
 * with field 'name' and criterion 'contains', the resulting rule is
 * [SELECT... WHERE] name LIKE '%kk%').
 */

// query form is echoed:
        
echo "\t\t\t\t\t<form id=\"form\" action=\"locaQueryProcess.php\"".
    " method=\"POST\" accept-charset=\"utf-8\">\n";
echo "\t\t\t\t\t\t<fieldset id=\"rules\">\n";
echo "\t\t\t\t\t\t\t<legend>"._("Find places where:")."</legend>\n";

/*
 * the rule with index 0 is displayed on page loading,
 * while the rest of rules are built dynamically
 * using JavaScript with DOM methods
 */

/*
 * ruleFields are, in each rule, the field against which
 * the results are being queried
 */

echo "\t\t\t\t\t\t\t<select name=\"ruleFields[0]\" id=\"ruleFields[0]\">\n";
echo "\t\t\t\t\t\t\t\t<option value=\"name\">"._("Name")."</option>\n";
echo "\t\t\t\t\t\t\t\t<option value=\"country\">"._("Country")."</option>\n";
echo "\t\t\t\t\t\t\t\t<option value=\"kind\">"._("Kind")."</option>\n";
echo "\t\t\t\t\t\t\t\t<option value=\"description\">"._("Description").
    "</option>\n";
echo "\t\t\t\t\t\t\t\t<option value=\"rating\">"._("Rating")."</option>\n";
echo "\t\t\t\t\t\t\t\t<option value=\"address\">"._("Address")."</option>\n";
echo "\t\t\t\t\t\t\t\t<option value=\"coordinatesExact\">".
    _("Exact coordinates")."</option>\n";
echo "\t\t\t\t\t\t\t\t<option value=\"coordinatesGeneric\">".
    _("Generic coordinates")."</option>\n";
echo "\t\t\t\t\t\t\t\t<option value=\"www\">"._("WWW")."</option>\n";
echo "\t\t\t\t\t\t\t\t<option value=\"locusID\">"._("Place ID")."</option>\n";
echo "\t\t\t\t\t\t\t</select>\n";

/*
 * ruleCriteria are the criteria applied in each rule
 * between a DB field and the value against which is evaluated.
 * the possible values of ruleCriterion differ
 * depending of the field's kind considered (string, number, date, bool).
 * the following are the possible criteria for the first field,
 * which is of type string.
 */

echo "\t\t\t\t\t\t\t<select name=\"ruleCriteria[0]\">\n";
echo "\t\t\t\t\t\t\t\t<option value=\"contains\">"._("contains")."</option>\n";
echo "\t\t\t\t\t\t\t\t<option value=\"doesNotContain\">"._("does not contain").
    "</option>\n";
echo "\t\t\t\t\t\t\t\t<option value=\"isString\">"._("is")."</option>\n";
echo "\t\t\t\t\t\t\t\t<option value=\"isNotString\">"._("is not")."</option>\n";
echo "\t\t\t\t\t\t\t\t<option value=\"beginsWith\">"._("begins with").
    "</option>\n";
echo "\t\t\t\t\t\t\t\t<option value=\"ends with\">"._("endsWith")."</option>\n";
echo "\t\t\t\t\t\t\t</select>\n";

/*
 * ruleStrings are the strings used to specify the restriction.
 * usually only a string is required,
 * but in certain occasions two values are needed.
 */

echo "\t\t\t\t\t\t\t<input type=\"text\" name=\"ruleStrings[0]\" />\n";

/*
 * at the end of each rule there is a plus button and,
 * when there are more than one rule, also a minus button.
 * they are used to add a new rule to the query or remove one rule from it.
 * their functionality is accomplished with JavaScript.
 */

echo "\t\t\t\t\t\t\t<button type=\"button\" id=\"addRule[0]\">+</button>\n";
echo "\t\t\t\t\t\t\t<button type=\"button\" id=\"removeRule[0]\">-</button>\n";

echo "\t\t\t\t\t\t</fieldset>\n";

echo "\t\t\t\t\t\t<input type=\"submit\" value=\""._("Submit data")."\" />\n";
echo "\t\t\t\t\t\t<input type=\"button\" name=\"cancel\" value=\""._("Cancel").
    "\" onclick=\"javascript: history.back();\" />\n";
echo "\t\t\t\t\t\t<input type=\"hidden\" name=\"sent\" value=\"1\" />\n";
echo "\t\t\t\t\t</form>\n";

echo "\t\t\t\t</article>\n";

echo "\t\t\t</section> <!-- }} section -->\n\n";
require_once 'footer.inc'; // footer of all the pages of the app

?>
