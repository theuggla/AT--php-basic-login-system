<?php
    session_start();

    error_reporting(E_ALL);
    ini_set('display_errors', 'On');

    require_once('LoginModule/model/IPersistance.php');

    // External dependecies - the view to be injected into, and a database / other persistance layer
    // that implements the IPersistance interface.
    require_once('Site/view/LayoutView.php');
    require_once('Site/view/DateTimeView.php');
    require_once('Site/persistance/MSQLConnector.php');
    require_once('Site/persistance/LoginModulePersistance.php');

    $msqlconnection = \persistance\MSQLConnector::getConnection('UserRegistry');
    $persistance = new \persistance\LoginModulePersistance($msqlconnection);
    $dateTimeView = new \view\DateTimeView();
    $layoutView = new \view\LayoutView($dateTimeView);
    // End external dependencies.
    
    require_once('LoginModule/controller/RegisterUserController.php');
    require_once('LoginModule/controller/LoginUserController.php');
    require_once('LoginModule/controller/MainController.php');

    require_once('LoginModule/model/User.php');
    require_once('LoginModule/model/Username.php');
    require_once('LoginModule/model/Password.php');
    require_once('LoginModule/model/Cookie.php');
    require_once('LoginModule/model/Exception.php');

    require_once('LoginModule/view/RegisterView.php');
    require_once('LoginModule/view/LoginView.php');

    $loginView = new \loginmodule\view\LoginView();
    $registerView = new \loginmodule\view\RegisterView();

    $cookieExpiryTimeInSeconds = 1000;
    $cookie = new \loginmodule\model\Cookie($cookieExpiryTimeInSeconds, $persistance);
    $user = new \loginmodule\model\User($persistance);

    $loginController = new \loginmodule\controller\LoginUserController($user, $cookie, $loginView);
    $registerController = new \loginmodule\controller\RegisterUserController($user, $registerView);
    $mainController = new \loginmodule\controller\MainController($user, $loginController, $registerController, $layoutView);

    $mainController->listenForUserAccessAttempt();
