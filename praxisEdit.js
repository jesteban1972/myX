/**
 * script 'praxisEdit.js'.
 * 
 * XXX
 * (c) Joaquin Javier ESTEBAN MARTINEZ
 * last updated 2018-04-25
*/

window.onload = function() {
    
    // form validation event:
    document.getElementById('praxisEditForm').
        addEventListener('submit', validateForm, true);
    
    /*
     * radio buttons 'locusOrigin' are initialized.
     */
    
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
    locusOriginExisting.addEventListener('change', changeLocusOrigin, true);
    locusOriginNew.addEventListener('change', changeLocusOrigin, true);
    
    // add event listener to the button 'locusNew':
    locusNew.addEventListener('click', newLocus, true);
    
    /*
     * radio buttons 'amorOrigin' are initialized.
     */
    
    var amorOriginExisting = document.getElementById('amorOriginExisting');
    var amorOriginNew = document.getElementById('amorOriginNew');
    var amorID = document.getElementById('amorID');
    var amorNew = document.getElementById('amorNew');
    
    if (amorOriginExisting.checked) { // there are some places yet. checked existing place
        
        amorID.disabled = false;
        amorNew.disabled = true;
        
    } else {
        
        amorID.disabled = true;
        amorNew.disabled = false;
        
    }
    
    // add event listeners to the radio buttons 'amorOrigin':
    amorOriginExisting.addEventListener('change', changeAmorOrigin, true);
    amorOriginNew.addEventListener('change', changeAmorOrigin, true);
    
    // add event listener to the button 'amorNew':
    amorNew.addEventListener('click', newAmor, true);
    
    // event listeners are added to 'addAmor[0]' and 'removeAmor[0]':
    document.getElementById('addAmor[0]').
        addEventListener('click', addAmor, true);
    document.getElementById('removeAmor[0]').
        addEventListener('click', removeAmor, true);
    
    // button removeAmor[0] is not shown on page load:
    document.getElementById('removeAmor[0]').style.visibility = 'hidden';
    
}

function addAmor(evt) {
    
    var /*hr, select,*/ att, /*option, label, br,*/ txt, /*input,*/ button;
    
    // rulesAmount is retrieved from the already existing 'ruleFields':
    var amoresAmount =
        document.querySelectorAll("select[name^='XXXruleFields[']").length + 1;

    // amoresTable is the DOM element
    // and at the end of which new lovers are added:
    var amoresTable = document.getElementById('amoresTable');
     

    // insert an horizontal rule and a DOM comment to separate rules:
//    hr = document.createElement('hr');
//    att = document.createAttribute('id');
//    att.value = 'hrRule' + (rulesAmount - 1);
//    hr.setAttributeNode(att);
//    rules.appendChild(hr);
    
    // button 'addAmor':
    button = document.createElement('button');
    att = document.createAttribute('type');
    att.value = 'button';
    button.setAttributeNode(att);
    att = document.createAttribute('id');
    att.value = 'addAmor[' + (amoresAmount - 1) + ']'; // array 0-based
    button.setAttributeNode(att);
    txt = document.createTextNode('+');
    button.appendChild(txt);
    amoresTable.appendChild(button);g
    
    // event listener is added to the newly created button:
    button.addEventListener('click', addAmor, true);
    
    // button 'removeAmor':
    button = document.createElement('button');
    att = document.createAttribute('type');
    att.value = 'button';
    button.setAttributeNode(att);
    att = document.createAttribute('id');
    att.value = 'removeAmor[' + (rulesAmount - 1) + ']'; // array 0-based
    button.setAttributeNode(att);
    txt = document.createTextNode('-');
    button.appendChild(txt);
    amoresTable.appendChild(button);
    
    // event listener is added to the newly created button:
    button.addEventListener('click', removeAmor, true);
    
    // button removeAmor[0] shown when amoresAmount > 1:
    if (amoresAmount > 1)
        document.getElementById('removeAmor[0]').style.visibility = 'visible';
    else
        document.getElementById('removeAmor[0]').style.visibility = 'hidden';
    
    
}

/**
 * this event handler is used to provide functionality when switching the
 * radio button 'locusOrigin'.
 * when an option is selected, the corresponding controls of the other option
 * are disabled.
 * @param {type} evt
 * @returns {undefined}
 */
function changeLocusOrigin (evt) {
    
    var locusOriginExisting = document.getElementById('locusOriginExisting');
    var locusOriginNew = document.getElementById('locusOriginNew');
    var locusID = document.getElementById('locusID');
    var locusNew = document.getElementById('locusNew');
    
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
    
    var amorOriginExisting = document.getElementById('amorOriginExisting');
    var amorOriginNew = document.getElementById('amorOriginNew');
    var amorID = document.getElementById('amorID');
    var amorNew = document.getElementById('amorNew');
    
    switch (evt.target) {
        
        case amorOriginExisting: // existing lover
            
            amorID.disabled = false; // TODO: what happens if there aren't any experiences?
            amorNew.disabled = true;
            break;
            
        case amorOriginNew: // new lover
            
            amorID.disabled = true;
            amorNew.disabled = false;
            break;
            
    }
    
}

function newAmor() {
    
    storeTempPraxisData();
    
    // redirect to 'locusEdit.php' passing in the URL an argument (GET method):
    window.location = 'amorEdit.php?tempPraxis=1';
    
///*
// * a temporary form is created and submitted,
// * so that 'amorEdit.php' has $_SERVER['REQUEST_METHOD'] === "GET"
// * and having as unique parameter tempPraxis set to 1.
// */    
//    var tempForm = document.createElement('form');
//    tempForm.action = 'amorEdit.php?tempPraxis=1';
//    tempForm.method = 'GET';
//    
////    var input = document.createElement('input');
////    input.type = 'hidden';
////    input.name = 'fragment';
////    input.value = '<!DOCTYPE html>' + document.documentElement.outerHTML;
////    tempForm.appendChild(input);
//    
//    document.body.appendChild(tempForm);
//    tempForm.submit();
    
}

/**
 * function 'newLocus'.
 * 
 * launched when button 'newPlace' is clicked, this function performs following:
 * - the current values are stored temporarily to be recovered later
 * - the script 'locusEdit' is called
 * - ...
 * @returns {undefined}
 */
function newLocus() {
    
    storeTempPraxisData();
    
    // redirect to 'locusEdit.php' passing in the URL an argument (GET method):
    window.location = 'locusEdit.php?tempPraxis=1';
/*
 * a temporary form is created and submitted,
 * so that 'locusEdit.php' has $_SERVER['REQUEST_METHOD'] === "GET"
 * and having as unique parameter tempPraxis set to 1.
 */    
//    var tempForm = document.createElement('form');
//    tempForm.action = 'locusEdit.php?tempPraxis=1';
//    tempForm.method = 'GET';
//    //tempForm.target = '_blank';
//
////    var input = document.createElement('input');
////    input.type = 'hidden';
////    input.name = 'fragment';
////    input.value = '<!DOCTYPE html>' + document.documentElement.outerHTML;
////    tempForm.appendChild(input);
//
//    document.body.appendChild(tempForm);
//    tempForm.submit();
    
}

function removeAmor() {
    
    return;
    
}

/**
 * function storeTempPraxisData.
 * 
 * the data input so far is JSON codified and stored in PHP's session,
 * making an asynchronous call to microscript 'sessionFromJS.php'.
 */
function storeTempPraxisData() {

    var tempPraxisData = JSON.stringify({
        achtung: document.getElementById('achtung').value,
        name: document.getElementById('name').value,
        rating: parseInt(document.getElementById('rating').value),
        favorite: document.getElementById('favorite').checked ? 1 : 0,
        /*locus: document.getElementById('XXX').value,*/
        date: document.getElementById('date').value,
        ordinal: document.getElementById('ordinal').value,
        /*amor: document.getElementById('XXX').value,*/
        descr: document.getElementById('descrTxt').value,
        tq: parseInt(document.getElementById('tq').value),
        tl: parseInt(document.getElementById('tl').value)
    });
    
    var request = new XMLHttpRequest(); // TODO: make it cross browser

//    request.onreadystatechange = function() {
//        
//        if ((this.readyState === 4) && (this.status === 200)) {
//            
//            console.log(this.responseText); // there is not any response
//            
//        }
//        
//    };

    request.open('POST', 'sessionFromJS.php', true);
    request.setRequestHeader("Content-type",
        "application/x-www-form-urlencoded");
    request.send('tempPraxisData=' + tempPraxisData);
    
    return;
    
}

function validateForm(evt) { // TODO: validate
    
    this.submit();
    
}