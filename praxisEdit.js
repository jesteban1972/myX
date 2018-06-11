/**
 * script 'praxisEdit.js'.
 * 
 * this script adds functionality to the page 'praxisEdit.php'.
 * 
 * @author Joaquin Javier ESTEBAN MARTINEZ <jesteban1972@me.com>
 * last updated 2018-05-22
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
     * radio buttons 'amorOrigin' are initialized. these can be an array, and
     * its length is determined by the amount radio buttons 'amorOriginXXX'.
     */
    var amoresAmount =
            document.querySelectorAll("input[name^='amorOrigin[']").length / 2;
    
    for (var i = 0; i < amoresAmount; i++) {
        
        var amorOriginExisting =
            document.getElementById('amorOriginExisting[' + i + ']');
        var amorOriginNew =
            document.getElementById('amorOriginNew[' + i + ']');
        var amorID = document.getElementById('amorID[' + i + ']');
        var amorNew = document.getElementById('amorNew[' + i + ']');

        if (amorOriginExisting.checked) { // there are some lovers yet. checked existing lover

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

        // event listeners are added to the buttons 'addAmor[XXX]' and
        // 'removeAmor[XXX]':
        document.getElementById('addAmor[' + i + ']').
        addEventListener('click', addAmor, true);

        if (i > 0) {
            
            document.getElementById('removeAmor[' + i + ']').
            addEventListener('click', removeAmor, true);
            
        }
        
    }
    
}

/**
 * function 'addAmor'.
 * 
 * this function dynamically add a row for a participant in the experience
 * using the DOM methods.
 * 
 * @param {type} evt
 * @returns {undefined}
 */
function addAmor(evt) {
    
    var br, hr, select, att, /*option,*/ label, txt, input, button;
    
    // amoresAmount is retrieved from the already existing 'amorID' fields:
    var amoresAmount =
        document.querySelectorAll("select[name^='amorID[']").length /*+ 1*/;

    // amoresTable is the DOM element
    // and at the end of which new lovers are added:
    var amoresTable = document.getElementById('amoresTable');
    var row, cell1, cell2, cell3;
    
   if (amoresAmount === 1) { 
/*
 * a row is inserted to display a separation line after the first lover.
 */
        row = amoresTable.insertRow(-1);
        att = document.createAttribute('id');
        att.value = 'hrAfterAmor1';
        row.setAttributeNode(att);
        cell1 = row.insertCell(0);
        att = document.createAttribute('colspan');
        att.value = '3';
        cell1.setAttributeNode(att);
        hr = document.createElement('hr');
        cell1.appendChild(hr);
    
    }
    
    amoresAmount++;
    
    row = amoresTable.insertRow(-1); // insert row at the end of the table
    att = document.createAttribute('id');
    att.value = 'amor' + amoresAmount;
    row.setAttributeNode(att);
    cell1 = row.insertCell(0);
    cell2 = row.insertCell(1);
    cell3 = row.insertCell(2);
    
/*
 * first column (cell1): ordinal.
 */
    
    att = document.createAttribute('id');
    att.value = 'amorOrdinal' + amoresAmount;
    cell1.setAttributeNode(att);
    txt = document.createTextNode(amoresAmount + '.');
    cell1.appendChild(txt);
    
/*
 * second column (cell2): radio buttons.
 */

    input = document.createElement('input');
    att = document.createAttribute('type');
    att.value = 'radio';
    input.setAttributeNode(att);
    att = document.createAttribute('id');
    att.value = 'amorOriginExisting[' + (amoresAmount - 1) + ']'; // array 0-based;
    input.setAttributeNode(att);
    att = document.createAttribute('name');
    att.value = 'amorOrigin[' + (amoresAmount - 1) + ']'; // array 0-based;
    input.setAttributeNode(att);
    att = document.createAttribute('checked');
    att.value = 'checked';
    input.setAttributeNode(att);
    cell2.appendChild(input);
    
    // event listener is added to the newly created radio button:
    document.getElementById('amorOriginExisting[' + (amoresAmount - 1) + ']').
        addEventListener('change', changeAmorOrigin, true);
    
    label = document.createElement('label');
    att = document.createAttribute('for');
    att.value = 'amorOriginExisting[' + (amoresAmount - 1) + ']'; // array 0-based;
    label.setAttributeNode(att);
    txt = document.createTextNode('Existing lover');
    label.appendChild(txt);
    cell2.appendChild(label);
    
    // the dropbox is cloned to avoid a new query to the DB:
    var selectExisting = document.getElementById('amorID[0]');
    select = selectExisting.cloneNode(true);
    
    att = document.createAttribute('id');
    att.value = 'amorID[' + (amoresAmount - 1) + ']'; // array 0-based;
    select.setAttributeNode(att);
    att = document.createAttribute('name');
    att.value = 'amorID[' + (amoresAmount - 1) + ']'; // array 0-based;
    select.setAttributeNode(att);
    att = document.createAttribute('style');
    att.value = 'width: 80%'; // array 0-based;
    select.setAttributeNode(att);
    cell2.appendChild(select);
    br = document.createElement('br');
    cell2.appendChild(br);
    
    input = document.createElement('input');
    att = document.createAttribute('type');
    att.value = 'radio';
    input.setAttributeNode(att);
    att = document.createAttribute('id');
    att.value = 'amorOriginNew[' + (amoresAmount - 1) + ']'; // array 0-based;
    input.setAttributeNode(att);
    att = document.createAttribute('name');
    att.value = 'amorOrigin[' + (amoresAmount - 1) + ']'; // array 0-based;
    input.setAttributeNode(att);
    cell2.appendChild(input);
    
    // event listener is added to the newly created radio button:
    document.getElementById('amorOriginNew[' + (amoresAmount - 1) + ']').
        addEventListener('change', changeAmorOrigin, true);
    
    label = document.createElement('label');
    att = document.createAttribute('for');
    att.value = 'amorOriginNew[' + (amoresAmount - 1) + ']'; // array 0-based;
    label.setAttributeNode(att);
    txt = document.createTextNode('New lover');
    label.appendChild(txt);
    cell2.appendChild(label);
    
    button = document.createElement('button');
    att = document.createAttribute('type');
    att.value = 'button';
    button.setAttributeNode(att);
    att = document.createAttribute('id');
    att.value = 'amorNew[' + (amoresAmount - 1) + ']'; // array 0-based
    button.setAttributeNode(att);
    txt = document.createTextNode('Add lover...');
    button.appendChild(txt);
    button.addEventListener('click', newAmor, true);
    cell2.appendChild(button);

/*
 * third column (cell3): plus and minus buttons.
 */
    
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
    cell3.appendChild(button);
    
    // event listener is added to the newly created button:
    button.addEventListener('click', addAmor, true);
    
    // button 'removeAmor':
    button = document.createElement('button');
    att = document.createAttribute('type');
    att.value = 'button';
    button.setAttributeNode(att);
    att = document.createAttribute('id');
    att.value = 'removeAmor[' + (amoresAmount - 1) + ']'; // array 0-based
    button.setAttributeNode(att);
    txt = document.createTextNode('-');
    button.appendChild(txt);
    cell3.appendChild(button);
    
    // event listener is added to the newly created button:
    button.addEventListener('click', removeAmor, true);
    
    // button removeAmor[0] shown when amoresAmount > 1:
//    if (amoresAmount > 1)
//        document.getElementById('removeAmor[0]').style.visibility = 'visible';
//    else
//        document.getElementById('removeAmor[0]').style.visibility = 'hidden';
    
/*
 * another row is inserted to display a the separation line.
 */
    row = amoresTable.insertRow(-1);
    att = document.createAttribute('id');
    att.value = 'hrAfterAmor' + amoresAmount;
    row.setAttributeNode(att);
    cell1 = row.insertCell(0);
    att = document.createAttribute('colspan');
    att.value = '3';
    cell1.setAttributeNode(att);
    
    br = document.createElement('hr');
    cell1.appendChild(br);
    
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
    
    // get the index of the lover whose origin is being changed:
    var amorIndex = parseInt(evt.target.name.match(/\d+/g));
    
    var amorOriginExisting =
        document.getElementById('amorOriginExisting[' + amorIndex + ']');
    var amorOriginNew =
        document.getElementById('amorOriginNew[' + amorIndex + ']');
    var amorID = document.getElementById('amorID[' + amorIndex + ']');
    var amorNew = document.getElementById('amorNew[' + amorIndex + ']');
    
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
    
    storeTempPraxisData(); // store in the session the data input so far
    
    // redirect to 'locusEdit.php' passing in the URL an argument (GET method):
    window.location = 'amorEdit.php?tempPraxis=1';
    
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
    
    storeTempPraxisData(); // store in the session the data input so far
    
    // redirect to 'locusEdit.php' passing in the URL an argument (GET method):
    window.location = 'locusEdit.php?tempPraxis=1';
    
}

function removeAmor(evt) {
    
    var select, input, button, hr; // DOM
    
    // amoresTable is the DOM element
    // from where lovers are deleted:
    var amoresTable = document.getElementById('amoresTable');
    
/*
 * amorIndex is the lover currently being removed. it is 0-based
 */

    // get the current lover index from minus button (id="removeAmor[XXX]"):
    var amorIndex = parseInt(evt.target.id.match(/\d+/g));
    
    // the separation line with the next lover is deleted:
    var hrAfterAmor = document.getElementById('hrAfterAmor' + (amorIndex + 1));
    hrAfterAmor.parentNode.removeChild(hrAfterAmor);
    
    // the row is deleted:
    var amor = document.getElementById('amor' + (amorIndex + 1));
    amor.parentNode.removeChild(amor);
    //amoresTable.deleteRow(amorIndex);
    
    // if only amor1 remains, delete the hr after his/her row:
    var amoresAmount =
        document.querySelectorAll("select[name^='amorID[']").length;
    if (amoresAmount === 1) {
        
        hrAfterAmor = document.getElementById('hrAfterAmor1');
        hrAfterAmor.parentNode.removeChild(hrAfterAmor);
        
    }
   
/*
 * indexes are rearranged:
 * when a lover is removed (e.g. lover #3),
 * the indexes of the remaining lovers (0, 1, 3...)
 * are to be rearranged (0, 1, 2...)
 * so that the values sent are in a coherent sequence in order the can be
 * succesfully processed.
 */

    var currentIndex;
    var amorOrigin = document.querySelectorAll("input[name^='amorOrigin[']");
    var amorID = document.querySelectorAll("select[id^='amorID[']");
    var amorNew = document.querySelectorAll("button[id^='amorNew[']");
    var amor, hrAfterAmor, amorOrdinal;

    for (var i = 0; i < (amorOrigin.length / 2); i ++) { // 2 entries/lover

        currentIndex = parseInt(amorID[i].id.match(/\d+/g)); // 0-based
        
        if (currentIndex !== i) {
            
            // update tr id and hr:
            // fix!
            amor = document.getElementById('amor' + (currentIndex + 1));
            amor.id = 'amor' + (i + 1);
            hrAfterAmor = document.getElementById('hrAfterAmor' + (currentIndex + 1));
            hrAfterAmor.id = 'hrAfterAmor' + (i + 1);

            // update the ordinal number:
            amorOrdinal = document.getElementById('amorOrdinal' + (currentIndex + 1));
            amorOrdinal.innerHTML = '<p>' + (i + 1) + '.</p>';
            
            amorOrigin[i].name = 'amorOrigin[' + i + ']';
            amorID[i].id = 'amorID[' + i + ']';
            amorNew[i].id = 'amorNew[' + i + ']';
            
            document.getElementById('addAmor[' + currentIndex + ']').id =
                'addAmor[' + i + ']';
            document.getElementById('removeAmor[' + currentIndex + ']').id =
                'removeAmor[' + i + ']';
                    
            i = 0;
            
        }

    }
    
/*
 * amoresAmount is calculated only AFTER deletion commands.
 */    
//    var amoresAmount =
//        (document.querySelectorAll("select[name^='amorOrigin[']").length / 2);
    
    // button removeAmor[0] shown only  when amoresAmount > 1:
//    if (amoresAmount > 1)
//        document.getElementById('removeAmor[0]').style.visibility = 'visible';
//    else
//        document.getElementById('removeAmor[0]').style.visibility = 'hidden';
    
    return;
    
}

/**
 * function storeTempPraxisData.
 * 
 * the data input so far is JSON codified and stored in PHP's session,
 * making a non asynchronous call to microscript 'sessionFromJS.php'.
 * this function can be called in three scenaria:
 * i) optionally, when adding (or editing) a new place
 * (thus before leaving 'praxisEdit.php' going to 'locusEdit.php').
 * ii) optionally, one or more times, when adding (or editing) a new lover
 * (thus before leaving 'praxisEdit.php' going to 'amorEdit.php').
 * iii) when submitting the form
 * (thus when leaving 'praxisEdit.php' going to 'praxisEditProcess.php').
 */
function storeTempPraxisData() {
    
    // field 'locus' is prepared:
    var locusOrigin = document.getElementsByName('locusOrigin');
    var locusID = (locusOrigin[0].checked) ?
        parseInt(document.getElementById('locusID').value) :
        -1; // using temporary value -1 when new place

    // field 'amores' is prepared:
    var amorOrigin0 = document.getElementsByName('amorOrigin[0]');
    var amorID = (amorOrigin0[0].checked) ?
        parseInt(document.getElementById('amorID[0]').value) :
        -1; // using temporary value -1 when new lover

    // document data are codified as JSON:
    var tempPraxisData = JSON.stringify({
        achtung: document.getElementById('achtung').value,
        name: document.getElementById('name').value,
        rating: parseInt(document.getElementById('rating').value),
        favorite: (document.getElementById('favorite').checked) ? 1 : 0,
        locus: locusID,
        date: document.getElementById('date').value,
        ordinal: document.getElementById('ordinal').value,
        amor: amorID,
        descr: document.getElementById('descrTxt').value,
        tq: parseInt(document.getElementById('tq').value),
        tl: parseInt(document.getElementById('tl').value)
    });
    
    // codified JSON is stored in the session:
    var request = new XMLHttpRequest(); // TODO: make it cross browser
    request.open('POST', 'sessionFromJS.php', false); // non asynchonous
    request.setRequestHeader('Content-type',
        'application/x-www-form-urlencoded');
    request.send('tempPraxisData=' + tempPraxisData);
    
    return;
    
}

function validateForm(evt) {
    
    evt.preventDefault();

/*
 * the data input so far is stored in the session. unlike 'amorEditProcess.php'
 * or 'locusEditProcess.php', data are not to be taken from $_POST but from
 * $_SESSION to be recovered in 'praxisEditProcess.php'.
 */

    // existing lovers are stored in $_SESSION['tempAmorData'][]:
    var existingAmoresAmount =
            document.querySelectorAll("input[name^='amorOrigin[']").length / 2;
    
//    for (var i = 0; i < existingAmoresAmount; i++) {
//        
//        // document data are codified as JSON:
//        var tempAmorData = JSON.stringify({
//            achtung: document.getElementById('achtung').value,
//            alias: document.getElementById('alias').value,
//            rating: parseInt(document.getElementById('rating').value),
//            genre: parseInt(document.getElementById('genre').value),
//            descr1: document.getElementById('descr1').value,
//            descr2: document.getElementById('descr2').value,
//            descr3: document.getElementById('descr3').value,
//            descr4: document.getElementById('descr4').value,
//            web: document.getElementById('web').value,
//            name: document.getElementById('name').value,
//            photo: document.getElementById('photo').checked ? 1 : 0,
//            email: document.getElementById('email').value,
//            other: document.getElementById('other').value
//        });
//        
//        // store codified JSON in the session:
//        var request = new XMLHttpRequest(); // TODO: make it cross browser
//        request.open('POST', 'sessionFromJS.php', false); // non asynchonous
//        request.setRequestHeader("Content-type",
//            'application/x-www-form-urlencoded');
//        request.send('tempAmorData=' + tempAmorData);
//    
//    }
    
    // experience data are stored in $_SESSION['tempPraxisData']:
    storeTempPraxisData();
    
    /*
     * the form is validated.
     */
    
    var doesValidate = true; // default value
    
    // name validation:
    var name = document.getElementById('name');
    if (name.value === '') {
        
        doesValidate = false;
        name.style.borderColor = 'red';
        
    }
    
    // place validation:
    var locusID = document.getElementById('locusID');
    var isTempLocus = document.getElementById('isTempLocus');
    if (locusID.value === "" && isTempLocus.value === "false") {
        
        doesValidate = false;
        document.getElementById('locusLegend').style.color = 'red';
        
    }
    
    // date validation:
    var date = document.getElementById('date');
    if (date.value === "") {
        
        doesValidate = false;
        date.style.borderColor = 'red';
        
    }
    
    if (doesValidate) { // validation OK
        
        console.log('form validation successfully');
        this.submit(); // the form is submitted
    
    } else {
        
        // the form is not submitted
        console.log('form validation failed');
        
    }
    
}