<?php
/**
 * script 'statistics.php'.
 * 
 * displays graphs
 * (c) Joaquin Javier ESTEBAN MARTINEZ
 * last updated 2019-01-05
*/

require_once 'core.inc';
require_once 'DB.inc';


// get a DB connection to work with:
$pdo = DB::getDBHandle();

// page header:
$title = "myX - Statistics";
$js = "statistics.js";
$charts = true;
require_once 'header.inc'; // header of all the pages of the app
echo "\t\t\t<section> <!-- section {{ -->\n";

echo <<<HTML
                <!-- Script statistics.php. Part 0: XXXDescription of the listXXX -->
                <article id="start">

HTML;

echo "\t\t\t\t\t<p class=\"medium\">I. Experiences per year</p>\n";

//echo "\t\t\t\t\t<p class=\"medium\"><img src=\"".getImage("praxis", "small").
//    "\" alt=\""._("(Image of a gold coin)")."\" /> <b>"._($designation).
//    "</b>: "._($description)." ";

echo "\t\t\t\t\t<div id=\"chartdiv\" style=\"width: 100%; height: 500px;\"></div>\n";

echo "\t\t\t\t\t<p class=\"medium\">I. Experiences per month</p>\n";
echo "\t\t\t\t\t<div id=\"chartdiv2\" style=\"width: 100%; height: 500px;\"></div>\n";

echo "\t\t\t\t\t<p class=\"medium\">I. Experiences per month (pie chart)</p>\n";
echo "\t\t\t\t\t<div id=\"chartdiv3\" style=\"width: 100%; height: 500px;\"></div>\n";

// link to top of the page:
echo "\t\t\t\t\t<p style=\"text-align: center;\"><img src=\"images/arrow_top.gif\" /> <a href=\"#start\">".
    _("Back to top").
    "</a></p>\n";

echo <<<HTML
                </article>

HTML;

echo <<<HTML
                <!-- Script queries.php. Part ii: Actions -->
                <article id="actions">
                    <h1>Actions</h1>

HTML;


// link to previous page:
echo "\t\t\t\t\t<p style=\"text-align: center;\">".
    "<img src=\"images/arrow_back.gif\" />".
    " <a href=\"javascript: history.back();\">".
    _("Back to previous").
    "</a></p>\n";

echo "\t\t\t\t</article>\n";

echo "\t\t\t</section> <!-- }} section -->\n\n";

// 'sidebar.inc':
//$_SESSION['asideItem'] = null;

require_once 'footer.inc'; // footer of all the pages of the app