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
	 * @return array
	 */
	public function index( GroupCollectionInterface $groups, \WP_REST_Request $request ): array {
		$groups = $groups->to_array();
		return $groups;
	}

	/**
	 * Get a single of group
	 * @param \WP_REST_Request $request Request data
	 * @return array|null
	 */
	public function show( GroupInterface $group = null, \WP_REST_Request $request ): ?array {
		if ( $group ) {
			$group = $group->to_array();
		}
		return $group;
	}

	/**
	 * Makes a new group
	 * @param \WP_REST_Request $request Request data
	 * @return array
	 */
	public function store( \WP_REST_Request $request ): array {
		$params = $request->get_params();
		$group = $this->group_repository->store( $params );
		if ( $group ) {
			return array(
				'credit_group' => $group,
				'status'       => 'Successfully created the group!',
			);
		}
		return array(
			'credit_group' => null,
			'status'       => 'Failed to create the group!',
		);
	}

	/**
	 * Updates an existing group
	 * @param \WP_REST_Request $request Request data
	 * @return array
	 */
	public function update( GroupInterface $group = null, \WP_REST_Request $request ): array {
		if ( $group ) {
			$params = $request->get_params();
			$this->group_repository->update( $group, $params );
			return array(
				'status' => 'Successfully updated the group!',
			);
		}
		return array(
			'status' => 'Failed to update the group!',
		);
	}

	/**
	 * Destroys an existing group
	 * @param \WP_REST_Request $request Request data
	 * @return array
	 */
	public function destroy( GroupInterface $group = null, \WP_REST_Request $request ): array {
		if ( $group ) {
			$this->group_repository->destroy( $group );
			return array(
				'status' => "Successfully deleted the group!",
			);
		}
		return array(
			'status' => "Failed to delete the group!",
		);
	}

	/**
	 * Get a collection of group accounts
	 * @param \WP_REST_Request $request Request data
	 * @return array
	 */
	public function account_index( \WP_REST_Request $request ): array {
		$group = $request->get_param( 'group' );
		$account = $this->account_repository->index( array(
			'group_uuid' => $group,
		) );
		$account = $account->to_array();
		return $account;
	}

	/**
	 * Updates an existing group
	 * @param \WP_REST_Request $request Request data
	 * @return array
	 */
	public function group_whitelist_update( \WP_REST_Request $request ): array {
		$whitelist = $request->get_param( 'whitelist' );
		$this->group_whitelist_repository->update( $whitelist );
		return array(
			'status' => 'Successfully updated the group whitelist!',
		);
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
