/**
 * script 'userSignUp.js'.
 * 
 * this script is used to provide complementary functionality to the form
 * of the script 'userSignUp.php'. 
 * 
 * @author Joaquin Javier ESTEBAN MARTINEZ <jesteban1972@me.com>
 * last updated 2018-06-09
*/

window.onload = function() {
    
    // add event to the username input:
    document.getElementById('username').
        addEventListener('input', checkAvailability, true);

    // add event to form submit:
    document.getElementById("userSignUpForm").
        addEventListener('submit', validateForm, true);

    // add event to password boxes:
    document.getElementById('password1').
        addEventListener('input', resetPasswordMessage, true);
    document.getElementById('password2').
        addEventListener('input', resetPasswordMessage, true);
    
}

function checkAvailability(evt) {
    
    usernameAvailability = document.getElementById('usernameAvailability');
    
    if (!isValidUsername())
        return;
    
    var request = new XMLHttpRequest(); // TODO: make it cross browser

    request.onreadystatechange = function() {
        
        if ((this.readyState === 4) && (this.status === 200)) {

            
            if (this.responseText === '1') {
            
                usernameAvailability.style.color = 'red';
                usernameAvailability.innerHTML = 'Username already exists';
            
            } else {
                
                usernameAvailability.style.color = 'green';
                usernameAvailability.innerHTML = 'Username is available';
                
            }
            
        }
        
    };

    request.open('GET',
        'userSignUpAvailability.php?username=' + evt.target.value, true);

    request.send(null);
    
}

/**
 * 
 * function 'doesPasswordMatch'.
 * 
 * this function check if the values input in the fields 'password1' and
 * 'password2' are the same.
 * 
 * @return bool boolean value indicating whether the values input in the fields
 * 'password1' and 'password2' are the same.
 */
function doesPasswordMatch() {
    
    var doesPasswordMatch = true;
    var passwordMessage = document.getElementById('passwordMessage');
    
    var password1 = document.getElementById('password1').value;
    var password2 = document.getElementById('password2').value;
    
    if (password1 !== password2) {
        
        passwordMessage.style.visibility = 'visible';
        passwordMessage.innerHTML = 'Password does not match.';
        
        doesPasswordMatch = false;
        
    }
    
    return doesPasswordMatch;
    
}

/**
 * function 'isValidEmail'.
 * 
 * this function checks if the input email is valid.
 *
 * @return bool boolean value indicating whether the input email is valid or
 * not.
 */
function isValidEmail() {
    
    var isValidEmail = true;
    
    var email = document.getElementById('email').value;
    var pattern = /^[a-z]([a-z0-9_.\-])+@[a-z]([a-z_.\-]+)+(\.[a-z]{3})$/;
    
    if (!pattern.test(email)) {
        
        //errorMsg += " <b>Wrong email</b>, it should be a valid email address.";
        isValidEmail = false;
        
    }
    
    return isValidEmail;
    
}

/**
 * function 'isValidUsername'.
 * 
 * this function checks if the input username is valid.
 * 
 * a valid username should be between 6 and 255 characters length, including
 * only latin alphabetical characters, numbers, space, underscore or hyphen.
 *
 * @return bool boolean value indicating whether the input username is valid or
 * not.
 */
function isValidUsername() {
    
    var isValidUsername = true;

    var username = document.getElementById('username').value.trim();
    var pattern = /^[a-zA-Z0-9 _-]+$/;
    var failureMessage;
    
    var usernameAvailability = document.getElementById('usernameAvailability');
    usernameAvailability.style.visibility = 'visible';
    
    if (username.length < 6 ||
            username.length > 255 ||
            !pattern.test(username)) {
        
        usernameAvailability.style.color = 'red';
        failureMessage = 'Wrong username: ';
        
        if (username.length < 6 || username.length > 255)
            var wrongLength = true;
        
        isValidUsername = false;
        
        if (username.length < 6)
            failureMessage +=
                "Minimal length 6 characters";
        
        else if (username.length > 255)
            failureMessage +=
                "Maximal length 255 characters";
        
        if (!pattern.test(username)) {
        
            if (wrongLength)
                failureMessage += '; '
        
            failureMessage +=
                "Invalid character(s) used (only latin letters, whitespace, underscore and hyphen allowed).";
        
        }
            
    }
    
    usernameAvailability.innerHTML = failureMessage;
    
    return isValidUsername;

}

function resetPasswordMessage() {
    
    document.getElementById('passwordMessage').style.visibility = 'hidden';
    
}

/**
 * function 'validateForm'.
 * 
 * this function validates the form.
 */
function validateForm(evt) {
    
    evt.preventDefault();
    
    var doesValidate = true; // default value
       
    // username validation:
    if (!isValidUsername())
        doesValidate = false;
    else
        document.getElementById('usernameAvailability').style.visibility =
            'hidden';
    
    // passwords match validation:
    if (!doesPasswordMatch())
        doesValidate = false;
    else
        document.getElementById('passwordMessage').style.visibility = 'hidden';
    
    // email validation:
    if (!isValidEmail())
        doesValidate = false;
    
    // birthdate validation:
    
    if (doesValidate) { // validation OK
        
        console.log('form validation successfully');
        this.submit(); // the form is submitted
    
    } else {
        
        // the form is not submitted
        console.log('form validation failed');
        
    }
    
}