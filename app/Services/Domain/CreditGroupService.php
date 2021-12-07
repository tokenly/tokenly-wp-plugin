<?php

namespace Tokenly\Wp\Services\Domain;

use Tokenly\Wp\Services\Domain\DomainService;
use Tokenly\Wp\Interfaces\Services\Domain\CreditGroupServiceInterface;
use Tokenly\Wp\Interfaces\Repositories\CreditGroupRepositoryInterface;

/**
 * Manages the promises
 */
class CreditGroupService extends DomainService implements CreditGroupServiceInterface {

	public function __construct(
		CreditGroupRepositoryInterface $credit_group_repository
	) {
		$this->credit_group_repository = $credit_group_repository;
	}

	/**
	 * Retrieves a collection of credit groups
	 * @param array $params Search parameters
	 * @return CreditGroupCollectionInterface Credit groups found
	 */
	protected function _index( array $params = array() ) {
		$credit_groups = $this->credit_group_repository->index();
		return $credit_groups;
	}

	/**
	 * Retrieves a single credit group
	 * @param array $params Search parameters
	 * @return CreditGroupInterface Credit group found
	 */
	protected function _show( array $params = array() ) {
		if ( !isset( $params['uuid'] ) ) {
			return false;
		}
		$uuid = $params['uuid'];
		$credit_group = $this->credit_group_repository->show( $uuid );
		return $credit_group;
	}
	
	/**
	 * Stores a new credit group
	 * @param array $params New credit group parameters
	 * @return CreditGroupInterface
	 */
	public function store( array $params = array() ) {
		$credit_group = $this->credit_group_repository->store( $params );
		return $credit_group;
	}
}
