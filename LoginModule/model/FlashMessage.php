<?php

namespace loginmodule\model;

class FlashMessage {

    private static $currentMessage = 'UpdatedLoginModule::MainController::CurrentFlashMessage';

    public function getCurrentMessage() : String
    {
        return isset($_SESSION[self::$currentMessage]) ? $_SESSION[self::$currentMessage] : '';
    }

    public function setCurrentMessage(string $message)
    {
        $_SESSION[self::$currentMessage] = $message;
    }
}