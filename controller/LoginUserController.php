<?php

namespace controller;

    class LoginUserController {
        private static $layoutView = 'LoginUserController::LayoutView';
        private static $loginView = 'LoginUserController::LoginView';
        private static $dateTimeView = 'LoginUserController::DateTimeView';
        private static $credentials = 'LoginUserController::Credentials';

        public function __construct($layoutView, $loginView, $dateTimeView) {
            self::$layoutView = $layoutView;
            self::$loginView = $loginView;
            self::$dateTimeView = $dateTimeView;
        }

        public function greetUser() {
            $this->showLoginForm();
            if (self::$layoutView->userWantsToLogin()) {
                echo 'you want to login!';
            }
        }

        private function tryToLoginUser() {
            
        }

        private function showLoginForm() {
            self::$layoutView->renderToOutput(self::$loginView, self::$dateTimeView, '');
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