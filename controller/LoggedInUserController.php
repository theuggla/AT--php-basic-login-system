<?php
    require_once('../view/LoggedInView.php');
    require_once('../view/DateTimeView.php');
    require_once('../view/LayoutView.php');

    $loggedInView = new LoggedInView();
    $dateTime = new DateTimeView();
    $layout = new LayoutView(); 

    class LoggedInUserController {
        public function greetUser() {
            $layout->renderToOutput($loggedInView, $dateTime);
        }
    }
?>