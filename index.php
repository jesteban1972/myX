<?php

/* 
 * index.php
 * home script of the app
 * (c) Joaquín Javier ESTEBAN MARTÍNEZ
 * last update: 2017-11-23
 */


require_once 'session.inc';
require_once 'core.inc';
require_once 'user.inc';

/*
 * app options initialization
 */
if (!isset($_SESSION['options']['resultsPerPage'])) {
    
    $_SESSION['options']['resultsPerPage'] = 25;
        
}

// title to be displayed in the corresponding browser tab:
$title = "myX Home";

// description for the homonyme meta tag in the head section of the XHTML file:
$description = "Homepage of myX";


require_once 'header.inc'; // header of all the pages of the app


echo <<<XHTML
                <section>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Vt enim ad minim ueniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in uoluptate uelit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum</p>
                </section>

XHTML;

//}}

require_once 'footer.inc'; // footer of all the pages of the app

?>