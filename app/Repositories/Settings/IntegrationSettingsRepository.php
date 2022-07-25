<?php

namespace Tokenly\Wp\Repositories\Settings;

use Tokenly\Wp\Repositories\SettingsRepository;
use Tokenly\Wp\Interfaces\Repositories\Settings\IntegrationSettingsRepositoryInterface;

use Tokenly\Wp\Models\Settings\IntegrationSettings;

class IntegrationSettingsRepository extends SettingsRepository implements IntegrationSettingsRepositoryInterface {
	protected string $option_prefix = 'integration';
	protected array $meta_keys = array(
		'client_id',
		'client_secret',
		'settings_updated',
		'can_connect',
		'extra_scopes',
	);
	protected string $class = IntegrationSettings::class;
}
