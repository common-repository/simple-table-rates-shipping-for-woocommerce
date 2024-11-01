<?php

namespace WPRuby_Str\Core\Rules;


abstract class Abstract_Rule implements Interface_Rule {

	protected $id = -1;

	protected $price = 0.0;

	/**
	 * @return int
	 */
	public function getId(): int {
		return $this->id;
	}

	/**
	 * @param int $id
	 *
	 * @return Abstract_Rule
	 */
	public function setId( int $id ): Abstract_Rule {
		$this->id = $id;

		return $this;
	}

	public function setPrice(float $price): self
	{
		$this->price = $price;
		return $this;
	}

	public function getPrice(): float
	{
		return $this->price;
	}


	public function populate(array $data): self
	{
		foreach ($data as $key => $value) {
			if ($this instanceof Product_Rule) {
				$value  = json_decode(stripslashes($value), true);
				$this->products[] = $value['code'];
			}
			elseif (property_exists($this, $key)) {
				$this->$key = $value;
			}
		}

		return $this;
	}

	protected function between(float $value, float $from, float $to) :bool
	{
		return $value >= $from && $value <= $to;
	}

}
