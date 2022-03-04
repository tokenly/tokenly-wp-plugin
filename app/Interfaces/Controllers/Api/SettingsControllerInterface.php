<?php

namespace Tokenly\Wp\Interfaces\Controllers\Api;

interface SettingsControllerInterface {
	public function show_integration( \WP_REST_Request $request ): \WP_REST_Response;
	public function show_oauth( \WP_REST_Request $request ): \WP_REST_Response;
	public function show_tca( \WP_REST_Request $request ): \WP_REST_Response;
	public function show_whitelist( \WP_REST_Request $request ): \WP_REST_Response;
	public function update_integration( \WP_REST_Request $request ): \WP_REST_Response;
	public function update_oauth( \WP_REST_Request $request ): \WP_REST_Response;
	public function update_tca( \WP_REST_Request $request ): \WP_REST_Response;
	public function update_token_whitelist( \WP_REST_Request $request ): \WP_REST_Response;
}
