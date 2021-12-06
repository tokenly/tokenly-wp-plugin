<?php

namespace Tokenly\Wp\Models\Settings;

use Tokenly\Wp\Models\Settings;
use Tokenly\Wp\Interfaces\Models\Settings\WhitelistSettingsInterface;
use Tokenly\Wp\Interfaces\Factories\Collections\WhitelistItemCollectionFactoryInterface;

class WhitelistSettings extends Settings implements WhitelistSettingsInterface {
	public $enabled = false;
	public $items = array();
	protected $option_prefix = 'whitelist';
	protected $fillable = array(
		'enabled',
		'items',
	);
}
