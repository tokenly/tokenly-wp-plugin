<?php

namespace Tokenly\Wp\Controllers\Api\User\Credit;

use Tokenly\Wp\Controllers\Controller;
use Tokenly\Wp\Interfaces\Controllers\Api\User\Credit\BalanceControllerInterface;

use Tokenly\Wp\Interfaces\Services\Domain\UserServiceInterface;
use Tokenly\Wp\Interfaces\Models\UserInterface;

/**
 * Defines promise-related endpoints
 */
class BalanceController extends Controller implements BalanceControllerInterface {
	protected $user_service;

	public function __construct(
		UserServiceInterface $user_service
	) {
		$this->user_service = $user_service;
	}
	
	/**
	 * Gets a collection of balance
	 * @param UserInterface $user Bound user
	 * @param \WP_REST_Request $request Request data
	 * @return array
	 */
	public function index( UserInterace $user, \WP_REST_Request $request ) {
		//
	}

	/**
	 * Gets model binding parameters
	 * @return array
	 */
	protected function get_bind_params() {
		return array(
			'service'                   => $this->user_service,
			'single_methods'            => array( 'show' ),
			'single_service_method'     => 'show',
			'collection_methods'        => array( 'index' ),
			'collection_service_method' => 'index',
		);
	}
}
