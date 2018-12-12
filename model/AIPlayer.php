<?php

namespace model;

class AIPlayer {
	
	public function getSelection(int $amountOfSticksLeft) : \model\StickSelection {

		$desiredAmountAfterDraw = array(21, 17, 13, 9, 5, 1);

		foreach ($desiredAmountAfterDraw as $desiredSticks) {
			if ($amountOfSticksLeft > $desiredSticks ) {
				$difference = $amountOfSticksLeft - $desiredSticks;

				if ($difference > 3 || $difference < 1) {
					$drawInteger = rand() % 3 + 1; // [1-3]

					echo "<p>AIPlayer - \"Grr...\" </p>";
				} else {
					$drawInteger = $difference;
					echo "<p>AIPlayer - \"Got you, you have already lost!!!\"</p>  ";
				}
				break;
			}
			
		}
	

		//change from integer into valid StickSelection
		return new StickSelection($drawInteger);

		//should never go here
		assert(false); 
	}
}