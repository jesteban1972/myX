/**
 * script userSignUp.js
 * XXX
 * (c) Joaquin Javier ESTEBAN MARTINEZ
 * last updated 2018-04-10
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
    
    // username must be at least 6 characters length:
//    if (evt.target.value.length < 6) {
//        
//        usernameAvailability.innerHTML = '';
//        return;
//        
//    }
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
 * @type Boolean
 */
function doesPasswordMatch() {
    
    var doesPasswordMatch = true;
    var passwordMessage = document.getElementById('passwordMessage');
    
    var password1 = document.getElementById('password1').value;
    var password2 = document.getElementById('password2').value;
    
    if (password1 !== password2) {
        
        passwordMessage.style.visibility = 'visible';
        passwordMessage.innerHTML = 'Password does not match.'
        
        doesPasswordMatch = false;
        
    }
    
    return doesPasswordMatch;
    
}

/**
 * 
 * the username must be a string containing any ASCII characters
 * whith minimal length 6 and maximal length 255.
 *
 * @type Boolean
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

function validateForm(evt) {
    
    var validates = true;
    
    evt.preventDefault();
    
    // username validation:
    if (!isValidUsername())
        validates = false;
    else
        document.getElementById('usernameAvailability').style.visibility =
            'hidden';
    
    // passwords match validation:
    if (!doesPasswordMatch())
        validates = false;
    else
        document.getElementById('passwordMessage').style.visibility = 'hidden';
    
    // email validation:
    if (!isValidEmail())
        validates = false;
    
    // birthdate validation:
    
    if (validates) { // validation OK
        
        console.log('validation OK');
        this.submit(); // the form is submitted
    
    } else {
        
        // the form is not submitted
        console.log('validation KO');
        
    }
    
}