<?php

namespace Tokenly\Wp\Controllers\Api\Token;

use Tokenly\Wp\Controllers\Controller;
use Tokenly\Wp\Interfaces\Controllers\Api\Token\BalanceControllerInterface;

use Tokenly\Wp\Interfaces\Services\Domain\Token\BalanceServiceInterface;
use Tokenly\Wp\Interfaces\Models\Token\BalanceInterface;
use Tokenly\Wp\Interfaces\Collections\Token\BalanceCollectionInterface;

/**
 * Defines promise-related endpoints
 */
class BalanceController extends Controller implements BalanceControllerInterface {
	protected $balance_service;

	public function __construct(
		BalanceServiceInterface $balance_service
	) {
		$this->balance_service = $balance_service;
	}
	
	/**
	 * Gets a collection of balance
	 * @param BalanceCollectionInterface $balance Bound balance
	 * @param \WP_REST_Request $request Request data
	 * @return array
	 */
	public function index( BalanceCollectionInterface $balance, \WP_REST_Request $request ) {
		$balance = $balance->to_array();
		return $balance;
	}

	/**
	 * Gets model binding parameters
	 * @return array
	 */
	protected function get_bind_params() {
		return array(
			'service'                   => $this->balance_service,
			'collection_methods'        => array( 'index' ),
			'collection_service_method' => 'index',
		);
	}
}
