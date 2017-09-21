<?php

namespace model;

class Password {
    private static $MIN_LENGTH = 1;
    private static $MIN_VALID_LENGTH = 6;

    private $password;

    public function __construct(string $suggestedPassword) {
        try {
            $this->validatePassword($suggestedPassword);
            $this->password = $suggestedPassword;
        } catch (PasswordIsNotValidException $e) {
            throw $e;
        }
    }

    public function validatePassword($password) {
        if (strlen($password) < self::$MIN_LENGTH) {
            throw new \model\PasswordIsNotValidException('Password is missing');
        } else if (strlen($password) < self::$MIN_VALID_LENGTH) {
            throw new \model\PasswordIsNotValidException("Password has too few characters, at least " . self::$MIN_VALID_LENGTH . " characters.");
        }
    }

    public function getPassword() {
        return $this->password;
    }

}

?>