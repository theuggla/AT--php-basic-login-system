<?php

namespace model;

class User {
    private $password;
    private $username;

    public function getUser(string $username, string $password) {
        try {
            $this->username = new Username($username);
            $this->password = new Password($password);

            $query='SELECT * FROM User WHERE BINARY username="' . $this->username->getUsername() . '" AND BINARY password="' . $this->password->getPassword() . '"';
            $dbconnection = \model\DBConnector::getConnection('UserRegistry');
            $result = $dbconnection->query($query);
            
            if ($result->num_rows > 0) {
                $this->login();
            } else {
                throw new \model\WrongCredentialsException('Wrong name or password');
            }
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function create(string $suggestedUsername, string $suggestedPassword) {
        try {
            $this->username = new Username($suggestedUsername);
            $this->password = new Password($suggestedPassword);
        } catch (\Exception $e) {
            echo 'found exception';
            echo e;
        }
    }

    public function logout() {
        $_SESSION["isLoggedIn"] = false;
    }

    public function login() {
        $_SESSION["isLoggedIn"] = true;
    }

    public function register() {

    }

    public function isUserLoggedIn() {
        return isset($_SESSION["isLoggedIn"]) && $_SESSION["isLoggedIn"];
    }
}

?>