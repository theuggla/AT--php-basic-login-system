<?php

namespace controller;

    class LoginUserController {
        private $layoutView = 'LoginUserController::LayoutView';
        private $loginView = 'LoginUserController::LoginView';
        private $dateTimeView = 'LoginUserController::DateTimeView';
        private $credentials = 'LoginUserController::Credentials';
        private $user = 'LoginUserController::User';

        private $COOKIE_EXPIRY;

        private $currentMessage = '';
        private $loginSucceeded = false;
        private $logoutSucceeded = false;

        public function __construct($user, $layoutView, $loginView, $dateTimeView) {
            $this->layoutView = $layoutView;
            $this->loginView = $loginView;
            $this->dateTimeView = $dateTimeView;

            $this->user = $user;

            $this->COOKIE_EXPIRY = time() + 1000;
        }

        public function handleLoggedOutUser() {
            if ($this->loginView->cookieCredentialsArePresent()) {

                $this->credentials = $this->loginView->getCookieCredentials();

                try {
                    if ($this->user->hasCorrectCookieCredentials($this->credentials['username'],  $this->credentials['cookiePassword'])) {
                        $this->user->login();
                        $this->loginSucceeded = true;
                        $this->currentMessage = 'Welcome back with cookie';
                    }
                } catch (\model\WrongInfoInCookieException $e) {
                    $this->currentMessage = $e->getMessage();
                    $this->loginView->removeCookieCredentials();
                }
            }


            if ($this->loginView->userWantsToLogin()) {

                $this->credentials = $this->loginView->getUserCredentials();
                $_SESSION["latestUsername"] = $this->credentials['username'];

                try {
                    if ($this->user->doesUserExist($this->credentials['username'])) {

                    if ($this->user->doesUserHaveCorrectCredentials($this->credentials['username'],  $this->credentials['password'])) {
                        
                        $this->user->login();
                        $this->loginSucceeded = true;

                        if ($this->loginView->userWantsToKeepCredentials()) {

                            $this->credentials['cookiePassword'] = $this->user->hashPassword($this->credentials['password']);
                            $this->loginView->setCookieCredentials($this->credentials, $this->COOKIE_EXPIRY);
                            $this->user->saveCookieCredentials($this->credentials, $this->COOKIE_EXPIRY);
                            $this->currentMessage = 'Welcome and you will be remebered';

                        } else {
                            $this->currentMessage = 'Welcome';
                        }
                    }
                    } else {
                         $this->currentMessage = "Wrong username or password";
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

        public function handleLoggedInUser() {
            if ($this->loginView->userWantsToLogout()) {
                $this->user->logout();
                $this->user->logoutSucceeded = true;
                $this->currentMessage = 'Bye bye!';
            }
        }

        public function loginSucceeded() {
            return $this->loginSucceeded;
        }

        public function userLoggedIn() {
            return $this->loginSucceeded;
        }

        public function userLoggedOut() {
            return $this->logoutSucceeded;
        }

        public function showLoginForm() {
            $this->layoutView->renderToOutput(false, $this->currentMessage, $this->loginView, $this->dateTimeView);
        }

        public function showLogoutForm() {
            $this->layoutView->renderToOutput( true, $this->currentMessage, $this->loginView, $this->dateTimeView);
        }
    }

?>