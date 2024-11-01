<?php

namespace WPRuby_Str\Core\Rules;

class Volume_Rule extends Abstract_Rule {

	public $volume_from = 0;
	public $volume_to = 0;

	public function match(array $package ): bool
	{
		return $this->between($this->get_volume($package), $this->volume_from, $this->volume_to);
	}

	private function get_volume(array $package): float
	{
		$volume = 0;

		foreach ($package['contents'] as $item) {
			/** @var WC_Product $product */
			$product = $item['data'];
			if (!$product->has_dimensions()) continue;
			$dimensions = $product->get_dimensions(false);
			$product_volume = $dimensions['width'] * $dimensions['height'] * $dimensions['length'];
			$volume += round($product_volume * $item['quantity'], 2);
		}

		return $volume;

	}
}
