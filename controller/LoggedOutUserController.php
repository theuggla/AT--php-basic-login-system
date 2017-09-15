<?php
    class LoggedOutUserController {

        private static $credentials = 'LoggedOutUserController::Credentials';

        public function greetUser() {
            if ($loggedOutView->credentialsAreSavedInCookie) {
                $this->credentials = $loggedOutView->getSavedCredentials();
                $this->tryToLoginUser($this->credentials);
            } else if ($loggedOutView->userWantsToRegister()){
                $this->showRegisterForm();
            } else if ($loggedOutView->userWantsToLogin()) {
                $this->credentials = $loggedOutView->getNewCredentials();
                $this->tryToLoginUser($this->credentials);
            } else {
                $this->showLoginForm();
            }
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