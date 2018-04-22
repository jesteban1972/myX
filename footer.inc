<?php

/* 
 * footer.inc
 * footer for all pages of myX
 * (c) Joaquin Javier ESTEBAN MARTINEZ
 * last update: 2018-04-11
 */

echo "\t\t\t<footer><!-- footer {{ -->\n";
echo "\t\t\t\t<p>\n";
echo "\t\t\t\t\tmyX \n";
echo "\t\t\t\t\t- &copy; Joaquín Javier Esteban Martínez 2018\n";
echo "\t\t\t\t\t- <a href=\"\">Privacy policy</a>\n";
echo "\t\t\t\t\t- <a href=\"\">Cookies policy</a>\n";
echo "\t\t\t\t</p>\n";
echo "\t\t\t</footer><!-- }} footer -->\n\n";

// include sidebar:
include 'aside.inc';

echo <<<HTML
        </div><!-- }} div container -->
    </body>
</html>

HTML;

?>