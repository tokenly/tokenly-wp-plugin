<?php

namespace Tokenly\Wp\Repositories\Settings;

use Tokenly\Wp\Repositories\SettingsRepository;
use Tokenly\Wp\Interfaces\Repositories\Settings\TcaSettingsRepositoryInterface;

use Tokenly\Wp\Models\Settings\TcaSettings;

class TcaSettingsRepository extends SettingsRepository implements TcaSettingsRepositoryInterface {
	protected string $option_prefix = 'tca';
	protected array $meta_keys = array(
		'taxonomies',
		'post_types',
		'filter_menu_items',
		'filter_post_results',
	);
	protected string $class = TcaSettings::class;
}
