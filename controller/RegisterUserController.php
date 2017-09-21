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

        public function showRegisterForm() {
            $this->layoutView->renderToOutput($this->registerView, $this->dateTimeView, false, $this->currentMessage);
        }
    }
?>