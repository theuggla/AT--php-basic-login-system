# Integrated PHP - login module.
This branch shows how to integrate the login module with another system. The example is simple, and made to show the basic principle behind the integration.

A live version of only the login-module can be found [here](http://178.62.87.11/basic-functionality/).

[A live version where the login module have been integrated with a simple TicTacToe-game](http://178.62.87.11/added-functionality/).

## Status of the system

### Login Module

#### Use Cases

[List of Use Cases the Login module is fullfilling] (https://github.com/dntoll/1dv610/blob/master/assignments/A2_resources/UseCases.md)

### TicTacToe Game

#### Use Cases

[List of Use Cases the TicTacToe module is fullfilling] (https://github.com/dntoll/1dv610/blob/master/assignments/A2_resources/UseCases.md)

## Install

### Login Module
    ```php
    session_start();

    require_once('LoginModule/model/IPersistance.php');
    require_once('LoginModule/LoginModule.php');

    require_once('Site/view/LayoutView.php');
    require_once('Site/view/DateTimeView.php');
    require_once('Site/persistance/MSQLConnector.php');
    require_once('Site/persistance/LoginModulePersistance.php');

    $cookieExpiryTimeInSeconds = 1000;
    $databaseName = 'UserRegistry';

    $msqlconnection = \site\persistance\MSQLConnector::getConnection('UserRegistry');
    $persistanceHandler = new \loginmodule\persistance\LoginModulePersistance($msqlconnection);

    $dateTimeView = new \site\view\DateTimeView();
    $layoutView = new \site\view\LayoutView($dateTimeView);

    $loginModule = new \loginmodule\LoginModule($persistanceHandler,                        
                                                $cookieExpiryTimeInSeconds);

    $loginModule->startLoginModule();
    
    $layoutView->renderToOutput($loginModule->getLoggedInStatus(),
                                $loginModule->getCurrentHTML());
    ```

### TicTacToe Game

## Test

### Login Module

#### Manual Test Cases

[A list of manual test cases here](https://github.com/dntoll/1dv610/blob/master/assignments/A2_resources/TestCases.md), written by [Daniel Toll](https://github.com/dntoll).  

To test the login-module, either manually go through the test cases or run the pre-written application against it. If you are testing the live version referenced above, the following credentials will work with the system:
**username:** Othman
**password:** elkabir

#### Automated Test Application

[An automated test application that runs those tests here](http://csquiz.lnu.se:25083/index.php), written by [Daniel Toll](https://github.com/dntoll).

### TicTacToe Game

#### Manual Test Cases

[A list of manual test cases here](https://www.google.com).

To test the TicTacToe-game, manually go through the test cases.

Not all the test cases are working at the applications current state - a reference of what test cases are current working can be found [here](https://www.google.com).
