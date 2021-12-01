<?php

namespace Tokenly\Wp\Models;

use Tokenly\Wp\Models\Model;
use Tokenly\Wp\Interfaces\Models\WhitelistInterface;
use Tokenly\Wp\Interfaces\Factories\Models\WhitelistItemFactoryInterface;
use Tokenly\Wp\Interfaces\Services\Domain\WhitelistServiceInterface;

class Whitelist extends Model implements WhitelistInterface {
	public $enabled = false;
	public $items = array();
	protected $whitelist_service;
	protected $whitelist_item_factory;
	protected $fillable = array(
		'enabled',
		'items',
	);
	
	public function __construct(
		WhitelistServiceInterface $whitelist_service,
		WhitelistItemFactoryInterface $whitelist_item_factory,
		array $data = array()
	) {
		$this->whitelist_service = $whitelist_service;
		$this->whitelist_item_factory = $whitelist_item_factory;
		parent::__construct( $data );
	}
}
