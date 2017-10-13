<?php
namespace loginmodule\controller;

class RegisterUserController
{
    private static $registrationSucessfulMessage = 'Registered new user';
    private static $saveCookieLoginSucessfullMessage = 'Welcome and you will be remembered';
    private static $cookieLoginSuccessfulMessage = 'Welcome back with cookie';
    private static $logoutSucessfulMessage = 'Bye bye!';
    private static $takenUsernameMessage = 'User exists, pick another username.';
    private static $usernameInvalidMessage = 'Username contains invalid characters.';
    private static $passwordMisMatchMessage = 'Passwords do not match.';
    private static $manipulatedCookieCredentialsMessage = 'Wrong information in cookies';
    private static $badPasswordMessage;
    private static $badUsernameMessage;

    private $registerView = 'RegisterUserController::RegisterView';
    
    private $currentUser = 'RegisterUserController::User';
    private $currentMessage;

    private $registrySucceeded = false;

    public function __construct($currentUser, $currentFlashMessage, $registerView)
    {
        $this->currentUser = $currentUser;
        $this->currentMessage = $currentFlashMessage;
        
        $this->registerView = $registerView;

        self::$badPasswordMessage = "Password has too few characters, at least " . $this->currentUser->getMinimumPasswordCharacters() . " characters.";
        self::$badUsernameMessage = "Username has too few characters, at least " . $this->currentUser->getMinimumUsernameCharacters() . " characters. ";
    }

    public function handleUserRegisterAttempt()
    {
        if ($this->userHasPressedRegisterButton()) {
            try {
                $this->attemptRegistration();
            } catch (\loginmodule\model\UsernameHasInvalidCharactersException $e) {
                $this->currentMessage->setCurrentMessage(self::$usernameInvalidMessage);
            } catch (\loginmodule\model\PasswordMisMatchException $e) {
                $this->currentMessage->setCurrentMessage(self::$passwordMisMatchMessage);
            } catch (\loginmodule\model\DuplicateUserException $e) {
                $this->currentMessage->setCurrentMessage(self::$takenUsernameMessage);
            } catch (\loginmodule\model\InvalidCredentialsException $e) {}
        }
    }

    public function registrationWasSuccessful()
    {
        return $this->registrySucceeded;
    }

    public function getHTML(string $message, string $latestUsername)
    {
        return $this->registerView->getHTML($message, $latestUsername);
    }

    public function userWantsToRegister()
    {
        return $this->registerView->userWantsToViewForm();
    }

    private function userHasPressedRegisterButton()
    {
        return $this->registerView->userWantsToRegister();
    }

    private function attemptRegistration()
    {
        $this->setCurrentCredentialsFromForm();
        $this->validateCurrentUser();
        $this->createNewUser();
    }

    private function setCurrentCredentialsFromForm()
    {
        $this->setUsernameOrErrorMessage();
        $this->setPasswordOrErrorMessage();

        if (($this->currentUser->isMissingCrendentials()))
        {
            throw new \loginmodule\model\InvalidCredentialsException('Attempted credentials are not valid.');
        }

    }

    private function setUsernameOrErrorMessage()
    {
        try
        {
            $this->currentUser->setUsername($this->registerView->getAttemptedUsername());
        }
        catch (\loginmodule\model\UsernameHasInvalidCharactersException $e) 
        {
            $this->currentMessage->setCurrentMessage(self::$usernameInvalidMessage);
            $this->currentUser->cleanUpUsername();
            throw new \loginmodule\model\InvalidCredentialsException('Attempted credentials are not valid.');
        }
        catch (\loginmodule\model\UsernameIsNotValidException $e) 
        {
            $this->currentMessage->addToCurrentMessage(self::$badUsernameMessage);
        }
    }

    private function setPasswordOrErrorMessage()
    {
        try
        {
            $this->currentUser->setPassword($this->registerView->getAttemptedPassword());
        }
        catch (\loginmodule\model\PasswordIsNotValidException $e) 
        {
            $this->currentMessage->addToCurrentMessage(self::$badPasswordMessage);
        }
    }

    private function validateCurrentUser()
    {
        $this->compareAttemptedPasswords();
        $this->currentUser->validateNewUser();
    }

    private function compareAttemptedPasswords()
    {
        if ($this->currentUser->getPassword() != $this->registerView->getAttemptedRepeatedPassword()) {
            throw new \loginmodule\model\PasswordMisMatchException();
        }
    }

    private function checkIfUserAlreadyExists()
    {
        $this->currentUser->validateNewUser();
    }

    private function createNewUser()
    {
        $this->currentUser->saveUser();
        $this->currentMessage->setCurrentMessage(self::$registrationSucessfulMessage);
        $this->registrySucceeded = true;
    }
}
