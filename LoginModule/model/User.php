<?php

namespace loginmodule\model;

class User
{
    private static $userAgent = 'UpdatedLoginModule::User::UserAgent';
    private static $isLoggedIn = 'UpdatedLoginModule::User::IsLoggedIn';
    private static $latestUsername = 'UpdatedLoginModule::User::LatestUserName';
    private static $serverUserAgent = 'HTTP_USER_AGENT';

    protected $username;
    protected $password;

    protected $persistance;

    public function __construct(\loginmodule\persistance\IPersistance $persistance)
    {
        $this->persistance = $persistance;
    }

    public function setUsername(string $username)
    {
        $this->username = new \loginmodule\model\Username($username);
        $this->rememberUsername();
    }

    public function setPassword(string $password)
    {
        $this->password = new \loginmodule\model\Password($password);
    }

    public function getUsername() : String
    {
        return isset($_SESSION[self::$latestUsername]) ? $_SESSION[self::$latestUsername] : '';
    }

    public function getPassword() : String
    {
        return $this->password;
    }

    public function logoutUser()
    {
        $_SESSION[self::$isLoggedIn] = false;
    }

    public function loginUser()
    {
        $_SESSION[self::$isLoggedIn] = true;
        $_SESSION[self::$userAgent] = $_SERVER['HTTP_USER_AGENT'];
    }

    public function validateUser()
    {
        if (!($this->persistance->doesUserExist($this->username, $this->password))) {
            throw new \loginmodule\model\loginmodule\model\WrongCredentialsException();
        }
        
    }

    public function isLoggedIn()
    {
        return isset($_SESSION[self::$isLoggedIn]) && $_SESSION[self::$isLoggedIn];
    }

    public function hasNotBeenHijacked()
    {
        return isset($_SESSION[self::$userAgent]) && $_SESSION[self::$userAgent] == $_SERVER["HTTP_USER_AGENT"];
    }

    public function getMinimumPasswordCharacters()
    {
        return \loginmodule\model\Password::getMinLength();
    }

    public function getMinimumUsernameCharacters()
    {
        return \loginmodule\model\Username::getMinLength();
    }

    private function rememberUsername()
    {
        $_SESSION[self::$latestUsername] = $this->username->getUsername();
    }
}
