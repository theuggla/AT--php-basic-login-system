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

    public function displayNewGameSetup()
    {
        return "Click on the square you want to play on!";
    }

    public function displayGameOver(bool $isAIWinner)
    {
        $winner = $isAIWinner ? "You lost!" : "You won!";
        return '<p>Game over! '
                . $winner .
                '</p> <a href="?newgame">Play again?</a> </p>'
        ;
    }

    public function wantsToPlay()
    {
        return isset($_GET['newgame']);
    }

    public function displayBoard(array $squares) : string
    {
        $board =            '
                            ';
        $count = 1;

        foreach ($squares as $square)
        {
            if ($count % 3 == 0)
            {
                $board .= $this->getSquare($square);
                $board .=   '
                            ';
            }
            else {
                $board .= $this->getSquare($square);
            }

            $count++;
        }
        
        return
            '<form action="GET"> <pre>'
                . $board .
            '</pre></form>'
        ;
    }

    public function squareSelected() : bool
    {
        return isset($_GET['square']);
    }

    public function collectDesiredSquare()
    {
        return $_GET['square']; 
    }

    private function getSquare(\tictactoe\model\Square $square)
    {
        return '<button type="submit" name="square" value="' . $square->getValue() . '">' . $square->isSelectedBy() . '</button>';
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