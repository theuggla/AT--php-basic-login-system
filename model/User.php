<?php

namespace model;

class User {
    public function doesUserExist($username, $password) {
        try {
            $this->findUser($username, $password);
            return true;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    private function findUser(string $username, string $password) {
        $username = new Username($username);
        $password = new Password($password);

        $query='SELECT * FROM User WHERE BINARY username="' . $username->getUsername() . '" AND BINARY password="' . $password->getPassword() . '"';
        $dbconnection = \model\DBConnector::getConnection('UserRegistry');
        $result = $dbconnection->query($query);
        
        if ($result->num_rows <= 0) {
            throw new \model\WrongCredentialsException('Wrong name or password');
        }
    }

    public function createUser(string $suggestedUsername, string $suggestedPassword) {
        try {
            $username = new Username($suggestedUsername);
            $password = new Password($suggestedPassword);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function logout() {
        $_SESSION["isLoggedIn"] = false;
    }

    public function login() {
        $_SESSION["isLoggedIn"] = true;
    }

    public function isUserLoggedIn() {
        return isset($_SESSION["isLoggedIn"]) && $_SESSION["isLoggedIn"];
    }
}

?>