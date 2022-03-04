<?php

namespace Tokenly\Wp\Interfaces\Controllers\Api\Credit;

use Tokenly\Wp\Interfaces\Controllers\ControllerInterface;

interface VendorControllerInterface extends ControllerInterface {
	public function debit( \WP_REST_Request $request ): \WP_REST_Response;
	public function credit( \WP_REST_Request $request ): \WP_REST_Response;
}
