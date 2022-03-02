<?php

namespace Tokenly\Wp\Policies;

use Tokenly\Wp\Interfaces\Policies\PolicyInterface;

class Policy implements PolicyInterface {
	public function before() {
		return false;
	}
}
