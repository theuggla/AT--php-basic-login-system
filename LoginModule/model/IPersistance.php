<?php

namespace loginmodule\persistance;

interface IPersistance
{
    public function saveUser(string $username, string $password);

    public function saveTempUser(string $username, string $password, int $timestamp);

    public function doesUserExist(string $username) : bool;

    public function getUserPassword(string $username);

    public function didTempUserExpire(string $username, string $password): bool;
}
