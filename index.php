<?php
    session_start();

    error_reporting(E_ALL);
    ini_set('display_errors', 'On');

    require_once('controller/LoggedOutUserController.php');
    require_once('controller/LoggedInUserController.php');

    require_once('view/LogoutView.php');   
    require_once('view/DateTimeView.php');
    require_once('view/LayoutView.php');
    require_once('view/LoginView.php');
    require_once('view/RegisterView.php');

    $logoutView = new LogoutView();
    $dateTime = new DateTimeView();
    $layout = new LayoutView(); 

    $loginView = new LoginView();
    $registerView = new RegisterView();
    $dateTime = new DateTimeView();
    $layout = new LayoutView();

    $isLoggedIn = $_SESSION ? $_SESSION["isLoggedIn"] ? $_SESSION["isLoggedIn"] : false : false;    
    $wantsToRegister = isset($_GET["register"]);

    if ($isLoggedIn) {
        $layout->renderToOutput($logoutView, $dateTime);
    } else if ($wantsToRegister) {
        $layout->renderToOutput($registerView, $dateTime);
    } else {
        $layout->renderToOutput($loginView, $dateTime);
    }

/*
to show logged in page
display session_login message
then
delete session_login message
if log out is pressed
destroy session
and
destroy saved username cookie
and
destroy saved password cookie

on logged out page
if cookie-username && cookie password isset
login user with those credentials
else if get_register user isset
display register user page
else
display session_error message
then
delete session_error message
display register user-link
and
display login form

when login is pressed (post_logininfo isset)
if username and password exist
try login with those credentials
else
set session_error message

to login with those credentials
check if username exists and matches password (http://php.net/manual/en/function.password-verify.php)
and if it does
login
else
save session_latest login credentials
set session_error message

to login
save login credentials
set session_login message
and set session_logged in to true

to save login credentials
set session_latest login credentials
and
check if keep logged in is true
and if it is
set password-cookie and username-cookie


to set password cookie and username cookie
do something with php_cookies


to display register user page
display index link
display session_registererror
delete session_ registererror
and display register-userform

when register is pressed (post_registerinfo isset)
check that info is valid
and if it is
register user
and
set session_latest username
else
set session_registererror


to check that info is valid
check that username and password is present
check that username is correct
check that password is correct
check that passwords match

to register user
hash password
and put in database with username*/




?>