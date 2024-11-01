<?php

namespace WPRuby_Str\Core\Rules;

class Weight_Rule extends Abstract_Rule {

	public $weight_from = 0;
	public $weight_to = 0;

	public function match(array $package ): bool {
		return $this->between($this->get_weight($package), $this->weight_from, $this->weight_to);
	}

	private function get_weight(array $package): float
	{
		$weight = 0;

		foreach ($package['contents'] as $item) {
			/** @var WC_Product $product */
			$product = $item['data'];
			if (!$product->has_weight()) continue;
			$product_weight = floatval($product->get_weight());
			$weight += round($product_weight * $item['quantity'], 2);
		}

		return $weight;

	}
}
