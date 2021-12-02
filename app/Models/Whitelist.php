<?php

namespace Tokenly\Wp\Models;

use Tokenly\Wp\Models\Model;
use Tokenly\Wp\Interfaces\Models\WhitelistInterface;
use Tokenly\Wp\Interfaces\Factories\Collections\WhitelistItemCollectionFactoryInterface;
use Tokenly\Wp\Interfaces\Repositories\General\OptionRepositoryInterface;

class Whitelist extends Model implements WhitelistInterface {
	public $enabled = false;
	public $items = array();
	protected $whitelist_item_collection_factory;
	protected $option_repository;
	protected $fillable = array(
		'enabled',
		'items',
	);
	
	public function __construct(
		WhitelistItemCollectionFactoryInterface $whitelist_item_collection_factory,
		OptionRepositoryInterface $option_repository,
		array $data = array()
	) {
		$this->option_repository = $option_repository;
		$this->whitelist_item_collection_factory = $whitelist_item_collection_factory;
		$whitelist = $this->option_repository->index( array(
			'whitelist_enabled',
			'whitelist_items',
		) );
		if ( is_array( $whitelist['whitelist_items'] ) ) {
			$whitelist['whitelist_items'] = $this->whitelist_item_collection_factory->create( $whitelist['whitelist_items'] );
		} else {
			$whitelist['whitelist_items'] = null;
		}
		
		$data = array(
			'enabled' => $whitelist['whitelist_enabled'] ?? false,
			'items'   => $whitelist['whitelist_items'],
		);
		parent::__construct( $data );
	}

	public function save() {
		$data = $this->to_array();
		$data_formatted = array();
		foreach ( $data as $key => $data_item ) {
			$data_formatted[ "whitelist_{$key}" ] = $data_item;
		}
		$this->option_repository->update( $data_formatted );
		return $this;
	}
}
