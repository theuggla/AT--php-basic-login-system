<?php

namespace controller;

    class LoginUserController {
        private static $layoutView = 'LoginUserController::LayoutView';
        private static $loginView = 'LoginUserController::LoginView';
        private static $dateTimeView = 'LoginUserController::DateTimeView';
        private static $credentials = 'LoginUserController::Credentials';
        private static $user = 'LoginUserController::User';

        private $currentMessage = '';

        public function __construct($user, $layoutView, $loginView, $dateTimeView) {
            self::$layoutView = $layoutView;
            self::$loginView = $loginView;
            self::$dateTimeView = $dateTimeView;

            self::$user = $user;
        }

        public function greetUser() {
            if (self::$loginView->userWantsToLogin()) {
                self::$credentials = self::$loginView->getUserCredentials();

                try {
                    self::$user->find( self::$credentials['username'],  self::$credentials['password']);
                } catch (\model\UsernameIsNotValidException $e) {
                    $this->currentMessage = $e->getMessage();
                }
            }
            
            $this->showLoginForm();
        }

        private function tryToLoginUser() {
            
        }

        private function showLoginForm() {
            self::$layoutView->renderToOutput(self::$loginView, self::$dateTimeView, $this->currentMessage);
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