<?php

namespace Tokenly\Wp\Interfaces\Controllers\Api;

interface AuthControllerInterface {
	public function show( \WP_REST_Request $request ): \WP_REST_Response;
}
