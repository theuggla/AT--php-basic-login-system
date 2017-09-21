<?php

namespace controller;

    class UserController {
        private $loginController = 'UserController::LoginController';
        private $logoutController = 'UserController::Logoutontroller';
        private $registerController = 'UserController::RegisterController';

        private $user  = 'UserController::User';

        private $currentMessage = '';

        private $displayLogin = false;
        private $displayRegister = false;

        public function __construct(
                                $user, 
                                $loginController, 
                                $logoutController,
                                $registerController) {

            $this->loginController = $loginController;
            $this->logoutController = $logoutController;
            $this->registerController = $registerController;

            $this->user = $user;

        }

        public function greetUserCorrectly() {
            $isLoggedIn = isset($_SESSION["isLoggedIn"]) && $_SESSION["isLoggedIn"];   
            $wantsToRegister = isset($_GET["register"]);

            if ($isLoggedIn) {
                $this->displayLogin = true;
            } else if ($wantsToRegister) {
                $this->displayRegister = true;
            } else {
                $this->loginController->tryToLoginUser();

                if ($this->loginController->loginSucceeded()) {
                    $this->displayLogin = true;
                    $this->currentMessage = 'Welcome';
                }
                
            }

            if ($this->displayLogin) {
                $this->logoutController->greetUser($this->currentMessage);
            } else if ($this->displayRegister) {
                echo 'wants to register';
            } else {
                $this->loginController->showLoginForm();
            }
        }
    }

?>