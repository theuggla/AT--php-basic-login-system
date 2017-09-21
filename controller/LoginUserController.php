<?php

namespace controller;

    class LoginUserController {
        private $layoutView = 'LoginUserController::LayoutView';
        private $loginView = 'LoginUserController::LoginView';
        private $dateTimeView = 'LoginUserController::DateTimeView';
        private $credentials = 'LoginUserController::Credentials';
        private $user = 'LoginUserController::User';

        private $currentMessage = '';
        private $loginSucceeded = false;

        public function __construct($user, $layoutView, $loginView, $dateTimeView) {
            $this->layoutView = $layoutView;
            $this->loginView = $loginView;
            $this->dateTimeView = $dateTimeView;

            $this->user = $user;
        }

        public function tryToLoginUser() {
            if ($this->loginView->userWantsToLogin()) {
                $this->credentials = $this->loginView->getUserCredentials();

                try {
                    if ($this->user->doesUserExist( $this->credentials['username'],  $this->credentials['password'])) {
                        $this->user->login();
                        $this->loginSucceeded = true;

                        if ($this->loginView->userWantsToKeepCredentials()) {
                            $this->loginView->setCookieCredentials($this->credentials);
                            $this->currentMessage = 'Welcome and you will be remebered';
                        } else {
                            $this->currentMessage = 'Welcome';
                        }
                    }
                } catch (\model\UsernameIsNotValidException $e) {
                    $this->currentMessage = $e->getMessage();
                } catch (\model\PasswordIsNotValidException $e) {
                    $this->currentMessage = $e->getMessage();
                } catch (\model\WrongCredentialsException $e) {
                    $this->currentMessage = $e->getMessage();
                } 
            }

        }

        public function tryToLogoutUser() {
            if ($this->loginView->userWantsToLogout()) {
                $this->user->logout();
                $this->currentMessage = 'Bye bye!';
            }
        }

        public function loginSucceeded() {
            return $this->loginSucceeded;
        }

        public function showLoginForm() {
            $this->layoutView->renderToOutput($this->loginView, $this->dateTimeView, false, $this->currentMessage);
        }

        public function showLogoutForm() {
            $this->layoutView->renderToOutput($this->loginView, $this->dateTimeView, true, $this->currentMessage);
        }
    }
?>