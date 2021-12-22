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
	 * Gets a collection of credit groups
	 * @param array $params Search parameters
	 * @return CreditAccountCollectionInterface Credit groups found
	 */
	public function index( array $params = array() ) {
		return $this->handle_method( __FUNCTION__, func_get_args() );
	}

	/**
	 * Gets a single credit account
	 * @param array $params Search parameters
	 * @return CreditAccountInterface Credit account found
	 */
	public function show( array $params = array() ) {
		return $this->handle_method( __FUNCTION__, func_get_args() );
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

	/**
	 * Implementation of the "index" method. Will only
	 * run if no cached instance was found.
	 * @param array $params Search parameters
	 * @return CreditAccountCollectionInterface Credit groups found
	 */
	protected function index_cacheable( array $params = array() ) {
		$credit_accounts = $this->credit_account_repository->index();
		return $credit_accounts;
	}

	/**
	 * Implementation of the "show" method. Will only
	 * run if no cached instance was found.
	 * @param array $params Search parameters
	 * @return CreditAccountInterface Credit account found
	 */
	protected function show_cacheable( array $params = array() ) {
		$credit_account = $this->credit_account_repository->show( $params );
		return $credit_account;
	}
}
