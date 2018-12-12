<?php

namespace model;

class LastStickGame {
	private static $startingNumberOfSticks = 22;

	private $ai;
	private $sticks;

	public function __construct() {
		$this->ai = new AIPlayer();
		$this->sticks = new PersistantSticks(self::$startingNumberOfSticks);
	}

	public function playerSelectsSticks(StickSelection $playerSelection, StickGameObserver $observer) {
		$this->sticks->removeSticks($playerSelection);

		if ($this->isGameOver()) {
			$observer->playerWins();
		} else {
			$this->AIPlayerTurn($observer);
		} 
	}
	
	public function getStartingNumberOfSticks()
	{
		return self::$startingNumberOfSticks;
	}

	private function AIPlayerTurn(StickGameObserver $observer) {
		$sticksLeft = $this->getNumberOfSticks();
		$selection = $this->ai->getSelection($sticksLeft);
		
		$this->sticks->removeSticks($selection);
		$observer->aiRemoved($selection);

		if ($this->isGameOver()) {
			$observer->playerLoose();
		}
	}

	public function isGameOver() : bool {
		return $this->sticks->getNumberOfSticks() < 2;
	}

	public function getNumberOfSticks() : int {
		return $this->sticks->getNumberOfSticks();
	}

	public function newGame() {
		$this->sticks->newGame(self::$startingNumberOfSticks);
	}
}