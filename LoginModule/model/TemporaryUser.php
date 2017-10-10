<?php

namespace loginmodule\model;

class TemporaryUser extends \loginmodule\model\User
{
    private $expiryTimeInSeconds;

    public function __construct(\loginmodule\persistance\IPersistance $persistance, int $expiryTimeInSeconds)
    {
        parent::__construct($persistance);
        $this->expiryTimeInSeconds = $expiryTimeInSeconds;
    }

    public function saveUser()
    {
        $timestamp = time() + self::$EXPIRY_TIME;
        $this->persistance->saveTempUser($this->username, $this->password, $timestamp);
    }

    public function checkForManipulation()
    {
        if ($this->persistance->didTempUserExpire($this->username, $this->password)) {
            throw new \loginmodule\model\WrongInfoInTempPasswordException('Wrong information in temporary password.');
        }
    }
}