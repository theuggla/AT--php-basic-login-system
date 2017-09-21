<?php

namespace controller;

    class LogoutUserController {

        private static $layoutView = 'LogoutUserController::LayoutView';
        private static $logoutView = 'LogoutUserController::LogoutView';
        private static $dateTimeView = 'LogoutUserController::DateTimeView';
        private static $user = 'LogoutUserController::User';

        private $currentMessage = '';

        public function __construct($user, $layoutView, $logoutView, $dateTimeView) {
            self::$layoutView = $layoutView;
            self::$logoutView = $logoutView;
            self::$dateTimeView = $dateTimeView;

            self::$user = $user;
        }


        public function greetUser() {
            self::$layoutView->renderToOutput(self::$logoutView, self::$dateTimeView, $this->currentMessage);
        }
    }
?>