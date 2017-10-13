# Integrated PHP - login module.
This branch shows how to integrate the login module with another system. The example is simple, and made to show the basic principle behind the integration.

A live version of only the login-module can be found [here](http://178.62.87.11/basic-functionality/).

[A live version where the login module have been integrated with a simple TicTacToe-game](http://178.62.87.11/added-functionality/).

## Status of the system

### Login Module

#### Use Cases

[List of Use Cases the Login module is fullfilling](https://github.com/dntoll/1dv610/blob/master/assignments/A2_resources/UseCases.md)

### TicTacToe Game

#### Use Cases

[List of Use Cases the TicTacToe module is fullfilling](https://github.com/dntoll/1dv610/blob/master/assignments/A2_resources/UseCases.md)

## Install

### Login Module

#### Getting the module
The following is an example code snippet from an `index.php` file, to show how to install and integrate the module. We will go through it step by step.

```
    session_start();

    require_once('LoginModule/model/IPersistance.php');
    require_once('LoginModule/LoginModule.php');

    require_once('Site/view/LayoutView.php');
    require_once('Site/view/DateTimeView.php');
    require_once('Site/persistance/MSQLConnector.php');
    require_once('Site/persistance/LoginModulePersistance.php');

    $databaseName = 'UserRegistry';
    $msqlconnection = \site\persistance\MSQLConnector::getConnection($databaseName);
    $persistanceHandler = new \site\persistance\LoginModulePersistance($msqlconnection);
    
    $cookieExpiryTimeInSeconds = 1000;
    
    $dateTimeView = new \site\view\DateTimeView();
    $layoutView = new \site\view\LayoutView($dateTimeView);

    $loginModule = new \loginmodule\LoginModule($persistanceHandler,                        
                                                $cookieExpiryTimeInSeconds);

    $loginModule->startLoginModule();
    
    $layoutView->renderToOutput($loginModule->getLoggedInStatus(),
                                $loginModule->getCurrentHTML());
```
    
1. Pull down the module to your computer, either with `git clone` or by downloading the zip-file from the realeases tab of this repo -> php-login L", release 2.0.
2. Place the folder named LoginModule in the root directory of the site that wishes to use it.
3. In your `index.php`, set up the module.

#### Setting up the module in index.php

The Login module demands the following:
* An ongoing session.
* A persistance class, implementing the IPersistance interface supplied,
* An optional expirytime for the cookies, if the user would like to save their credentials.

The Login module will supply:
* An HTML-string of the module and it's current status.
* A boolean representing the current status of the user - are they logged in or not.

##### The basics

###### Initiating the module

1. Make sure there is a session running. If there is not, the module will crash on upstart.

```
session_start();
```

2. Require the module s and the IPersistance interface. This should probably be done first, before requiring the class you have written, that implements this interface.

```
require_once('LoginModule/model/IPersistance.php');
require_once('LoginModule/LoginModule.php');
```

3. Require the class you have written that implements this interface and it's dependencies. In this case it is a simple MYSQL-database, but it could be any sort of persistance, even a text file. The interface-specification can be found [here](https://github.com/theuggla/basic-php-login-system/blob/added-functionality/LoginModule/model/IPersistance.php), and the fully qualified classname of the interface it needs to implement would be `\loginmodule\persistance\IPersistance`

```
require_once('Site/persistance/MSQLConnector.php');
require_once('Site/persistance/LoginModulePersistance.php');

$databaseName = 'UserRegistry';
$msqlconnection = \site\persistance\MSQLConnector::getConnection($databaseName);
$persistanceHandler = new \site\persistance\LoginModulePersistance($msqlconnection);

```

4. Create the loginmodule with the persistance class you've initiated, and the optional expiry time for the cookies. If not given, the expiry time will be 30 days.

```
$cookieExpiryTimeInSeconds = 1000;
$loginModule = new \loginmodule\LoginModule($persistanceHandler, $cookieExpiryTimeInSeconds);
```

5. Start the module

```
$loginModule->startLoginModule();
```

###### Displaying the module

The displaying of the module will of course depend on how the rest of your site is built - this is an  that only displays the module itseld, and the current date and time. You need to set up a view of some sort that takes the login-module as a HTML-string argument.

1. Do whatever you need to do to ensure the running of the rest of your site.

```
require_once('Site/view/LayoutView.php');
require_once('Site/view/DateTimeView.php');

$dateTimeView = new \site\view\DateTimeView();
$layoutView = new \site\view\LayoutView($dateTimeView);

```

2. Pass in the Login module HTML, and, should you wish (which you probably do, if you are using the module) the boolean to indicate wheter the user is logged in or not.

```
$layoutView->renderToOutput($loginModule->getLoggedInStatus(), $loginModule->getCurrentHTML());
```

##### Integrating the module with other parts of the site

For an example of integrating the module with other parts of your site and adjust them depending on log in-status, read on under the TicTacToe Game header below.

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
