<?php

namespace Tokenly\Wp\Controllers\Api\Token;

use Tokenly\Wp\Controllers\Controller;
use Tokenly\Wp\Interfaces\Controllers\Api\Token\BalanceControllerInterface;

use Tokenly\Wp\Interfaces\Repositories\Token\BalanceRepositoryInterface;
use Tokenly\Wp\Interfaces\Models\Token\BalanceInterface;
use Tokenly\Wp\Interfaces\Collections\Token\BalanceCollectionInterface;

/**
 * Defines balance endpoints
 */
class BalanceController extends Controller
	implements BalanceControllerInterface
{
	protected BalanceRepositoryInterface $balance_repository;

	public function __construct(
		BalanceRepositoryInterface $balance_repository
	) {
		$this->balance_repository = $balance_repository;
	}
	
	/**
	 * Gets a collection of balance
	 * @param \WP_REST_Request $request Request data
	 * @param BalanceCollectionInterface $balance Bound balance
	 * @return \WP_REST_Response
	 */
	public function index(
		\WP_REST_Request $request, BalanceCollectionInterface $balance
	): \WP_REST_Response {
		$balance = $balance->to_array();
		return new \WP_REST_Response( $balance );
	}

	/**
	 * Gets model binding parameters
	 * @return array
	 */
	protected function get_bind_params(): array {
		return array(
			'service'                   => $this->balance_repository,
			'collection_methods'        => array( 'index' ),
			'collection_service_method' => 'index',
		);
	}
}
