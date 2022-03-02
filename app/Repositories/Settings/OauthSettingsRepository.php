<?php

namespace Tokenly\Wp\Repositories\Settings;

use Tokenly\Wp\Repositories\SettingsRepository;
use Tokenly\Wp\Interfaces\Repositories\Settings\OauthSettingsRepositoryInterface;

use Tokenly\Wp\Models\Settings\OauthSettings;

class OauthSettingsRepository extends SettingsRepository implements OauthSettingsRepositoryInterface {
	protected string $option_prefix = 'oauth';
	protected array $meta_keys = array(
		'use_single_sign_on',
		'success_url',
		'allow_no_email',
		'allow_unconfirmed_email',
	);
	protected string $class = OauthSettings::class;
}
