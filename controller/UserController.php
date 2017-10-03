<?php

namespace controller;

class UserController
{
    private static $currentMessage = 'UpdatedLoginModule::UserController::CurrentFlashMessage';

    private $loginUserController = 'UserController::LoginController';
    private $registerUserController = 'UserController::RegisterController';

    private $user  = 'UserController::User';

    private $currentFlashMessage = '';
    private $lastUsername = 'UserController::LastUsername';
    private $userIsLoggedIn = 'UserController::LoggedInStatus';

    private $externalView = 'UserController::ExternalView';

    private $displayLoginForm = false;
    private $displayRegisterForm = false;

    public function __construct($user, $loginUserController, $registerUserController, $externalView)
    {
        $this->user = $user;

        $this->loginUserController = $loginUserController;
        $this->registerUserController = $registerUserController;

        $this->externalView = $externalView;
    }

    public function listenForUserAccessAttempt()
    {
        $this->delegateControlDependingOnUseCase();
        $this->displayCorrectView();
    }

    private function delegateControlDependingOnUseCase()
    {
        $this->updateCurrentUserStatus();

        if ($this->userIsLoggedIn) {
            $this->determineResultOfLogoutAttempt();
            $this->currentFlashMessage = $this->loginUserController->getCurrentMessage();
        } else if ($this->externalView->userWantsToRegister()) {
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
            $this->renderRegisterForm();
        } else {
            $this->renderDependingOnLoginStatus();
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
        header("Location: /");
    }

    private function determineResultOfLoginAttempt()
    {
        $this->loginUserController->handleLoggedOutUser();

        if ($this->loginUserController->loginSuccessful()) {
            $this->displayLoginForm = false;
        }
    }

    private function renderDependingOnLoginStatus()
    {
        $this->updateCurrentUserStatus();
        $currentHTML = $this->loginUserController->getHTML($this->getCurrentFlashMessage(), $this->lastUsername);

        $this->externalView->renderToOutput($this->userIsLoggedIn, $currentHTML);
    }

    private function renderRegisterForm()
    {
        $this->updateCurrentUserStatus();
        $currentHTML = $this->registerUserController->getHTML($this->getCurrentFlashMessage(), $this->lastUsername);

        $this->externalView->renderToOutput($this->userIsLoggedIn, $currentHTML);
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
