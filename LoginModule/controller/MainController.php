<?php

namespace loginmodule\controller;

class MainController
{
    private $loginUserController = 'MainController::LoginController';
    private $registerUserController = 'MainController::RegisterController';

    private $currentHTML = 'MainController::CurrentHTML';

    private $currentFlashMessage;
    private $currentUser;

    private $displayLoginForm = false;
    private $displayRegisterForm = false;

    public function __construct($currentUser, $currentFlashMessage, $loginUserController, $registerUserController)
    {
        $this->loginUserController = $loginUserController;
        $this->registerUserController = $registerUserController;

        $this->currentUser = $currentUser;
        $this->currentFlashMessage = $currentFlashMessage;
    }

    public function listenForUserAccessAttempt()
    {
        $this->delegateControlDependingOnUseCase();
        $this->setCorrectViewHTML();
        $this->currentFlashMessage->resetMessage();
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
            $this->determineResultOfLogoutAttempt();
        } else if ($this->registerUserController->userWantsToRegister()) {
            $this->displayRegisterForm = true;
            $this->determineResultOfRegisterAttempt();
        } else {
            $this->displayLoginForm = true;
            $this->determineResultOfLoginAttempt();
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
        $this->currentHTML = $this->loginUserController->getHTML($this->currentFlashMessage->getCurrentMessage());
    }

    private function setRegisterFormHTML()
    {
        $this->currentHTML = $this->registerUserController->getHTML($this->currentFlashMessage->getCurrentMessage(), $this->currentUser->getUsername());
    }

    private function userIsLoggedIn()
    {
        return ($this->currentUser->isLoggedIn() && $this->currentUser->hasNotBeenHijacked());
    }
}
