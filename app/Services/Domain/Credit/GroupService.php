<?php

namespace Tokenly\Wp\Services\Domain\Credit;

use Tokenly\Wp\Services\Domain\DomainService;
use Tokenly\Wp\Interfaces\Services\Domain\Credit\GroupServiceInterface;

use Tokenly\Wp\Interfaces\Models\Credit\GroupInterface;
use Tokenly\Wp\Interfaces\Repositories\Credit\GroupRepositoryInterface;
use Tokenly\Wp\Interfaces\Collections\Credit\GroupCollectionInterface;

/**
 * Manages credit groups
 */
class GroupService extends DomainService implements GroupServiceInterface {
	protected $group_repository;

	public function __construct(
		GroupRepositoryInterface $group_repository
	) {
		$this->group_repository = $group_repository;
	}

	/**
	 * Gets a collection of groups
	 * @param array $params Search parameters
	 * @return GroupCollectionInterface Groups found
	 */
	public function index( array $params = array() ) {
		return $this->handle_method( __FUNCTION__, func_get_args() );
	}

	/**
	 * Gets a single group
	 * @param array $params Search parameters
	 * @return GroupInterface Group found
	 */
	public function show( array $params = array() ) {
		return $this->handle_method( __FUNCTION__, func_get_args() );
	}

	/**
	 * Makes a new group
	 * @param array $params New group parameters
	 * @return GroupInterface
	 */
	public function store( array $params = array() ) {
		$credit_group = $this->group_repository->store( $params );
		return $credit_group;
	}

	/**
	 * Implementation of the "index" method. Will only
	 * run if no cached instance was found.
	 * @param array $params Search parameters
	 * @return GroupCollectionInterface Groups found
	 */
	protected function index_cacheable( array $params = array() ) {
		$credit_groups = $this->group_repository->index();
		return $credit_groups;
	}

	/**
	 * Implementation of the "show" method. Will only
	 * run if no cached instance was found.
	 * @param array $params Search parameters
	 * @return GroupInterface Group found
	 */
	protected function show_cacheable( array $params = array() ) {
		$credit_group = $this->group_repository->show( $params );
		return $credit_group;
	}
}
