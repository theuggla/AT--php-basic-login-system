<?php

namespace controller;

    class UserController {
        private $loginController = 'UserController::LoginController';
        private $registerController = 'UserController::RegisterController';

        private $user  = 'UserController::User';

        private $displayLoginForm = true;
        private $displayRegisterForm = false;

        public function __construct($user, $loginController, $registerController) {
            $this->loginController = $loginController;
            $this->registerController = $registerController;

            $this->user = $user;

        }

        public function greetUserCorrectly() {
            $this->delegateControlDependingOnUseCase();
            $this->displayCorrectView();
        }

        private function delegateControlDependingOnUseCase() {
            if ($this->user->isLoggedIn() && $this->user->hasNotBeenHijacked()) {                
                
                $this->loginController->handleLoggedInUser();

                if ($this->user->isLoggedIn()) {
                    $this->displayLoginForm = false;
                }

            } else if ($this->registerController->userWantsToRegister()) {
                
                $this->displayRegisterForm = true;

                $this->registerController->handleUser();

            } else {
                $this->loginController->handleLoggedOutUser();

                if ($this->user->isLoggedIn()) {
                    $this->displayLoginForm = false;
                }
                
            }

        }

        private function displayCorrectView() {
            if ($this->displayLoginForm) {

                $this->loginController->showLoginForm();
                
            } else if ($this->displayRegisterForm) {

                $this->registerController->showRegisterForm();

            } else {

                $this->loginController->showLogoutForm();
                
            }
        }
    }
?>