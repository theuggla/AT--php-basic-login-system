<?php

namespace controller;

    class UserController {
        private $loginController = 'UserController::LoginController';
        private $registerController = 'UserController::RegisterController';

        private $user  = 'UserController::User';

        private $displayLogout = false;
        private $displayRegister = false;

        public function __construct(
                                $user, 
                                $loginController, 
                                $registerController) {

            $this->loginController = $loginController;
            $this->registerController = $registerController;

            $this->user = $user;

        }

        public function greetUserCorrectly() {
            $isLoggedIn = $this->user->isUserLoggedIn();  
            $wantsToRegister = isset($_GET["register"]);

            if ($isLoggedIn) {
                $this->displayLogout = true;
            } else if ($wantsToRegister) {
                $this->displayRegister = true;
            } else {
                $this->loginController->tryToLoginUser();

                if ($this->loginController->loginSucceeded()) {
                    $this->displayLogout = true;
                }
                
            }

            if ($this->displayLogout) {
                $this->loginController->showLogoutForm();
            } else if ($this->displayRegister) {
                echo 'wants to register';
            } else {
                $this->loginController->showLoginForm();
            }
        }
    }

?>