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

        public function tryToRegisterUser() {
            if ($this->registerView->userWantsToRegister()) {
                $this->credentials = $this->registerView->getUserCredentials();

                try {
                    $this->user->validateUsername($this->credentials['username']);
                    $this->user->validatePassword($this->credentials['password']);
                    $this->user->validatePassword($this->credentials['passwordRepeat']);
                    $this->user->matchPlaintextPasswords( $this->credentials['password'],  $this->credentials['passwordRepeat'] );

                } catch (\model\UsernameIsNotValidException $e) {
                    $this->currentMessage = $e->getMessage();
                } catch (\model\PasswordIsNotValidException $e) {
                    $this->currentMessage = $e->getMessage();
                } catch (\model\PasswordMisMatchException $e) {
                    $this->currentMessage = $e->getMessage();
                } 
            } 
        }


        public function showRegisterForm() {
            $this->layoutView->renderToOutput($this->registerView, $this->dateTimeView, false, $this->currentMessage);
        }
    }
?>