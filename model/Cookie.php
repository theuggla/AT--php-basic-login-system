<?php

namespace model;

class Cookie
{

    private static $EXPIRY_TIME;
    private $persistance;

    public function __construct(int $expiryTime, IPersistance $persistance)
    {
        self::$EXPIRY_TIME = $expiryTime;
        $this->persistance = $persistance;
    }

    public function checkForManipulation(string $username, string $cookiePassword)
    {
        if ($this->persistance->doesCookieExist($username, $cookiePassword)) {
            return true;
        } else {
            throw new \model\WrongInfoInCookieException('Wrong information in cookies');
        }
    }

    public function saveCookie(string $username, string $cookiePassword)
    {
        $timestamp = time() + self::$EXPIRY_TIME;
        $this->persistance->saveCookie($username, $cookiePassword, $timestamp);
    }

    public function hashPassword(string $password)
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        return $hashedPassword;
    }

    public function getExpiryTime()
    {
        return self::$EXPIRY_TIME;
    }
}
