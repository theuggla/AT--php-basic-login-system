<?php

namespace controller;

    class LoginUserController {
        private static $layoutView;
        private static $loginView;
        private static $dateTimeView;
        private static $credentials = 'LoginUserController::Credentials';

        public function __construct($layoutView, $loginView, $dateTimeView) {
            $this->layoutView = $layoutView;
            $this->loginView = $loginView;
            $this->dateTimeView = $dateTimeView;
        }

        public function greetUser() {
            
        }

        private function tryToLoginUser() {
            
        }

        private function showRegisterForm() {
            $layout->renderToOutput($registerView, $dateTime);
        }

        private function showLoginForm() {
            $layout->renderToOutput($loggedOutView, $dateTime);
        }

        public function authenticateUserWithNewCredentials() {
            if ($this->view->userWantsToAuthenticate()) {
                $credentials = $this->view->getUserCredentials();

                $this->authenticateUser($credentials);
            }
        }

        public function authenticateUserWithSavedCredentials() {
            if ($this->view->userWantsToAuthenticate()) {

                $credentials = $this->view->getSavedUserCredentials();

                $this->authenticateUser($credentials);
            }
        }

        private function authenticateUser() {

             if ($this->user->credentialsAreCorrect($credentials)) {

                $this->view->setUserAsLoggedIn();

                if ($this->view->userWantsToSaveCredentials()) {

                    $this->view->saveUserCredentials();

                } else {
                    $this->view->setLoginAttemptFailed();
                }
             }
        }
    }
?>