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
    require_once('view/IUseCaseView.php');
    require_once('view/RegisterView.php');   
    require_once('view/LoginView.php');

    require_once('model/Exception.php');
    require_once('model/DBConnector.php');

    $layoutView = new \view\LayoutView(); 
    $dateTimeView = new \view\DateTimeView();
    $loginView = new \view\LoginView();
    $registerView = new \view\RegisterView();

    $user = new \model\User();

    $loginController = new \controller\LoginUserController($user, $layoutView, $loginView, $dateTimeView);
    $registerController = new \controller\RegisterUserController($user, $layoutView, $registerView, $dateTimeView);
    $mainController = new \controller\UserController($user, $loginController, $registerController);

    $mainController->greetUserCorrectly();
?>