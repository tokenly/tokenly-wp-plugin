<?php

namespace Tokenly\Wp\Controllers\Api\Credit;

use Tokenly\Wp\Interfaces\Controllers\Api\Credit\TransactionControllerInterface;

use Tokenly\Wp\Interfaces\Collections\Credit\TransactionCollectionInterface;
use Tokenly\Wp\Interfaces\Services\Domain\Credit\TransactionServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\UserServiceInterface;

/**
 * Defines transaction endpoints
 */
class TransactionController implements TransactionControllerInterface {
	protected $transaction_service;
	protected $user_service;

	public function __construct(
		TransactionServiceInterface $transaction_service,
		UserServiceInterface $user_service
	) {
		$this->transaction_service = $transaction_service;
		$this->user_service = $user_service;
	}
	
	/**
	 * Gets a collection of transactions
	 * @param \WP_REST_Request $request Request data
	 * @return TransactionCollectionInterface
	 */
	public function index( TransactionCollectionInterface $transactions, \WP_REST_Request $request ) {
		$transactions = $this->transaction_service->index( $params );
		$transactions = $transactions->to_array();
		return $transactions;
	}

	/**
	 * Makes a new transaction
	 * @param \WP_REST_Request $request Request data
	 * @return array
	 */
	public function store( \WP_REST_Request $request ) {
		$params = $request->get_params();
		if (
			!isset( $params['type'] ) ||
			!isset( $params['account'] ) ||
			!isset( $params['group_uuid'] )
		)
		$user = null;
		$user = $this->user_service->show( array(
			'id'   => $params['account'],
			'with' => array( 'oauth_user' ),
		) );
		if ( !$user ) {
			return false;
		}
		if ( !$user->oauth_user ) {
			return false;
		}
		$type = $params['type'];
		switch ( $type ) {
			case 'debit':
				$transactions = $user->oauth_user->debit_app_credits( $params );
				break;
			case 'credit':
				$transactions = $user->oauth_user->credit_app_credits( $params );
				break;
		}
		return array(
			'transactions' => $transactions,
		);
	}

	protected function remap_parameters( array $params = array() ) {
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
	protected function get_bind_params() {
		return array(
			'service'                   => $this->transaction_service,
			'collection_methods'        => array( 'index' ),
			'collection_service_method' => 'index',
		);
	}
}
