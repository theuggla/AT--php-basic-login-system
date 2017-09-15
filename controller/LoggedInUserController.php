<?php
    class LoggedInUserController {
        public function greetUser() {
            $layout->renderToOutput($loggedInView, $dateTime);
        }
    }
?>