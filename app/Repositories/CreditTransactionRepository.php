<?php

namespace Tokenly\Wp\Repositories;

use Tokenly\TokenpassClient\TokenpassAPIInterface;
use Tokenly\Wp\Interfaces\Repositories\CreditTransactionRepositoryInterface;
use Tokenly\Wp\Interfaces\Models\CreditTransactionInterface;
use Tokenly\Wp\Interfaces\Collections\CreditTransactionCollectionInterface;
use Tokenly\Wp\Interfaces\Factories\Models\CreditTransactionFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Collections\CreditTransactionCollectionFactoryInterface;


class CreditTransactionRepository implements CreditTransactionRepositoryInterface {
	protected $client;
	protected $credit_transaction_factory;
	protected $credit_transaction_collection_factory;
	
	public function __construct(
		TokenpassAPIInterface $client,
		CreditTransactionFactoryInterface $credit_transaction_factory,
		CreditTransactionCollectionFactoryInterface $credit_transaction_collection_factory
	) {
		$this->client = $client;
		$this->credit_transaction_factory = $credit_transaction_factory;
		$this->credit_transaction_collection_factory = $credit_transaction_collection_factory;
	}

	/**
	 * Retrieves a collection of credit transactions
	 * @return array
	 */
	public function index( array $params = array() ) {
		$history = null;
		if ( isset( $params['group_uuid'] ) ) {
			$group_uuid = $params['group_uuid'];
			$history = $this->client->getAppCreditGroupHistory( $group_uuid );
			foreach ( $history['transactions'] as &$transaction ) {
				$transaction = $this->remap_fields( $transaction );
			}
		}
		if ( !$history ) {
			return false;
		}
		$transactions = $history['transactions'];
		$transactions = $this->credit_transaction_collection_factory->create( $transactions );
		return $transactions;
	}

	/**
	 * Creates a new app credits transaction
	 * @param array $params Transaction data
	 * @return array
	 */
	public function store( array $params = array() ) {
		if (
			!isset( $params['type'] ) ||
			!isset( $params['group_uuid'] ) ||
			!isset( $params['account'] )
		) {
			return;
		}
		$group_uuid = $params['group_uuid'];
		$account_user = $params['account'];
		$amount = intval( $params['amount'] );
		$account = array(
			'account' => $account_user->username,
			'amount'  => $amount,
			'ref'     => $params['ref'] ?? '',
		);
		$type = $params['type'];
		$source = null;
		if ( isset( $params['source'] ) ) {
			$source = $params['source']->id;
		}
		$accounts = array( $account );
		$transactions = null;
		switch( $type ) {
			case 'debit':
				$transactions = $this->client->takeAppCredit( $group_uuid, $account_user->id, $amount, null, $source );
				break;
			case 'credit':
				$transactions = $this->client->giveAppCredit( $group_uuid, $account_user->id, $amount, null, $source );
				break;
		}
		if ( !$transactions ) {
			return;
		}
		if ( isset( $transactions['debit'] ) ) {
			$transactions_debit = $transactions['debit'];
			$transactions['debit'] = $this->credit_transaction_collection_factory->create( $transactions_debit );
		}
		if ( isset( $transactions['credit'] ) ) {
			$transactions_credit = $transactions['credit'];
			$transactions['credit'] = $this->credit_transaction_collection_factory->create( $transactions_credit );
		}
		return $transactions;
	}

	protected function remap_fields( array $transaction ) {
		if ( isset( $transaction['tokenpass_user'] ) ) {
			$transaction['oauth_user_id'] = $transaction['tokenpass_user'];
			unset( $transaction['tokenpass_user'] );
		}
		return $transaction;
	}
}
