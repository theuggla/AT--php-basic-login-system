<?php

namespace site\persistance;

class LoginModulePersistance implements \loginmodule\persistance\IPersistance
{
    private static $dbconnection;

    public function __construct($dbconnection)
    {
        self::$dbconnection = $dbconnection;
    }

    public function didTempUserExpire(string $username, string $password) : bool
    {
        $query='SELECT * FROM TemporaryPassword WHERE BINARY username="' . $username . '" AND password="' . $password . '"';
        $result = self::$dbconnection->query($query);
             
        $cookie = $result->fetch_object();
        return ($result->num_rows <= 0 || $cookie->expiry < time());
    }

    public function saveTempUser(string $username, string $password, int $timestamp)
    {
        $password = self::$dbconnection->real_escape_string($password);
        $username = self::$dbconnection->real_escape_string($username);
        $query = 'INSERT INTO TemporaryPassword (password, username, expiry) VALUES ("' . $password . '", "' . $username . '", ' . $timestamp . ')';
    
        self::$dbconnection->query($query);
    }

    public function doesUserExist(string $username) : bool
    {
        $result = $this->getUserByUsername($username);
            
        if ($result->num_rows <= 0) {
            return false;
        } else {
            return true;
        }
    }

    public function getUserPassword(string $username) : String
    {
        $result = $this->getUserByUsername($username);
            
        if ($result->num_rows <= 0) {
            return '';
        } else {
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
