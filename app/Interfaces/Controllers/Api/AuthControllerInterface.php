<?php

namespace Tokenly\Wp\Interfaces\Controllers\Api;

interface AuthControllerInterface {
	public function show( \WP_REST_Request $request );
	public function store( \WP_REST_Request $request );
	public function destroy( \WP_REST_Request $request );
	public function callback();
}
