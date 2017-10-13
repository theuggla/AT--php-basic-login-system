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
        $timestamp = time() + $this->expiryTimeInSeconds;
        $this->password->hashPassword();
        $this->persistance->saveTempUser($this->username->getUsername(), $this->password->getPassword(), $timestamp);
    }

    public function checkForManipulation()
    {
        if ($this->persistance->didTempUserExpire($this->username->getUsername(), $this->password->getPassword())) {
            throw new \loginmodule\model\WrongInfoInTempPasswordException('Wrong information in temporary password.');
        }
    }

    public function getExpiryTime() : int
    {
        return $this->expiryTimeInSeconds;
    }
}