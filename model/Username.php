<?php

namespace model;

class Username {
    private static $MIN_LENGTH = 0;
    private static $MIN_VALID_LENGTH = 0;

    private $username;

    public function __construct(string $suggestedUsername) {
        try {
            if (!strlen($suggestedUsername) > 0) {
                throw new \model\UsernameIsNotValidException('Username is missing');
            }
            if (strlen($suggestedUsername) >= self::$MIN_LENGTH) {
                $this->username = $suggestedUsername;
            }

        } catch (UsernameIsNotValidException $e) {
            throw $e;
        } catch (\Exception $e) {
            echo 'exception in username';
            echo $e;
        }
    }

    public function getUsername() {
        return $this->username;
    }

}

?>