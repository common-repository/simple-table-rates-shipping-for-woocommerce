<?php

namespace WPRuby_Str\Core\Rules;

class Product_Rule extends Abstract_Rule {

	public $products = [];

	public function match(array $package ): bool {
		$cart_product_ids = $this->get_product_ids($package);
		return !empty(array_intersect($this->products, $cart_product_ids));
	}

	private function get_product_ids(array $package): array
	{
		$product_ids = [];

		foreach ($package['contents'] as $item) {
			/** @var WC_Product $product */
			$product = $item['data'];
			$product_ids[] = $product->get_parent_id() === 0? $product->get_id(): $product->get_parent_id();
		}

		return $product_ids;
	}

}
