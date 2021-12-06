<?php

namespace Tokenly\Wp\Interfaces\Controllers\Api;

interface SettingsControllerInterface {
	public function show( \WP_REST_Request $request );
	public function update( \WP_REST_Request $request );
}
