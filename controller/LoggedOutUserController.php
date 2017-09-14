<?php
    require_once('../view/LoggedOutView.php');
    require_once('../view/RegisterUserView.php');
    require_once('../view/DateTimeView.php');
    require_once('../view/LayoutView.php');

    $loggedOutView = new LoggedOutView();
    $registerView = new RegisterUserView();
    $dateTime = new DateTimeView();
    $layout = new LayoutView();

    class LoggedOutUserController {

        public function greetUser() {
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