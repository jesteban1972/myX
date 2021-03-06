<?php

/**
 * script amoresFilter.php
 * XXX
 * @author Joaquin Javier ESTEBAN MARTINEZ <jesteban1972@me.com>
 * last updated 2018-04-06
*/

require_once 'core.inc';
//require_once 'DB.inc';
//require_once 'praxis.inc';
//require_once 'amor.inc';
//require_once 'locus.inc';

// get a DB connection to work with:
//$pdo = DB::getDBHandle();


$title = "myX - Query Lovers";
$js = "amoresFilter.js";

if ($_SERVER['REQUEST_METHOD'] !== "POST") {
    
    // script called from outside the normal flush, redirect to 'index.php':
    $_SESSION['notification'] = _("Unable to load the required page");
    header ("Location: index.php");
    
}
    
/*
 * we first check if button 'remove filter' have been pressed in
 * 'amores.php', in which case $_SESSION['amoresList] will be unset
 */
if (isset($_POST['removeFilter'])) {

    unset($_SESSION['amoresQuery']);

    // redirect to 'amores.php':
    header("Location: amores.php");

}
        
include 'header.inc'; // header of all the pages of the app
echo "\t\t\t<section> <!-- section {{ -->\n";

echo <<<HTML
                <!-- script amoresFilter.php -->
                <article id="start">

HTML;

/*
 * one or more rules are set to query the table 'amores'.
 * each one of this rules consist in three parts:
 * 
 * i) a rule field, which is the field taken in consideration in the rule
 * (v.gr. alias).
 * 
 * ii) a rule criterion, which is the criterion applied over the field
 * (v.gr. contains). this criterion will be 'translated' in the SQL query
 * (v.gr. 'contains' becomes LIKE '% ... %')
 * 
 * iii) a rule string, the value against which the value of the field
 * is evaluated using the selected criterion (if e.g. string 'kk' is used
 * with field 'name' and criterion 'contains', the resulting rule is
 * [SELECT... WHERE] alias LIKE '%kk%').
 */

// query form is echoed:
        
echo "\t\t\t\t\t<form id=\"form\" action=\"amoresFilterProcess.php\"".
    " method=\"POST\" accept-charset=\"utf-8\">\n";
echo "\t\t\t\t\t\t<fieldset id=\"rules\">\n";
echo "\t\t\t\t\t\t\t<legend>"._("Find lovers where:")."</legend>\n";

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
echo "\t\t\t\t\t\t\t\t<option value=\"alias\">"._("Alias")."</option>\n";
echo "\t\t\t\t\t\t\t\t<option value=\"genre\">"._("Genre")."</option>\n";
echo "\t\t\t\t\t\t\t\t<option value=\"descr1\">"._("Description 1").
    "</option>\n";
echo "\t\t\t\t\t\t\t\t<option value=\"descr2\">"._("Description 2").
    "</option>\n";
echo "\t\t\t\t\t\t\t\t<option value=\"descr3\">"._("Description 3").
    "</option>\n";
echo "\t\t\t\t\t\t\t\t<option value=\"descr4\">"._("Description 4").
    "</option>\n";
echo "\t\t\t\t\t\t\t\t<option value=\"rating\">"._("Rating")."</option>\n";
echo "\t\t\t\t\t\t\t\t<option value=\"web\">"._("Web")."</option>\n";
echo "\t\t\t\t\t\t\t\t<option value=\"name\">"._("Name")."</option>\n";
echo "\t\t\t\t\t\t\t\t<option value=\"photo\">"._("Photo")."</option>\n";
echo "\t\t\t\t\t\t\t\t<option value=\"phone\">"._("Telephone").
    "</option>\n";
echo "\t\t\t\t\t\t\t\t<option value=\"email\">"._("Email")."</option>\n";
echo "\t\t\t\t\t\t\t\t<option value=\"other\">"._("Other")."</option>\n";
echo "\t\t\t\t\t\t\t\t<option value=\"amorID\">"._("Lover ID")."</option>\n";
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
echo "\t\t\t\t\t\t\t\t<option value=\"isString\">"._("is").
    "</option>\n";
echo "\t\t\t\t\t\t\t\t<option value=\"isNotString\">"._("is not").
    "</option>\n";
echo "\t\t\t\t\t\t\t\t<option value=\"beginsWith\">"._("begins with").
    "</option>\n";
echo "\t\t\t\t\t\t\t\t<option value=\"ends with\">"._("endsWith").
    "</option>\n";
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
