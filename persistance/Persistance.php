<?php

namespace persistance;

class Persistance implements IPersistance
{

    private static $dbconnection;

    public function __construct($dbconnection)
    {
        self::$dbconnection = $dbconnection;
    }

    public function doesCookieExist(string $username, string $cookiePassword)
    {
        $query='SELECT * FROM Cookie WHERE BINARY username="' . $username . '" AND cookiepassword="' . $cookiePassword . '"';
        $result = self::$dbconnection->query($query);
             
        $cookie = $result->fetch_object();

        if ($result->num_rows <= 0 || $cookie->expiry < time()) {
            return false;
        } else {
            return true;
        }
    }

    public function saveCookie(string $username, string $cookiepassword, int $timestamp)
    {
        $cookiepassword = self::$dbconnection->real_escape_string($cookiepassword);
        $username = self::$dbconnection->real_escape_string($username);

        $query = 'INSERT INTO Cookie (cookiepassword, username, expiry) VALUES ("' . $cookiepassword . '", "' . $username . '", ' . $timestamp . ')';
    
        self::$dbconnection->query($query);
    }

    public function doesUserExist(string $username)
    {
        $result = $this->getUserByUsername($username);
            
        if ($result->num_rows <= 0) {
            return false;
        } else {
            return true;
        }
    }

    public function getUserPasswordFromUsername(string $username)
    {
        if ($this->doesUserExist($username)) {
            $result = $this->getUserByUsername($username);
            $user = $result->fetch_object();
            return $user->password;
        }
    }

    public function saveUser(string $username, string $password)
    {
        $username = self::$dbconnection->real_escape_string($username);
        $query = 'INSERT INTO User (username, password) VALUES ("' . $username . '", "' . $password . '")';
        
        $result = self::$dbconnection->query($query);
    }

    private function getUserByUsername(string $username)
    {
        $query='SELECT * FROM User WHERE BINARY username="' . $username . '"';
        $result = self::$dbconnection->query($query);

        return $result;
    }
}
