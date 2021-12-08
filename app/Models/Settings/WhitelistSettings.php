<?php

namespace Tokenly\Wp\Models\Settings;

use Tokenly\Wp\Models\Settings;
use Tokenly\Wp\Interfaces\Models\Settings\WhitelistSettingsInterface;
use Tokenly\Wp\Interfaces\Factories\Collections\WhitelistItemCollectionFactoryInterface;
use Tokenly\Wp\Interfaces\Repositories\General\OptionRepositoryInterface;

class WhitelistSettings extends Settings implements WhitelistSettingsInterface {
	public $enabled = false;
	public $items = array();
	protected $whitelist_item_collection_factory;
	protected $option_prefix = 'whitelist';
	protected $fillable = array(
		'enabled',
		'items',
	);

	public function __construct(
		OptionRepositoryInterface $domain_repository,
		WhitelistItemCollectionFactoryInterface $whitelist_item_collection_factory
	) {
		$this->whitelist_item_collection_factory = $whitelist_item_collection_factory;
		parent::__construct( $domain_repository );
	}

	/**
	 * Override of parent function to turn the whitelist items
	 * into a collection
	 * @return array
	 */
	protected function get_options() {
		$options = parent::get_options();
		if ( isset( $options['items'] ) ) {
			$options['items'] = $this->whitelist_item_collection_factory->create( $options['items'] );
		}
		return $options;
	}
}
