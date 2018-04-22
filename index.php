<?php
/** 
 * script 'index.php'.
 * 
 * home script of the app
 * (c) Joaquin Javier ESTEBAN MARTINEZ
 * last update: 2018-01-16
 */

require_once 'core.inc';
//require_once 'user.inc';

// title to be displayed in the corresponding browser tab:
$title = "myX - Home";
$js = "index.js";

// description for the homonyme meta tag in the head section of the HTML file:
$description = "Homepage of myX";

require_once 'header.inc'; // header of all the pages of the app
echo "\t\t\t<section> <!-- section {{ -->\n";

echo <<<HTML
                <p class="quote">«Me rappellant les plaisirs que j'eus je me les renouvelle,<br />
                et je vis des peines que j'ai enduré, et que je ne sens plus»<br />
                (Giacomo Casanova, Histoire de ma vie, Préface)</p>

HTML;

if (!isset($_SESSION['userID']))
    echo "\t\t\t\t\t<p class=\"large\"><b>"._("Welcome to myX!")."</b></p>\n";

echo <<<HTML
                <p class="medium">«<cite>By recollecting the pleasures I have had formerly, I renew them, I enjoy them a second time</cite>», wrote once Casanova.<br />
                There's no need to be a famous libertine. If you also feel pleasure remembering your sexual life, the web application <b>myX</b> is conceived to make your life easier:<br />
                With the multilingual user interface, you can record your <b>experiences</b>, with the detail level you choose, in order to remember them everytime you want.<br />
                Along with the experiences, you'll remember also your <b>lovers</b>. You could easily query your data.<br />
                Last but not least, having your <b>places</b> well arranged will allow you to surf through them in a map.</p>

HTML;

if (DEBUG) {
    
    echo "\t\t\t\t<div id=\"sessionViewer\"><h1>session status</h1>\n".
        "\t\t\t\t\t<pre>";
    print_r($_SESSION);
    echo "</pre>\n\t\t\t\t</div>\n";
//    echo "<span class=\"debug\">session: ".var_dump($_SESSION)."</span>";
}

echo "\t\t\t</section> <!-- }} section -->\n\n";
require_once 'footer.inc'; // footer of all the pages of the app

?>