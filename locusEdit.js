/**
 * script 'locusEdit.js'.
 * 
 * this script is used to provide complementary functionality to the form
 * of the script 'locusEdit.php'.
 * 
 * @author Joaquin Javier ESTEBAN MARTINEZ <jesteban1972@me.com>
 * last updated 2018-06-09
*/

window.onload = function() {
    
    // event listener is added to form:
    document.getElementById('locusEditForm').
        addEventListener('submit', submitForm, true);
    
    // radio buttons 'countryOrigin':
    
    // radio buttons are initialized:
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
    
    // event listeners are added:
    countryOriginExisting.addEventListener('change', changeCountryOrigin, true);
    countryOriginNew.addEventListener('change', changeCountryOrigin, true);
    countryNew.addEventListener('click', newCountry, true);
    
    // radio buttons 'kindOrigin':
    
    // radio buttons are initialized:
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
    
    // event listeners are added:
    kindOriginExisting.addEventListener('change', changeKindOrigin, true);
    kindOriginNew.addEventListener('change', changeKindOrigin, true);
    kindNew.addEventListener('click', newKind, true);
    
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
    
    // the current value of field 'countryNewTxt' is codified:
    var tempCountryData = JSON.stringify({
            name: document.getElementById('countryNewTxt').value
        });
    
    // store codified JSON in the session:
    var request = new XMLHttpRequest(); // TODO: make it cross browser
    request.open('POST', 'sessionFromJS.php', false); // non asynchonous
    request.setRequestHeader('Content-type', 
        'application/x-www-form-urlencoded');
    request.send('tempCountryData=' + tempCountryData);
        
}

function newKind() {
    
    // the current value of field 'kindNewTxt' is codified:
    var tempKindData = JSON.stringify({
            name: document.getElementById('kindNewTxt').value
        });
    
    // store codified JSON in the session:
    var request = new XMLHttpRequest(); // TODO: make it cross browser
    request.open('POST', 'sessionFromJS.php', false); // non asynchonous
    request.setRequestHeader('Content-type', 
        'application/x-www-form-urlencoded');
    request.send('tempKindData=' + tempKindData);
    
}

/**
 * function 'storeTempLocusData'.
 * 
 * the data input so far is JSON codified and stored in PHP's session,
 * making an asynchronous call to microscript 'sessionFromJS.php'.
 * the data is updated in the following three scenaris:
 * i) when the page is left.
 * ii) when country is changed.
 * iii) when kind is changed.
 */
//function storeTempLocusData() {
//    
//    // fields 'country' and 'kind' are prepared:
//    var countryOrigin = document.getElementsByName('countryOrigin');
//    var countryID = (countryOrigin[0].checked) ?
//        parseInt(document.getElementById('countryID').value) :
//        -1; // using temporary value -1 when new country
//    var kindOrigin = document.getElementsByName('kindOrigin');
//    var kindID = (kindOrigin[0].checked) ?
//        parseInt(document.getElementById('kindID').value) :
//        -1; // using temporary value -1 when new country
//
//    // document data are codified as JSON:
//    var tempLocusData = JSON.stringify({
//        achtung: document.getElementById('achtung').value,
//        name: document.getElementById('name').value,
//        rating: parseInt(document.getElementById('rating').value),
//        address: document.getElementById('address').value,
//        country: countryID,
//        kind: kindID,
//        descr: document.getElementById('descrTxt').value,
//        coordExact: document.getElementById('coordExact').value,
//        coordGeneric: document.getElementById('coordGeneric').value,
//        web: document.getElementById('web').value
//    });
//
//    // codified JSON is stored in the session:
//    var request = new XMLHttpRequest(); // TODO: make it cross browser
//    request.open('POST', 'sessionFromJS.php', false); // non asynchonous
//    request.setRequestHeader('Content-type',
//        'application/x-www-form-urlencoded');
//    request.send('tempLocusData=' + tempLocusData);
//    
//    return;
//    
//}

function submitForm(evt) { // TODO: validate form
    
    evt.preventDefault();
    
    var tempPraxis = document.getElementById('tempPraxis');
    
    if (tempPraxis === null) {
        // if tempPraxis not set, script called from 'locus.php' for edition
        
        var doesValidate = true; // default value
        
        // name validation:
        var name = document.getElementById('name');
        if (name.value === '') {

            doesValidate = false;
            name.style.borderColor = 'red';

        }
        
        if (doesValidate) { // validation OK
        
            console.log('form validation successfully');
            this.submit(); // the form is submitted
    
        } else {
        
            // the form is not submitted
            console.log('form validation failed');

        }
        
    } else { // save and continue
        
        // fields 'country' and 'kind' are prepared:
        var countryOrigin = document.getElementsByName('countryOrigin');
        var countryID = (countryOrigin[0].checked) ?
            parseInt(document.getElementById('countryID').value) :
            -1; // using temporary value -1 when new country
        var kindOrigin = document.getElementsByName('kindOrigin');
        var kindID = (kindOrigin[0].checked) ?
            parseInt(document.getElementById('kindID').value) :
            -1; // using temporary value -1 when new country

        // document data are codified as JSON:
        var tempLocusData = JSON.stringify({
            achtung: document.getElementById('achtung').value,
            name: document.getElementById('name').value,
            rating: parseInt(document.getElementById('rating').value),
            address: document.getElementById('address').value,
            country: countryID,
            kind: kindID,
            descr: document.getElementById('descrTxt').value,
            coordExact: document.getElementById('coordExact').value,
            coordGeneric: document.getElementById('coordGeneric').value,
            web: document.getElementById('web').value
        });

        // codified JSON is stored in the session:
        var request = new XMLHttpRequest(); // TODO: make it cross browser
        request.open('POST', 'sessionFromJS.php', false); // non asynchonous
        request.setRequestHeader('Content-type',
            'application/x-www-form-urlencoded');
        request.send('tempLocusData=' + tempLocusData);
        
        // redirect to 'praxisEdit.php':
        window.location = 'praxisEdit.php?tempLocus=1';
        
    }
    
}