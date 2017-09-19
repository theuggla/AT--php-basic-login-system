<?php

namespace model;

class User {
    private $password;
    private $username;

    public function getUser(string $username, string $password) {
        try {
            $this->username = new Username($username);
            $this->password = new Password($password);

            $query='SELECT * FROM User WHERE username="' . $this->username->getUsername() . '" AND password="' . $this->password->getPassword() . '"';
            $dbconnection = \model\DBConnector::getConnection('UserRegistry');
            $result = $dbconnection->query($query);
            
            if ($result->num_rows > 0) {
                $_SESSION["isLoggedIn"] = true;
            } else {
                throw new \model\WrongCredentialsException('Username or password is wrong');
            }
        } catch (\model\WrongCredentialsException $e) {
            throw $e;
        } catch (\Exception $e) {
            echo 'exception';
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

    public function logOut() {

    }

    public function logIn() {

    }

    public function register() {

    }

    public function isUserLoggedIn() {
        return $_SESSION["isLoggedIn"];
    }
}

?>