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
                $this->user->getUser( $this->credentials['username'],  $this->credentials['password']);
                } catch (\model\UsernameIsNotValidException $e) {
                    $this->currentMessage = $e->getMessage();
                } catch (\model\PasswordIsNotValidException $e) {
                    $this->currentMessage = $e->getMessage();
                } catch (\model\WrongCredentialsException $e) {
                    $this->currentMessage = $e->getMessage();
                } 
            }

            if ($this->user->isUserLoggedIn()) {
                $this->loginSucceeded = true;
                $this->currentMessage = 'Welcome';
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