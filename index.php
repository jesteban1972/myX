<?php
/** 
 * script 'index.php'.
 * 
 * home script of the app
 * (c) Joaquin Javier ESTEBAN MARTINEZ
 * last update: 2018-05-12
 */

require_once 'core.inc';
require_once 'praxis.inc';
require_once 'amor.inc';
require_once 'locus.inc';
//require_once 'user.inc';

// title to be displayed in the corresponding browser tab:
$title = "myX - Home";
$js = "index.js";

// description for the homonyme meta tag in the head section of the HTML file:
$description = "Homepage of myX";

require_once 'header.inc'; // header of all the pages of the app
echo "\t\t\t<section> <!-- section {{ -->\n";

if (DEBUG) {
    var_dump($_SESSION);
//    echo "\t\t\t\t<div id=\"sessionViewer\"><h1>session status</h1>\n".
//        "\t\t\t\t\t<pre>";
//    print_r($_SESSION);
//    echo "</pre>\n\t\t\t\t</div>\n";
//    
//    echo "<span class=\"debug\">session: ".var_dump($_SESSION)."</span>";
}

//echo <<<HTML
//                <p class="quote">«Me rappellant les plaisirs que j'eus je me les renouvelle,<br />
//                et je vis des peines que j'ai enduré, et que je ne sens plus»<br />
//                (Giacomo Casanova, Histoire de ma vie, Préface)</p>
//
//HTML;

echo <<<HTML
                <p class="quote">«Me rappellant les plaisirs que j'eus je me les renouvelle»<br />
                (Casanova)</p>

HTML;

if (!isset($_SESSION['userID']) || $_SESSION['userID'] === -1) {

/*
 * when a user is not logged in the body of this page displays a text
 * with summary information about the app.
 */
    
    echo "\t\t\t\t\t<p class=\"large\"><b>"._("Welcome to myX!")."</b></p>\n";

    echo <<<HTML
                <p class="medium">«<cite>By recollecting the pleasures I have had formerly, I renew them, I enjoy them a second time</cite>», wrote once Casanova.<br />
                There's no need to be a famous libertine. If you also feel pleasure remembering your sexual life, the web application <b>myX</b> is conceived to make your life easier:<br />
                With the multilingual user interface, you can record your <b>experiences</b>, with the detail level you choose, in order to remember them everytime you want.<br />
                Along with the experiences, you'll remember also your <b>lovers</b>. You could easily query your data.<br />
                Last but not least, having your <b>places</b> well arranged will allow you to surf through them in a map.</p>

HTML;
} else { // user logged in
    
/*
 * when a user is logged in the app, the body of this page contains:
 * i) a button to add a new experience (and eventually new lovers, places...).
 * ii) the previews of a random experience, a random lover and a random place.
 */
    
    // new experience:
    echo "\t\t\t\t<p class=\"medium\">"._("Add experiences").":</p>\n";
    echo "\t\t\t\t<form action=\"praxisEdit.php\" method=\"GET\">\n";
    echo "\t\t\t\t\t<input type=\"submit\" value=\""._("New experience").
        "\" />\n";
    echo "\t\t\t\t</form>\n";
    
    if ($_SESSION['DBStatus']['doPracticaExist']) {
        
        echo "\t\t\t\t<p class=\"medium\">"._("Discover your experiences").
            ":</p>\n";
        
        $practica = Praxis::getAllPractica();
        $randomPraxis = new Praxis($practica[rand(0, sizeof($practica))]);
        $randomPraxis->HTMLPreview(0);
        
        echo "\t\t\t\t<p class=\"medium\">"._("Discover your lovers").
            ":</p>\n";
        
        $amores = Amor::getAllAmores();
        $randomAmor = new Amor($amores[rand(0, sizeof($amores))]);
        $randomAmor->HTMLPreview(0);
        
        echo "\t\t\t\t<p class=\"medium\">"._("Discover your places").
            ":</p>\n";       
        $loca = Locus::getAllLoca();
        $randomLocus = new Locus($loca[rand(0, sizeof($loca))]);
        $randomLocus->HTMLPreview(0);
        
    }
    
}

echo "\t\t\t</section> <!-- }} section -->\n\n";
require_once 'footer.inc'; // footer of all the pages of the app

?>