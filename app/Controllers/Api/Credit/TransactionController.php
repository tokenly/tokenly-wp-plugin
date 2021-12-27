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
	public function index( \WP_REST_Request $request ) {
		$params = array();
		if ( isset( $_GET['group'] ) ) {
			$params['group_uuid'] = $_GET['group'];
		} else {
			return false;
		}
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
}
