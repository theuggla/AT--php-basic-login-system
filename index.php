<?php
    session_start();

    require_once('model/IPersistance.php');

    // External dependecies - the view to be injected into, and a database / other persistance layer
    // that implements the IPersistance interface.
    require_once('view/LayoutView.php');
    require_once('view/DateTimeView.php');
    require_once('persistance/MSQLConnector.php');
    require_once('persistance/Persistance.php');

    $msqlconnection = \persistance\MSQLConnector::getConnection('UpdatedUserRegistry');
    $persistance = new \persistance\Persistance($msqlconnection);
    $dateTimeView = new \view\DateTimeView();
    $layoutView = new \view\LayoutView($dateTimeView);
    // End external dependencies.
    
    require_once('controller/LoginUserController.php');
    require_once('controller/RegisterUserController.php');
    require_once('controller/UserController.php');

    require_once('model/User.php');
    require_once('model/Username.php');
    require_once('model/Password.php');
    require_once('model/Cookie.php');

    require_once('view/RegisterView.php');
    require_once('view/LoginView.php');

    require_once('model/Exception.php');

    $loginView = new \view\LoginView();
    $registerView = new \view\RegisterView();

    $cookieExpiryTimeInSeconds = 1000;
    $user = new \model\User($persistance);
    $cookie = new \model\Cookie($cookieExpiryTimeInSeconds, $persistance);

    $loginController = new \controller\LoginUserController($user, $cookie, $loginView);
    $registerController = new \controller\RegisterUserController($user, $registerView);
    $mainController = new \controller\UserController($user, $loginController, $registerController, $layoutView);

    $mainController->listenForUserAccessAttempt();
