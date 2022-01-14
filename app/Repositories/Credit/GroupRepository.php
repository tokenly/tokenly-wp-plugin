<?php

namespace Tokenly\Wp\Repositories\Credit;

use Tokenly\Wp\Interfaces\Repositories\Credit\GroupRepositoryInterface;

use Tokenly\Wp\Interfaces\Models\Credit\GroupInterface;
use Tokenly\Wp\Interfaces\Collections\Credit\GroupCollectionInterface;
use Tokenly\Wp\Interfaces\Factories\Models\Credit\GroupFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Collections\Credit\GroupCollectionFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Models\Credit\GroupHistoryFactoryInterface;
use Tokenly\TokenpassClient\TokenpassAPIInterface;

class GroupRepository implements GroupRepositoryInterface {
	protected $client;
	protected $group_factory;
	protected $group_collection_factory;
	protected $group_history_factory;
	
	public function __construct(
		TokenpassAPIInterface $client,
		GroupFactoryInterface $group_factory,
		GroupCollectionFactoryInterface $group_collection_factory,
		GroupHistoryFactoryInterface $group_history_factory
	) {
		$this->client = $client;
		$this->group_factory = $group_factory;
		$this->group_collection_factory = $group_collection_factory;
		$this->group_history_factory = $group_history_factory;
	}

	/**
	 * Gets a collection of groups
	 * @return GroupCollectionInterface Groups found
	 */
	public function index() {
		$groups = $this->client->listAppCreditGroups();
		if ( !$groups ) {
			$groups = array();
		}
		$groups = $this->group_collection_factory->create( $groups );
		return $groups;
	}

	/**
	 * Gets a single group
	 * @param array $params Search parameters
	 * @return GroupInterface Group found
	 */
	public function show( array $params = array() ) {
		if ( !isset( $params['group_uuid'] ) ) {
			return;
		}
		$uuid = $params['group_uuid'];
		$group = $this->client->getAppCreditGroup( $uuid );
		if ( $group && is_array( $group ) ) {
			$group = $this->group_factory->create( $group );
		}
		return $group;
	}
	
	/**
	 * Gets group history for the specified group
	 * @param array $params Search parameters
	 * @return GroupHistoryInterface Group found
	 */
	public function show_history( array $params = array() ) {
		if ( !isset( $params['group_uuid'] ) ) {
			return;
		}
		$group_uuid = $params['group_uuid'];
		$history = $this->client->getAppCreditGroupHistory( $group_uuid );
		if ( !$history ) {
			return;
		}
		$history = $this->group_history_factory->create( $history );
		return $history;
	}
	
	/**
	 * Makes a new promise
	 * @param array $params New promise data
	 * @return GroupInterface New promise
	 */
	public function store( array $params = array() ) {
		$name = '';
		if ( isset( $params['name'] ) ) {
			$name = $params['name'];
		}
		$app_whitelist = array();
		if ( isset( $params['app_whitelist'] ) ) {
			$app_whitelist = $params['app_whitelist'];
			$app_whitelist = preg_replace( '/\s+/', '', $app_whitelist );
			$app_whitelist = explode( ',', $app_whitelist) ;
		}
		$credit_group_data = $this->client->newAppCreditGroup( $name, $app_whitelist );
		if ( !$credit_group_data ) {
			return;
		}
		$group = $this->group_factory->create( $credit_group_data );
		return $group;
	}

	/**
	 * Updates the existing promised transaction
	 * @param PromiseInterface $promise Promise to update
	 * @param $params New promise properties
	 * @return void
	 */
	public function update( GroupInterface $group, array $params = array() ) {
		$update_params = array();
		if ( isset( $params['name'] ) ) {
			$update_params['name'] = $params['name'];
		}
		if ( isset( $params['app_whitelist'] ) ) {
			$update_params['app_whitelist'] = $params['app_whitelist'];
		}
		$this->client->updateAppCreditGroup( $group->uuid, $update_params );
	}
}
