<?php

namespace model;

class Password {
    private static $MIN_LENGTH = 2;
    private $password;

    public function __construct(string $suggestedPassword) {
        try {
            if (!strlen($suggestedPassword) > 0) {
                throw new \model\PasswordIsNotValidException('Password is missing');
            }
            if (strlen($suggestedPassword) >= self::$MIN_LENGTH) {
                $this->password = $suggestedPassword;
            }

        } catch (PasswordIsNotValidException $e) {
            throw $e;
        } catch (\Exception $e) {
            echo 'exception in password';
            echo $e;
        }
    }

    public function getPassword() {
        return $this->password;
    }

}

?>