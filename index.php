<?php
    session_start();

    error_reporting(E_ALL);
    ini_set('display_errors', 'On');

    require_once('controller/LogoutUserController.php');
    require_once('controller/LoginUserController.php');
    require_once('controller/RegisterUserController.php');
    require_once('controller/UserController.php');

    require_once('model/User.php');
    require_once('model/Username.php');
    require_once('model/Password.php');

    require_once('view/LayoutView.php');
    require_once('view/DateTimeView.php');
    require_once('view/IUseCaseView.php');
    require_once('view/LogoutView.php');
    require_once('view/RegisterView.php');   
    require_once('view/LoginView.php');

    require_once('model/Exception.php');
    require_once('model/DBConnector.php');

    $layoutView = new \view\LayoutView(); 
    $dateTimeView = new \view\DateTimeView();
    $loginView = new \view\LoginView();
    $logoutView = new \view\LogoutView();
    $registerView = new \view\RegisterView();

    $user = new \model\User();
    $db = new \model\DBConnector();

    $db->connect('UserRegistry');

    $loginController = new \controller\LoginUserController($user, $layoutView, $loginView, $dateTimeView);
    $logoutController = new \controller\LogoutUserController($user, $layoutView, $logoutView, $dateTimeView);
    $registerController = new \controller\RegisterUserController($user, $layoutView, $registerView, $dateTimeView);
    $mainController = new \controller\UserController($user, $loginController, $logoutController, $registerController);

    $mainController->greetUserCorrectly();
/*
    $isLoggedIn = isset($_SESSION["isLoggedIn"]) ? $_SESSION["isLoggedIn"] : false ;    
    $wantsToRegister = isset($_GET["register"]);

    if ($isLoggedIn) {
        showLogoutPage();
    } else if ($wantsToRegister) {
        showRegisterPage();
    } else {
        showLoginPage();
    }

    function showLogoutPage() {
        $message = getCurrentMessage();
        $layout->renderToOutput($logoutView, $dateTime, $message);
        removeCurrentMessage();

        if (userWantsToLogOut()) {
            logoutUser();
        }
    }

    function showLoginPage() {
        if (thereAreSavedCredentials()) {
            $username = getSavedUsername();
            $password = getSavedPassword();

            loginUser($username, $password);
        } else {
            $layout = new LayoutView(); 
            $logoutView = new LogoutView();
            $dateTime = new DateTimeView();
            $loginView = new LoginView();
            $registerView = new RegisterView(); 

            $message = getCurrentMessage();
            $layout->renderToOutput($loginView, $dateTime, $message);
            removeCurrentMessage();

            if (userTriesToLogin()) {
                $username = getNewUsername();
                $password = getNewPassword();

                loginUser($username, $password);
            }
        }
    }

    function thereAreSavedCredentials() {
        return false;
    }

    function getCurrentMessage() {
        $message = isset($_SESSION['current_message']) ? $_SESSION['current_message'] : '';

        return $message;
    }

    function removeCurrentMessage() {
        if (isset($_SESSION['current_message'])) {
            unset($_SESSION['current_message']);
        }
    }

    function userTriesToLogin() {
        return isset($_POST['LoginView::Login']);
    }

    function showRegisterPage() {
        $message = getCurrentMessage();
        $layout->renderToOutput($registerView, $dateTime, $message);
        $this->removeCurrentMessage();

        if (userTriesToSignup()) {
                $username = getNewUsername();
                $password = getNewPassword();

                registerUser($username, $password);
            }
    }

    function getNewUsername() {
        return $_POST['LoginView::UserName'];
    }

    function getNewPassword() {
        return $_POST['LoginView::Password'];
    }

    function loginUser() {
        $_SESSION['current_message'] = 'wrong username or password';
    }

    function logoutUser() {
        destroySession();
        destroyCookies();
    }

/*

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