<?php

namespace Tokenly\Wp\Models;

use Tokenly\Wp\Interfaces\Models\WhitelistInterface;
use Tokenly\Wp\Interfaces\Repositories\WhitelistRepositoryInterface;
use Tokenly\Wp\Interfaces\Factories\WhitelistItemFactoryInterface;

class Whitelist implements WhitelistInterface {
	public $enabled;
	public $items;
	protected $whitelist_repository;
	protected $whitelist_item_factory;
	
	public function __construct(
		$whitelist_data = array(),
		WhitelistRepositoryInterface $whitelist_repository,
		WhitelistItemFactoryInterface $whitelist_item_factory
	) {
		$this->whitelist_repository = $whitelist_repository;
		$this->whitelist_item_factory = $whitelist_item_factory;
		$this->from_array( $whitelist_data );
	}
	
	public function update( $whitelist_data ) {
		$this->from_array( $whitelist_data );
		$this->save();
	}

	public function save() {
		$save_data = $this->to_array();
		$this->whitelist_repository->update( $save_data );
	}

	public function from_array( $whitelist_data ) {
		$enabled = $whitelist_data['enabled'] ?? null;
		if ( isset( $enabled ) ) {
			$this->enabled = $enabled;
		}
		$items = $whitelist_data['items'] ?? null;
		if ( isset( $items ) ) {
			$items = array_map( function( $item_data ) {
				$item = $this->whitelist_item_factory->create( $item_data );
				return $item;
			}, $items );
			$this->items = $items;
		}
		return $this;
	}

	public function to_array() {
		$array = array();
		if ( $this->enabled ) {
			$array['enabled'] = $this->enabled;
		}
		if ( $this->items ) {
			$array['items'] = $this->items;
		}
		return $array;
	}
}
