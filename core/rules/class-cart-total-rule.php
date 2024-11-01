<?php

namespace WPRuby_Str\Core\Rules;

class Cart_Total_Rule extends Abstract_Rule {

	public $price_from = 0.0;
	public $price_to = 0.0;

	public function match( array $package ): bool {
		$cart_total = $this->get_cart_total($package);

		return $this->between($cart_total, $this->price_from, $this->price_to);
	}

	private function get_cart_total(array $package): float
	{
		if (isset($package['cart_subtotal'])) {
			return $package['cart_subtotal'];
		}

		return 0;
	}


}
