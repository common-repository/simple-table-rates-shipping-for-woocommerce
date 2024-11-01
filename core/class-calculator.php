<?php

namespace WPRuby_Str\Core;

use WPRuby_Str\Core\Rules\Abstract_Rule;

class Calculator {

	/** @var Settings */
	private $settings;

	public function __construct( Settings $settings ) {
		$this->settings = $settings;
	}


	/**
	 * @param array $package
	 *
	 * @return Rate $package
	 */
	public function calculate( array $package ): Rate {
		$rate = new Rate();
		$rate->setId( $this->settings->getInstanceId() )->setLabel( $this->settings->getTitle() );

		$matchedRules = [];

		foreach ( $this->settings->getRules() as $rule ) {
			if ( ! $rule->match( $package ) ) {
				continue;
			}

			$matchedRules[] = $rule;
		}

		if ( count( $matchedRules ) > 0 ) {
			$costs = array_reduce( $matchedRules, function ( $carry, Abstract_Rule $matchedRule ) {
				return $carry + $matchedRule->getPrice();
			}, 0 );
			$rate->setMatchedRules($matchedRules);
			$rate->setCost( $costs + $this->get_handling_fees($costs) );
		}


		return $rate;

	}


	private function get_handling_fees(float $cost): float
	{
		if ($this->settings->getHandlingFees() === 0) {
			return 0;
		}

		if ($this->settings->getHandlingFeesType() === 'amount') {
			return round(floatval($this->settings->getHandlingFees()), 2);
		}

		return round($cost * ($this->settings->getHandlingFees() / 100), 2);
	}

}
