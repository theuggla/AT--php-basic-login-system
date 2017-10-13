<?php

namespace tictactoe\view;

class GameView
{
    private static $newGame = 'newgame';
    private static $quit = 'quit';
    private static $squareChosen = 'square';

    public function displayInstructions()
    {
        return
            "<p>Welcome to the TicTacToe-Game!</p>"
            . "<p>Click on the square you want to play on. If you are logged in, the difficulty will
                be harder.</p>"
            ."<p>"
            . $this->getActionsHTML()
            ."</p>"
        ;
    }

    public function displayGameOver(bool $isPlayerWinner)
    {
        $winner = $isPlayerWinner ? "You won!" : "You lost!";
        return '<p>Game over! '
                . $winner .
                '</p> <a href="?' . self::$newGame . '">Play again?</a> </p>'
        ;
    }

    public function wantsToPlay()
    {
        return isset($_GET[self::$newGame]);
    }

    public function displayBoard(array $squares) : string
    {
        $board = '';

        foreach ($squares as $index => $square) {
            if (($index + 1) % 3 == 0) {
                $board .= $this->getSquare($index, $square);
                $board .= '</br>';
            } else {
                $board .= $this->getSquare($index, $square);
            }
        }
        
        return
            '<form action="GET"> <pre>'
                . $board .
            '</pre></form>'
        ;
    }

    public function squareSelected() : bool
    {
        return isset($_GET[self::$squareChosen]);
    }

    public function collectDesiredSquare()
    {
        return $_GET[self::$squareChosen];
    }

    private function getSquare(int $index, \tictactoe\model\Square $square)
    {
        $sign = $square->isSelected() ? $square->isSelectedBy() : '  ';
        return '<button type="submit" name="' . self::$squareChosen . '" value="' . $index . '">' . $sign . '</button>';
    }

    private function getActionsHTML()
    {
        return
        '
            <a href="?' . self::$newGame . '">Play new game</a>
            <a href="?' . self::$quit . '">Quit</a>
        ';
    }
}
