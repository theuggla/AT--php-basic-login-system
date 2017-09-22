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
                    }

                } catch (\model\PasswordIsNotValidException $e) {
                    $this->currentMessage = "Password has too few characters, at least 6 characters.";
                } catch (\model\UsernameIsNotValidException $e) {
                    $this->currentMessage = "Username has too few characters, at least 3 characters.";
                } catch (\model\PasswordMisMatchException $e) {
                    $this->currentMessage = $e->getMessage();
                } 
            }
        }


        public function showRegisterForm() {
            $this->layoutView->renderToOutput(false, $this->currentMessage, $this->registerView, $this->dateTimeView);
        }
    }
?>