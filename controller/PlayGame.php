<?php

namespace controller;

class PlayGame {

	private $game;

	private $view;

	private $message = "";


	public function __construct() {
		$this->game = new \model\LastStickGame();
		$this->view = new \view\GameView($this->game);
	}

	public function runGame() : String {
		if ($this->game->isGameOver()) {
			$this->doGameOver();
		} else {
			$this->playGame();
		}

		return $this->view->show($this->message);
	}

	public function getStartingNumberOfSticks() {

	}

	private function playGame() {
		if ($this->view->playerSelectSticks()) {
			try {
				$sticksDrawnByPlayer = $this->view->getNumberOfSticks();
				$this->game->playerSelectsSticks($sticksDrawnByPlayer, $this->view);
			} catch(\Exception $e) {
				$this->message = $e;
			}
		}
	}

	private function doGameOver() {
		if ($this->view->playerStartsOver()) {
			$this->game->newGame();
		}		
	}
}