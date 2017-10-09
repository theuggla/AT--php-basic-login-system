<?php
    session_start();

    error_reporting(E_ALL);
    ini_set('display_errors', 'On');

    require_once('LoginModule/model/IPersistance.php');
    require_once('LoginModule/LoginModule.php');

    require_once('Site/view/LayoutView.php');
    require_once('Site/view/DateTimeView.php');
    require_once('Site/persistance/MSQLConnector.php');
    require_once('Site/persistance/LoginModulePersistance.php');

    $cookieExpiryTimeInSeconds = 1000;

    $msqlconnection = \site\persistance\MSQLConnector::getConnection('UserRegistry');
    $persistanceHandler = new \loginmodule\persistance\LoginModulePersistance($msqlconnection);

    $dateTimeView = new \site\view\DateTimeView();
    $layoutView = new \site\view\LayoutView($dateTimeView);
    $loginModule = new \loginmodule\LoginModule($persistanceHandler, $cookieExpiryTimeInSeconds);

    $loginModule->startLoginModule();
    $layoutView->renderToOutput($loginModule->loggedInStatus(), $loginModule->currentHTML());
