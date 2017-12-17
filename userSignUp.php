<?php

/* 
 * userSignUp.php
 * sign up PHP file of myX
 * (c) Joaquín Javier ESTEBAN MARTÍNEZ
 * last update: 2017-11-05
 */

//session_start(); // the session is initiated NOT NEEDED

require_once 'user.inc'; // script used to manage user access

// title to be displayed in the corresponding browser tab:
$title = "myX sign up";

// description for the homonyme meta tag in the head section of the XHTML file:
$description = "Sign up form in myX";


require_once 'header.inc'; // header of all the pages of the app

echo <<<HTML
                    <article id="start">
                        <form action="userSignUpProcess.php" method="POST">
                            <p>Username: <input type="text" name="username" value="{$_POST['username']}" required="required" /></p>
                            <p>Password: <input type="password" name="password1" value="{$_POST['password1']}" required="required" /></p>
                            <p>Confirm password: <input type="password" name="password2" value="{$_POST['password2']}" required="required" /></p>
                            <p>Email: <input type="email" name="email" value="{$_POST['email']}" required="required" /></p>
                            <p><input type="submit" value="Submit" /></p>
                        </form>
                        <p>Back to <a href="index.php">start page</a></p>
                    </article>

HTML;

require_once 'footer.inc'; // footer of all the pages of the app

?>