<?php

namespace WPRuby_Str\Core\Rules;

use WPRuby_Str\Core\Rules\Cart_Total_Rule;

class Rules_Factory {

	public static function make( array $rule ): Abstract_Rule
	{
		$rules = [
			'weight'           => Weight_Rule::class,
			'product'          => Product_Rule::class,
			'quantity'         => Quantity_Rule::class,
			'volume'           => Volume_Rule::class,
			'cart_total' => Cart_Total_Rule::class,
		];

		return new $rules[$rule['type']];
	}

}
