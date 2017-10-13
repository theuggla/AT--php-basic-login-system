<?php
    session_start();

    error_reporting(E_ALL);
    ini_set('display_errors', 'On');

    require_once('LoginModule/model/IPersistance.php');
    require_once('LoginModule/LoginModule.php');

    require_once('TicTacToe/TicTacToe.php');

    require_once('Site/view/LayoutView.php');
    require_once('Site/view/DateTimeView.php');
    require_once('Site/persistance/MSQLConnector.php');
    require_once('Site/persistance/LoginModulePersistance.php');

    $cookieExpiryTimeInSeconds = 1000;
    $databaseName = 'UserRegistry';
    $msqlconnection = \site\persistance\MSQLConnector::getConnection($databaseName);
    $persistanceHandler = new \site\persistance\LoginModulePersistance($msqlconnection);

    $dateTimeView = new \site\view\DateTimeView();
    $layoutView = new \site\view\LayoutView($dateTimeView);

    $loginModule = new \loginmodule\LoginModule($persistanceHandler, $cookieExpiryTimeInSeconds);
    $ticTacToe = new \tictactoe\TicTacToe();

    $loginModule->startLoginModule();
    $ticTacToe->runGame($loginModule->getLoggedInStatus());
    
    $layoutView->renderToOutput($loginModule->getLoggedInStatus(),
                                $loginModule->getCurrentHTML(),
                                $ticTacToe->getCurrentHTML());
