/**
 * script 'praxis.js'.
 * 
 * this script provides additional functionality to the script 'praxis.php'.
 * 
 * @author Joaquin Javier ESTEBAN MARTINEZ <jesteban1972@me.com>
 * last updated 2018-06-09
*/

window.onload = function() {
    
    // makes notification (if any) dessapear after 3 secs:
    if (document.getElementById('notification'))
        window.setTimeout('hideNotification()', 3000);
    
}

function hideNotification() {
    
    document.getElementById("notification").style.display = "none";
    
}