<?php

namespace Tokenly\Wp\Controllers\Api\User;

use Tokenly\Wp\Controllers\Controller as BaseController;
use Tokenly\Wp\Interfaces\Services\Domain\UserServiceInterface;

/**
 * Defines promise-related endpoints
 */
class Controller extends BaseController {
	protected $user_service;

	public function __construct(
		UserServiceInterface $user_service
	) {
		$this->user_service = $user_service;
	}
	
	protected function get_bind_params() {
		return array(
			'service'                   => $this->user_service,
			'single_service_method'     => 'show',
		);
	}
}
