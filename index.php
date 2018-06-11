<?php
/** 
 * script 'index.php'.
 * 
 * home script of the app myX.
 * 
 * @author Joaquin Javier ESTEBAN MARTINEZ <jesteban1972@me.com>
 * last update: 2018-06-07
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

if (DEBUG)
    var_dump($_SESSION);

// quote uncut
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

    switch ($_SESSION['navOptions']['GUILang']) {
        
        case GUI_ENGLISH:
            
            echo <<<HTML
                <p class="large">«<cite>By recollecting the pleasures I had I
                renew them</cite>», wrote once Casanova.</p>
                <p class="large">There's no need to be a famous libertine. If you
                also feel pleasure remembering your sexual life, the web app
                <b>myX</b> is conceived to make your life easier: You can record
                your <b>experiences</b>, with the detail level you choose.
                Afterwards you can easily query your data with a number of
                exciting possibilites, in order to remember them everytime you
                want and feel pleasure. Along with the experiences, you'll
                remember also your <b>lovers</b>. Last but not least, having
                your <b>places</b> well arranged you'll be able to surf through
                them in a map.</p>

HTML;
            break;
        
        case GUI_SPANISH:
            
            echo <<<HTML
                <p class="large">«<cite>Acordándome de los placeres que he
                tenido yo me los renuevo</cite>», escribió una vez Casanova.</p>
                <p class="large">No es necesario ser un famoso libertino. Si tú
                también sientes placer recordando tu vida sexual, la aplicación
                web <b>myX</b> está pensada para hacerte la vida más fácil:
                Puedes registrar tus <b>experiencias</b>, con el nivel de
                detalle que tú elijas. Después podrás fácilmente consultar tus
                datos con varias interesantes posibilidades, de modo que puedas
                acordarte de ellas cada vez que quieras, sintiendo así placer.
                Junto con tus experiencias te acordarás también de tus
                <b>amantes</b>. <i>Last but not least</i>, teniendo tus
                <b>lugares</b> bien organizados podrás moverte a través ellos
                por un mapa.</p>

HTML;
            break;

        case GUI_GREEK:
            
            echo <<<HTML
                <p class="large">«<cite>Ὅταν θυμοῦμαι τὰς ἡδονὰς ἃς ἀπήλαυσα
                τὲς ἀνανεώνω</cite>», έγραψε κάποτε ο Καζανόβας.</p>
                <p class="large">Δεν είναι ανάγκη να είσαι ένας περίφημος
                λιβερτίνος. Εάν νοιώθεις κι εσύ ηδονή όταν θυμάσαι την
                σεξουαλική σου ζωή, η εφαρμοφή web <b>myX</b> δημιουργήθηκε
                για να διευκολύνει τη ζωή σου: μπορείς ν' αποθηκεύεις τις
                <b>φάσεις</b> σου, όσο αναλυτικά θελήσεις. Έπειτα θα μπορέσεις
                εύκολα ν' αναζητήσεις τα στοιχεία σου χρησιμοποιώντας
                ενδιαφέρουσες επιλογές ούτως, έτσι μπορέσεις να τα θυμάσαι όταν
                θελήσεις, δοκιμάζοντας έτσι ηδονή. Μαζί με τις φάσεις σου θα
                θυμηθείς και τους <b>εραστές</b> σου. <i>Last but not least</i>,
                έχοντας τους <b>τόπους</b> σου οργανωμένους θα μπορέσεις να πλεύσεις
                σ' αυτούς μ' ένα χάρτη.</p>

HTML;
            break;
    }
    
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
        
        $amores = Amor::getAllAmores();
        $randomAmor = new Amor($amores[rand(0, sizeof($amores))]);
        
        $loca = Locus::getAllLoca();
        $randomLocus = new Locus($loca[rand(0, sizeof($loca))]);
        
        echo <<<HTML
                <div id="myCarousel" class="carousel slide" data-ride="carousel">
                    <!-- Indicators -->
                    <ol class="carousel-indicators">
                      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                      <li data-target="#myCarousel" data-slide-to="1"></li>
                      <li data-target="#myCarousel" data-slide-to="2"></li>
                    </ol>

                    <!-- wrapper for slides -->
                    <div class="carousel-inner" role="listbox" style="text-align: center;">

HTML;
     
echo "<div class=\"item active\"><img src=\"images/sliderFrame.png\" />\n";        
$randomPraxis->HTMLPreview(0);
echo "</div>\n";

echo "<div class=\"item\"><img src=\"images/sliderFrame.png\" />\n";        
$randomAmor->HTMLPreview(0);
echo "</div>\n";

echo "<div class=\"item\"><img src=\"images/sliderFrame.png\" />\n";
$randomLocus->HTMLPreview(0);
echo "</div>\n";
        
        echo <<<HTML
                    </div>

                    <!-- left and right controls -->
                    <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
                      <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                      <span class="sr-only">Previous</span>
                    </a>
                    <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
                      <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                      <span class="sr-only">Next</span>
                    </a>
                </div>
                <script>

                $('.carousel').carousel({
                  interval: 10000
                })
                </script>

HTML;
        
    }
    
}

echo "\t\t\t</section> <!-- }} section -->\n\n";
require_once 'footer.inc'; // footer of all the pages of the app

?>