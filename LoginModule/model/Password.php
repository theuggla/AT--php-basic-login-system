<?php

namespace loginmodule\model;

class Password
{
    private static $MIN_VALID_LENGTH = 6;

    protected $password;

    public function __construct(string $password)
    {
        $this->validate($password);
        $this->password = $this->getHashedPassword($password);
    }

    public static function getMinLength() : bool
    {
        return self::$MIN_VALID_LENGTH;
    }

    private function validate($password)
    {
        if ($this->passwordIsMissing()) {
            throw new \loginmodule\model\PasswordIsMissingException('Password is missing');
        } elseif ($this->passwordIsTooShort()) {
            throw new \loginmodule\model\PasswordIsNotValidException("Password has too few characters, at least " . self::$MIN_VALID_LENGTH . " characters.");
        }
    }

    private function getHashedPassword($password) : string
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }
}
