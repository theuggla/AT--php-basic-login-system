<?php

namespace controller;

    class UserController {
        private $layoutView;
        private $loginView;
        private $logoutView;
        private $registerView;
        private $dateTimeView;

        private $user;

        private $loginController;
        private $logoutController;
        private $registerController;

        public function __construct($layoutView, 
                                $loginView,
                                $logoutView, 
                                $registerView, 
                                $dateTimeView, 
                                $loginController, 
                                $logoutController,
                                $registerController) {

            $this->layoutView = $layoutView;
            $this->loginView = $loginView;
            $this->logoutView = $logoutView;
            $this->registerView = $layoutView;
            $this->dateTimeView = $dateTimeView;
            $this->loginController = $loginController;
            $this->logoutController = $logoutController;
            $this->registerController = $registerController;

        }

        public function greetUserCorrectly() {
            
        }
    }

?>