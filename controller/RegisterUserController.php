<?php
namespace controller;

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
    private static $MIN_PASSWORD_CHARACTERS;
    private static $badPasswordMessage;


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

        self::$MIN_PASSWORD_CHARACTERS = $this->user->getMinimumPasswordCharacters();
        self::$badPasswordMessage = "Password has too few characters, at least " . self::$MIN_PASSWORD_CHARACTERS . " characters.";
    }

    public function handleUserRegisterAttempt()
    {
        if ($this->userHasPressedRegisterButton()) {
            try {
                $this->getAttemptedCredentials();
                $this->validateCredentialsAndSetErrorMessage();
                $this->checkIfUserAlreadyExists();
                $this->createNewUser();
                $this->currentMessage = self::$registrationSucessfulMessage;
            } catch (\model\UsernameHasInvalidCharactersException $e) {
                $this->attemptedUsername = $this->user->cleanUpUsername($this->attemptedUsername);
                $this->currentMessage = self::$usernameInvalidMessage;
            } catch (\model\DuplicateUserException $e) {
                $this->currentMessage = self::$takenUsernameMessage;
            } catch (\model\PasswordMisMatchException $e) {
                $this->currentMessage = self::$passwordMisMatchMessage;
            } catch (\model\InvalidCredentialsException $e) {
            }
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
        $usernameIsValid = $this->isUsernameValid();
        $passwordIsValid = $this->isPasswordValid();

        if (!($usernameIsValid)) {
            $this->currentMessage .= "Username has too few characters, at least " . $this->user->getMinimumUsernameCharacters() . " characters. ";
        }

        if (!($passwordIsValid)) {
            $this->currentMessage .= self::$badPasswordMessage;
        }

        if ($usernameIsValid && $passwordIsValid) {
            $this->comparePlaintextPasswords($this->attemptedPassword, $this->attemptedRepeatedPassword);
        } else {
            throw new \model\InvalidCredentialsException("Credentials are invalid.");
        }
    }

    private function isUsernameValid()
    {
        $result;

        try {
            $this->user->validateUsername($this->attemptedUsername);
            $result = true;
        } catch (\model\UsernameHasInvalidCharactersException $e) {
            throw $e;
        }catch (\model\UsernameIsNotValidException $e) {
            $result = false;
        } catch (\model\UsernameIsMissingException $e) {
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
        } catch (\model\PasswordIsNotValidException $e) {
            $result = false;
        } catch (\model\PasswordIsMissingException $e) {
            $result = false;
        }

        return $result;
    }

    private function comparePlaintextPasswords($firstPassword, $secondPassword)
    {
        if (!($firstPassword == $secondPassword)) {
            throw new \model\PasswordMisMatchException("Passwords do not match.");
        }
    }

    private function checkIfUserAlreadyExists()
    {
        if ($this->user->doesUserExist($this->attemptedUsername)) {
            throw new \model\DuplicateUserException("User already exists.");
        }
    }

    private function createNewUser()
    {
        $this->user->saveUser($this->attemptedUsername, $this->attemptedPassword);
        $this->currentMessage = "Registered new user.";
        $this->registrySucceeded = true;
    }
}
