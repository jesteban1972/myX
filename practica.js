/**
 * script 'practica.js'.
 * 
 * XXX
 * (c) Joaquin Javier ESTEBAN MARTINEZ
 * last updated 2018-03-31
*/

window.onload = function(){
    
    // add event listeners to the buttons of the navigation bar
    // 'firstPage', 'previousPage', 'directPageInput', 'nextPage' and 'lastPage':
    var directPageInput = document.getElementsByName('directPageInput');
            
    for (var i = 0; i < directPageInput.length; i++) // there are two items
        directPageInput[i].addEventListener('change', gotoPage, false);
    
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