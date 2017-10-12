<?php

namespace tictactoe\controller;

class GameController {

    private $game = 'TicTacToeGame::GameController::Game';
    private $gameView = 'TicTacToeGame::GameController::GameView';

    private $currentHTML = 'TicTacToeGame::GameController::CurrentHTML';

    public function __construct(\tictactoe\model\Game $game, \tictactoe\view\GameView $gameView)
    {
        $this->game = $game;
        $this->gameView = $gameView;
    }

    public function getCurrentHTML()
    {
        return $this->currentHTML;
    }

    public function playGame()
    {
        $this->currentHTML = $this->gameView->displayInstructions();

        if ($this->game->gameIsOver())
        {
            $this->gameView->displayGameOver($this->game->isAIWinner());
        }

        if ($this->gameView->wantsToPlay())
        {
            $this->gameView->displayNewGameSetup();
            $this->game->newGame();
        }
        else if ($this->gameView->squareSelected())
        {
            $this->game->playOn($this->gameView->collectDesiredSquare());
        }

        $this->currentHTML .= $this->gameView->displayBoard($this->game->getBoard());
    }


}