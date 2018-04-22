/**
 * script 'praxisEdit.js'.
 * 
 * XXX
 * (c) Joaquin Javier ESTEBAN MARTINEZ
 * last updated 2018-04-21
*/

window.onload = function() {
    
    // initialize radio buttons 'locusOrigin':
    var locusOriginExisting = document.getElementById('locusOriginExisting');
    var locusOriginNew = document.getElementById('locusOriginNew');
    var locusID = document.getElementById('locusID');
    var locusNew = document.getElementById('locusNew');
    
    if (locusOriginExisting.checked) { // there are some places yet. checked existing place
        
        locusID.disabled = false;
        locusNew.disabled = true;
        
    } else /*if (locusOriginNew.checked)*/ {
        
        locusID.disabled = true;
        locusNew.disabled = false;
        
    }
    
    // add event listeners to the radio buttons 'locusOrigin':
    locusOriginExisting.addEventListener('change', changeLocusOrigin, false);
    locusOriginNew.addEventListener('change', changeLocusOrigin, false);
    
    // add event listener to the button 'locusNew':
    locusNew.addEventListener('click', newLocus, false);
    
//    // initialize radio buttons 'amorOrigin':
//    var amorOrigin = document.getElementsByName('amorOrigin');
//    var amorID = document.getElementById('locusID');
//    var amorNew = document.getElementById('locusNew');
//    
//    if (amorOrigin[0].checked) { // there are some places yet. checked existing place
//        
//        amorID.enabled = 'enabled';
//        amorNew.disabled = 'disabled';
//        
//    } else {
//        
//        amorID.disabled = 'disabled';
//        amorNew.enabled = 'enabled';
//        
//    }
//    
//    // add event listeners to the radio buttons 'amorOrigin':
//    amorOrigin[0].addEventListener('change', changeAmorOrigin, false);
//    amorOrigin[1].addEventListener('change', changeAmorOrigin, false);
    
}

function changeLocusOrigin (evt) {
    
    var locusOriginExisting = document.getElementById('locusOriginExisting');
    var locusOriginNew = document.getElementById('locusOriginNew');
    var locusID = document.getElementById('locusID');
    var locusNew = document.getElementById('locusNew');
    
    //console.log(evt.target);
    
    switch (evt.target) {
        
        case locusOriginExisting: // existing place
            
            locusID.disabled = false; // TODO: what happens if there aren't any experiences?
            locusNew.disabled = true;
            break;
            
        case locusOriginNew: // new place
            
            locusID.disabled = true;
            locusNew.disabled = false;
            break;
            
    }
    
}

function changeAmorOrigin (evt) {
    
    var amorOrigin = document.getElementsByName('amorOrigin');
    var amorID = document.getElementById('amorID');
    var amorNew = document.getElementById('amorNew');
    
    //console.log(evt.target);
    
    switch (evt.target) {
        
        case amorOrigin[0]: // existing lover
            
            amorID.disabled = false; // TODO: what happens if there aren't any experiences?
            amorNew.disabled = true;
            break;
            
        case amorOrigin[1]: // new place
            
            amorID.disabled = true;
            amorNew.disabled = false;
            break;
            
    }
    
}

/**
 * function 'newPlace'.
 * 
 * launched when button 'newPlace' is clicked, this function performs following:
 * - the current values are stored temporarily to be recovered later
 * - the script 'locusEdit' is called
 * - ...
 * @returns {undefined}
 */
function newLocus() {
    
    // the current values of all fields are temporarily stored
    // name, rating, favorite, date, ordinal, (lovers), description, tq, tl
    var temporaryPraxisData;
    
    sessionStorage.setItem(temporaryPraxisData,
        JSON.stringify({
            name: document.getElementById('name').value,
            rating: document.getElementById('rating').value,
            favorite: document.getElementById('favorite').checked ? 1 : 0,
            date: document.getElementById('date').value,
            ordinal: document.getElementById('ordinal').value,
            description: document.getElementById('description').value,
            tq: document.getElementById('tq').value,
            tl: document.getElementById('tl').value,
        })
    );
    
/*
 * a temporary form is created and submitted,
 * so that 'locusEdit.php' has $_SERVER['REQUEST_METHOD'] === "POST"
 */    
    var temporaryForm = document.createElement('form');
    temporaryForm.action = 'locusEdit.php';
    temporaryForm.method = 'POST';
    //temporaryForm.target = '_blank';

    var input=document.createElement('input');
    input.type = 'hidden';
    input.name = 'fragment';
    input.value = '<!DOCTYPE html>' + document.documentElement.outerHTML;
    temporaryForm.appendChild(input);

    document.body.appendChild(temporaryForm);
    temporaryForm.submit();
    
    //location.href = 'locusEdit.php';
    
}