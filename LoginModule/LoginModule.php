<?php

namespace loginmodule;

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

class LoginModule {

    private $currentHTML;
    private $isLoggedIn;

    private $persistanceHandler;
    private $cookieExpiryTimeInSeconds;

    private $loginVew;
    private $registerView;

    private $cookieModel;
    private $userModel;

    private $mainController;
    private $loginController;
    private $registerController;

    public function __construct(persistance\IPersistance $persistanceHandler, int $cookieExpiryTimeInSeconds)
    {
        $this->persistanceHandler = $persistanceHandler;
        $this->cookieExpiryTimeInSeconds = $cookieExpiryTimeInSeconds;   

        $this->initiateDependencies();
    }

    public function startLoginModule()
    {
        $this->mainController->listenForUserAccessAttempt();

        $this->currentHTML = $this->mainController->getCurrentHTML();
        $this->isLoggedIn = $this->mainController->getLoggedInStatus();
    }

    public function getCurrentHTML()
    {
        return $this->currentHTML;
    }

    public function getLoggedInStatus()
    {
        return $this->isLoggedIn;
    }

    private function initiateDependencies()
    {
        $this->initiateViews();
        $this->initiateModels();
        $this->initiateControllers();
    }

    private function initiateViews()
    {
        $this->loginView = new \loginmodule\view\LoginView();
        $this->registerView = new \loginmodule\view\RegisterView();
    }

    private function initiateModels()
    {
        $this->cookieModel = new \loginmodule\model\Cookie($this->cookieExpiryTimeInSeconds, $this->persistanceHandler);
        $this->userModel = new \loginmodule\model\User($this->persistanceHandler);
    }

    private function initiateControllers()
    {
        $this->loginController = new \loginmodule\controller\LoginUserController($this->userModel, $this->cookieModel, $this->loginView);
        $this->registerController = new \loginmodule\controller\RegisterUserController($this->userModel, $this->registerView);
        $this->mainController = new \loginmodule\controller\MainController($this->userModel, $this->loginController, $this->registerController);
    }
}