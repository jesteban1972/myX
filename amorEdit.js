/**
 * script 'amorEdit.js'.
 * 
 * XXX
 * (c) Joaquin Javier ESTEBAN MARTINEZ
 * last updated 2018-04-24
*/

window.onload = function() {
    
    // event listener is added to form:
    document.getElementById('amorEditForm').
        addEventListener('submit', submitForm, true);
    
    // radio buttons 'countryOrigin':
    
    // radio buttons are initialized:
//    var countryOriginExisting = document.getElementById('countryOriginExisting');
//    var countryOriginNew = document.getElementById('countryOriginNew');
//    var countryID = document.getElementById('countryID');
//    var countryNewTxt = document.getElementById('countryNewTxt');
//    var countryNew = document.getElementById('countryNew');
//    
//    if (countryOriginExisting.checked) { // there are some places yet. checked existing place
//        
//        countryID.disabled = false;
//        countryNewTxt.disabled = true;
//        countryNew.disabled = true;
//        
//    } else {
//        
//        countryID.disabled = true;
//        countryNewTxt.disabled = false;
//        countryNew.disabled = false;
//        
//    }
//    
//    // event listeners are added:
//    countryOriginExisting.addEventListener('change', changeCountryOrigin, true);
//    countryOriginNew.addEventListener('change', changeCountryOrigin, true);
//    countryNew.addEventListener('click', newCountry, true);
//    
//    // radio buttons 'kindOrigin':
//    
//    // radio buttons are initialized:
//    var kindOriginExisting = document.getElementById('kindOriginExisting');
//    var kindOriginNew = document.getElementById('kindOriginNew');
//    var kindID = document.getElementById('kindID');
//    var kindNewTxt = document.getElementById('kindNewTxt');
//    var kindNew = document.getElementById('kindNew');
//    
//    if (kindOriginExisting.checked) { // there are some places yet. checked existing place
//        
//        kindID.disabled = false;
//        kindNewTxt.disabled = true;
//        kindNew.disabled = true;
//        
//    } else {
//        
//        kindID.disabled = true;
//        kindNewTxt.disabled = false;
//        kindNew.disabled = false;
//        
//    }
//    
//    // event listeners are added:
//    kindOriginExisting.addEventListener('change', changeKindOrigin, true);
//    kindOriginNew.addEventListener('change', changeKindOrigin, true);
//    kindNew.addEventListener('click', newKind, true);
    
}

/**
 * function 'storeTempAmorData'.
 * 
 * the data input so far is JSON codified and stored in PHP's session,
 * making an asynchronous call to microscript 'sessionFromJS.php'.
 */
function storeTempAmorData() {

    var tempAmorData = JSON.stringify({
            achtung: document.getElementById('achtung').value,
            alias: document.getElementById('alias').value,
            rating: parseInt(document.getElementById('rating').value),
            genre: parseInt(document.getElementById('genre').value),
            descr1: document.getElementById('descr1').value,
            descr2: document.getElementById('descr2').value,
            descr3: document.getElementById('descr3').value,
            descr4: document.getElementById('descr4').value,
            web: document.getElementById('web').value,
            name: document.getElementById('name').value,
            photo: document.getElementById('photo').checked ? 1 : 0,
            email: document.getElementById('email').value,
            other: document.getElementById('other').value
        });
    
    var request = new XMLHttpRequest(); // TODO: make it cross browser
    request.open('POST', 'sessionFromJS.php', true);
    request.setRequestHeader("Content-type",
        "application/x-www-form-urlencoded");
    request.send('tempAmorData=' + tempAmorData);
    
    return;
    
}

function submitForm(evt) { // TODO: validate form
    
    evt.preventDefault();
    
/*
 * a hidden field tempPraxis has been placed in the document
 * to distinguish when...
 */
    
    var tempPraxis = document.getElementById('tempPraxis');
    
    if (tempPraxis === null) { // tempPraxis not set, script not called from praxisEdit.php
        
        this.submit();
        
    } else { // save and continue
        
        storeTempAmorData();

        // redirect to 'praxisEdit.php' passing in the URL an argument (GET method):
        window.location = 'praxisEdit.php?tempAmor=1';
        
///*
// * a temporary form is created and submitted,
// * so that 'praxisEdit.php' has $_SERVER['REQUEST_METHOD'] === "GET".
// */    
//    
//        var tempForm = document.createElement('form');
//        tempForm.action = 'praxisEdit.php';
//        tempForm.method = 'GET';
//
////        var input = document.createElement('input');
////        input.type = 'hidden';
////        input.name = 'fragment';
////        input.value = '<!DOCTYPE html>' + document.documentElement.outerHTML;
////        tempForm.appendChild(input);
//
//        document.body.appendChild(tempForm);
//        tempForm.submit();
        
    }
    
}