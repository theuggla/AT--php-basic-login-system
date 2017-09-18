<?php

namespace model;

class Password {
    private static $MIN_LENGTH = 7;
    private $password;

    public function __construct(string $suggestedPassword) {
        try {
            if ($suggestedPassword >= self::$MIN_LENGTH) {
                $this->password = $suggestedPassword;
            }

        } catch (\Exception $e) {
            echo 'exception in password';
            echo $e;
        }
    }

}

?>