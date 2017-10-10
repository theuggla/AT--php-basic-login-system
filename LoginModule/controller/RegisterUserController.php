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
    private $user = 'RegisterUserController::User';

    private $attemptedUsername = '';
    private $attemptedPassword = '';
    private $atteptedRepeatedPassword = '';

    private $currentMessage = '';
    private $registrySucceeded = false;

    public function __construct($user, $registerView)
    {
        $this->registerView = $registerView;
        $this->user = $user;

        self::$badPasswordMessage = "Password has too few characters, at least " . $this->user->getMinimumPasswordCharacters() . " characters.";
        self::$badUsernameMessage = "Username has too few characters, at least " . $this->user->getMinimumUsernameCharacters() . " characters. ";
    }

    public function handleUserRegisterAttempt()
    {
        if ($this->userHasPressedRegisterButton()) {
            try {
                $this->getAttemptedCredentials();
                $this->validateCredentialsAndSetErrorMessage();
                $this->checkIfUserAlreadyExists();
                $this->createNewUser();
            } catch (\loginmodule\model\UsernameHasInvalidCharactersException $e) {
                $this->attemptedUsername = $this->user->getUsername();
                $this->currentMessage = self::$usernameInvalidMessage;
            } catch (\loginmodule\model\DuplicateUserException $e) {
                $this->currentMessage = self::$takenUsernameMessage;
            } catch (\loginmodule\model\PasswordMisMatchException $e) {
                $this->currentMessage = self::$passwordMisMatchMessage;
            } catch (\loginmodule\model\InvalidCredentialsException $e) {}
            finally
            {
                $this->user->setLatestUsername($this->attemptedUsername);
            }
        }
    }

    public function registrationWasSuccessful()
    {
        return $this->registrySucceeded;
    }

    public function getCurrentMessage()
    {
        return $this->currentMessage;
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

    private function getAttemptedCredentials()
    {
        $this->attemptedUsername = $this->registerView->getAttemptedUsername();
        $this->attemptedPassword = $this->registerView->getAttemptedPassword();
        $this->attemptedRepeatedPassword = $this->registerView->getAttemptedRepeatedPassword();
    }

    private function validateCredentialsAndSetErrorMessage()
    {
        try
        {
            $this->user($attemptedUsername, $attemptedPassword);
        }
        catch (\loginmodule\model\UsernameIsMissingException $e)
        {
            echo 'specific';
        }
        catch (\loginmodule\model\InvalidCredentialsException $e)
        {
            echo 'generic';
        }
    }

    private function isUsernameValid()
    {
        $result;

        try {
            $this->user->validateUsername($this->attemptedUsername);
            $result = true;
        } catch (\loginmodule\model\UsernameHasInvalidCharactersException $e) {
            throw $e;
        } catch (\loginmodule\model\UsernameIsNotValidException $e) {
            $result = false;
        }

        return $result;
    }
        
    private function isPasswordValid()
    {
        $result;

        try {
            $this->user->validatePassword($this->attemptedPassword);
            $result = true;
        } catch (\loginmodule\model\PasswordIsNotValidException $e) {
            $result = false;
        }

        return $result;
    }

    private function comparePlaintextPasswords($firstPassword, $secondPassword)
    {
        if (!($firstPassword == $secondPassword)) {
            throw new \loginmodule\model\PasswordMisMatchException();
        }
    }

    private function checkIfUserAlreadyExists()
    {
        if ($this->user->doesUserExist($this->attemptedUsername)) {
            throw new \loginmodule\model\DuplicateUserException();
        }
    }

    private function createNewUser()
    {
        $this->user->saveUser($this->attemptedUsername, $this->attemptedPassword);
        $this->currentMessage = self::$registrationSucessfulMessage;
        $this->registrySucceeded = true;
    }
}
