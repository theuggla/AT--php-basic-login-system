<?php

namespace controller;

    class LoginUserController {
        private static $newCredentialsLoginSucessfullMessage = 'Welcome';
        private static $saveCookieLoginSucessfullMessage = 'Welcome and you will be remembered';
        private static $cookieLoginSuccessfulMessage = 'Welcome back with cookie';
        private static $logoutSucessfullMessage = 'Bye bye!';
        private static $wrongCredentialsMessage = 'Wrong name or password';
        private static $noUsernameMessage = 'Username is missing';
        private static $noPasswordMessage = 'Password is missing';
        private static $manipulatedCookieCredentialsMessage = 'Wrong information in cookies';

        private $loginView = 'LoginUserController::LoginView';

        private $cookie = 'LoginUserController::Cookie';
        private $user = 'LoginUserController::User';

        private $currentMessage = '';
        private $currentUsername = '';
        private $currentPassword = '';
        private $currentCookieUsername = '';
        private $currentCookiePassword = '';


        private $loginSucceeded = false;
        private $logoutSucceeded = false;

        public function __construct($user, $cookie, $loginView) 
        {
            $this->user = $user;
            $this->cookie = $cookie;
            $this->loginView = $loginView;
        }

        public function handleLoggedOutUser() 
        {
            try
            {
                if ($this->loginView->cookieCredentialsArePresent()) 
                {
                    $this->attemptLoginWithCookieCredentials();
                }
                else if ($this->loginView->userWantsToLogin()) 
                {
                    $this->attemptLoginWithNewCredentials();
                    $this->user->setLatestUsername($this->currentUsername);
                }
            }
            catch (\model\WrongInfoInCookieException $e) 
            {
                $this->currentMessage = self::$manipulatedCookieCredentialsMessage;
                $this->loginView->removeCookieCredentials();
            }
            catch (\model\UsernameIsNotValidException $e) 
            {
                $this->currentMessage = self::$noUsernameMessage;
                $this->user->setLatestUsername($this->currentUsername);
            } 
            catch (\model\PasswordIsNotValidException $e) 
            {
                $this->currentMessage = self::$noPasswordMessage;
                $this->user->setLatestUsername($this->currentUsername);
            }
            catch (\model\UserIsMissingException $e) 
            {
                $this->currentMessage = self::$wrongCredentialsMessage;
                $this->user->setLatestUsername($this->currentUsername);
            } 
            catch (\model\WrongCredentialsException $e) 
            {
                $this->currentMessage = self::$wrongCredentialsMessage;
                $this->user->setLatestUsername($this->currentUsername);
            }

        }

        public function handleLoggedInUser() 
        {
            if ($this->loginView->userWantsToLogout()) 
            {
                $this->logoutUser();
            }
        }

        private function attemptLoginWithCookieCredentials()
        {
            $this->setCurrentCredentialsFromCookie();

            $this->ensureCookieCredentialsHaveNotBeenManipulated();
            $this->loginUserWithCookieCredentials();
            $this->currentMessage = self::$cookieLoginSuccessfulMessage;
            
        }

        private function attemptLoginWithNewCredentials()
        {
            $this->setCurrentCredentialsFromLoginForm();
            $this->loginUserWithCurrentCredentials();
        }

        private function ensureCookieCredentialsHaveNotBeenManipulated()
        {
            $this->cookie->checkForManipulation($this->currentCookieUsername, $this->currentCookiePassword);
        }

        private function loginUserWithCurrentCredentials()
        {
            $this->user->checkThatCredentialsAreValid($this->currentUsername, $this->currentPassword);
            $this->user->login();
            $this->loginSucceeded = true;

            if ($this->loginView->userWantsToKeepCredentials()) 
            {
                $this->makeCookie();
                $this->currentMessage = self::$saveCookieLoginSucessfullMessage;
            } 
            else 
            {
                $this->currentMessage = self::$newCredentialsLoginSucessfullMessage;
            }
        }

        private function loginUserWithCookieCredentials()
        {
            $this->user->login();
            $this->loginSucceeded = true;

            $this->currentMessage = self::$cookieLoginSuccessfulMessage;
        }

        private function logoutUser()
        {
            $this->user->logout();
            $this->loginView->removeCookieCredentials();
            $this->logoutSucceeded = true;
            $this->currentMessage = self::$logoutSucessfullMessage;
        }

        private function setCurrentCredentialsFromCookie()
        {
            $this->currentCookieUsername = $this->loginView->getCookieUsername();
            $this->currentCookiePassword = $this->loginView->getCookiePassword();
        }

        private function setCurrentCredentialsFromLoginForm()
        {
            $this->currentUsername = $this->loginView->getLoginFormUsername();
            $this->currentPassword = $this->loginView->getLoginFormPassword();
        }

        private function makeCookie()
        {
            $expirytimestamp = time() + $this->cookie->getExpiryTime();
            $this->currentCookiePassword = $this->cookie->hashPassword($this->currentPassword);
            $this->loginView->setCookieCredentials($this->currentUsername, $this->currentCookiePassword, $expirytimestamp);
            $this->cookie->saveCookie($this->currentUsername, $this->currentCookiePassword);
        }

        public function loginSuccessful() 
        {
            return $this->loginSucceeded;
        }

        public function logoutSuccessful() 
        {
            return $this->logoutSucceeded;
        }

        public function getHTML(string $message, string $latestUsername)
        {
            return $this->loginView->getHTML($this->user->isLoggedIn(), $message, $latestUsername);
        }

        public function getCurrentMessage()
        {
            return $this->currentMessage;
        }
    }