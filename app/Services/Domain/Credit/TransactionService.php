<?php

namespace Tokenly\Wp\Services\Domain\Credit;

use Tokenly\Wp\Services\Domain\DomainService;
use Tokenly\Wp\Interfaces\Services\Domain\Credit\TransactionServiceInterface;

use Tokenly\Wp\Interfaces\Repositories\Credit\TransactionRepositoryInterface;
use Tokenly\Wp\Interfaces\Collections\Credit\TransactionCollectionInterface;

/**
 * Manages transactions
 */
class TransactionService extends DomainService implements TransactionServiceInterface {
	protected $transaction_repository;

	public function __construct(
		TransactionRepositoryInterface $transaction_repository
	) {
		$this->transaction_repository = $transaction_repository;
	}

	/**
	 * Gets a collection of transactions
	 * @param array $params Search parameters
	 * @return TransactionCollectionInterface Transactions found
	 */
	public function index( array $params = array() ) {
		return $this->handle_method( __FUNCTION__, func_get_args() );
	}

	/**
	 * Implementation of the "index" method. Will only
	 * run if no cached instance was found.
	 * @param array $params Search parameters
	 * @return TransactionCollectionInterfaceTransactions Transactions found
	 */
	protected function index_cacheable( array $params = array() ) {
		$credit_transactions = $this->transaction_repository->index( $params );
		return $credit_transactions;
	}
}
