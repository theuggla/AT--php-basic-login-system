<?php

namespace loginmodule\model;

class User
{
    private static $isLoggedIn = 'UpdatedLoginModule::User::IsLoggedIn';
    private static $latestUsername = 'UpdatedLoginModule::Username::LatestUserName';

    protected $username;
    protected $password;

    protected $persistance;

    public function __construct(\loginmodule\persistance\IPersistance $persistance)
    {
        $this->persistance = $persistance;
    }

    public function setUsername(string $username, bool $stripHTML = false)
    {
        $this->rememberUsername($username);
        $this->username = new \loginmodule\model\Username($username, $stripHTML);
        $this->rememberUsername($this->username->getUsername());
    }

    public function setPassword(string $password)
    {
        $this->password = new \loginmodule\model\Password($password);
    }

    public function getUsername() : string
    {
        $username = \is_null($this->username) ? isset($_SESSION[self::$latestUsername]) ? $_SESSION[self::$latestUsername] : '' : $this->username->getUsername();
        return  $username;
    }

    public function getPassword() : string
    {
        return $this->password->getPassword();
    }

    public function logoutUser()
    {
        $_SESSION[self::$isLoggedIn] = false;
    }

    public function loginUser()
    {
        $_SESSION[self::$isLoggedIn] = true;
        $_SESSION[self::$userAgent] = $_SERVER[self::$serverUserAgent];
    }

    public function validateUserAgainstDatabase()
    {
        if ($this->userIsNotRegistredInDatabase()) {
            throw new \loginmodule\model\WrongCredentialsException('User does not exist.');
        } elseif ($this->passwordsDoesNotMatch()) {
            throw new \loginmodule\model\WrongCredentialsException('Password is wrong.');
        }
    }

    public function validateNewUser()
    {
        if (!($this->userIsNotRegistredInDatabase())) {
            throw new \loginmodule\model\DuplicateUserException('User already exists.');
        }
    }

    public function cleanUpUsername()
    {
        $stripHTML = true;
        $this->setUsername($this->getUsername(), $stripHTML);
    }

    public function isMissingCrendentials() : bool
    {
        return \is_null($this->username) || \is_null($this->password);
    }

    public function saveUser()
    {
        $this->password->hashPassword();
        $this->persistance->saveUser($this->username->getUsername(), $this->password->getPassword());
    }

    public function isLoggedIn() : bool
    {
        return isset($_SESSION[self::$isLoggedIn]) && $_SESSION[self::$isLoggedIn];
    }

    public function getMinimumPasswordCharacters() : int
    {
        return \loginmodule\model\Password::$MIN_VALID_LENGTH;
    }

    public function getMinimumUsernameCharacters() : int
    {
        return \loginmodule\model\Username::$MIN_VALID_LENGTH;
    }

    private function rememberUsername($username)
    {
        $_SESSION[self::$latestUsername] = $username;
    }

    private function userIsNotRegistredInDatabase() : bool
    {
        return !($this->persistance->doesUserExist($this->username->getUsername()));
    }

    private function passwordsDoesNotMatch() : bool
    {
        $savedPassword = $this->persistance->getUserPassword($this->username->getUsername());
        return !($this->password->isPasswordCorrect($savedPassword));
    }
}
