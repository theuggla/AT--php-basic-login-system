<?php

namespace model;

class Username {
    private static $MIN_LENGTH = 1;
    public static $MIN_VALID_LENGTH = 3;
    private static $INVALID_CHARS = array(">", "<", "/", "\\");

    public function validateUsername(string $username) 
    {
        if (strlen($username) < self::$MIN_LENGTH) 
        {
            throw new \model\UsernameIsNotValidException('Username is missing');
        } 
        else if (strlen($username) < self::$MIN_VALID_LENGTH) 
        {
            throw new \model\UsernameIsNotValidException("Username has too few characters, at least " . self::$MIN_VALID_LENGTH . " characters.");
        } 
        else 
        {
            foreach(self::$INVALID_CHARS as $char) 
            {
                $found = strpos($username , $char);

                if ($found > -1) 
                {
                    throw new \model\UsernameIsNotValidException('Username contains invalid characters.');
                }
            }
        }
    }

    public function cleanUpUsername(string $username) 
    {
        $cleanedUpString = strip_tags($username);
        $cleanedUpString = str_replace(self::$INVALID_CHARS , '', $cleanedUpString);
        return $cleanedUpString;
    }

}

?>