<?php

namespace model;

class Cookie {
    public function findCookie(string $username, string $cookiePassword) {
        $query='SELECT * FROM Cookie WHERE BINARY username="' . $username . '" AND BINARY cookiepassword="' . $cookiePassword . '"';
        $dbconnection = \model\DBConnector::getConnection('UserRegistry');
        $result = $dbconnection->query($query);

        $cookie = $result->fetch_object();
        
        if ($result->num_rows <= 0 || $cookie->expiry < time()) {
            throw new \model\WrongInfoInCookieException('Wrong information in cookies');
        } else {
            return true;
        }
    }

    public function saveCookie(string $username, string $cookiepassword, int $timestamp) {
        $dbconnection = \model\DBConnector::getConnection('UserRegistry');

        $cookiepassword = $dbconnection->real_escape_string($cookiepassword);
        $username = $dbconnection->real_escape_string($username);

        $query = 'INSERT INTO Cookie (cookiepassword, username, expiry) VALUES ("' . $cookiepassword . '", "' . $username . '", ' . $timestamp . ')';
    
        $result = $dbconnection->query($query);
    }
}

?>