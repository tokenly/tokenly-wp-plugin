<?php

namespace Tokenly\Wp\Models;

use Tokenly\Wp\Interfaces\Models\WhitelistInterface;
use Tokenly\Wp\Interfaces\Factories\Models\WhitelistItemFactoryInterface;
use Tokenly\Wp\Interfaces\Services\Domain\WhitelistServiceInterface;

class Whitelist implements WhitelistInterface {
	public $enabled = false;
	public $items = array();
	protected $whitelist_service;
	protected $whitelist_item_factory;
	
	public function __construct(
		$whitelist_data = array(),
		WhitelistServiceInterface $whitelist_service,
		WhitelistItemFactoryInterface $whitelist_item_factory
	) {
		$this->whitelist_service = $whitelist_service;
		$this->whitelist_item_factory = $whitelist_item_factory;
		$this->from_array( $whitelist_data );
	}
	
	public function update( $whitelist_data ) {
		$this->from_array( $whitelist_data );
		$this->save();
	}

	public function save() {
		$save_data = $this->to_array();
		$this->whitelist_service->update( $save_data );
	}

	public function from_array( $whitelist_data ) {
		if ( isset( $whitelist_data['enabled'] ) ) {
			$this->enabled = $whitelist_data['enabled'];
		}
		if ( isset( $whitelist_data['items'] ) ) {
			$items = array_map( function( $item_data ) {
				$item = $this->whitelist_item_factory->create( $item_data );
				return $item;
			}, $whitelist_data['items'] );
			$this->items = $items;
		}
		return $this;
	}

	public function to_array() {
		return array(
			'enabled' => $this->enabled,
			'items'   => array_map( function( $item ) {
				return $item->to_array();
			}, $this->items ),
		);
	}
}
