<?php

namespace Tokenly\Wp\Controllers\Api\Credit;

use Tokenly\Wp\Controllers\Controller;
use Tokenly\Wp\Interfaces\Controllers\Api\Credit\TransactionControllerInterface;

use Tokenly\Wp\Interfaces\Collections\Credit\TransactionCollectionInterface;
use Tokenly\Wp\Interfaces\Repositories\Credit\TransactionRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\UserRepositoryInterface;

/**
 * Defines transaction endpoints
 */
class TransactionController extends Controller implements TransactionControllerInterface {
	protected TransactionRepositoryInterface $transaction_repository;
	protected UserRepositoryInterface $user_repository;

	public function __construct(
		TransactionRepositoryInterface $transaction_repository,
		UserRepositoryInterface $user_repository
	) {
		$this->transaction_repository = $transaction_repository;
		$this->user_repository = $user_repository;
	}
	
	/**
	 * Gets a collection of transactions
	 * @param \WP_REST_Request $request Request data
	 * @param TransactionCollectionInterface $transactions Bound transactions
	 * @return array
	 */
	public function index( \WP_REST_Request $request, TransactionCollectionInterface $transactions ): array {
		$users = clone $transactions;
		$users->extract( 'account_uuid' );
		$users = $this->user_repository->index( array(
			'uuids' => $users,
		) );
		$users = clone $users;
		$users->key_by_field('uuid');
		$users = $users->to_array();
		$transactions = $transactions->to_array();
		foreach ( $transactions as &$transaction ) {
			$uuid = $transaction['account'];
			$user = $users[ $uuid ] ?? null;
			$transaction['user'] = $user;
		}
		return $transactions;
	}

	/**
	 * Makes a new transaction
	 * @param \WP_REST_Request $request Request data
	 * @return array|null
	 */
	public function store( \WP_REST_Request $request ): ?array {
		$params = $request->get_params();
		$this->transaction_repository->store( $params );
	}

	protected function remap_parameters( array $params = array() ): array {
		if ( isset( $params['group'] ) ) {
			$params['group_uuid'] = $params['group'];
			unset( $params['group'] );
		}
		return $params;
	}

	/**
	 * Gets model binding parameters
	 * @return array
	 */
	protected function get_bind_params(): array {
		return array(
			'service'                   => $this->transaction_repository,
			'collection_methods'        => array( 'index' ),
			'collection_service_method' => 'index',
		);
	}
}
