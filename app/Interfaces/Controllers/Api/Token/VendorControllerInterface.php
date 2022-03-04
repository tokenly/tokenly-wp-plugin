<?php

namespace Tokenly\Wp\Interfaces\Controllers\Api\Token;

use Tokenly\Wp\Interfaces\Controllers\ControllerInterface;

interface VendorControllerInterface extends ControllerInterface {
	public function promise( \WP_REST_Request $request ): \WP_REST_Response;
}
