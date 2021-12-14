<?php

namespace Tokenly\Wp\Interfaces\Models;

use Tokenly\Wp\Interfaces\Models\ModelInterface;

interface QuantityInterface extends ModelInterface {
	public function get_value();
	public function get_value_sat();
}
