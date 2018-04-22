/**
 * script 'locusEdit.js'.
 * 
 * XXX
 * (c) Joaquin Javier ESTEBAN MARTINEZ
 * last updated 2018-04-21
*/

window.onload = function() {
    
    // initialize radio buttons 'countryOrigin':
    var countryOriginExisting = document.getElementById('countryOriginExisting');
    var countryOriginNew = document.getElementById('countryOriginNew');
    var countryID = document.getElementById('countryID');
    var countryNewTxt = document.getElementById('countryNewTxt');
    var countryNew = document.getElementById('countryNew');
    
    if (countryOriginExisting.checked) { // there are some places yet. checked existing place
        
        countryID.disabled = false;
        countryNewTxt.disabled = true;
        countryNew.disabled = true;
        
    } else {
        
        countryID.disabled = true;
        countryNewTxt.disabled = false;
        countryNew.disabled = false;
        
    }
    
    // add event listeners to the radio buttons 'countryOrigin':
    countryOriginExisting.addEventListener('change', changeCountryOrigin, false);
    countryOriginNew.addEventListener('change', changeCountryOrigin, false);
    
    // add event listener to the button 'countryNew':
    countryNew.addEventListener('click', newCountry, false);
    
    // initialize radio buttons 'kindOrigin':
    var kindOriginExisting = document.getElementById('kindOriginExisting');
    var kindOriginNew = document.getElementById('kindOriginNew');
    var kindID = document.getElementById('kindID');
    var kindNewTxt = document.getElementById('kindNewTxt');
    var kindNew = document.getElementById('kindNew');
    
    if (kindOriginExisting.checked) { // there are some places yet. checked existing place
        
        kindID.disabled = false;
        kindNewTxt.disabled = true;
        kindNew.disabled = true;
        
    } else {
        
        kindID.disabled = true;
        kindNewTxt.disabled = false;
        kindNew.disabled = false;
        
    }
    
    // add event listeners to the radio buttons 'kindOrigin':
    kindOriginExisting.addEventListener('change', changeKindOrigin, false);
    kindOriginNew.addEventListener('change', changeKindOrigin, false);
    
    // add event listener to the button 'kindNew':
    kindNew.addEventListener('click', newKind, false);
    
}

function changeCountryOrigin(evt) {
    
    var countryOriginExisting = document.getElementById('countryOriginExisting');
    var countryOriginNew = document.getElementById('countryOriginNew');
    var countryID = document.getElementById('countryID');
    var countryNewTxt = document.getElementById('countryNewTxt');
    var countryNew = document.getElementById('countryNew');
    
    switch (evt.target) {
        
        case countryOriginExisting: // existing country
            
            countryID.disabled = false; // TODO: what happens if there aren't any experiences?
            countryNewTxt.disabled = true;
            countryNew.disabled = true;
            break;
            
        case countryOriginNew: // new country
            
            countryID.disabled = true;
            countryNewTxt.disabled = false
            countryNew.disabled = false;
            break;
            
    }
    
}

function changeKindOrigin(evt) {
    
    var kindOriginExisting = document.getElementById('kindOriginExisting');
    var kindOriginNew = document.getElementById('kindOriginNew');
    var kindID = document.getElementById('kindID');
    var kindNewTxt = document.getElementById('kindNewTxt');
    var kindNew = document.getElementById('kindNew');
    
    switch (evt.target) {
        
        case kindOriginExisting: // existing kind
            
            kindID.disabled = false; // TODO: what happens if there aren't any experiences?
            kindNewTxt.disabled = true;
            kindNew.disabled = true;
            break;
            
        case kindOriginNew: // new kind
            
            kindID.disabled = true;
            kindNewTxt.disabled = false
            kindNew.disabled = false;
            break;
            
    }
    
}

function newCountry() {
    
    // the current value of field 'countryNewTxt' is temporarily stored:
    var temporaryCountryData;
    
    sessionStorage.setItem(temporaryCountryData,
        JSON.stringify({
            name: document.getElementById('countryNewTxt').value
        })
    );
    
}

function newKind() {
    
    // the current value of field 'kindNewTxt' is temporarily stored:
    var temporaryKindData;
    
    sessionStorage.setItem(temporaryKindData,
        JSON.stringify({
            name: document.getElementById('kindNewTxt').value
        })
    );
    
}