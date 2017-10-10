<?php

namespace loginmodule\model;

class Username
{
    private static $MIN_VALID_LENGTH = 3;
    private static $INVALID_CHARS = array(">", "<", "/", "\\");

    private $username;

    public function __construct(string $username)
    {
        $this->username = $this->stripOfHTMLTags($username);
        $this->validate($username);
    }

    private function validate($username)
    {
        if ($this->usernameIsMissing()) {
            throw new \loginmodule\model\UsernameIsMissingException('Username is missing');
        } elseif ($this->usernameIsTooShort()) {
            throw new \loginmodule\model\UsernameIsNotValidException("Username has too few characters, at least " . self::$MIN_VALID_LENGTH . " characters.");
        } elseif ($this->usernameContainsInvalidCharacters()) {
            throw new \loginmodule\model\UsernameHasInvalidCharactersException('Username contains invalid characters.');
        }
    }

    public function setInvalidChars(array $invalidChars)
    {
        self::$INVALID_CHARS = $invalidChars;
    }

    public static function getMinLength() : int
    {
        return self::$MIN_VALID_LENGTH;
    }

    private function stripOfHTMLTags() : string
    {
        return strip_tags($this->username);
    }

    private function usernameIsMissing() : bool
    {
        return strlen($this->username) == 0;
    }

    private function usernameIsTooShort() : bool
    {
        return strlen($username) < self::$MIN_VALID_LENGTH;
    }

    private function usernameContainsInvalidCharacters() : bool
    {
        foreach (self::$INVALID_CHARS as $char) {
            $found = strpos($username, $char);

            if ($found > -1) {
                return true;
            }

            return false;
        }
    }
}
