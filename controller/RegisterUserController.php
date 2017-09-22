<?php
namespace controller;

    class RegisterUserController {

        private $layoutView = 'RegisterUserController::LayoutView';
        private $registerView = 'RegisterUserController::RegisterView';
        private $dateTimeView = 'RegisterUserController::DateTimeView';
        private $credentials = 'RegisterUserController::Credentials';
        private $user = 'RegisterUserController::User';

        private $currentMessage = '';
        private $registrySucceeded = false;

        public function __construct($user, $layoutView, $registerView, $dateTimeView) {
            $this->layoutView = $layoutView;
            $this->registerView = $registerView;
            $this->dateTimeView = $dateTimeView;

            $this->user = $user;
        }

        public function userWantsToRegister() {
            return $this->registerView->userWantsToViewForm();
        }

        public function handleUser() {

            if ($this->registerView->userWantsToRegister()) {
                
                $this->credentials = $this->registerView->getUserCredentials();
                $_SESSION["latestUsername"] = $this->credentials['username'];

                try {
                    $usernameValid = strlen($this->credentials['username']) >= 3;
                    $passwordValid = strlen($this->credentials['password']) >= 6;

                    if (!$usernameValid) {
                        $this->currentMessage = "Username has too few characters, at least 3 characters. ";
                    }

                    if (!$passwordValid) {
                        $this->currentMessage .= "Password has too few characters, at least 6 characters.";
                    }

                    if ($usernameValid && $passwordValid) {
                        $this->user->validateUsername($this->credentials['username']);
                        $this->user->validatePassword($this->credentials['password']);
                        $this->user->matchPlaintextPasswords( $this->credentials['password'],  $this->credentials['passwordRepeat'] );

                        if ($this->user->doesUserExist($this->credentials['username'])) {
                            $this->currentMessage = "User exists, pick another username.";
                        } else {
                            $this->user->saveUser($this->credentials['username'], $this->credentials['password']);
                            $this->currentMessage = "Registered new user.";
                            unset($_GET['register']);
                            $this->registrySucceeded = true;
                        }
                    }

                } catch (\model\PasswordIsNotValidException $e) {
                    $this->currentMessage = "Password has too few characters, at least 6 characters.";
                } catch (\model\UsernameIsNotValidException $e) {
                    $this->currentMessage = $e->getMessage();
                    $_SESSION["latestUsername"] = $this->user->cleanUpUsername($this->credentials['username']);
                } catch (\model\PasswordMisMatchException $e) {
                    $this->currentMessage = $e->getMessage();
                }
            }
        }

        public function registrationSuccessful() {
            return $this->registrySucceeded;
        }

        public function showRegisterForm() {
            $this->layoutView->renderToOutput(false, $this->currentMessage, $this->registerView, $this->dateTimeView);
        }
    }
?>