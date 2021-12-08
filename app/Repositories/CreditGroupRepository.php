<?php

namespace Tokenly\Wp\Repositories;

use Tokenly\TokenpassClient\TokenpassAPIInterface;
use Tokenly\Wp\Interfaces\Repositories\CreditGroupRepositoryInterface;
use Tokenly\Wp\Interfaces\Models\CreditGroupInterface;
use Tokenly\Wp\Interfaces\Collections\CreditGroupCollectionInterface;
use Tokenly\Wp\Interfaces\Factories\Models\CreditGroupFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Collections\CreditGroupCollectionFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Models\CreditGroupHistoryFactoryInterface;

class CreditGroupRepository implements CreditGroupRepositoryInterface {
	protected $client;
	protected $credit_group_factory;
	protected $credit_group_collection_factory;
	protected $credit_group_history_factory;
	
	public function __construct(
		TokenpassAPIInterface $client,
		CreditGroupFactoryInterface $credit_group_factory,
		CreditGroupCollectionFactoryInterface $credit_group_collection_factory,
		CreditGroupHistoryFactoryInterface $credit_group_history_factory
	) {
		$this->client = $client;
		$this->credit_group_factory = $credit_group_factory;
		$this->credit_group_collection_factory = $credit_group_collection_factory;
		$this->credit_group_history_factory = $credit_group_history_factory;
	}

	/**
	 * Retrieves a collection of credit groups
	 * @return CreditGroupCollectionInterface Credit groups found
	 */
	public function index() {
		$credit_groups = $this->client->listAppCreditGroups();
		$credit_groups = $this->credit_group_collection_factory->create( $credit_groups );
		return $credit_groups;
	}

	/**
	 * Retrieves a single credit group
	 * @param array $params Search parameters
	 * @return CreditGroupInterface Credit group found
	 */
	public function show( array $params = array() ) {
		if ( !isset( $params['group_uuid'] ) ) {
			return;
		}
		$uuid = $params['group_uuid'];
		$credit_groups = $this->index();
		$credit_group = null;
		foreach( (array) $credit_groups as $credit_group_item ) {
			if ( $credit_group_item->uuid == $uuid ) {
				$credit_group = $credit_group_item;
				break;
			}
		}
		if ( !$credit_group ) {
			return;
		}
		return $credit_group;
	}
	
	/**
	 * Retrieves credit group history for the specified group
	 * @param array $params Search parameters
	 * @return CreditGroupHistoryInterface Credit group found
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
		$history = $this->credit_group_history_factory->create( $history );
		return $history;
	}
	
	/**
	 * Creates a new promised transaction
	 * @param string $name Credit group name
	 * @param array $app_whitelist Credit group whitelist
	 * @return CreditGroupInterface
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
		$credit_group = $this->credit_group_factory->create( $credit_group_data );
		return $credit_group;
	}

	/**
	 * Updates the existing promised transaction
	 * @param PromiseInterface $promise Promise to update
	 * @param $params New promise properties
	 * @return void
	 */
	public function update( CreditGroupInterface $credit_group, array $params = array() ) {
		$update_params = array();
		if ( isset( $params['name'] ) ) {
			$update_params['name'] = $params['name'];
		}
		if ( isset( $params['app_whitelist'] ) ) {
			$update_params['app_whitelist'] = $params['app_whitelist'];
		}
		$this->client->updateAppCreditGroup( $credit_group->uuid, $update_params );
	}
}
