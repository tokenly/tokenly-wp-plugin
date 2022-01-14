<?php

namespace Tokenly\Wp\Models\Settings;

use Tokenly\Wp\Models\Settings;
use Tokenly\Wp\Interfaces\Models\Settings\OauthSettingsInterface;

class OauthSettings extends Settings implements OauthSettingsInterface {
	public $use_single_sign_on = false;
	public $success_url = '/tokenly/user/me/';
	public $allow_no_email = false;
	public $allow_unconfirmed_email = false;
	protected $option_prefix = 'oauth';
	protected $fillable = array(
		'use_single_sign_on',
		'success_url',
		'allow_no_email',
		'allow_unconfirmed_email',
	);
	protected $casts = array(
		'use_single_sign_on'        => 'boolean',
		'success_url'               => 'string',
		'allow_no_email'            => 'boolean',
		'allow_unconfirmed_email'   => 'boolean',
	);
}
