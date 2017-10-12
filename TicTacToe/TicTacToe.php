<?php

namespace tictactoe;

require_once('TicTacToe/controller/GameController.php');
require_once('TicTacToe/model/Game.php');
require_once('TicTacToe/model/Square.php');
require_once('TicTacToe/model/Player.php');
require_once('TicTacToe/model/AI.php');
require_once('TicTacToe/view/GameView.php');

class TicTacToe {

    private $currentHTML;
    
    public function runGame(bool $isLoggedIn)
    {
        $game = new \tictactoe\model\Game($isLoggedIn);
        $gameview = new \tictactoe\view\GameView();
        $gamecontroller = new \tictactoe\controller\GameController($game, $gameview);

        $gamecontroller->playGame();
        $this->currentHTML = $gamecontroller->getCurrentHTML();
    }

    public function getCurrentHTML()
    {
        return $this->currentHTML;
    }
}