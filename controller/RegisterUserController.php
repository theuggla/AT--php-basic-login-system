<?php
namespace controller;

class RegisterUserController
{
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
    }

    public function handleUserRegisterAttempt()
    {
        if ($this->userHasPressedRegisterButton()) {
            try {
                $this->getAttemptedCredentials();
                $this->validateCredentialsAndSetErrorMessage();
                $this->checkIfUserAlreadyExists();
                $this->createNewUser();
                $this->currentMessage = "Registered new user";
            } catch (\model\UsernameHasInvalidCharactersException $e) {
                $this->attemptedUsername = $this->user->cleanUpUsername($this->attemptedUsername);
                $this->currentMessage = "Username contains invalid characters.";
            } catch (\model\DuplicateUserException $e) {
                $this->currentMessage = "User exists, pick another username.";
            } catch (\model\PasswordMisMatchException $e) {
                $this->currentMessage = "Passwords do not match.";
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
            $this->currentMessage .= "Password has too few characters, at least " . $this->user->getMinimumPasswordCharacters() . " characters.";
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
        } catch (\model\UsernameIsNotValidException $e) {
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
