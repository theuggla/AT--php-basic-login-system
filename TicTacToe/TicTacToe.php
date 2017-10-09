<?php

namespace tictactoe;

class TicTacToe {

    private $currentHTML;
    
    public function runGame(bool $isLoggedIn)
    {
        if ($isLoggedIn)
        {
            $this->currentHTML = 'LoggedInTicTacToe';
        }
        else {
            $this->currentHTML = 'LoggedOutTicTacToe';
        }
    }

    public function getCurrentHTML()
    {
        return $this->currentHTML;
    }
}