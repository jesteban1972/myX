/**
 * script 'dashboard.js'.
 * 
 * XXX
 * @author Joaquin Javier ESTEBAN MARTINEZ <jesteban1972@me.com>
 * last updated 2018-05-12
*/

window.onload = function() {
    
    // form validation event:
    document.getElementById('goToForm').
        addEventListener('submit', submitForm, true);
    
//    /*
//     * radio buttons 'locusOrigin' are initialized.
//     */
//    
//    var locusOriginExisting = document.getElementById('locusOriginExisting');
//    var locusOriginNew = document.getElementById('locusOriginNew');
//    var locusID = document.getElementById('locusID');
//    var locusNew = document.getElementById('locusNew');
//    
//    if (locusOriginExisting.checked) { // there are some places yet. checked existing place
//        
//        locusID.disabled = false;
//        locusNew.disabled = true;
//        
//    } else /*if (locusOriginNew.checked)*/ {
//        
//        locusID.disabled = true;
//        locusNew.disabled = false;
//        
//    }
//    
//    // add event listeners to the radio buttons 'locusOrigin':
//    locusOriginExisting.addEventListener('change', changeLocusOrigin, true);
//    locusOriginNew.addEventListener('change', changeLocusOrigin, true);
//    
//    // add event listener to the button 'locusNew':
//    locusNew.addEventListener('click', newLocus, true);
//    
//    /*
//     * radio buttons 'amorOrigin' are initialized.
//     */
//    
//    var amorOriginExisting = document.getElementById('amorOriginExisting');
//    var amorOriginNew = document.getElementById('amorOriginNew');
//    var amorID = document.getElementById('amorID');
//    var amorNew = document.getElementById('amorNew');
//    
//    if (amorOriginExisting.checked) { // there are some places yet. checked existing place
//        
//        amorID.disabled = false;
//        amorNew.disabled = true;
//        
//    } else {
//        
//        amorID.disabled = true;
//        amorNew.disabled = false;
//        
//    }
//    
//    // add event listeners to the radio buttons 'amorOrigin':
//    amorOriginExisting.addEventListener('change', changeAmorOrigin, true);
//    amorOriginNew.addEventListener('change', changeAmorOrigin, true);
//    
//    // add event listener to the button 'amorNew':
//    amorNew.addEventListener('click', newAmor, true);
//    
//    // event listeners are added to 'addAmor[0]' and 'removeAmor[0]':
//    document.getElementById('addAmor[0]').
//        addEventListener('click', addAmor, true);
//    document.getElementById('removeAmor[0]').
//        addEventListener('click', removeAmor, true);
//    
//    // button removeAmor[0] is not shown on page load:
//    document.getElementById('removeAmor[0]').style.visibility = 'hidden';
    
}

function submitForm(evt) {
    
    evt.preventDefault();
    
    var goToRadios = document.getElementsByName('goTo');
    var ID = document.getElementById('ID');
    
//    goToRadios[0].name = '';
//    goToRadios[1].name = '';
//    goToRadios[2].name = '';
    
    if (goToRadios[0].checked) { // go to experience
        
        this.action = "praxis.php";
        alert(ID.value);
        ID.name = encodeURIComponent('praxisID=' + ID.value);
        alert(ID.name);
        
    } else if (goToRadios[1].checked) { // go to lover
        
        alert('lover selected');
        
    } else if (goToRadios[2].checked) { // go to place
        
        alert('locus selected');
        
    }
    this.submit();
    
}