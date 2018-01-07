<?php
        session_start();
        
            error_reporting(E_ALL);
            ini_set('display_errors', 'On');

    require_once('LoginModule/model/IPersistance.php');
    require_once('LoginModule/LoginModule.php');

    require_once('ABISDB/AbisDB.php');

    require_once('Site/view/LayoutView.php');
    require_once('Site/persistance/MSQLConnector.php');
    require_once('Site/persistance/LoginModulePersistance.php');

    $userDB = 'UserRegistry';
    $userconnection = \site\persistance\MSQLConnector::getConnection($userDB);
    $persistanceHandler = new \site\persistance\LoginModulePersistance($userconnection);

    $abisDB = 'ABIS';
    $abisconnection = \site\persistance\MSQLConnector::getConnection($abisDB);

    $layoutView = new \site\view\LayoutView();

    $cookieExpiryTimeInSeconds = 1000;
    $loginModule = new \loginmodule\LoginModule($persistanceHandler, $cookieExpiryTimeInSeconds);
    $abisDB = new \abisDB\AbisDB($abisconnection);

    $loginModule->startLoginModule();
    $abisDB->runDB($loginModule->getLoggedInStatus());
    
    $layoutView->renderToOutput($loginModule->getLoggedInStatus(),
                                $loginModule->getCurrentHTML(),
                                $abisDB->getCurrentHTML());
