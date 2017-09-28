<?php
    session_start();

    error_reporting(E_ALL);
    ini_set('display_errors', 'On');
    
    require_once('controller/LoginUserController.php');
    require_once('controller/RegisterUserController.php');
    require_once('controller/UserController.php');

    require_once('model/User.php');
    require_once('model/Username.php');
    require_once('model/Password.php');
    require_once('model/Cookie.php');

    require_once('view/LayoutView.php');
    require_once('view/DateTimeView.php');
    require_once('view/RegisterView.php');   
    require_once('view/LoginView.php');

    require_once('model/Exception.php');
    require_once('model/MSQLConnector.php');
    require_once('model/Persistance.php');

    $dateTimeView = new \view\DateTimeView();
    $layoutView = new \view\LayoutView($dateTimeView);
    $loginView = new \view\LoginView();
    $registerView = new \view\RegisterView();

    $dbconnection = \model\DBConnector::getConnection('UserRegistry');
    $persistance = new \model\Persistance($dbconnection);

    $user = new \model\User($persistance);
    $cookie = new \model\Cookie(1000, $persistance);

    $loginController = new \controller\LoginUserController($user, $cookie, $loginView);
    $registerController = new \controller\RegisterUserController($user, $registerView);
    $mainController = new \controller\UserController($user, $loginController, $registerController, $layoutView);

    $mainController->listenForUserAccessAttempt();