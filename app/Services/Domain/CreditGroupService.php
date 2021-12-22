<?php

namespace Tokenly\Wp\Services\Domain;

use Tokenly\Wp\Services\Domain\DomainService;
use Tokenly\Wp\Interfaces\Services\Domain\CreditGroupServiceInterface;
use Tokenly\Wp\Interfaces\Repositories\CreditGroupRepositoryInterface;

/**
 * Manages credit groups
 */
class CreditGroupService extends DomainService implements CreditGroupServiceInterface {
	protected $credit_group_repository;

	public function __construct(
		CreditGroupRepositoryInterface $credit_group_repository
	) {
		$this->credit_group_repository = $credit_group_repository;
	}

	/**
	 * Gets a collection of credit groups
	 * @param array $params Search parameters
	 * @return CreditGroupCollectionInterface Credit groups found
	 */
	public function index( array $params = array() ) {
		return $this->handle_method( __FUNCTION__, func_get_args() );
	}

	/**
	 * Gets a single credit group
	 * @param array $params Search parameters
	 * @return CreditGroupInterface Credit group found
	 */
	public function show( array $params = array() ) {
		return $this->handle_method( __FUNCTION__, func_get_args() );
	}

	/**
	 * Makes a new credit group
	 * @param array $params New credit group parameters
	 * @return CreditGroupInterface
	 */
	public function store( array $params = array() ) {
		$credit_group = $this->credit_group_repository->store( $params );
		return $credit_group;
	}

	/**
	 * Implementation of the "index" method. Will only
	 * run if no cached instance was found.
	 * @param array $params Search parameters
	 * @return CreditGroupCollectionInterface Credit groups found
	 */
	protected function index_cacheable( array $params = array() ) {
		$credit_groups = $this->credit_group_repository->index();
		return $credit_groups;
	}

	/**
	 * Implementation of the "show" method. Will only
	 * run if no cached instance was found.
	 * @param array $params Search parameters
	 * @return CreditGroupInterface Credit group found
	 */
	protected function show_cacheable( array $params = array() ) {
		$credit_group = $this->credit_group_repository->show( $params );
		return $credit_group;
	}
}
