<?php

namespace tictactoe\model;

class Game
{
    private $winningRows;
    private $squares;
    private $player;
    private $AI;
    private $isPlayerWinner;

    public function __construct(bool $cleverAI)
    {
        $this->player = new Player('X');
        $this->AI = $cleverAI ? new CleverAI('O') : new DumbAI('O');

        // Both of these functions assume that the game is played on a 3x3 grid
        $this->setSquares();
        $this->setWinningRows();
    }

    public function newGame()
    {
        foreach ($this->squares as $square) {
            $square->unselect();
        }
    }

    public function playOn(int $squareIndex)
    {
        if ($this->squares[$squareIndex]->isFree()) {
            $this->squares[$squareIndex]->select($this->player);

            if (!$this->gameIsOver()) {
                $this->AI->getSquareToPlayOn($this->squares)->select($this->AI);
            }
        }
    }

    public function getBoard() : array
    {
        return $this->squares;
    }

    public function gameIsOver() : bool
    {
        if ($this->thereIsAWinner() || $this->gameIsDraw()) {
            return true;
        }

        return false;
    }

    public function isPlayerWinner() : bool
    {
        return $this->isPlayerWinner;
    }

    private function gameIsDraw() : bool
    {
        foreach ($this->squares as $square) {
            if (!$square->isSelected()) {
                return false;
            }
        }

        $this->isPlayerWinner = false;
        return true;
    }

    private function thereIsAWinner() : bool
    {
        foreach ($this->winningRows as $row) {
            if ($this->isRowWon($row)) {
                $this->setPlayerWinnerStatus($row);
                return true;
            }
        }

        return false;
    }

    private function isRowWon(array $row) : bool
    {
        if ($row[0]->isSelected() && $row[1]->isSelected() && $row[2]->isSelected()) {
            return (($row[0]->isSelectedBy() == $row[1]->isSelectedBy()) && ($row[0]->isSelectedBy() == $row[2]->isSelectedBy()));
        }

        return false;
    }
    
    private function setPlayerWinnerStatus(array $row)
    {
        $this->isPlayerWinner = ($row[0]->isSelectedBy() == $this->player->getSign());
    }

    private function setWinningRows()
    {
        $this->winningRows = array(
            array(
                $this->squares[0],
                $this->squares[1],
                $this->squares[2]
            ),
            array(
                $this->squares[3],
                $this->squares[4],
                $this->squares[5]
            ),
            array(
                $this->squares[6],
                $this->squares[7],
                $this->squares[8]
            ),
            array(
                $this->squares[0],
                $this->squares[3],
                $this->squares[6]
            ),
            array(
                $this->squares[1],
                $this->squares[4],
                $this->squares[7]
            ),
            array(
                $this->squares[2],
                $this->squares[5],
                $this->squares[8]
            ),
            array(
                $this->squares[2],
                $this->squares[4],
                $this->squares[6]
            ),
            array(
                $this->squares[0],
                $this->squares[4],
                $this->squares[8]
            ),
        );
    }

    private function setSquares()
    {
        $this->squares = array(
            new Square("A1"),
            new Square("A2"),
            new Square("A3"),
            new Square("B1"),
            new Square("B2"),
            new Square("B3"),
            new Square("C1"),
            new Square("C2"),
            new Square("C3"));
    }
}
