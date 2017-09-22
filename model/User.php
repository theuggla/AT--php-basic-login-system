<?php

namespace model;

class User {

    private $username;
    private $password;
    private $cookie;

    public function __construct() {
        $this->username = new \model\Username();
        $this->password = new \model\Password();
        $this->cookie = new \model\Cookie();
    }

    public function doesUserExist(string $username, string $password) {
        try {
            $this->findUser($username, $password);
            return true;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function hasCorrectCookieCredentials(string $username, string $cookiePassword) {
        return $this->cookie->findCookie($username, $cookiePassword);
    }

    private function findUser(string $username, string $password) {
        $this->username->validateUsername($username);
        $this->password->validatePassword($password);

        $query='SELECT * FROM User WHERE BINARY username="' . $username . '" AND BINARY password="' . $password . '"';
        $dbconnection = \model\DBConnector::getConnection('UserRegistry');
        $result = $dbconnection->query($query);
        
        if ($result->num_rows <= 0) {
            throw new \model\WrongCredentialsException('Wrong name or password');
        }
    }

    public function logout() {
        $_SESSION["isLoggedIn"] = false;
    }

    public function login() {
        $_SESSION["isLoggedIn"] = true;
        $_SESSION['userAgent'] = $_SERVER['HTTP_USER_AGENT'];
    }

    public function isLoggedIn() {
        return isset($_SESSION["isLoggedIn"]) && $_SESSION["isLoggedIn"];
    }

    public function hasNotBeenHijacked() {
        return isset($_SESSION["userAgent"]) && $_SESSION["userAgent"] == $_SERVER["HTTP_USER_AGENT"];
    }

    public function hashPassword($password) {
        $hashedPassword = $this->password->hashPassword($password);
        return ($hashedPassword);
    }

    public function matchPlaintextPasswords($passOne, $passTwo) {
        if ($passOne === $passTwo) {
            return true;
        } else {
            throw new \model\PasswordMisMatchException("Passwords do not match.");
        }
    }

    public function saveCookieCredentials($credentials, $expiry) {
        $this->cookie->saveCookie($credentials["username"], $credentials["cookiePassword"], $expiry);
    }

    public function validateUsername($username) {
        return $this->username->validateUsername($username);
    }

    public function cleanUpUsername($username) {
        return $this->username->cleanUpUsername($username);
    }

    public function validatePassword($password) {
        return $this->password->validatePassword($password);
    }

    public function saveUser(string $username, string $password) {

    }
}

?>