<?php

namespace tictactoe\model;

class DumbAI extends AI {
    public function getSquareToPlayOn(array $squares) : string
    {
        foreach($squares as $square)
        {
            if (!$square->isSelected())
            {
                return $square->getValue();
            }
        }
    }
}