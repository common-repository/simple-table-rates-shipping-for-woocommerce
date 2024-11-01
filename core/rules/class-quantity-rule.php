<?php

namespace WPRuby_Str\Core\Rules;

class Quantity_Rule extends Abstract_Rule {

	public $quantity_from = 0;
	public $quantity_to = 0;

	public function match(array $package ): bool
	{
		return $this->between($this->get_total_quantity($package), $this->quantity_from, $this->quantity_to);
	}

	private function get_total_quantity(array $package): int
	{
		return array_reduce($package['contents'], function ($carry, $line) {
			return $carry + $line['quantity'];
		}, 0);
	}
}
