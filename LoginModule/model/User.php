<?php

namespace loginmodule\model;

class User
{
    private static $userAgent = 'UpdatedLoginModule::User::UserAgent';
    private static $isLoggedIn = 'UpdatedLoginModule::User::IsLoggedIn';
    private static $latestUsername = 'UpdatedLoginModule::Username::LatestUserName';
    private static $serverUserAgent = 'HTTP_USER_AGENT';

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

    public function getUsername() : String
    {
        $username = \is_null($this->username) ? isset($_SESSION[self::$latestUsername]) ? $_SESSION[self::$latestUsername] : '' : $this->username->getUsername();
        return  $username;
    }

    public function getPassword() : String
    {
        return $this->password->getPassword();
    }

    public function isMissingCrendentials()
    {
        return \is_null($this->username) || \is_null($this->password);
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
        } else if ($this->passwordsDoesNotMatch()) {
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

    public function saveUser()
    {
        $this->password->hashPassword();
        $this->persistance->saveUser($this->username->getUsername(), $this->password->getPassword());
    }

    public function isLoggedIn()
    {
        return isset($_SESSION[self::$isLoggedIn]) && $_SESSION[self::$isLoggedIn];
    }

    public function hasNotBeenHijacked()
    {
        return isset($_SESSION[self::$userAgent]) && $_SESSION[self::$userAgent] === $_SERVER[self::$serverUserAgent];
    }

    public function getMinimumPasswordCharacters()
    {
        return \loginmodule\model\Password::$MIN_VALID_LENGTH;
    }

    public function getMinimumUsernameCharacters()
    {
        return \loginmodule\model\Username::$MIN_VALID_LENGTH;
    }

    private function rememberUsername($username)
    {
        $_SESSION[self::$latestUsername] = $username;
    }

    private function userIsNotRegistredInDatabase()
    {
        return !($this->persistance->doesUserExist($this->username->getUsername()));
    }

    private function passwordsDoesNotMatch()
    {
        $savedPassword = $this->persistance->getUserPassword($this->username->getUsername());
        return !($this->password->isPasswordCorrect($savedPassword));
    }
}
