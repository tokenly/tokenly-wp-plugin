<?php

namespace Tokenly\Wp\Interfaces\Models;

use Tokenly\Wp\Interfaces\Models\ModelInterface;

interface IntegrationInterface extends ModelInterface {
	public function can_connect();
}
