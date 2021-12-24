<?php

namespace Tokenly\Wp\Controllers\Api\Credit;

use Tokenly\Wp\Interfaces\Controllers\Api\Credit\GroupControllerInterface;

use Tokenly\Wp\Interfaces\Services\Domain\Credit\GroupServiceInterface;
use Tokenly\Wp\Interfaces\Collections\Credit\GroupCollectionInterface;
use Tokenly\Wp\Interfaces\Models\Credit\GroupInterface;

/**
 * Defines promise-related endpoints
 */
class GroupController implements GroupControllerInterface {
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
	public function index( \WP_REST_Request $request ) {
		$params = $request->get_params();
		$groups = $this->group_service->index( $params );
		$groups = $groups->to_array();
		return $groups;
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
	public function update( \WP_REST_Request $request ) {
		$group_id = $request->get_param( 'uuid' );
		$group = $this->group_service->show( array(
			'group_uuid' => $group_id,
		) );
		if ( !$group_id ) {
			return;
		}
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
	public function destroy( \WP_REST_Request $request ) {
		$group = $this->get_group( $request );
		if ( !$credit_group ) {
			return;
		}
		$group->destroy();
		return array(
			'status' => "Group successfully cancelled!",
		);
	}
	
	/**
	 * Retrieves queried group
	 * @param \WP_REST_Request $request Request data
	 * @return GroupInterface
	 */
	protected function get_group( \WP_REST_Request $request ) {
		$group_id = $request->get_param( 'credit_group' );
		if ( !$group_id ) {
			return;
		}
		$group = $this->group_service->show( array(
			'group_uuid' => $group_id,
		) );
		return $group;
	}
}
