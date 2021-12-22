<?php

namespace Tokenly\Wp\Services\Domain\Token;

use Tokenly\Wp\Services\Domain\DomainService;
use Tokenly\Wp\Interfaces\Services\Domain\Token\BalanceServiceInterface;

use Tokenly\Wp\Interfaces\Repositories\Token\BalanceRepositoryInterface;
use Tokenly\Wp\Interfaces\Collections\Token\BalanceCollectionInterface;

/**
 * Manages the balances
 */
class BalanceService extends DomainService implements BalanceServiceInterface {
	protected $balance_repository;

	public function __construct(
		BalanceRepositoryInterface $balance_repository
	) {
		$this->balance_repository = $balance_repository;
	}

	/**
	 * Gets a collection of balances
	 * @param array $params Search parameters
	 * @return BalanceCollectionInterface Balances found
	 */
	public function index( array $params = array() ) {
		return $this->handle_method( __FUNCTION__, func_get_args() );
	}

	/**
	 * Implementation of the "index" method. Will only
	 * run if no cached instance was found.
	 * @param array $params Search parameters
	 * @return BalanceCollectionInterface Balances found
	 */
	protected function index_cacheable( array $params = array() ) {
		if ( !isset( $params['oauth_token'] ) ) {
			return false;
		}
		$balance = $this->balance_repository->index( $params );
		return $balance;
	}
}
