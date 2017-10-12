<?php

namespace tictactoe\model;

class Square {
    private $selectedBy = 'TicTacToe::Model::Square::SelectedBy::';
    private $value;

    public function __construct(string $value)
    {
        $this->value = $value;
        $this->selectedBy .= $value;
    }

    public function unselect()
    {
        unset($_SESSION[$this->selectedBy]);
    }

    public function isSelected() : bool
    {
       return isset($_SESSION[$this->selectedBy]);
    }

    public function isSelectedBy() : string
    {
       return $this->isSelected() ? $_SESSION[$this->selectedBy] : '  ';
    }

    public function getValue()
    {
        return $this->value;
    }

    public function select(\tictactoe\model\Player $player)
    {
        $_SESSION[$this->selectedBy] = $player->getSign();
    }
}