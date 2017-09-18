<?php

namespace controller;

    class LogoutUserController {
        public function greetUser() {
            $layout->renderToOutput($loggedInView, $dateTime);
        }
    }
?>