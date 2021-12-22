<?php

namespace Tokenly\Wp\Services\Domain\Credit;

use Tokenly\Wp\Services\Domain\DomainService;
use Tokenly\Wp\Interfaces\Services\Domain\Credit\AccountServiceInterface;

use Tokenly\Wp\Interfaces\Repositories\Credit\AccountRepositoryInterface;
use Tokenly\Wp\Interfaces\Models\Credit\AccountInterface;
use Tokenly\Wp\Interfaces\Collections\Credit\AccountCollectionInterface;

/**
 * Manages credit accounts
 */
class AccountService extends DomainService implements AccountServiceInterface {
	protected $account_repository;

	public function __construct(
		AccountRepositoryInterface $account_repository
	) {
		$this->account_repository = $account_repository;
	}

	/**
	 * Gets a collection of accounts
	 * @param array $params Search parameters
	 * @return AccountCollectionInterface Accounts found
	 */
	public function index( array $params = array() ) {
		return $this->handle_method( __FUNCTION__, func_get_args() );
	}

	/**
	 * Gets a single account
	 * @param array $params Search parameters
	 * @return AccountInterface Account found
	 */
	public function show( array $params = array() ) {
		return $this->handle_method( __FUNCTION__, func_get_args() );
	}

	/**
	 * Creates a new account for the specified user
	 * @param array $params New account data
	 * @return AccountInterface New account
	 */
	public function store( array $params = array() ) {
		$credit_account = $this->account_repository->store( $params );
		return $credit_account;
	}

	/**
	 * Implementation of the "index" method. Will only
	 * run if no cached instance was found.
	 * @param array $params Search parameters
	 * @return AccountCollectionInterface Accounts found
	 */
	protected function index_cacheable( array $params = array() ) {
		$credit_accounts = $this->account_repository->index();
		return $credit_accounts;
	}

	/**
	 * Implementation of the "show" method. Will only
	 * run if no cached instance was found.
	 * @param array $params Search parameters
	 * @return AccountInterface Account found
	 */
	protected function show_cacheable( array $params = array() ) {
		$credit_account = $this->account_repository->show( $params );
		return $credit_account;
	}
}
