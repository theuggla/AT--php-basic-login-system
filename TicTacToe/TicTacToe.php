<?php

namespace tictactoe;

require_once('TicTacToe/controller/GameController.php');
require_once('TicTacToe/model/Game.php');
require_once('TicTacToe/model/Square.php');
require_once('TicTacToe/model/Player.php');
require_once('TicTacToe/model/AI.php');
require_once('TicTacToe/model/CleverAI.php');
require_once('TicTacToe/model/DumbAI.php');
require_once('TicTacToe/view/GameView.php');

class TicTacToe
{

    private $currentHTML = 'TicTacToeGame::CurrentHTML';
    
    public function runGame(bool $harderDifficulty = false)
    {
        $this->assertThereIsASession();

        $game = new \tictactoe\model\Game($harderDifficulty);
        $gameview = new \tictactoe\view\GameView();
        $gamecontroller = new \tictactoe\controller\GameController($game, $gameview);

        $gamecontroller->playGame();
        $this->currentHTML = $gamecontroller->getCurrentHTML();
    }

    public function getCurrentHTML() : string
    {
        return $this->currentHTML;
    }

    private function assertThereIsASession()
    {
        assert(isset($_SESSION));
    }
}
