/**
 * script 'userOptions.js'.
 * 
 * this script is used to provide complementary functionality to the form
 * of the script 'userOptions.php'. 
 * 
 * @author Joaquin Javier ESTEBAN MARTINEZ <jesteban1972@me.com>
 * last updated 2018-06-09
*/

window.onload = function() {
    
    // add event to form submit:
    document.getElementById("userOptionsForm").
        addEventListener('submit', validateForm, true);
    
}

/**
 * function 'validateForm'.
 * 
 * this function validates the form.
 */
function validateForm(evt) {
    
    evt.preventDefault();
    
    var doesValidate = true; // default value
    
    // resultsPerPage validation:
    var resultsPerPage = document.getElementById('resultsPerPage');
    if (resultsPerPage.value < 1) {
        
        doesValidate = false;
        resultsPerPage.style.borderColor = 'red';
        
    }
    
    if (doesValidate) { // validation OK
        
        console.log('form validation successfully');
        this.submit(); // the form is submitted
    
    } else {
        
        // the form is not submitted
        console.log('form validation failed');
        
    }
    
}