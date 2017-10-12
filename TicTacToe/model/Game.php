<?php

namespace tictactoe\model;

class Game {

    private $isLoggedIn;
    private $squares;

    public function __construct(bool $isLoggedIn)
    {
        $this->isLoggedIn = $isLoggedIn;
        $this->squares = array( "A1" => new Square("A1"),
                                "A2" => new Square("A2"), 
                                "A3" => new Square("A3"),
                                "B1" => new Square("A1"),
                                "B2" => new Square("B2"),
                                "B3" => new Square("B3"),
                                "C1" => new Square("C1"),
                                "C2" => new Square("C2"),
                                "C3" => new Square("C3"),
                            );
    }

    public function newGame()
    {
        foreach ($this->squares as $square)
        {
            $square->unselect();
        }   
    }

    public function playOn()
    {

    }

    public function getBoard()
    {
        return $this->squares;
    }

    public function gameIsOver()
    {
        return true;
    }

    public function isAIWinner()
    {
        return true;
    }

}