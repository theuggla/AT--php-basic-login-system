<?php

namespace model;

class Username {
    private static $MIN_LENGTH = 7;
    private $username;

    public function __construct(string $suggestedUsername) {
        try {
            if ($suggestedUsername >= self::$MIN_LENGTH) {
                $this->username = $suggestedUsername;
            }

        } catch (\Exception $e) {
            echo 'exception in username';
            echo $e;
        }
    }

}

?>