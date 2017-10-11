<?php

namespace loginmodule\controller;

class MainController
{
    private $loginUserController = 'MainController::LoginController';
    private $registerUserController = 'MainController::RegisterController';

    private $currentFlashMessage = '';
    private $currentHTML = 'MainController::CurrentHTML';

    private $currentUser;

    private $displayLoginForm = false;
    private $displayRegisterForm = false;

    public function __construct($currentUser, $loginUserController, $registerUserController)
    {
        $this->loginUserController = $loginUserController;
        $this->registerUserController = $registerUserController;

        $this->currentUser = $currentUser;
    }

    public function listenForUserAccessAttempt()
    {
        $this->delegateControlDependingOnUseCase();
        $this->setCorrectViewHTML();
    }

    public function getCurrentHTML()
    {
        return $this->currentHTML;
    }

    public function getLoggedInStatus()
    {
        return $this->currentUser->isLoggedIn();
    }

    private function delegateControlDependingOnUseCase()
    {
        if ($this->userIsLoggedIn()) {
            var_dump($this->currentUser->hasNotBeenHijacked());
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

    private function setCorrectViewHTML()
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
        $this->currentHTML = $this->loginUserController->getHTML($this->currentFlashMessage);
    }

    private function setRegisterFormHTML()
    {
        $this->currentHTML = $this->registerUserController->getHTML($this->currentFlashMessage, $this->currentUser->getUsername());
    }

    private function userIsLoggedIn()
    {
        return ($this->currentUser->isLoggedIn() && $this->currentUser->hasNotBeenHijacked());
    }
}
