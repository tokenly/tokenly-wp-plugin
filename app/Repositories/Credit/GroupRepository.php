<?php

namespace Tokenly\Wp\Repositories\Credit;

use Tokenly\Wp\Repositories\Repository;
use Tokenly\Wp\Interfaces\Repositories\Credit\GroupRepositoryInterface;

use Tokenly\Wp\Collections\Credit\GroupCollection;
use Tokenly\Wp\Models\Credit\Group;
use Tokenly\Wp\Models\Credit\GroupHistory;
use Tokenly\Wp\Interfaces\Collections\Credit\GroupCollectionInterface;
use Tokenly\Wp\Interfaces\Models\Credit\GroupInterface;
use Tokenly\Wp\Interfaces\Models\Credit\GroupWhitelistInterface;
use Tokenly\Wp\Interfaces\Models\Credit\GroupHistoryInterface;
use Tokenly\Wp\Interfaces\Models\Settings\IntegrationSettingsInterface;
use Tokenly\Wp\Interfaces\Repositories\Settings\IntegrationSettingsRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\Credit\GroupWhitelistRepositoryInterface;
use Tokenly\TokenpassClient\TokenpassAPIInterface;

class GroupRepository extends Repository implements GroupRepositoryInterface {
	protected TokenpassAPIInterface $client;
	protected IntegrationSettingsRepositoryInterface $integration_settings_repository;
	protected IntegrationSettingsInterface $integration_settings;
	protected GroupWhitelistRepositoryInterface $group_whitelist_repository;
	protected GroupWhitelistInterface $group_whitelist;
	
	public function __construct(
		TokenpassAPIInterface $client,
		IntegrationSettingsRepositoryInterface $integration_settings_repository,
		GroupWhitelistRepositoryInterface $group_whitelist_repository
	) {
		$this->client = $client;
		$this->integration_settings_repository =
			$integration_settings_repository;
		$this->integration_settings =
			$this->integration_settings_repository->show();
		$this->group_whitelist_repository = $group_whitelist_repository;
		$this->group_whitelist = $this->group_whitelist_repository->show();
	}

	/**
	 * Gets a collection of groups
	 * @param array $params Search parameters
	 * @return GroupCollectionInterface Groups found
	 */
	public function index(
		array $params = array()
	): GroupCollectionInterface {
		return $this->handle_method( __FUNCTION__, func_get_args() );
	}

	/**
	 * Gets a single group
	 * @param array $params Search parameters
	 * @return GroupInterface|null Group found
	 */
	public function show( array $params = array() ): ?GroupInterface {
		return $this->handle_method( __FUNCTION__, func_get_args() );
	}

	/**
	 * Gets group history for the specified group
	 * @param array $params Search parameters
	 * @return GroupHistoryInterface|null Group found
	 */
	public function show_history(
		array $params = array()
	): ?GroupHistoryInterface {
		if ( !isset( $params['group_uuid'] ) ) {
			return null;
		}
		$group_uuid = $params['group_uuid'];
		$history = $this->client->getAppCreditGroupHistory( $group_uuid );
		if ( !$history ) {
			return null;
		}
		$history = ( new GroupHistory() )->from_array( $history );
		return $history;
	}

	/**
	 * Makes a new group
	 * @param array $params New group parameters
	 * @return GroupInterface|null
	 */
	public function store( array $params = array() ): ?GroupInterface {
		$name = '';
		if ( isset( $params['name'] ) ) {
			$name = $params['name'];
		}
		$app_whitelist = array();
		if ( isset( $params['app_whitelist'] ) ) {
			$app_whitelist = $params['app_whitelist'];
			$app_whitelist = preg_replace( '/\s+/', '', $app_whitelist );
			$app_whitelist = explode( ',', $app_whitelist ) ;
		}
		$credit_group_data = $this->client->newAppCreditGroup(
			$name, $app_whitelist
		);
		if ( !$credit_group_data ) {
			return null;
		}
		$group = ( new Group() )->from_array( $credit_group_data );
		return $group;
	}

	/**
	 * Updates the Group
	 * @param GroupInterface $group Target Group
	 * @param array $params Update parameters
	 * @return void
	 */
	public function update(
		GroupInterface $group, array $params = array()
	): ?GroupInterface {
		$update_params = array();
		if ( isset( $params['name'] ) ) {
			$update_params['name'] = $params['name'];
		}
		if ( isset( $params['app_whitelist'] ) ) {
			$update_params['app_whitelist'] = $params['app_whitelist'];
		}
		$group = $this->client->updateAppCreditGroup(
			$group->uuid, $update_params
		);
		$group = ( new Group() )->from_array( $group );
		return $group;
	}

	/**
	 * Implementation of the "index" method. Will only
	 * run if no cached instance was found.
	 * @param array $params Search parameters
	 * @return GroupCollectionInterface $groups Groups found
	 */
	protected function index_cacheable(
		array $params = array()
	): GroupCollectionInterface {
		$groups = $this->client->listAppCreditGroups();
		if ( !$groups ) {
			$groups = array();
		}
		$groups = ( new GroupCollection() )->from_array( $groups );
		$groups->exclude_not_valid_clients(
			$this->integration_settings->client_id
		);
		if (
			!isset( $params['filtered'] ) ||
			$params['filtered'] === true
		) {
			$groups->exclude_not_whitelisted( $this->group_whitelist );
		}
		
		return $groups;
	}

	/**
	 * Implementation of the "show" method. Will only
	 * run if no cached instance was found.
	 * @param array $params Search parameters
	 * @return GroupInterface|null Group found
	 */
	protected function show_cacheable(
		array $params = array()
	): ?GroupInterface {
		if ( !isset( $params['group_uuid'] ) ) {
			return null;
		}
		$uuid = $params['group_uuid'];
		$group = $this->client->getAppCreditGroup( $uuid );
		if ( $group && is_array( $group ) ) {
			$group = ( new Group() )->from_array( $group );
			return $group;
		}
		return null;
	}
}
