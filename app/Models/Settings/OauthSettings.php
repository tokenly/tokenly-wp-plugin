<?php

namespace Tokenly\Wp\Models\Settings;

use Tokenly\Wp\Models\Settings;
use Tokenly\Wp\Interfaces\Models\Settings\OauthSettingsInterface;

class OauthSettings extends Settings implements OauthSettingsInterface {
	public $use_single_sign_on;
	public $redirect_url;
	public $allow_no_email;
	public $allow_unconfirmed_email;
	protected $option_prefix = 'oauth';
	protected $fillable = array(
		'use_single_sign_on',
		'redirect_url',
		'allow_no_email',
		'allow_unconfirmed_email',
	);
}
