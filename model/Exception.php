<?php

namespace model;

    class UsernameIsNotValidException extends \Exception
    {
        public function __construct($message, $code = 0, \Exception $previous = null) {    
            parent::__construct($message, $code, $previous);
        }
    }

    class PasswordIsNotValidException extends \Exception
    {
        public function __construct($message, $code = 0, \Exception $previous = null) {    
            parent::__construct($message, $code, $previous);
        }
    }

    class WrongCredentialsException extends \Exception
    {
        public function __construct($message, $code = 0, \Exception $previous = null) {    
            parent::__construct($message, $code, $previous);
        }
    }

    class WrongInfoInCookieException extends \Exception
    {
        public function __construct($message, $code = 0, \Exception $previous = null) {    
            parent::__construct($message, $code, $previous);
        }
    }
?>