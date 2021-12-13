<?php

namespace Tokenly\Wp\Services\Domain;

use Tokenly\Wp\Services\Domain\DomainService;
use Tokenly\Wp\Interfaces\Services\Domain\CreditAccountServiceInterface;
use Tokenly\Wp\Interfaces\Repositories\CreditAccountRepositoryInterface;

/**
 * Manages credit accounts
 */
class CreditAccountService extends DomainService implements CreditAccountServiceInterface {
	protected $credit_account_repository;

	public function __construct(
		CreditAccountRepositoryInterface $credit_account_repository
	) {
		$this->credit_account_repository = $credit_account_repository;
	}

	/**
	 * Retrieves a collection of credit groups
	 * @param array $params Search parameters
	 * @return CreditAccountCollectionInterface Credit groups found
	 */
	protected function _index( array $params = array() ) {
		$credit_accounts = $this->credit_account_repository->index();
		return $credit_accounts;
	}

	/**
	 * Retrieves a single credit group
	 * @param array $params Search parameters
	 * @return CreditAccountInterface Credit group found
	 */
	protected function _show( array $params = array() ) {
		$credit_account = $this->credit_account_repository->show( $params );
		return $credit_account;
	}

	/**
	 * Creates a new credit account for the specified user
	 * @param array $params New account data
	 * @return CreditAccountInterface New credit account
	 */
	public function store( array $params = array() ) {
		$credit_account = $this->credit_account_repository->store( $params );
		return $credit_account;
	}
}
