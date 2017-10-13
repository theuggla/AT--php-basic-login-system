<?php

namespace tictactoe\model;

class DumbAI extends AI {
    public function getSquareToPlayOn(array $squares) : Square
    {
        foreach($squares as $square)
        {
            if ($square->isFree())
            {
                return $square;
            }
        }
    }
}