<?php

namespace Tokenly\Wp\Services\Domain;

use Tokenly\Wp\Services\Domain\DomainService;
use Tokenly\Wp\Interfaces\Services\Domain\CreditTransactionServiceInterface;
use Tokenly\Wp\Interfaces\Repositories\CreditTransactionRepositoryInterface;

/**
 * Manages credit transactions
 */
class CreditTransactionService extends DomainService implements CreditTransactionServiceInterface {
	protected $credit_transaction_repository;

	public function __construct(
		CreditTransactionRepositoryInterface $credit_transaction_repository
	) {
		$this->credit_transaction_repository = $credit_transaction_repository;
	}

	/**
	 * Retrieves a collection of credit transactions
	 * @param array $params Search parameters
	 * @return CreditTransactionCollectionInterface Credit transactions found
	 */
	protected function _index( array $params = array() ) {
		$credit_transactions = $this->credit_transaction_repository->index( $params );
		return $credit_transactions;
	}
}
