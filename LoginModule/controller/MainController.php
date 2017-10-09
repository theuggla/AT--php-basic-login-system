<?php

namespace loginmodule\controller;

class MainController
{
    private static $currentMessage = 'UpdatedLoginModule::MainController::CurrentFlashMessage';

    private $loginUserController = 'MainController::LoginController';
    private $registerUserController = 'MainController::RegisterController';

    private $user  = 'MainController::User';

    private $currentFlashMessage = '';
    private $lastUsername = 'MainController::LastUsername';
    private $userIsLoggedIn = 'MainController::LoggedInStatus';
    private $currentHTML = 'MainController::CurrentHTML';

    private $displayLoginForm = false;
    private $displayRegisterForm = false;

    public function __construct($user, $loginUserController, $registerUserController)
    {
        $this->user = $user;

        $this->loginUserController = $loginUserController;
        $this->registerUserController = $registerUserController;
    }

    public function listenForUserAccessAttempt()
    {
        $this->delegateControlDependingOnUseCase();
        $this->displayCorrectView();
    }

    public function getCurrentHTML()
    {
        return $this->currentHTML;
    }

    public function getLoggedInStatus()
    {
        return $this->userIsLoggedIn;
    }

    private function delegateControlDependingOnUseCase()
    {
        $this->updateCurrentUserStatus();

        if ($this->userIsLoggedIn) {
            $this->determineResultOfLogoutAttempt();
            $this->currentFlashMessage = $this->loginUserController->getCurrentMessage();
        } else if ($this->registerUserController->userWantsToRegister()) {
            $this->displayRegisterForm = true;
            $this->determineResultOfRegisterAttempt();
            $this->currentFlashMessage = $this->registerUserController->getCurrentMessage();
        } else {
            $this->displayLoginForm = true;
            $this->determineResultOfLoginAttempt();
            $this->currentFlashMessage = $this->loginUserController->getCurrentMessage();
        }
    }

    private function displayCorrectView()
    {
        if ($this->displayRegisterForm) {
            $this->setRegisterFormHTML();
        } else {
            $this->setLoginHTMLDependingOnLoginStatus();
        }
    }

    private function determineResultOfLogoutAttempt()
    {
        $this->loginUserController->handleLoggedInUser();

        if ($this->loginUserController->logoutSuccessful()) {
            $this->displayLoginForm = true;
        }
    }

    private function determineResultOfRegisterAttempt()
    {
        $this->registerUserController->handleUserRegisterAttempt();

        if ($this->registerUserController->registrationWasSuccessful()) {
            $this->currentFlashMessage = $this->registerUserController->getCurrentMessage();
            $this->updateCurrentUserStatus();
            $this->sendUserToLoginPage();
        }
    }

    private function sendUserToLoginPage()
    {
        $this->displayLoginForm = true;
        $this->displayRegisterForm = false;
        header("Location: /added-functionality/");
    }

    private function determineResultOfLoginAttempt()
    {
        $this->loginUserController->handleLoggedOutUser();

        if ($this->loginUserController->loginSuccessful()) {
            $this->displayLoginForm = false;
        }
    }

    private function setLoginHTMLDependingOnLoginStatus()
    {
        $this->updateCurrentUserStatus();
        $this->currentHTML = $this->loginUserController->getHTML($this->getCurrentFlashMessage(), $this->lastUsername);
    }

    private function setRegisterFormHTML()
    {
        $this->updateCurrentUserStatus();
        $this->currentHTML = $this->registerUserController->getHTML($this->getCurrentFlashMessage(), $this->lastUsername);
    }

    private function updateCurrentUserStatus()
    {
        $this->updateCurrentUserLoggedInStatus();
        $this->updateCurrentUserFlashMessage();
        $this->updateCurrentUserLatestUsername();
    }

    private function updateCurrentUserLoggedInStatus()
    {
        $this->userIsLoggedIn = ($this->user->isLoggedIn() && $this->user->hasNotBeenHijacked());
    }

    private function updateCurrentUserFlashMessage()
    {
        $_SESSION[self::$currentMessage] = $this->currentFlashMessage;
    }

    private function updateCurrentUserLatestUsername()
    {
        $this->lastUsername = $this->user->getLatestUsername();
    }

    private function getCurrentFlashMessage()
    {
        return isset($_SESSION[self::$currentMessage]) ? $_SESSION[self::$currentMessage] : '';
    }
}
