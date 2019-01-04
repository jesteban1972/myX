<?php

/* 
 * info.php
 * XXX
 * @author Joaquin Javier ESTEBAN MARTINEZ <jesteban1972@me.com>
 * last update: 2018-01-12
 */


$title = "myX - info";
$description = "Information about myX";

require_once 'header.inc'; // header of all the pages of the app
echo "\t\t\t<section> <!-- section {{ -->\n";

echo <<<HTML
<p class="medium">Have you ever had any sex? Do you have sex regularly? If yes, could you remember in detail the sexual experiences you’ve had yet? (Where/when was it? With who? How many experiences had I with her/him? When was the last time I had sex with this person?...). Unfortunately, memory has limits. As long as we aren’t elephants, after a while all the pleasant experiences you had won’t be anything but a confusing mix of people and situations in the back of your brain. What a pity, isn’t it? The only way to remember them would be to write it down. Feeling lazy? No need to worry, there’s something to make your life easier: myX.</p>
<p class="medium">myX is a web application conceived to record your sexual activity. If you’ve had and you have pleasure having sex, probably you’ll feel pleasure remembering in detail the lived experiences. As the famous libertine Giacomo Casanova wrote in his memories: “By recollecting the pleasures I have had formerly, I renew them, I enjoy them a second time”. The more detail you record of your experiences, the more pleasure you’ll get by remembering them.</p>
<p class="medium">myX doesn’t require any installation and its multilingual interface is very simple to use. Needless to say, the information provided by you will be private, and thus available to nobody but you.</p>
<p class="medium">After signing up for an account, you’ll have your own, private space, where you can record all your sexual experiences one by one. Ideally you’ll record your experiences shortly after having them, in order to remember the most of them. Along with the experiences, you’ll record information about your lovers and about the places where the experiences happened. You can rate all the information you input in order to have exciting classification criteria (my best lovers, for instance).</p>
<p class="medium">Immediately after submitting any information, you’ll have access to your records, and you can browse through your data in a number of ways: Using a chronological list of your experiences, using an alphabetic list of your lovers, or surfing in a map with your places. You can navigate through your experiences using the Synchroton, an ingenious mechanism which allows you to surf forwards or backwards in the time according to different criteria: Next/previous experience with the same lover, chronologically or in the same place.</p>
<p class="medium">Have at a glance practical statistics about your sexual activity: How many lovers did you have yet? Which were your best experiences? How many experiences you had in a given year? How was the evolution of my sexual activity yearly? and much, much more. You can query your data to get personalized queries (ex.: Which were my best experiences in a determinate place in a determinate time span). You can save your personalized queries and they will be dynamically updated.</p>
<p class="medium">There’s no need to be a famous libertine to use myX. It’s a practical tool for anyone having an active sexual life, from the extreme promiscuity to any old-fashion, monogamic behavour.</p>
<p class="medium">Create now your free myX account, enjoy having sex… and enjoy remembering it!<br />
Your myX team.</p>
HTML;

echo "\t\t\t</section> <!-- }} section -->\n\n";
require_once 'footer.inc'; // footer of all the pages of the app

?>