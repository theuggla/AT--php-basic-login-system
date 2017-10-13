<?php

namespace loginmodule;

require_once('LoginModule/controller/RegisterUserController.php');
require_once('LoginModule/controller/LoginUserController.php');
require_once('LoginModule/controller/MainController.php');

require_once('LoginModule/model/User.php');
require_once('LoginModule/model/Username.php');
require_once('LoginModule/model/Password.php');
require_once('LoginModule/model/TemporaryUser.php');
require_once('LoginModule/model/Exception.php');
require_once('LoginModule/model/FlashMessage.php');

require_once('LoginModule/view/RegisterView.php');
require_once('LoginModule/view/LoginView.php');

class LoginModule {

    private $currentHTML;
    private $isLoggedIn;

    private $persistanceHandler;
    private $cookieExpiryTimeInSeconds;

    private $loginVew;
    private $registerView;

    private $currentUser;
    private $currentFlashMessage;

    private $mainController;
    private $loginController;
    private $registerController;

    public function __construct(\loginmodule\persistance\IPersistance $persistanceHandler, int $cookieExpiryTimeInSeconds = 2592000)
    {
        $this->assertThereIsASession();

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

    public function getCurrentHTML() : String
    {
        return $this->currentHTML;
    }

    public function getLoggedInStatus() : bool
    {
        return $this->isLoggedIn;
    }

    private function assertThereIsASession()
    {
        assert(isset($_SESSION));
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
        $this->currentUser = new \loginmodule\model\User($this->persistanceHandler);
        $this->currentTempUser = new \loginmodule\model\TemporaryUser($this->persistanceHandler, $this->cookieExpiryTimeInSeconds);
        $this->currentFlashMessage = new \loginmodule\model\FlashMessage();
    }

    private function initiateControllers()
    {
        $this->loginController = new \loginmodule\controller\LoginUserController($this->currentUser, $this->currentTempUser, $this->currentFlashMessage, $this->loginView);
        $this->registerController = new \loginmodule\controller\RegisterUserController($this->currentUser, $this->currentFlashMessage, $this->registerView);
        $this->mainController = new \loginmodule\controller\MainController($this->currentUser, $this->currentFlashMessage, $this->loginController, $this->registerController);
    }
}