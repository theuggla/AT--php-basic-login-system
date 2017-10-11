<?php

namespace loginmodule\model;

class Username
{
    public static $MIN_VALID_LENGTH = 3;

    private $INVALID_CHARS = array(">", "<", "/", "\\");
    private $username;

    public function __construct(string $username)
    {
        $this->username = $username;
        $this->username = $this->stripUsernameOfHTMLTags();
        $this->validate($username);
    }

    public function getUsername() : String
    {
        return $this->username;
    }

    public function setInvalidChars(array $invalidChars)
    {
        $this->INVALID_CHARS = $invalidChars;
    }

    private function validate()
    {
        if ($this->usernameIsMissing()) {
            throw new \loginmodule\model\UsernameIsMissingException('Username is missing');
        } elseif ($this->usernameIsTooShort()) {
            throw new \loginmodule\model\UsernameIsTooShortException("Username has too few characters, at least " . self::$MIN_VALID_LENGTH . " characters.");
        } elseif ($this->usernameContainsInvalidCharacters()) {
            throw new \loginmodule\model\UsernameHasInvalidCharactersException('Username contains invalid characters.');
        }
    }

    private function stripUsernameOfHTMLTags() : string
    {
        return strip_tags($this->username);
    }

    private function usernameIsMissing() : bool
    {
        return strlen($this->username) == 0;
    }

    private function usernameIsTooShort() : bool
    {
        return strlen($this->username) < self::$MIN_VALID_LENGTH;
    }

    private function usernameContainsInvalidCharacters() : bool
    {
        foreach ($this->INVALID_CHARS as $char) {
            $found = strpos($this->username, $char);

            if ($found > -1) {
                return true;
            }

            return false;
        }
    }
}
