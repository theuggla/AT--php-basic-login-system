<?php

namespace tictactoe\model;

class Square {
    private $selectedBy;
    private $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function unselect()
    {
        unset($this->selectedBy);
    }

    public function isSelected() : bool
    {
       return isset($this->selectedBy);
    }

    public function isSelectedBy() : string
    {
       return $this->isSelected() ? $this->selectedBy : ' ';
    }

    public function getValue()
    {
        return $this->value;
    }

    public function select(\tictactoe\model\Player $player)
    {
        $this->selectedBy = $player->getSign();
    }
}