<?php

namespace view;

class GameView implements \model\StickGameObserver {
	private static $draw = "draw";
	private static $startOver = "startOver";

	private $numberOfSticksAIDrewLastTime = 0;

	private $playerWon = false;

	public function playerWins() {
		$this->playerWon = true;
	}
	public function playerLoose() {
		$this->playerWon = false;
	}

	public function aiRemoved(\model\StickSelection $sticks) {
		$this->numberOfSticksAIDrewLastTime = $sticks->getAmount();
	}

	public function __construct(\model\LastStickGame $game) {
		$this->game = $game;
	}

	public function show($message) : String {
		if ($this->game->isGameOver()) {

			return 	$message .
					$this->showSticks() . 
					$this->showWinner() . 
					$this->startOver();
		} else {
			return 	$message .
					$this->showSticks() . 
					$this->showSelection();
		}
	}

	public function playerSelectSticks() : bool {
		return isset($_GET[self::$draw]);
	}

	public function playerStartsOver() : bool {
		return isset($_GET[self::$startOver]);
	}

	public function getNumberOfSticks() : \model\StickSelection {
		$numberOfSticks = $_GET[self::$draw];
		
		return new \model\StickSelection($numberOfSticks);
	}

	private function showSticks() : String {
		$numSticks = $this->game->getNumberOfSticks();
		$aiDrew = $this->numberOfSticksAIDrewLastTime;

		$opponentsMove = "";
		if ($aiDrew > 0) {
			$opponentsMove = "Your opponent drew $aiDrew stick". ($aiDrew > 1 ? "s" : "");
		}
		//Make a visualisation of the sticks 
		$sticks = "";
		for ($i = 0; $i < $numSticks; $i++) {
			$sticks .= "I"; //Sticks remaining
		}
		for (; $i < $aiDrew + $numSticks; $i++) {
			$sticks .= "."; //Sticks taken by opponent
		}
		for (; $i < $this->game->getStartingNumberOfSticks(); $i++) {
			$sticks .= "_"; //old sticks
		}
		return "<p>There is $numSticks stick" . ($numSticks > 1 ? "s" : "") ." left</p>
				<p style='font-family: \"Courier New\", Courier, monospace'>$sticks</p>
				<p>$opponentsMove</p>";
	}

	private function showSelection() : String {
		
		$numSticks = $this->game->getNumberOfSticks();

		$ret = "<h2>Select number of sticks</h2>
				<p>The player who draws the last stick looses</p>";
		$ret .= "<ol>";
		for ($i = 1; $i <= 3 && $i < $numSticks; $i++ ) {

			$ret .= "<li><a href='?draw=$i'>Draw $i stick". ($i > 1 ? "s" : ""). "</a></li>";
		}
		$ret .= "<ol>";

		return $ret;
	}

	private function showWinner() : String {
		if ($this->playerWon) {
			return "<h2>Congratulations</h2>
					<p>You force the opponent to draw the last stick!</p>";
		} else {
			return "<h2>Epic FAIL!</h2>
					<p>You have to draw the last stick</p>";
		}
	}

	private function startOver() : String {

		return "<a href='?startOver'>Start new game</a>";
		
	}
}