<?php

namespace Tokenly\Wp\Controllers\Api;

use Tokenly\Wp\Interfaces\Controllers\Api\CreditTransactionControllerInterface;
use Tokenly\Wp\Interfaces\Services\Domain\CreditTransactionServiceInterface;
use Tokenly\Wp\Interfaces\Models\CreditTransactionInterface;
use Tokenly\Wp\Interfaces\Services\Domain\UserServiceInterface;

/**
 * Defines promise-related endpoints
 */
class CreditTransactionController implements CreditTransactionControllerInterface {
	protected $credit_transaction_service;
	protected $user_service;

	public function __construct(
		CreditTransactionServiceInterface $credit_transaction_service,
		UserServiceInterface $user_service
	) {
		$this->credit_transaction_service = $credit_transaction_service;
		$this->user_service = $user_service;
	}
	
	/**
	 * Retrieves a collection of credit groups
	 * @param \WP_REST_Request $request Request data
	 * @return CreditTransactionCollectionInterface
	 */
	public function index( \WP_REST_Request $request ) {
		$credit_transactions = $this->credit_transaction_service->index();
		$credit_transactions = $credit_transactions->to_array();
		return $credit_transactions;
	}

	/**
	 * Creates a new credit group
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
}
