<?php

namespace tictactoe\model;

class Game {

    private $isLoggedIn;

    public function __construct(bool $isLoggedIn)
    {
        $this->isLoggedIn = $isLoggedIn;
    }

    public function newGame()
    {
        if ($this->isLoggedIn)
        {
            return 'You are playing logged in TicTacToe';
        }

        return 'You are playing logged out TicTacToe';
    }

}