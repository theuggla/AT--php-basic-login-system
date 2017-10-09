<?php

namespace loginmodule\model;

interface IPersistance
{

    public function doesCookieExist(string $username, string $cookiePassword);

    public function saveCookie(string $username, string $cookiepassword, int $timestamp);

    public function doesUserExist(string $username);

    public function getUserPasswordFromUsername(string $username);

    public function saveUser(string $username, string $password);
}
