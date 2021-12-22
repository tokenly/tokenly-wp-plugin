<?php

namespace Tokenly\Wp\Interfaces\Controllers\Api\Credit;

interface GroupControllerInterface {
	public function index( \WP_REST_Request $request );
	public function store( \WP_REST_Request $request );
	public function update( \WP_REST_Request $request );
	public function destroy( \WP_REST_Request $request );
}
