<?php

/* 
 * index.php
 * home script of the app
 * (c) Joaquin Javier ESTEBAN MARTINEZ
 * last update: 2018-01-16
 */


require_once 'session.inc';
//require_once 'core.inc';
//require_once 'user.inc';

// title to be displayed in the corresponding browser tab:
$title = _("myX Home");

// description for the homonyme meta tag in the head section of the HTML file:
$description = "Homepage of myX";

require_once 'header.inc'; // header of all the pages of the app
echo "\t\t\t<section> <!-- section {{ -->\n";

var_dump($_SESSION);

echo "<p>"._("myX Home")."</p>\n";

echo "<p>"._("myX welcome message")."</p>\n";

echo <<<HTML
                <table border="0" style="margin-left:auto; margin-right:auto;">
                    <tr>
                        <td style="text-align: center;">
HTML;

echo "<img src=\"".getImage("praxis","medium")."\" alt=\"".
    _("(Image of a gold coin)").
    "\" />";

echo <<<HTML
</td>
                        <td>
HTML;

// items concerning experiences:
echo <<<HTML
<ul>
                                <li>Remember in detail each one of your experiences, feeling pleasure with it.</li>
                                <li>Rate your experiences.</li>
                                <li>Get statistics and graphics about your experiences (how many experiences you've had yet, how is the evolution in the time of your activity...).</li>
                                <li>Have personalized lists of your experiences (by years, by rating...).</li>
                                <li>Have an overview of your anniversaries.</li>
                            </ul>
HTML;

echo <<<HTML
</td>
                    </tr>
                    <tr>
                        <td>
HTML;

// items concerning lovers:
echo <<<HTML
<ul>
                                <li>Remember in detail each one of your lovers, feeling pleasure with it.</li>
                                <li>Rate your lovers.</li>
                                <li>Get statistics about your lovers (how many lovers you've had yet, which were your best lovers...).</li>
                                <li>Have lists of your experiences with each one of your lovers.</li>
                                <li>Have contact information to easily reach your lovers (telephone, email, social networks...).</li>
                            </ul>
HTML;

echo <<<HTML
</td>
                        <td style="text-align: center;">
HTML;

echo "<img src=\"".getImage("amor","medium")."\" alt=\"".
    _("(Image of a cycladic idol)").
    "\" />";

echo <<<HTML
</td>
                    </tr>
                    <tr>
                        <td style="text-align: center;">
HTML;

echo "<img src=\"images/marker-medium.png\" alt=\"".
    _("(Image of a Google Maps marker)").
    "\" />";

echo <<<HTML
</td>
                        <td>
HTML;

// items concerning places:
echo <<<HTML
<ul>
                                <li>Know in how many places you've experiences yet.</li>
                                <li>Surf on a map through your places.</li>
                                <li>Have lists of your experiences in each one of your places.</li>
                            </ul>
HTML;

echo <<<HTML
</td>
                    </tr>
                </table>

HTML;

echo "\t\t\t</section> <!-- }} section -->\n\n";
require_once 'footer.inc'; // footer of all the pages of the app

?>