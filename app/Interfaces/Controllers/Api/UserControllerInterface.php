<?php

namespace Tokenly\Wp\Interfaces\Controllers\Api;

interface UserControllerInterface {
	public function index( \WP_REST_Request $request );
	public function show( \WP_REST_Request $request );
}
