<?php

namespace model;

class StickSelection {
	private $amount;

	public function getAmount() {
		return $this->amount;
	}

	/**
	 * Private constructor makes sure we cannot create outside of 1,2,3
	 * @param [type] $amount [description]
	 */
	public function __construct($amount) {
		if ($amount <= 3 && $amount >= 1)
		{
			$this->amount = $amount;
		}
		else
		{
			throw new \Exception($amount);
		}
	}



}