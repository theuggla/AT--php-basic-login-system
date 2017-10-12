<?php

namespace tictactoe\model;

class Player {
    protected $sign;

    public function __construct(string $sign)
    {
        $this->sign = $sign;
    }

    public function getSign()
    {
        return $this->sign;
    }

    public function play(array $squares, string $square)
    {
        $squares[$square]->select($this);
    }
}