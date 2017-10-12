<?php

namespace tictactoe\model;

class CleverAI extends AI {
    public function getSquareToPlayOn(array $squares) : string
    {
        if (!$squares["B2"]->isSelected()) {
            return $squares["B2"]->getValue();
        }

        if (!$squares["A1"]->isSelected()) {
            return $squares["A1"]->getValue();
        }

        if (!$squares["A3"]->isSelected()) {
            return $squares["A3"]->getValue();
        }

        if (!$squares["C1"]->isSelected()) {
            return $squares["C1"]->getValue();
        }

        if (!$squares["C3"]->isSelected()) {
            return $squares["C3"]->getValue();
        }

        if (!$squares["A2"]->isSelected()) {
            return $squares["A2"]->getValue();
        }

        if (!$squares["B1"]->isSelected()) {
            return $squares["B1"]->getValue();
        }

        if (!$squares["B3"]->isSelected()) {
            return $squares["B3"]->getValue();
        }

        if (!$squares["C2"]->isSelected()) {
            return $squares["C2"]->getValue();
        }
    }
}