<?php

namespace loginmodule\controller;

class LoginUserController
{
    private static $newCredentialsLoginSucessfullMessage = 'Welcome';
    private static $saveCookieUserLoginSucessfullMessage = 'Welcome and you will be remembered';
    private static $tempUserLoginSuccessfulMessage = 'Welcome back with cookie';
    private static $logoutSucessfulMessage = 'Bye bye!';
    private static $wrongCredentialsMessage = 'Wrong name or password';
    private static $noUsernameMessage = 'Username is missing';
    private static $noPasswordMessage = 'Password is missing';
    private static $manipulatedTempUserCredentialsMessage = 'Wrong information in cookies';

    private $loginView = 'LoginModule::LoginUserController::LoginView';

    private $currentUser = 'LoginModule::LoginUserController::User';
    private $currentTempUser = 'LoginModule::LoginUserController::TempUser';

    private $currentMessage;

    private $loginSucceeded = false;
    private $logoutSucceeded = false;

    public function __construct($currentUser, $currentTempUser, $currentFlashMessage, $loginView)
    {
        $this->currentUser = $currentUser;
        $this->currentTempUser = $currentTempUser;
        $this->currentMessage = $currentFlashMessage;
        $this->loginView = $loginView;
    }

    public function loginSuccessful()
    {
        return $this->loginSucceeded;
    }

    public function logoutSuccessful()
    {
        return $this->logoutSucceeded;
    }

    public function getHTML(string $message)
    {
        return $this->loginView->getHTML($this->currentUser->isLoggedIn(), $message, $this->currentUser->getUsername());
    }

    public function handleLoggedOutUser()
    {
        try {
            if ($this->loginView->cookieCredentialsArePresent()) {
                $this->attemptLoginWithCookieCredentials();
            } elseif ($this->loginView->userWantsToLogin()) {
                $this->attemptLoginWithNewCredentials();
            }
        } catch (\loginmodule\model\WrongInfoInTempPasswordException $e) {
            $this->currentMessage->setCurrentMessage(self::$manipulatedTempUserCredentialsMessage);
            $this->loginView->removeCookieCredentials();
        } catch (\loginmodule\model\UsernameIsMissingException $e) {
            $this->currentMessage->setCurrentMessage(self::$noUsernameMessage);
        } catch (\loginmodule\model\PasswordIsMissingException $e) {
            $this->currentMessage->setCurrentMessage(self::$noPasswordMessage);
        } catch (\loginmodule\model\UserIsMissingException $e) {
            $this->currentMessage->setCurrentMessage(self::$wrongCredentialsMessage);
        } catch (\loginmodule\model\WrongCredentialsException $e) {
            $this->currentMessage->setCurrentMessage(self::$wrongCredentialsMessage);
        } catch (\loginmodule\model\InvalidCredentialsException $e) {
            $this->currentMessage->setCurrentMessage(self::$wrongCredentialsMessage);
        }
    }

    public function handleLoggedInUser()
    {
        if ($this->loginView->userWantsToLogout()) {
            $this->logoutUser();
        }
    }

    private function attemptLoginWithCookieCredentials()
    {
        $this->createTempUserFromCookie();
        $this->ensureTempUserCredentialsHaveNotBeenManipulated();
        $this->loginUserWithTempUserCredentials();
        $this->currentMessage->setCurrentMessage(self::$tempUserLoginSuccessfulMessage);
    }

    private function createTempUserFromCookie()
    {
        $this->currentTempUser->setUsername($this->loginView->getCookieUsername());
        $this->currentTempUser->setPassword($this->loginView->getCookiePassword());
    }

    private function ensureTempUserCredentialsHaveNotBeenManipulated()
    {
        $this->currentTempUser->checkForManipulation();
    }

    private function loginUserWithTempUserCredentials()
    {
        $this->transformTempUserToCurrentUser();
        $this->loginCurrentUser();
    }

    private function transformTempUserToCurrentUser()
    {
        $this->currentUser->setUsername($this->currentTempUser->getUsername());
        $this->currentUser->setPassword($this->currentTempUser->getPassword());
    }

    private function attemptLoginWithNewCredentials()
    {
        $this->setCurrentCredentialsFromLoginForm();
        $this->validateCurrentUser();
        $this->loginCurrentUser();
    }

    private function setCurrentCredentialsFromLoginForm()
    {
        $this->currentUser->setUsername($this->loginView->getLoginFormUsername());
        $this->currentUser->setPassword($this->loginView->getLoginFormPassword());
    }

    private function validateCurrentUser()
    {
        $this->currentUser->validateUserAgainstDatabase();
    }

    private function loginCurrentUser()
    {
        $this->currentUser->loginUser();
        $this->loginSucceeded = true;

        if ($this->loginView->userWantsToKeepCredentials()) {
            $this->createCookieFromTempUser();
            $this->currentMessage->setCurrentMessage(self::$saveCookieUserLoginSucessfullMessage);
        } else {
            $this->currentMessage->setCurrentMessage(self::$newCredentialsLoginSucessfullMessage);
        }
    }

    private function logoutUser()
    {
        $this->currentUser->logoutUser();
        $this->loginView->removeCookieCredentials();
        $this->logoutSucceeded = true;
        $this->currentMessage->setCurrentMessage(self::$logoutSucessfulMessage);
    }

    private function createCookieFromTempUser()
    {
        $this->currentTempUser->setUsername($this->currentUser->getUsername());
        $this->currentTempUser->setPassword($this->currentUser->getPassword());
        $expirytimestamp = time() + $this->currentTempUser->getExpiryTime();

        $this->currentTempUser->saveUser();

        $this->loginView->setCookieCredentials($this->currentTempUser->getUsername(), $this->currentTempUser->getPassword(), $expirytimestamp);
    }
}
