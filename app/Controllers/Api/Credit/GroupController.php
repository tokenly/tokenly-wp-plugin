<?php

namespace Tokenly\Wp\Controllers\Api\Credit;

use Tokenly\Wp\Controllers\Controller;
use Tokenly\Wp\Interfaces\Controllers\Api\Credit\GroupControllerInterface;

use Tokenly\Wp\Interfaces\Services\Domain\Credit\GroupServiceInterface;
use Tokenly\Wp\Interfaces\Collections\Credit\GroupCollectionInterface;
use Tokenly\Wp\Interfaces\Models\Credit\GroupInterface;

/**
 * Defines promise-related endpoints
 */
class GroupController extends Controller implements GroupControllerInterface {
	protected $group_service;

	public function __construct(
		GroupServiceInterface $group_service
	) {
		$this->group_service = $group_service;
	}
	
	/**
	 * Get a collection of groups
	 * @param \WP_REST_Request $request Request data
	 * @return GroupCollectionInterface
	 */
	public function index( GroupCollectionInterface $groups, \WP_REST_Request $request ) {
		$groups = $groups->to_array();
		return $groups;
	}

	/**
	 * Get a single of group
	 * @param \WP_REST_Request $request Request data
	 * @return GroupInterface
	 */
	public function show( GroupInterface $group, \WP_REST_Request $request ) {
		$group = $group->to_array();
		return $group;
	}

	/**
	 * Makes a new group
	 * @param \WP_REST_Request $request Request data
	 * @return array
	 */
	public function store( \WP_REST_Request $request ) {
		$params = $request->get_params();
		$group = $this->group_service->store( $params );
		return array(
			'credit_group' => $group,
			'status'  => 'Group created successfully',
		);
	}

	/**
	 * Updates an existing group
	 * @param \WP_REST_Request $request Request data
	 * @return array
	 */
	public function update( GroupInterface $group, \WP_REST_Request $request ) {
		$params = $request->get_params();
		$group->update( $params );
		return array(
			'status' => 'Group successfully updated!',
		);
	}

	/**
	 * Destroys an existing group
	 * @param \WP_REST_Request $request Request data
	 * @return array
	 */
	public function destroy( GroupInterface $group, \WP_REST_Request $request ) {
		$group->destroy();
		return array(
			'status' => "Group successfully cancelled!",
		);
	}

	/**
	 * Gets model binding parameters
	 * @return array
	 */
	protected function get_bind_params() {
		return array(
			'service'                   => $this->group_service,
			'query_parameter'           => 'group',
			'single_service_parameter'  => 'group_uuid',
			'single_service_method'     => 'show',
			'single_methods'            => array( 'show', 'update', 'destroy' ),
			'collection_methods'        => array( 'index' ),
			'collection_service_method' => 'index',
		);
	}
}
