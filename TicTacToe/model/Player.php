<?php

namespace tictactoe\model;

class Player {
    private $sign;

    public function __construct(char $sign)
    {
        $this->sign = $sign;
    }

    public function getSign()
    {
        return $this->sign;
    }
}