<?php

namespace model;

class Password {
    private static $MIN_LENGTH = 1;
    public static $MIN_VALID_LENGTH = 6;

    public function validatePassword(string $password) 
    {
        if (strlen($password) < self::$MIN_LENGTH) 
        {
            throw new \model\PasswordIsNotValidException('Password is missing');
        } 
        else if (strlen($password) < self::$MIN_VALID_LENGTH) 
        {
            throw new \model\PasswordIsNotValidException("Password has too few characters, at least " . self::$MIN_VALID_LENGTH . " characters.");
        }
    }

    public function hashPassword(string $password) 
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        return $hashedPassword;
    }

}

?>