<?php

namespace controller;

    class LogoutController {
        public function greetUser() {
            $layout->renderToOutput($loggedInView, $dateTime);
        }
    }
?>