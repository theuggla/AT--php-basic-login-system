<?php

namespace loginmodule\model;

class User
{
    private static $userAgent = 'UpdatedLoginModule::User::UserAgent';
    private static $isLoggedIn = 'UpdatedLoginModule::User::IsLoggedIn';
    private static $latestUsername = 'UpdatedLoginModule::User::LatestUserName';

    private $username;
    private $password;
    private $persistance;

    public function __construct(IPersistance $persistance)
    {
        $this->username = new \loginmodule\model\Username();
        $this->password = new \loginmodule\model\Password();
        $this->persistance = $persistance;
    }

    public function doesUserExist(string $username)
    {
        $this->username->validateUsername($username);
        return $this->persistance->doesUserExist($username);
    }

    public function checkForUserWithThoseCredentials(string $username, string $password)
    {
        if ($this->persistance->doesUserExist($username)) {
            $hashedPassword = $this->persistance->getUserPasswordFromUsername($username);
            $passwordIsCorrect = password_verify($password, $hashedPassword);

            if ($passwordIsCorrect) {
                return true;
            } else {
                throw new \loginmodule\model\WrongCredentialsException("Wrong credentials");
            }
        } else {
            throw new \loginmodule\model\UserIsMissingException('User does not exist');
        }
    }

    public function logout()
    {
        $_SESSION[self::$isLoggedIn] = false;
    }

    public function login()
    {
        $_SESSION[self::$isLoggedIn] = true;
        $_SESSION[self::$userAgent] = $_SERVER['HTTP_USER_AGENT'];
    }

    public function isLoggedIn()
    {
        return isset($_SESSION[self::$isLoggedIn]) && $_SESSION[self::$isLoggedIn];
    }

    public function isLoggedOut()
    {
        return !$this->isLoggedIn();
    }

    public function hasNotBeenHijacked()
    {
        return isset($_SESSION[self::$userAgent]) && $_SESSION[self::$userAgent] == $_SERVER["HTTP_USER_AGENT"];
    }

    public function validateUsername($username)
    {
        return $this->username->validateUsername($username);
    }

    public function cleanUpUsername($username)
    {
        return $this->username->cleanUpUsername($username);
    }

    public function validatePassword($password)
    {
        return $this->password->validatePassword($password);
    }

    public function saveUser(string $username, string $password)
    {
        $hashedPassword = $this->password->hashPassword($password);
        $this->persistance->saveUser($username, $hashedPassword);
    }

    public function getLatestUsername()
    {
        return isset($_SESSION[self::$latestUsername]) ? $_SESSION[self::$latestUsername] : '';
    }

    public function setLatestUsername(string $username)
    {
        $_SESSION[self::$latestUsername] = $username;
    }

    public function getMinimumPasswordCharacters()
    {
        return $this->password::$MIN_VALID_LENGTH;
    }

    public function getMinimumUsernameCharacters()
    {
        return $this->username::$MIN_VALID_LENGTH;
    }
}
