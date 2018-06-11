/**
 * script 'practica.js'.
 * 
 * this script provides additional functionality to the script 'practica.php'.
 * 
 * @author Joaquin Javier ESTEBAN MARTINEZ <jesteban1972@me.com>
 * last updated 2018-06-08
*/

window.onload = function(){
    
    // add event listeners to the buttons of the navigation bar
    // 'firstPage', 'previousPage', 'directPageInput', 'nextPage' and 'lastPage':
    var directPageInput = document.getElementsByName('directPageInput');
            
    for (var i = 0; i < directPageInput.length; i++) // there are two items
        directPageInput[i].addEventListener('change', gotoPage, false);
    
    // makes notification (if any) dessapear after 3 secs:
    if (document.getElementById('notification'))
        window.setTimeout('hideNotification()', 3000);
    
}

function gotoPage(evt) {
    
    var page = evt.target.value;
    
    // check if in range
    var pagesAmount = document.getElementById('pagesAmount').value;
    if (/*!isNaN(page) || */page < 1 || page > pagesAmount) {
     
        evt.target.value = 1; // TODO: get current page from URL
        return;
        
    }
    
    var url = 'http://' + window.location.host + window.location.pathname +
        '?page=' + page;
    window.location.replace(url);
    
}

function hideNotification() {
    
    document.getElementById("notification").style.display = "none";
    
}