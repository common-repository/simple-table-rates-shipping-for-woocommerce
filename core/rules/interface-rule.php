<?php

namespace WPRuby_Str\Core\Rules;

interface Interface_Rule {

	public function match(array $package): bool;
}
