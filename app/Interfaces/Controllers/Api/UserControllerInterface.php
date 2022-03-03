<?php

namespace Tokenly\Wp\Interfaces\Controllers\Api;

use Tokenly\Wp\Interfaces\Controllers\ControllerInterface;

use Tokenly\Wp\Interfaces\Collections\UserCollectionInterface;
use Tokenly\Wp\Interfaces\Models\UserInterface;

interface UserControllerInterface extends ControllerInterface {
	public function index( \WP_REST_Request $request, UserCollectionInterface $users ): \WP_REST_Response;
	public function show( \WP_REST_Request $request, ?UserInterface $user = null ): \WP_REST_Response;
	public function credit_balance_index( \WP_REST_Request $request, ?UserInterface $user = null ): \WP_REST_Response;
	public function credit_balance_show( \WP_REST_Request $request, ?UserInterface $user = null ): \WP_REST_Response;
	public function token_balance_index( \WP_REST_Request $request, ?UserInterface $user = null ): \WP_REST_Response;
	public function token_balance_show( \WP_REST_Request $request, ?UserInterface $user = null ): \WP_REST_Response;
	public function token_address_index( \WP_REST_Request $request, ?UserInterface $user = null ): \WP_REST_Response;
}
