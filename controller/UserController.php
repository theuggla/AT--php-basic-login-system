<?php

namespace controller;

    class UserController {
        private $loginController = 'UserController::LoginController';
        private $registerController = 'UserController::RegisterController';

        private $user  = 'UserController::User';

        private $displayLogout;
        private $displayRegister;

        public function __construct($user, $loginController, $registerController) {
            $this->loginController = $loginController;
            $this->registerController = $registerController;

            $this->user = $user;

        }

        public function greetUserCorrectly() {

            if ($this->user->isLoggedIn() && $this->user->hasNotBeenHijacked()) {
                
                $this->displayLogout = true;
                
                $this->loginController->handleLoggedInUser();

            } else if ($this->registerController->userWantsToRegister()) {

                $this->displayRegister = true;

                $this->registerController->handleUser();

            } else {
                $this->loginController->handleLoggedOutUser();

                if ($this->loginController->loginSucceeded()) {

                    $this->displayLogout = true;

                }
                
            }

            if ($this->displayLogout) {

                $this->loginController->showLogoutForm();

            } else if ($this->displayRegister) {

                $this->registerController->showRegisterForm();

            } else {
                $this->loginController->showLoginForm();
            }
        }
    }
?>