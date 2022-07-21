<?php

namespace Tokenly\Wp\Repositories\Credit;

use Tokenly\Wp\Repositories\Repository;
use Tokenly\Wp\Interfaces\Repositories\Credit\TransactionRepositoryInterface;

use Tokenly\Wp\Collections\Credit\TransactionCollection;
use Tokenly\Wp\Models\Credit\Transaction;
use Tokenly\Wp\Interfaces\Models\Credit\TransactionInterface;
use Tokenly\Wp\Interfaces\Collections\Credit\TransactionCollectionInterface;
use Tokenly\TokenpassClient\TokenpassAPIInterface;

class TransactionRepository extends Repository
	implements TransactionRepositoryInterface
{
	protected TokenpassAPIInterface $client;
	
	public function __construct(
		TokenpassAPIInterface $client
	) {
		$this->client = $client;
	}

	/**
	 * Gets a collection of transactions
	 * @param array $params Search parameters
	 * @return TransactionCollectionInterface Transactions found
	 */
	public function index(
		array $params = array()
	): TransactionCollectionInterface {
		return $this->handle_method( __FUNCTION__, func_get_args() );
	}

	/**
	 * Implementation of the "index" method. Will only
	 * run if no cached instance was found.
	 * @param array $params Search parameters
	 * @return TransactionCollectionInterface Transactions found
	 */
	protected function index_cacheable(
		array $params = array()
	): TransactionCollectionInterface {
		$transactions = array();
		if ( isset( $params['group_uuid'] ) ) {
			$group_uuid = $params['group_uuid'];
			$history = $this->client->getAppCreditGroupHistory( $group_uuid );
			if ( $history && isset( $history['transactions'] ) ) {
				foreach ( $history['transactions'] as &$transaction ) {
					$transaction = $this->remap_fields( $transaction );
				}
				$transactions = $history['transactions'];
			}
		}
		$transactions =
			( new TransactionCollection() )->from_array( $transactions );
		return $transactions;
	}

	protected function remap_fields( array $transaction ): array {
		if ( isset( $transaction['tokenpass_user'] ) ) {
			$transaction['oauth_user_id'] = $transaction['tokenpass_user'];
			unset( $transaction['tokenpass_user'] );
		}
		return $transaction;
	}
}
