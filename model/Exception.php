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

    class PasswordIsMissingException extends \Exception
    {
        public function __construct($message, $code = 0, \Exception $previous = null) {    
            parent::__construct($message, $code, $previous);
        }
    }

    class UsernameIsMissingException extends \Exception
    {
        public function __construct($message, $code = 0, \Exception $previous = null) {    
            parent::__construct($message, $code, $previous);
        }
    }

    class UserIsMissingException extends \Exception
    {
        public function __construct($message, $code = 0, \Exception $previous = null) {    
            parent::__construct($message, $code, $previous);
        }
    }

    class DuplicateUserException extends \Exception
    {
        public function __construct($message, $code = 0, \Exception $previous = null) {    
            parent::__construct($message, $code, $previous);
        }
    }

    class InvalidCredentialsException extends \Exception
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

    class PasswordMisMatchException extends \Exception
    {
        public function __construct($message, $code = 0, \Exception $previous = null) {    
            parent::__construct($message, $code, $previous);
        }
    }
?>