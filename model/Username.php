<?php

namespace model;

class Username {
    private static $MIN_LENGTH = 1;
    private static $MIN_VALID_LENGTH = 3;

    public function validateUsername(string $username) {
        if (strlen($username) < self::$MIN_LENGTH) {
            throw new \model\UsernameIsNotValidException('Username is missing');
        } else if (strlen($username) < self::$MIN_VALID_LENGTH) {
            throw new \model\UsernameIsNotValidException("Username has too few characters, at least " . self::$MIN_VALID_LENGTH . " characters.");
        }
    }

}

?>