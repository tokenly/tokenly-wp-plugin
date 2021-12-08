<?php

namespace Tokenly\Wp\Services\Domain;

use Tokenly\Wp\Services\Domain\DomainService;
use Tokenly\Wp\Interfaces\Services\Domain\BalanceServiceInterface;
use Tokenly\Wp\Interfaces\Repositories\BalanceRepositoryInterface;
use Tokenly\Wp\Interfaces\Collections\BalanceCollectionInterface;

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
	 * Retrieves balances associated with the specified oauth token
	 * @param array $params Search parameters
	 * @return BalanceCollectionInterface
	 */
	protected function _index( array $params = array() ) {
		if ( !isset( $params['oauth_token'] ) ) {
			return false;
		}
		$balance = $this->balance_repository->index( $params );
		return $balance;
	}
}
