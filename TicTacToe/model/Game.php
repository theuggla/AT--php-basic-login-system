<?php

namespace tictactoe\model;

class Game {

    private $winningRows;
    private $isLoggedIn;
    private $board;
    private $player;
    private $AI;
    private $isAIWinner;

    public function __construct(bool $isLoggedIn)
    {
        $this->isLoggedIn = $isLoggedIn;
        $this->squares = array( "A1" => new Square("A1"),
                                "A2" => new Square("A2"), 
                                "A3" => new Square("A3"),
                                "B1" => new Square("B1"),
                                "B2" => new Square("B2"),
                                "B3" => new Square("B3"),
                                "C1" => new Square("C1"),
                                "C2" => new Square("C2"),
                                "C3" => new Square("C3")
                            );

                            $this->player = new Player('X');
                            $this->AI = new AI('O');

                            $this->winningRows = array(
                                array(
                                    $this->squares["A1"],
                                    $this->squares["A2"],
                                    $this->squares["A3"]
                                ),
                                array(
                                    $this->squares["B1"],
                                    $this->squares["B2"],
                                    $this->squares["B3"]
                                ),
                                array(
                                    $this->squares["C1"],
                                    $this->squares["C2"],
                                    $this->squares["C3"]
                                ),
                                array(
                                    $this->squares["A1"],
                                    $this->squares["B1"],
                                    $this->squares["C1"]
                                ),
                                array(
                                    $this->squares["A2"],
                                    $this->squares["B2"],
                                    $this->squares["C2"]
                                ),
                                array(
                                    $this->squares["A3"],
                                    $this->squares["B3"],
                                    $this->squares["C3"]
                                ),
                                array(
                                    $this->squares["A3"],
                                    $this->squares["B2"],
                                    $this->squares["C1"]
                                ),
                                array(
                                    $this->squares["A1"],
                                    $this->squares["B2"],
                                    $this->squares["C3"]
                                ),
                            );
    }

    public function newGame()
    {
        foreach ($this->squares as $square)
        {
            $square->unselect();
        } 
    }

    public function playOn(string $square)
    {
        if (!($this->squares[$square]->isSelected()))
        {
            $this->player->play($this->squares, $square);
            if (!$this->gameIsOver()) {
                $this->AI->play($this->squares, $this->AI->getSquareToPlayOn($this->squares));
            }
        }
    }

    public function getBoard()
    {
        return $this->squares;
    }

    public function gameIsOver() : bool
    {
        if ($this->thereIsAWinner() || $this->gameIsDraw())
        {
            return true;
        }

        return false;
    }

    private function gameIsDraw() : bool
    {
        foreach ($this->squares as $square)
        {
            if (!$square->isSelected())
            {
                return false;
            }
        }

        return true;
    }

    public function thereIsAWinner()
	{

        foreach ($this->winningRows as $row)
        {
            if ($this->isRowWon($row))
            {
                $this->setAIWinnerStatus($row);
                return true;
            }
        }

        return false;
	}

	private function isRowWon(array $row) : bool
	{
        if ($row[0]->isSelected() && $row[1]->isSelected() && $row[2]->isSelected())
        {
            return (($row[0]->isSelectedBy() == $row[1]->isSelectedBy()) && ($row[0]->isSelectedBy() == $row[2]->isSelectedBy()));
        }

        return false;
    }
    
    private function setAIWinnerStatus(array $row)
    {
        $this->isAIWinner = ($row[0]->isSelectedBy() == $this->AI->getSign());
    }

    public function isAIWinner()
    {
        return $this->isAIWinner;
    }

}