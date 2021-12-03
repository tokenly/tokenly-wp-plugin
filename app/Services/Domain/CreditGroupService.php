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
	public function index( array $params = array() ) {
		$credit_groups = $this->credit_group_repository->index();
		$credit_groups = $this->index_after( $credit_groups, $params );
		return $credit_groups;
	}

	/**
	 * Retrieves a single credit group
	 * @param string $uuid Credit group uuid
	 * @return CreditGroupInterface Credit group found
	 */
	public function show( string $uuid ) {
		$credit_group = $this->credit_group_repository->show( $uuid );
		$credit_group = $this->show_after( $credit_group );
		if ( !$credit_group ) {
			return false;
		}
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
