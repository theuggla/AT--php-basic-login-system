<?php

namespace tictactoe\view;

class GameView {

    public function displayInstructions()
    {
        return "<p>Welcome!</p>"
        ."<p>"
        . $this->getActionsHTML()
        ."</p>"
        ;
    }

    public function displayNewGameSetup(bool $isAIWinner)
    {
        return "Click on the square you want to play on!";
    }

    public function displayGameOver(bool $isAIWinner)
    {
        return "<p>Game over! "
                . $isAIWinner ? "You lost!" : "You won!" .
                "</p>"
        ;
    }

    public function wantsToPlay()
    {
        return isset($_GET['newgame']);
    }

    public function displayBoard(array $squares) : string
    {
        $board = '___________\n';

        foreach ($squares as $square)
        {
			$board .= $this->getSquare($square);
        }
        
        return
            '<form action="POST">'
                . $board .
            "</form>"
        ;
    }

    public function squareSelected() : bool
    {
        return isset($_POST['square']);
    }

    public function collectDesiredSquare()
    {
        return $_POST['square']; 
    }

    private function getSquare(\tictactoe\model\Square $square)
    {
        return '<button type="submit" form="form1" value="' . $square->getValue() . '">' . $square->isSelectedBy() . '</button>';
    }

    private function getActionsHTML()
    {
        return
        '
            <a href="?newgame">Play new game</a>
            <a href="?quit">Quit</a>
        ';
    }
}