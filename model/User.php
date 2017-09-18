<?php

namespace model;

class User {
    private $password;
    private $username;

    private $isLoggedIn;

    public function __construct(string $suggestedUsername, string $suggestedPassword) {
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
        return $this->isLoggedIn;
    }
}

?>