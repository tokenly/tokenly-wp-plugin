<?php

namespace Tokenly\Wp\Controllers\Api\Credit;

use Tokenly\Wp\Controllers\Controller;
use Tokenly\Wp\Interfaces\Controllers\Api\Credit\GroupControllerInterface;

use Tokenly\Wp\Interfaces\Repositories\Credit\AccountRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\Credit\GroupRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\Credit\GroupWhitelistRepositoryInterface;
use Tokenly\Wp\Interfaces\Collections\Credit\GroupCollectionInterface;
use Tokenly\Wp\Interfaces\Models\Credit\GroupInterface;
use Tokenly\Wp\Interfaces\Models\Credit\GroupWhitelistInterface;

/**
 * Defines promise-related endpoints
 */
class GroupController extends Controller implements GroupControllerInterface {
	protected AccountRepositoryInterface $account_repository;
	protected GroupRepositoryInterface $group_repository;
	protected GroupWhitelistRepositoryInterface $group_whitelist_repository;
	protected GroupWhitelistInterface $group_whitelist;

	public function __construct(
		AccountRepositoryInterface $account_repository,
		GroupRepositoryInterface $group_repository,
		GroupWhitelistRepositoryInterface $group_whitelist_repository
	) {
		$this->account_repository = $account_repository;
		$this->group_repository = $group_repository;
		$this->group_whitelist_repository = $group_whitelist_repository;
		$this->group_whitelist = $this->group_whitelist_repository->show();
	}
	
	/**
	 * Get a collection of groups
	 * @param \WP_REST_Request $request Request data
	 * @param GroupCollectionInterface $groups Bound groups
	 * @return \WP_REST_Response
	 */
	public function index( \WP_REST_Request $request, GroupCollectionInterface $groups ): \WP_REST_Response {
		$groups = $groups->to_array();
		return new \WP_REST_Response( $groups );
	}

	/**
	 * Get a single of group
	 * @param \WP_REST_Request $request Request data
	 * @param GroupInterface $group Bound group
	 * @return \WP_REST_Response
	 */
	public function show( \WP_REST_Request $request, GroupInterface $group = null ): \WP_REST_Response {
		if ( $group ) {
			$group = $group->to_array();
		}
		return new \WP_REST_Response ( $group );
	}

	/**
	 * Makes a new group
	 * @param \WP_REST_Request $request Request data
	 * @return \WP_REST_Response
	 */
	public function store( \WP_REST_Request $request ): \WP_REST_Response {
		$params = $request->get_params();
		$group = $this->group_repository->store( $params );
		if ( $group ) {
			$group = $group->to_array();
		}
		return new \WP_REST_Response( array (
			'status' => 'The group was successfully created!',
			'group'  => $group,
		) );
	}

	/**
	 * Updates an existing group
	 * @param \WP_REST_Request $request Request data
	 * @param GroupInterface $group Bound group
	 * @return \WP_REST_Response
	 */
	public function update( \WP_REST_Request $request, GroupInterface $group = null ): \WP_REST_Response {
		if ( $group ) {
			$params = $request->get_params();
			$group = $this->group_repository->update( $group, $params );
			if ( $group ) {
				$group = $group->to_array();
			}
		}
		return new \WP_REST_Response();
	}

	/**
	 * Destroys an existing group
	 * @param \WP_REST_Request $request Request data
	 * @param GroupInterface $group Bound group
	 * @return \WP_REST_Response
	 */
	public function destroy( \WP_REST_Request $request, GroupInterface $group = null ): \WP_REST_Response {
		if ( $group ) {
			$this->group_repository->destroy( $group );
		}
		return new \WP_REST_Response();
	}

	/**
	 * Get a collection of group accounts
	 * @param \WP_REST_Request $request Request data
	 * @return \WP_REST_Response
	 */
	public function account_index( \WP_REST_Request $request ): \WP_REST_Response {
		$group = $request->get_param( 'group' );
		$account = $this->account_repository->index( array(
			'group_uuid' => $group,
		) );
		$account = $account->to_array();
		return new \WP_REST_Response( $account );
	}

	/**
	 * Updates an existing group
	 * @param \WP_REST_Request $request Request data
	 * @return \WP_REST_Response
	 */
	public function group_whitelist_update( \WP_REST_Request $request ): \WP_REST_Response {
		$whitelist = $request->get_param( 'whitelist' );
		$this->group_whitelist_repository->update( $whitelist );
		return new \WP_REST_Response( array(
			'status' => 'Successfully updated the group whitelist!',
		) );
	}

	protected function remap_parameters( array $params = array() ): array {
		if ( isset( $params['group'] ) ) {
			$params['group_uuid'] = $params['group'];
			unset( $params['group'] );
		}
		return $params;
	}

	/**
	 * Gets model binding parameters
	 * @return array
	 */
	protected function get_bind_params(): array {
		return array(
			'service'                   => $this->group_repository,
			'single_service_method'     => 'show',
			'single_methods'            => array( 'show', 'update', 'destroy' ),
			'collection_methods'        => array( 'index' ),
			'collection_service_method' => 'index',
		);
	}
}
