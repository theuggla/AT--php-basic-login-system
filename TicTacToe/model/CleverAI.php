<?php

namespace tictactoe\model;

class CleverAI extends AI {

    public function getSquareToPlayOn(array $squares) : Square
    {
        if ($squares[4]->isFree()) {
            return $squares[4];
        }

        if ($squares[0]->isFree()) {
            return $squares[0];
        }

        if ($squares[2]->isFree()) {
            return $squares[2];
        }

        if ($squares[6]->isFree()) {
            return $squares[6];
        }

        if ($squares[8]->isFree()) {
            return $squares[8];
        }

        if ($squares[1]->isFree()) {
            return $squares[1];
        }

        if ($squares[3]->isFree()) {
            return $squares[3];
        }

        if ($squares[5]->isFree()) {
            return $squares[5];
        }

        if ($squares[7]->isFree()) {
            return $squares[7];
        }
    }
}