/**
 * script 'amorEdit.js'.
 * 
 * this script is used to provide complementary functionality to the form
 * of the script 'amorEdit.php'.
 * 
 * @author Joaquin Javier ESTEBAN MARTINEZ <jesteban1972@me.com>
 * last updated 2018-06-09
*/

window.onload = function() {
    
    // event listener is added to form:
    document.getElementById('amorEditForm').
        addEventListener('submit', submitForm, true);
    
}

function submitForm(evt) {
    
    evt.preventDefault();
    
    var tempPraxis = document.getElementById('tempPraxis');
    
    if (tempPraxis === null) {
        // if tempPraxis not set, script called from 'amor.php' for edition
        
        var doesValidate = true; // default value
        
        // alias validation:
        var alias = document.getElementById('alias');
        if (alias.value === '') {

            doesValidate = false;
            alias.style.borderColor = 'red';

        }
        
        if (doesValidate) { // validation OK
        
            console.log('form validation successfully');
            this.submit(); // the form is submitted
    
        } else {
        
            // the form is not submitted
            console.log('form validation failed');

        }
        
    } else { // save and continue
        
        // codify document data:
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
        
        // store codified JSON in the session:
        var request = new XMLHttpRequest(); // desideratum: cross browser
        request.open('POST', 'sessionFromJS.php', false); // non asynchonous
        request.setRequestHeader("Content-type",
            'application/x-www-form-urlencoded');
        request.send('tempAmorData=' + tempAmorData);

        // redirect to 'praxisEdit.php':
        window.location = 'praxisEdit.php?tempAmor=1';
        
    }
    
}