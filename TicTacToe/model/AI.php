<?php

namespace tictactoe\model;

abstract class AI extends Player
{

    public function getSquareToPlayOn(array $squares) : Square
    {
    }
}
