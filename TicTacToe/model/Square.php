<?php

namespace tictactoe\model;

class Square
{
    private $selectedBy = 'TicTacToe::Model::Square::SelectedBy::';
    private $value = 'TicTacToe::Model::Square::Value';

    public function __construct(string $value)
    {
        $this->value = $value;
        $this->selectedBy .= $value;
    }

    public function unselect()
    {
        unset($_SESSION[$this->selectedBy]);
    }

    public function isFree() : bool
    {
        return !isset($_SESSION[$this->selectedBy]);
    }

    public function isSelected() : bool
    {
        return isset($_SESSION[$this->selectedBy]);
    }

    public function isSelectedBy() : string
    {
        return $_SESSION[$this->selectedBy];
    }

    public function getValue() : string
    {
        return $this->value;
    }

    public function select(\tictactoe\model\Player $player)
    {
        $_SESSION[$this->selectedBy] = $player->getSign();
    }
}
