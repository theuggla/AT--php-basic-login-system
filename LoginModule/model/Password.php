<?php

namespace loginmodule\model;

class Password
{
    public static $MIN_VALID_LENGTH = 6;

    private $password;

    public function __construct(string $password)
    {
        $this->password = $password;
        $this->validatePassword();
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function hashPassword()
    {
        $this->password = \password_hash($this->password, PASSWORD_DEFAULT);
    }

    public function isPasswordCorrect(string $hashedPassword) : bool
    {
        return \password_verify($this->password, $hashedPassword);
    }

    private function validatePassword()
    {
        if ($this->passwordIsMissing()) {
            throw new \loginmodule\model\PasswordIsMissingException('Password is missing');
        } elseif ($this->passwordIsTooShort()) {
            throw new \loginmodule\model\PasswordIsTooShortException("Password has too few characters, at least " . self::$MIN_VALID_LENGTH . " characters.");
        }
    }

    private function passwordIsMissing() : bool
    {
        return strlen($this->password) == 0;
    }

    private function passwordIsTooShort() : bool
    {
        return strlen($this->password) < self::$MIN_VALID_LENGTH;
    }
}
