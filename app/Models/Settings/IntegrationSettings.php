<?php

namespace Tokenly\Wp\Models\Settings;

use Tokenly\Wp\Models\Settings;
use Tokenly\Wp\Interfaces\Models\Settings\IntegrationSettingsInterface;

class IntegrationSettings extends Settings implements IntegrationSettingsInterface {
	public $client_id = '';
	public $client_secret = '';
	public $settings_updated = false;
	protected $option_prefix = 'integration';
	protected $fillable = array(
		'client_id',
		'client_secret',
		'settings_updated',
	);
}
