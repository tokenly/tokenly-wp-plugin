<?php

namespace Tokenly\Wp\Controllers\Api;

use Tokenly\Wp\Interfaces\Controllers\Api\AuthControllerInterface;
use Tokenly\Wp\Interfaces\Models\CurrentUserInterface;

/**
 * Defines OAuth-related endpoints
 */
class AuthController implements AuthControllerInterface {
	protected $current_user;

	public function __construct(
		CurrentUserInterface $current_user
	) {
		$this->current_user = $current_user;
	}

	/**
	 * Responds the Tokenpass connection status
	 * @return void
	*/
	public function show( \WP_REST_Request $request ) {
		if ( $this->current_user->is_guest() === true ) {
			return;
		}
		$status = $this->current_user->can_connect();
		return array(
			'status' => $connected,
		);
	}
}
